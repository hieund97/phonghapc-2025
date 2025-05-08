@component('mail::message')
# Thông báo
Các sản phẩm sau sẽ hết thời gian Flash Sale vào hôm nay:

@foreach($products as $product)
* [{{ $product->name }}]({{ route('products.edit', ['product' => $product->id]) }}) - *{{ $product->flashsale_to }}*

@endforeach

Thanks, ***{{ config('app.name') }}***
@endcomponent
