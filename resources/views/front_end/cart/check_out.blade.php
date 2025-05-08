@extends('front_end.layouts.app')
@if(!empty($mainSettings['seo_schema']))
    @section('seo_schema')
        {!! $mainSettings['seo_schema'] !!}
    @endsection
@endif
@section('page-title', 'Đặt hàng thành công')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/cart.css') }}">
@endpush
@section('content')
    <div class="cart-page container">

        <div class="page-title d-inline-flex align-items-baseline">
            <h1 class="mb-0 blue-2 font-700">Đặt hàng thành công</h1>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-4 col-lg-4">
                <div class="cart-customer-group">
                    <div class="cart-customer-holder">
                        <p class="title blue-2">Thông tin thanh toán</p>

                        <label>Tên khách hàng</label>
                        <input type="text" class="form-input" disabled style="color:black; height:45px; font-size:20px" name="customer_name"
                               id="buyer_name" value="{{ $order->customer_name }}">

                        <label>Email</label>
                        <input type="text" class="form-input" disabled style="color:black; height:45px; font-size:20px"
                               name="customer_email" id="buyer_tel" value="{{ $order->customer_email }}">

                        <label>Số điện thoại</label>
                        <input type="text" class="form-input" disabled style="color:black; height:45px; font-size:20px" name="customer_mobile"
                               value="{{ $order->customer_mobile }}">

                        <label>Tỉnh thành</label>
                        <input type="text" class="form-input" disabled style="color:black; height:45px; font-size:20px"
                               name="province" id="buyer_tel" value="{{  $order->address->provinceDetail->name }}">

                        <label>Quận/huyện</label>
                        <input type="text" class="form-input" disabled style="color:black; height:45px; font-size:20px"
                               name="district" id="buyer_tel" value="{{  $order->address->districtDetail->name }}">

                        <label>Xã/Phường</label>
                        <input type="text" class="form-input" disabled style="color:black; height:45px; font-size:20px"
                               name="ward" id="buyer_tel" value="{{  $order->address->wardDetail->name }}">

                        <label>Địa chỉ chi tiết</label>
                        <input type="text" class="form-input" disabled style="color:black; height:45px; font-size:20px" name="address[address]"
                               id="buyer_address" value="{{ $order->address->address }}">

                        <label>Ghi chú</label>
                        <textarea class="form-input" disabled style="color:black; height:45px; font-size:20px"  name="customer_note" id="buyer_note">{{ $order->customer_note }}</textarea>

                    </div>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-xs-12 col-md-8 col-lg-8">
                <div class="cart-items-group">
                    @foreach($order->orderProducts as $item)
                        <div class="item js-item-row" data-variant_id="0" data-item_id="2903" data-item_type="product">
                            <div class="item-left">
                        <span class="item-img">
                            <img src="{{ (!empty($item->config_img)) ? get_image_url($item->config_img, 'default'): get_image_url($item->product->feature_img, 'default') }}" alt="{{ $item->product->name }}">
                        </span>

                                <div class="item-text">
                                    <a href="{{ route("fe.product",["slug"=> $item->product->slug]) }}"
                                       class="item-name">{{ $item->config_name ?? $item->product->name }}</a>
                                    <p class="item-status">
                                        <span style="color: #0DB866;">
                                            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                            Còn hàng
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="item-right">
                                <div class="item-price-holder">
                                    <p class="total-item-price">
                                <span class="js-total-item-price total-item-{{ $item->id }}">
                                     {{ $item->amount }} x @money($item->price)
                                </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="item cart-total-summary">
                        <div class="item-left font-700 text-16">Tổng giá trị đơn hàng</div>

                        <div class="item-right cart-total-price">
                            <span class="js-total-cart-price">@money($order->total_payment_price)</span>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
@endsection
@push('scripts')
    <script>
        $(document).on('click', '.choose-type-payment-cart-select', function () {
            $('.choose-type-payment-cart-select').children().removeClass('border-choose-type-payment-active')
            if (!$(this).children().hasClass('border-choose-type-payment-active')) {
                $(this).children().addClass('border-choose-type-payment-active')
            }
        })
    </script>
     @if(!empty($mainSettings['cart_successfull']))
        {!! $mainSettings['cart_successfull'] !!}
     @endif
@endpush
