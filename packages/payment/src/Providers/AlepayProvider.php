<?php

namespace Ladifire\LaravelPayment\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Ladifire\LaravelPayment\PaymentStatus;
use phpseclib\Crypt\RSA;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AlepayProvider extends AbstractProvider
{
    protected $mapStatus = [
        PaymentStatus::SUCCESS => ['000'],
        PaymentStatus::WAIT => ['107', '150', '155'],
        PaymentStatus::FAIL => ['111'],
        PaymentStatus::BAD_REQUEST => [
            '101',
            '102',
            '103',
            '104',
            '105',
            '110',
            '120',
            '121',
            '122',
            '123',
            '124',
            '125',
            '126',
            '127',
            '128',
            '129',
            '130',
            '131',
            '132',
            '133',
            '134',
            '136',
            '145',
        ],
        PaymentStatus::INVALID_CONFIG => ['138', '139', '140'],
        PaymentStatus::INVALID_RESPONSE => ['106', '108', '109', '135', '137', '142', '143', '144'],
        PaymentStatus::REDIRECTION => [],
    ];

    /**
     * @inheritDoc
     */
    public function purchase(array $data): Result
    {
        $requestData = [
            'cancelUrl' => $data['cancel_url'],
            'amount' => $data['amount'],
            'orderCode' => $data['order_id'],
            'currency' => 'VND',
            'orderDescription' => $data['description'],
            'totalItem' => $data['quantity'],
            'checkoutType' => 3,
            'buyerName' => $data['customer_name'],
            'buyerEmail' => $data['customer_email'],
            'buyerPhone' => $data['customer_phone'],
            'buyerAddress' => $data['customer_address'],
            'buyerCity' => $data['customer_city'],
            'buyerCountry' => $data['customer_country'],
            'month' => 3,
            'paymentHours' => 48,
            'allowDomestic' => true,
            'returnUrl' => $data['callback_url'],
        ];

        if (!empty($data['month']) && !empty($data['bank_code']) && !empty($data['installment_type'])) {
            $requestData['installment'] = true;
            $requestData['month'] = $data['month'];
            $requestData['bankCode'] = $data['bank_code'];
            $requestData['paymentMethod'] = $data['installment_type'];
            $requestData['allowDomestic'] = false;
        }

        $encryptedData = $this->encryptData($requestData);

        $result = $this->makeRequest(rtrim($this->config['api_url'], '/') . '/checkout/v1/request-order', [
            'token' => $this->config['token_key'],
            'data' => $encryptedData,
            'checksum' => md5($encryptedData . $this->config['checksum_key']),
        ]);

        $resultData = $this->decryptData($rawData = $result['data'] ?? null);
        $checksum = md5($rawData . $this->config['checksum_key']);

        if ($result['errorCode'] != '000' || $result['checksum'] != $checksum || empty($resultData['checkoutUrl'])) {
            throw new RuntimeException(__('Purchase Error: :context', [
                'context' => !empty($resultData) ? json_encode($resultData, JSON_UNESCAPED_UNICODE) : json_encode($result, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
            ]));
        }

        return $this->mapResultToObject(array_merge($resultData, $requestData, ['status' => PaymentStatus::REDIRECTION]));
    }

    /**
     * Encrypt data to alepay format.
     *
     * @param array|null $data
     *
     * @return string
     */
    public function encryptData(?array $data): string
    {
        $rsa = new RSA;
        $rsa->loadKey($this->config['encrypt_key']);
        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);

        return base64_encode($rsa->encrypt(json_encode($data)));
    }

    /**
     * Decrypt alepay response data.
     *
     * @param string|null $encryptedText
     *
     * @return array|null
     */
    public function decryptData(?string $encryptedText): ?array
    {
        if (empty($encryptedText)) {
            return null;
        }

        $rsa = new RSA;
        $rsa->loadKey($this->config['encrypt_key']);
        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);

        return json_decode($rsa->decrypt(base64_decode($encryptedText)), true);
    }

    /**
     * @inheritDoc
     */
    public function mapResultToObject(array $result): Result
    {
        Log::info('Payment Result', $result);

        $status = $result['status'];

        foreach ($this->mapStatus as $key => $values) {
            if (in_array($result['status'], $values)) {
                $status = $key;
                break;
            }
        }

        return (new Result)->setRaw($result)->map([
            'redirectUrl' => $result['checkoutUrl'] ?? null,
            'providerOrderId' => $result['transactionCode'] ?? ($result['token'] ?? null),
            'orderId' => $result['orderCode'] ?? '',
            'amount' => (int) $result['amount'],
            'status' => $status,
            'message' => $result['message'] ?? null,
            'transactionTime' => !empty($result['transactionTime']) ? Carbon::make($result['transactionTime']) : null,
            'successTime' => !empty($result['successTime']) ? Carbon::make($result['successTime']) : null,
            'fee' => ($result['merchantFee'] ?? 0) + ($result['payerFee'] ?? 0),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function handleProviderCallback(Request $request): Result
    {
        if (!$request->has(['data', 'checksum'])) {
            return $this->mapResultToObject([
                'status' => PaymentStatus::BAD_REQUEST,
                'message' => __('User cancel transaction.'),
                'amount' => 0,
            ]);
        }

        $encryptedData = base64_decode($request->get('data'));

        // Validate callback data
        $checksum = md5($encryptedData . $this->config['checksum_key']);

        if ($checksum != $request->get('checksum')) {
            throw new BadRequestHttpException(__('Checksum is invalid.'));
        }

        $data = $this->decryptData($encryptedData);

        if (!in_array($data['errorCode'], ['000', '150', '155']) || empty($data['data']) || $data['cancel'] == 'True') {
            throw new RuntimeException(__('Callback Data Error: :context', [
                'context' => !empty($data) ? json_encode($data) : $encryptedData,
            ]));
        }

        // Get transaction info.
        $result = $this->makeRequest(rtrim($this->config['api_url'], '/') . '/checkout/v1/get-transaction-info', [
            'token' => $this->config['token_key'],
            'data' => ($encryptedData = $this->encryptData(['transactionCode' => $data['data']])),
            'checksum' => md5($encryptedData . $this->config['checksum_key']),
        ]);

        return $this->mapResultToObject($this->decryptData($result['data']));
    }
}
