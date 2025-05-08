<section class="top-content">
    <div class="container pd-10">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 fade-left animated fadeInLeft">
                <div class="left-product">
                    <div class="content-product home-first">
                        <div class="title-primary wow fadeInUp">
                            <a href="#">
                                <h3 class="title1">Sản phẩm khuyến mại</h3>
                            </a>
                        </div>
                        <div class="nav-product">
                            <div class="row">
                                <div id="product-sale-home" class='owl-carousel'>
                                    @foreach($saleProducts as $saleProd)
                                        <div class="wow fadeInUp"
                                             style="visibility: visible; animation-name: fadeInUp;">
                                            <div class="item-product" style="align-items:center">
                                                <div class="image border-image-namha">
                                                    <a href="{{ route('fe.product', ['slug' => $saleProd->slug]) }}"
                                                       class="thubmail-img">
                                                        <img class="lazy"
                                                             data-src="{{ get_image_url($saleProd->feature_img, 'default') }}"
                                                             alt="{{ $saleProd->name }}"
                                                             data-ll-status="loaded"
                                                             src=""
                                                        >
                                                    </a>
                                                    <div class="new-pr {{ $saleProd->status != config('front_end.product_status.new') ? 'hidden' : '' }}">
                                                        <img src="{{ asset('images/new.png') }}"
                                                             alt="new">
                                                    </div>
                                                    <div class="sale-pr {{ !empty($saleProd->sale_price) ? 'hidden' : '' }} {{ $saleProd->status != config('front_end.product_status.new') ? 'top-0' : '' }}">
                                                        <img src="{{ asset('images/sale.png') }}"
                                                             alt="sale">
                                                    </div>
                                                </div>

                                                <h3 class="title">
                                                    <a href="{{ route('fe.product', ['slug' => $saleProd->slug]) }}">
                                                        {{ $saleProd->name }}
                                                    </a>
                                                </h3>


                                                <div class="price-c">
                                                    <p class="price">
                                                        @if(!empty($saleProd->sale_price))
                                                            <span class="gia-moi" style="display:inline-block">{{ number_format($saleProd->sale_price, 0, '', ',') }} đ</span>
                                                            <span class="gia-cu">{{ number_format($saleProd->price, 0, '', ',') }} đ</span>
                                                            <span class="tiet-kiem">(Tiết kiệm: {{ round(($saleProd->price - $saleProd->sale_price) / $saleProd->price * 100) }}%)</span>
                                                        @else
                                                            <span class="gia-moi">{{ number_format($saleProd->price, 0, '', ',') }} đ</span>
                                                        @endif
                                                    </p>
                                                    <div class="sale-off-show">-100%</div>
                                                </div>

                                                <div class="add-cart" style="justify-content:space-evenly">
                                                    <a class="is-stock">
                                                        @if(isset($saleProd))
                                                            @switch($saleProd->status)
                                                                @case(config('front_end.product_status.new'))
                                                                    <span class="icon-is-stock">
                                                                        <i class="fa fa-check" aria-hidden="true"></i> Còn hàng
                                                                    </span>
                                                                    @break
                                                                @case(config('front_end.product_status.in_stock'))
                                                                    <span class="icon-is-stock">
                                                                        <i class="fa fa-check" aria-hidden="true"></i> Còn hàng
                                                                    </span>
                                                                    @break
                                                                @case(config('front_end.product_status.out_of_stock'))
                                                                    <span class="icon-none-is-stock">
                                                                        <i class="fa fa-times" aria-hidden="true"></i> Hết hàng
                                                                    </span>
                                                                    @break
                                                                @case(config('front_end.product_status.coming_soon'))
                                                                    <span class="icon-coming-in-stock">
                                                                        <i class="fa fa-spinner" aria-hidden="true"></i> Hàng sắp về
                                                                    </span>
                                                                    @break
                                                            @endswitch
                                                        @endif
                                                    </a>

                                                    <a href="javascript:void(0)"
                                                       class="ajax-addtocart button-single-cart pc-add-cart"
                                                       data-id="{{ $saleProd->id }}">
                                                        <i class="fa fa-cart-plus" aria-hidden="true"></i> Thêm vào
                                                        giỏ
                                                    </a>

                                                    <a href="javascript:void(0)"
                                                       class="ajax-addtocart button-single-cart mobile-add-cart"
                                                       data-id="{{ $saleProd->id }}"
                                                       style="display: none">
                                                        <i class="fa fa-cart-plus" aria-hidden="true"></i> Giỏ hàng
                                                    </a>

                                                    <a href="" class="mh ajax-addtocart hidden-box"
                                                       data-redirect="redirect" data-quantity="1" data-id="1502"
                                                       data-price="0">
                                                        Mua hàng
                                                    </a>

                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>