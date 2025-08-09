@extends('front_end.layouts.app')
@if(!empty($mainSettings['seo_schema']))
    @section('seo_schema')
        {!! $mainSettings['seo_schema'] !!}
    @endsection
@endif
@section('page-title', 'Giỏ hàng')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/cart.css') }}">
@endpush
@section('content')
    <div class="cart-page container">

        <div class="page-title d-inline-flex align-items-baseline">
            <h1 class="mb-0 dark font-700">Giỏ hàng của tôi</h1>
            <span class="text-12 ml-2" id="js-cart-total-item">({{ \Cart::getTotalQuantity() }}  sản phẩm )</span>
        </div>

        <form class="row" action="{{ route('fe.cart.save') }}" method="POST">
            @csrf
            @php
                $provinceId = old('address.province') ? old('address.province'):'';
                $districtId = old('address.district') ? old('address.district'):'';
                $wardId     = old('address.ward')     ? old('address.ward'):'';
            @endphp
            <div class="col-xs-12 col-md-8 col-lg-8">
                <div class="cart-items-group">
                    @foreach($cartCollection as $item)
                        <div class="item js-item-row" data-variant_id="0" data-item_id="2903" data-item_type="product">
                            <div class="item-left">
                        <span class="item-img">
                            <img src="{{ get_image_url($item->attributes['picture'], '') }}">
                        </span>

                                <div class="item-text">
                                    <a href="{{ route("fe.product",["slug"=> $item->attributes['slug']]) }}"
                                       class="item-name bold"><h4>{{ $item->name }}</h4></a>
                                    <p class="item-status">
                                        <span style="color: #0DB866;">
                                            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                            Còn hàng
                                        </span>
                                    </p>
                                    <p class="item-status">
                                        <span style="color:#db0006;">Mã sản phẩm: {{ $item->attributes['serial'] ?? '' }}</span>
                                    </p>
                                    {{-- <p class="item-status">
                                        <span>{!! $item->attributes['description'] ?? '' !!}</span>
                                    </p>
                                    <p class="item-status">
                                        <span>{!! $item->attributes['technical_specification'] ?? '' !!}</span>
                                    </p>
                                    <p class="item-status">
                                        <span>{!! $item->attributes['outstanding_features'] ?? '' !!}</span>
                                    </p>
                                    <p class="item-status">
                                        <span>{!! $item->attributes['gift_product'] ?? '' !!}</span>
                                    </p> --}}
                                </div>
                            </div>

                            <div class="item-right">
                                <div class="item-quantity-holder">
                                    <a href="javascript:void(0)"
                                       class="js-quantity-change fa fa-minus"
                                       data-id="{{ $item->id }}"
                                       data-type="-1"
                                       data-config="{{ $item->attributes->config }}"
                                       aria-hidden="true"></a>
                                    <input type="text" class="js-buy-quantity quantity-id-{{ $item->id }}"
                                           value="{{ $item->quantity }}">
                                    <a href="javascript:void(0)"
                                       class="js-quantity-change fa fa-plus"
                                       data-id="{{ $item->id }}"
                                       data-type="1"
                                       data-config="{{ $item->attributes->config }}"
                                       aria-hidden="true"></a>
                                </div>

                                <a href="javascript:void(0)" data-id="{{ $item->id }}"
                                   class="js-delete-item icon-delete"></a>

                                <div class="item-price-holder">
                                    <p class="item-price price-id-{{ $item->id }}" data-price="{{ $item->price }}">
                                        @money($item->price)
                                    </p>

                                    <p class="total-item-price">
                                        <span class="js-total-item-price total-item-{{ $item->id }}">
                                             @money($item->price * $item->quantity)
                                        </span>
                                    </p>
                                </div>
                                <div class="image-installment" style="width: 140px; display: none;">
                                    <img src="{{ asset('images/tra-gop.png') }}" alt="Trả góp">
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="item cart-total-summary">
                        <div class="item-left font-700 text-16">Tổng giá trị đơn hàng</div>

                        <div class="item-right cart-total-price">
                            <span class="js-total-cart-price">@money(\Cart::getTotal())</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('fe.cart.destroy.all') }}" class="btn-remove-group">Làm trống giỏ hàng</a>
            </div>

            <div class="col-xs-12 col-md-4 col-lg-4">
                <div class="cart-customer-group">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="cart-customer-holder">
                        <p class="title pink-2">Thông tin thanh toán</p>

                        <input type="text" placeholder="Họ tên người nhận hàng"
                               class="form-input @error('customer_name') is-invalid @enderror" name="customer_name"
                               id="buyer_name" value="{{ old('customer_name') }}">

                        <input type="text" placeholder="Số điện thoại người nhận" class="form-input"
                               name="customer_mobile" id="buyer_tel" value="{{ old('customer_mobile') }}">
                        <input type="text" placeholder="Email" class="form-input" name="customer_email" id="buyer_email"
                               value="{{ old('customer_email') }}">
                        <input type="hidden" name="address[country]" value="Việt Nam">
                        <input type="hidden" name="customer_id" value="{{ auth()->check() ?? auth()->user()->id }}">

                        <select name="address[province]" id="province_id" class="form-input">
                            @include('partials.forms.province',['provinceId'=>$provinceId])
                        </select>
                        <select name="address[district]" id="district_id" class="form-input">
                            <option>Chọn thành quận/huyện</option>
                        </select>
                        <select name="address[ward]" id="ward_id" class="form-input">
                            <option>Chọn thành phường/xã</option>
                        </select>
                        <input type="text" placeholder="Địa chỉ chi tiết" class="form-input" name="address[address]"
                               id="buyer_address" value="">

                        <textarea class="form-input" placeholder="Ghi chú" name="customer_note"
                                  id="buyer_note"></textarea>
                        <input type="hidden" name="buy_type" id="buy-type" value="1">

                        <p id="js-cart-note" class="font-500 red text-15"
                           style="color: #e00;line-height: 1.5;margin: 15px 0;"> <!-- // Báo lỗi --> </p>
                    </div>

                    <button type="submit" class="btn-submit-cart js-send-cart">
                        <b>Đặt hàng</b>
                        <span class="text-buy-now">Tư vấn viên sẽ gọi điện thoại xác nhận đơn hàng của bạn</span>
                        <span class="text-installment" style="display: none;">Tư vấn viên sẽ gọi điện thoại xác nhận thủ tục trả góp đơn hàng của bạn</span>
                    </button>
                </div>
            </div>
        </form>

    </div>
@endsection
@push('script')
    @include('partials.js.locations')
    <script>
        $(function () {
            const buyType = getUrlParameter('type');
            const imageInstallment = $(".image-installment");
            const textBuyNow = $(".text-buy-now");
            const textInstallment = $(".text-installment");
            const inputInstallment = $("#buy-type");

            if (buyType === "tra-gop") {
                imageInstallment.show();
                textBuyNow.hide();
                textInstallment.show();
                inputInstallment.val(2);
            }

            $('.js-quantity-change').on('click', function (e) {
                var product_id = $(this).data('id');
                var countItem = $('.quantity-id-' + product_id).val();
                var type = $(this).data('type');
                var price = $('.price-id-' + product_id).data('price');
                var config =  $(this).data('config');

                if(config != 'original') {
                    Swal.fire({
                        position         : 'top',
                        icon             : 'info',
                        title            : 'Bạn không điều chỉnh số lượng với cầu hình tuỳ chọn',
                        showConfirmButton: false,
                        timer            : 1300
                    });
                    return;
                }

                if (type == -1 && countItem == 1) {
                    Swal.fire('Bạn đã ở số lượng nhỏ nhất')
                    return;
                }
                countItem = +countItem + type;
                var totalPriceItem = price * countItem;

                $.ajax({
                    url    : '{{ route('fe.cart.add') }}',
                    type   : 'POST',
                    data   : ({
                        productId: product_id,
                        countItem: type,
                        isAjax   : true,
                        _token   : '{{ csrf_token() }}',
                        configType: config,
                    }),
                    success: function (result) {
                        $('.quantity-id-' + product_id).val(countItem);
                        $('.total-item-' + product_id).html(formatMoney(totalPriceItem))
                        console.log(result);
                        $('.js-total-cart-price').html(formatMoney(result))
                    },
                    error  : function (error) {

                    }
                });

            });

            $('.js-delete-item').on('click', function () {
                var id = $(this).data('id');

                Swal.fire({
                    title             : 'XOÁ SẢN PHẨM',
                    text              : "Bạn có chắc chắn xoá sản phẩm",
                    icon              : 'warning',
                    showCancelButton  : true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor : '#d33',
                    confirmButtonText : 'Xác nhận'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url    : '{{ route('fe.cart.destroy') }}',
                            type   : 'POST',
                            data   : ({
                                id     : id,
                                _token : '{{ csrf_token() }}',
                                _method: 'DELETE'
                            }),
                            success: function (result) {
                                location.reload();
                            },
                            error  : function (error) {

                            }
                        });
                    }
                })


            })

        });

        function formatMoney(money) {
            return new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(money);
        }

        function getUrlParameter(sParam) {
            let sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        }
    </script>
@endpush
