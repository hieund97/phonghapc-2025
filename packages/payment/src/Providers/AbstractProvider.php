<?php

namespace Ladifire\LaravelPayment\Providers;

use GuzzleHttp\Client;
use Ladifire\LaravelPayment\Contracts\Provider;

abstract class AbstractProvider implements Provider
{
    /**
     * The config.
     *
     * @var array
     */
    protected array $config;

    /**
     * Create a new provider instance.
     *
     * @param array $config
     *
     * @return void
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Make a Http request.
     *
     * @param string $url
     * @param array  $data
     * @param string $method
     * @param array  $headers
     *
     * @return array
     */
    public function makeRequest(string $url, array $data = [], string $method = 'POST', array $headers = []): ?array
    {
        $client = new Client([
            'timeout' => 5,
        ]);

        $response = $client->request($method, $url, [
            ($method == 'POST' ? 'json' : 'query') => $data,
            'headers' => array_merge($headers, [
                'Accept' => 'application/json',
            ]),
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * Map the raw result array to a Payment Result instance.
     *
     * @param array $result
     *
     * @return \Ladifire\LaravelPayment\Providers\Result
     */
    abstract protected function mapResultToObject(array $result): Result;
}
