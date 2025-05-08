@component('mail::message')
<h1 style="text-align: center;">Đặt hàng thành công</h1>

Xin chào, **{{ $order->customer_name }}**

Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi. Dưới đây là thông tin chi tiết đơn hàng của bạn:

@component('mail::panel')
    @component('mail::table')
        | Thông tin đơn hàng     |                |
        | ---------------------- | -------------- |
         Mã đơn hàng:             {{ $order->order_id }}
         Ngày thực hiện:          {{ \Illuminate\Support\Carbon::createFromTimeString($order->created_at)->format('H:i:s d/m/Y') }}
         Số tiền thanh toán:      {{ number_format($order->total_payment_price) }}đ
         Phương thức thanh toán:  {{ config('admin.payment_method')[$order->payment_method] }}
         Địa chỉ nhận hàng:       {{ $order->customer_address }}
    @endcomponent
@endcomponent

Trân trọng cảm ơn, **{{ config('app.name') }}**
@endcomponent
