<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartCollection = Cart::getContent();

        /* Set meta */
        $metaTitle       = 'Giỏ hàng - maytinhnamha.vn';
        $metaDescription = 'NAM HÀ COMPUTER LÀ THƯƠNG HIỆU HÀNG ĐẦU VỀ LAPTOP ,MÁY TÍNH GAMING, MÁY TÍNH VĂN PHÒNG, VỚI ĐỘI NGŨ KỸ THUẬT CHUYÊN NGHIỆP NHIỆT TÌNH. UY TÍN - CHẤT LƯỢNG - CAO CẤP 02473063686';
        meta()->set('title', $metaTitle)
              ->set('og:title', $metaTitle)
              ->set('description', $metaDescription)
              ->set('og:description', $metaDescription)
              ->set('canonical', route('fe.cart'))
        ;

        meta()->set('robots', 'noindex');

        /* Hết Set meta */

        return view('front_end.cart.cart-detail', compact('cartCollection'));
    }

    public function destroy(Request $request)
    {
        $productId = $request->get('id');

        return Cart::remove($productId);
    }

    public function update(Request $request)
    {
        $productId = $request->get('productId');
        $quantity  = $request->get('quantity');
        $item      = Cart::get($productId);
        if ($item) {
            Cart::update($productId, [
                'quantity' => [
                    'relative' => false,
                    'value'    => $quantity,
                ],
            ]);
        }
        $cartCollection = Cart::getContent();

        return view('front_end.carts.elements.product', compact('cartCollection'));
    }

    public function addItemToCart(Request $request)
    {
        $aryConfig    = [];
        $productId    = $request->get('productId');
        $countItem    = $request->get('countItem');
        $configType   = $request->configType;
        $product      = Product::findOrFail($request->get('productId'));
        $config_image = null;

        if (!empty($configType) && $configType !== 'original') {
            $priceConfig = 0;
            foreach ($product->config as $index => $config) {
                if ($index == $configType) {
                    $aryConfig = $config;
                }

                if (!empty($config['sale_price']) && $config['sale_price'] != 0) {
                    $priceConfig = $config['sale_price'];
                } else {
                    $priceConfig = $config['price'];
                }

                if (!empty($config['config_img'])) {
                    $config_image = $config['config_img'];
                }
            }
        }

        $item      = Cart::get($productId);
        $countItem = !empty($countItem) ? $countItem : 1;
        if ($item && $item['attributes']['config'] == $configType) {
            if (!empty($request->get('countItem'))) {
                Cart::update($product->id, [
                    'quantity' => (int)$countItem,
                ]);
            } else {
                Cart::update($product->id, [
                    'quantity' => +1,
                ]);
            }
        } else {
            Cart::add([
                'id'              => $productId,
                'name'            => !empty($aryConfig) ? $aryConfig['name'] : $product->name,
                'price'           => !empty($aryConfig) && !empty($priceConfig) && $priceConfig != 0 ? $priceConfig : $product->getRealPriceAttribute(),
                'quantity'        => $countItem,
                'attributes'      => [
                    "picture" => !empty($aryConfig) ? get_image_url($config_image) : get_image_url($product->feature_img,
                        ''),
                    "slug"    => $product->slug,
                    "config"  => $request->configType ?? 'original'
                ],
                'associatedModel' => Product::class,
            ]);
        }

        if ($request->has('isAjax')) {
            return Cart::getTotal();
        }

        return Cart::getTotalQuantity();
    }

    public function save(Checkout $request)
    {
        $data = $request->validated();
        \DB::beginTransaction();
        try {
            $getData = static::calculatorPaymentPrice($data);

            $totalPrice    = $getData['total_price'];
            $paymentPrice  = $getData['payment_price'];
            $orderProducts = $getData['order_products'];

            $order = Order::create(array_merge($data, [
                'order_id'            => date('YmdHis') . random_int(100, 999),
                'status'              => array_search('New', Order::$ORDERSTATUS),
                'total_price'         => $totalPrice,
                'total_payment_price' => $paymentPrice,
                'bundle_saving'       => $getData['bundle_savings'],
            ]));

            $address = $order->address()->create($data['address']);
            $order->orderProducts()->createMany($orderProducts);

            $this->addUser($data);

            \DB::commit();
            //Mail::to($order->customer_email)->send(new Ordered($order));
            Cart::clear();

            return redirect()
                ->route('fe.checkout', ["order_id" => $order->order_id])
                ->with('success', __('Tạo đơn hàng thành công'))
            ;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());

            return redirect()->back();
        }
    }

    public static function calculatorPaymentPrice(array $data): array
    {
        $totalPrice    = 0;
        $orderProducts = [];

        $products = Product::whereIn('id', ($productData = collect($data['products']))->pluck('id'))
                           ->get()
                           ->transform(function ($product) use ($productData) {
                               $currentProduct  = $productData->where('id', $product->id)->first();
                               $product->amount = (int)$currentProduct['quantity'];

                               return $product;
                           })
        ;

        // Get bundles saving.
        $saving       = [];
        $totalSavings = 0;

        foreach ($products as $key => $product) {
            $warranty = null;

            if (!empty($warranty)) {
                $warrantyName = $warranty->name;

                if ($warranty->price_type == 'percent') {
                    $warranty->price = $product->price * $warranty->price / 100;
                }

                if ($product->amount > 1) {
                    $warrantyName .= ' (' . number_format($warranty->price) . 'đ / Sản phẩm)';
                }

                $warrantyPrice = $warranty->price * $product->amount;
            }

            $orderProducts[] = [
                'product_id'     => $product->id,
                'customer_id'    => $data['customer_id'] ?? null,
                'amount'         => $product->amount,
                'price'          => $data['products'][$key]['price'],
                'warranty_name'  => $warrantyName ?? null,
                'warranty_price' => $warrantyPrice ?? null,
                'total_price'    => $totalProductPrice = $product->amount * $data['products'][$key]['price'] - ($saveBundle = $saving[$product->id] ?? 0) + ($warrantyPrice ?? 0),
                'note'           => !empty($saveBundle) ? 'Giảm ' . number_format($saveBundle) . 'đ từ bundle.' : null,
                'config_name'    => $data['products'][$key]['name'],
                'config_name'    => $data['products'][$key]['config_img'],

            ];

            $totalPrice += $totalProductPrice;
        }

        $paymentPrice = $totalPrice;

        if (!empty($data['coupon_code'])) {
            $coupon = Coupon::where('code', $data['coupon_code'])->firstOrFail();
            if ($coupon->min_price <= $totalPrice) {
                $priceDiscount = 0;
                if ($coupon->type == 'percent') {
                    $priceDiscount = $totalPrice / 100 * $coupon->discount;
                } elseif ($coupon->type = 'fixed') {
                    $priceDiscount = $coupon->discount;
                }
                if ($coupon->max_discount < $priceDiscount) {
                    $priceDiscount = $coupon->max_discount;
                }
                $paymentPrice = max($totalPrice - $priceDiscount, 0);
            }
        }

        $paymentPrice -= $totalSavings;

        return [
            'total_price'    => $totalPrice,
            'payment_price'  => $paymentPrice,
            'order_products' => $orderProducts,
            'bundle_savings' => $totalSavings,
        ];
    }

    public function checkOut(Request $request)
    {
        $orderId = $request->get('order_id');
        $order   = Order::whereOrderId($orderId)->firstOrFail();

        /* Set meta */
        $metaTitle       = 'Đặt hàng thành công - maytinhnamha.vn';
        $metaDescription = 'ĐẶT HÀNG THÀNH CÔNG - NAM HÀ COMPUTER LÀ THƯƠNG HIỆU HÀNG ĐẦU VỀ LAPTOP ,MÁY TÍNH GAMING, MÁY TÍNH VĂN PHÒNG, VỚI ĐỘI NGŨ KỸ THUẬT CHUYÊN NGHIỆP NHIỆT TÌNH. UY TÍN - CHẤT LƯỢNG - CAO CẤP 02473063686';
        meta()->set('title', $metaTitle)
              ->set('og:title', $metaTitle)
              ->set('description', $metaDescription)
              ->set('og:description', $metaDescription)
              ->set('canonical', route('fe.checkout', ["order_id" => $orderId]))
        ;
        meta()->set('robots', 'noindex');

        /* Hết Set meta */

        return view('front_end.cart.check_out', compact('order'));
    }

    /**
     * Add to cart for build PC
     * @param Request $request
     * @return mixed
     */
    public function addItemToCartForBuildPC(Request $request)
    {
        $data = json_decode($request->add_to_cart_build_pc, true);
        foreach ($data as $key => $itemProd) {
            if ($key == 'total') {
                continue;
            }
            $item = Cart::get($itemProd['product_id']);
            if ($item) {
                Cart::update($itemProd['product_id'], [
                    'quantity' => $itemProd['quantity'],
                ]);
            } else {
                Cart::add([
                    'id'              => $itemProd['product_id'],
                    'name'            => $itemProd['name'],
                    'price'           => $itemProd['price'],
                    'quantity'        => $itemProd['quantity'],
                    'attributes'      => [
                        "picture" => get_image_url($itemProd['image'], ''),
                        "slug"    => $itemProd['slug'],
                    ],
                    'associatedModel' => Product::class,
                ]);
            }
        }
        session()->flash('add_to_cart_success', 'success');


        return redirect()->back();
    }

    public function destroyAll()
    {
        \Cart::clear();

        return redirect()->back();
    }

    public function updateQuantity(Request $request)
    {
    }

    public function addUser($data)
    {
        $user = User::where('email', $data['customer_email'])->first();
        if (!$user) {
            $user = User::create([
                'name'        => $data['customer_name'],
                'email'       => $data['customer_email'],
                'mobile'      => $data['customer_mobile'],
                'description' => $data['customer_note'],
                'province'    => $data['address']['province'],
                'address'     => $data['address']['address'],
                'password'    => bcrypt('123456'),
            ]);

            $user->assignRole('Customers');
        }

        return $user;
    }
}
