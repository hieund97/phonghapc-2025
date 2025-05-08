<div class="row" style="margin-top: 30px">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="nav-main-content">
            <div class="content-product">
                <div class="content-detail-product">
                    <div style="margin-top: 0px">
                        <ul class="nav nav-tabs nav-tp-custom">
                            <li class="active"><a data-toggle="tab" href="#home">Sản phẩm tương
                                    đương</a></li>
                            <li><a data-toggle="tab" href="#menu1">Sản phẩm đã xem</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <div class="content-box">
                                    <div class="nav-product">
                                        <div id="product-sale-home"
                                             class="owl-carousel owl-loaded owl-drag">
                                            @if($similarProducts)
                                                @foreach($similarProducts as $similarProd)
                                                    <div class="item-product">
                                                        <div class="image">
                                                            <a href="{{ route('fe.product', ['slug' => $similarProd->slug]) }}"
                                                               class="thubmail-img"><img
                                                                        class="lazy"
                                                                        data-src="{{ get_image_url($similarProd->feature_img, 'default') }}"
                                                                        alt="{{ $similarProd->name }}"
                                                                        src=""
                                                                ></a>
                                                            <div class="new-pr {{ $similarProd->status != config('front_end.product_status.new') ? 'hidden' : '' }}">
                                                                <img src="{{ asset('images/new.png') }}"
                                                                     alt="new">
                                                            </div>
                                                            <div class="sale-pr {{ !isset($similarProd->sale_price) ? 'hidden' : '' }}">
                                                                <img src="{{ asset('images/sale.png') }}"
                                                                     alt="sale">
                                                            </div>
                                                        </div>

                                                        <h3 class="title">
                                                            <a href="{{ route('fe.product', ['slug' => $similarProd->slug]) }}">{{ $similarProd->name }}</a>
                                                        </h3>


                                                        <div class="price-c"><p class="price">

                                                                @if(!empty($similarProd->sale_price))
                                                                    <span class="gia-moi">@money($similarProd->sale_price)</span>
                                                                    <span class="gia-cu">@money($similarProd->price)</span>
                                                                    <span class="tiet-kiem">(Tiết kiệm: {{ round(($similarProd->price - $similarProd->sale_price) / $similarProd->price * 100) }}%)</span>
                                                                @else
                                                                    <span class="gia-moi">@money($similarProd->price)</span>
                                                                @endif

                                                            </p>
                                                            <div class="sale-off-show">
                                                                -100%
                                                            </div>


                                                        </div>

                                                        <div class="add-cart">

                                                            <a class="is-stock">
                                                                @if(isset($similarProd))
                                                                    @switch($similarProd->status)
                                                                        @case(config('front_end.product_status.new'))
                                                                            <span class="icon-is-stock">
                                                                                                <i class="fa fa-check"
                                                                                                   aria-hidden="true"></i> Còn hàng
                                                                                            </span>
                                                                            @break
                                                                        @case(config('front_end.product_status.in_stock'))
                                                                            <span class="icon-is-stock">
                                                                                                <i class="fa fa-check"
                                                                                                   aria-hidden="true"></i> Còn hàng
                                                                                            </span>
                                                                            @break
                                                                        @case(config('front_end.product_status.out_of_stock'))
                                                                            <span class="icon-none-is-stock">
                                                                                                <i class="fa fa-times"
                                                                                                   aria-hidden="true"></i> Hết hàng
                                                                                            </span>
                                                                            @break
                                                                        @case(config('front_end.product_status.coming_soon'))
                                                                            <span class="icon-coming-in-stock">
                                                                                                <i class="fa fa-spinner"
                                                                                                   aria-hidden="true"></i> Hàng sắp về
                                                                                            </span>
                                                                            @break
                                                                    @endswitch
                                                                @endif
                                                            </a>

                                                            <a href="javascript:void(0)"
                                                               class="ajax-addtocart button-single-cart pc-add-cart"
                                                               data-id="{{ $similarProd->id }}">
                                                                <i class="fa fa-cart-plus"
                                                                   aria-hidden="true"></i>
                                                                Thêm vào giỏ
                                                            </a>

                                                            <a href="javascript:void(0)"
                                                               class="ajax-addtocart button-single-cart mobile-add-cart"
                                                               data-id="{{ $similarProd->id }}"
                                                               style="display: none"><i
                                                                        class="fa fa-cart-plus"
                                                                        aria-hidden="true"></i>
                                                                Giỏ hàng</a>

                                                            <a href=""
                                                               class="mh ajax-addtocart hidden-box"
                                                               data-redirect="redirect"
                                                               data-quantity="1"
                                                               data-id="1693"
                                                               data-price="0">Mua hàng</a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="menu1" class="tab-pane fade">
                                <div class="content-box">
                                    <div class="nav-product">
                                        <div id="product-sale-home-2"
                                             class="owl-carousel owl-loaded owl-drag">
                                            @if(!empty($recentlyViewed))
                                                @foreach($recentlyViewed as $prod)
                                                    <div class="item-product">
                                                        <div class="image">
                                                            <a href="{{ route('fe.product', ['slug' => $prod['slug']]) }}"
                                                               class="thubmail-img"><img
                                                                        class="lazy"
                                                                        data-src="{{ get_image_url($prod['feature_img'], 'default') }}"
                                                                        alt="{{ $prod['name'] }}"
                                                                        src="{{ $prod['feature_img'] }}"></a>

                                                            <div class="new-pr {{ $prod['status'] != config('front_end.product_status.new') ? 'hidden' : '' }}">
                                                                <img src="{{ asset('images/new.png') }}"
                                                                     alt="new">
                                                            </div>
                                                            <div class="sale-pr {{ !isset($prod['sale_price']) ? 'hidden' : '' }}">
                                                                <img src="{{ asset('images/sale.png') }}"
                                                                     alt="sale">
                                                            </div>
                                                        </div>

                                                        <h3 class="title">

                                                            <a href="{{ route('fe.product', ['slug' => $prod['slug']]) }}">{{ $prod['name'] }}</a>

                                                        </h3>


                                                        <div class="price-c"><p
                                                                    class="price">

                                                                @if(!empty($prod['sale_price']))
                                                                    <span class="gia-moi">@money($prod['sale_price'])</span>
                                                                    <span class="gia-cu">@money($prod['price'])</span>
                                                                    <span class="tiet-kiem">(Tiết kiệm: {{ round(($prod['price'] - $prod['sale_price']) / $prod['price'] * 100) }}%)</span>
                                                                @else
                                                                    <span class="gia-moi">@money($prod['price'])</span>
                                                                @endif

                                                            </p>
                                                            <div class="sale-off-show">
                                                                -100%
                                                            </div>


                                                        </div>

                                                        <div class="add-cart">
                                                            <a class="is-stock">
                                                                @if(isset($prod))
                                                                    @switch($prod['status'])
                                                                        @case(config('front_end.product_status.new'))
                                                                            <span class="icon-is-stock">
                                                                                                <i class="fa fa-check"
                                                                                                   aria-hidden="true"></i> Còn hàng
                                                                                            </span>
                                                                            @break
                                                                        @case(config('front_end.product_status.in_stock'))
                                                                            <span class="icon-is-stock">
                                                                                                <i class="fa fa-check"
                                                                                                   aria-hidden="true"></i> Còn hàng
                                                                                            </span>
                                                                            @break
                                                                        @case(config('front_end.product_status.out_of_stock'))
                                                                            <span class="icon-none-is-stock">
                                                                                                <i class="fa fa-times"
                                                                                                   aria-hidden="true"></i> Hết hàng
                                                                                            </span>
                                                                            @break
                                                                        @case(config('front_end.product_status.coming_soon'))
                                                                            <span class="icon-coming-in-stock">
                                                                                                <i class="fa fa-spinner"
                                                                                                   aria-hidden="true"></i> Hàng sắp về
                                                                                            </span>
                                                                            @break
                                                                    @endswitch
                                                                @endif
                                                            </a>
                                                            <a href=""
                                                               class="ajax-addtocart button-single-cart pc-add-cart"
                                                               data-id="{{ $prod['id'] }}"
                                                               data-price="0"><i
                                                                        class="fa fa-cart-plus"
                                                                        aria-hidden="true"></i>
                                                                Thêm vào giỏ</a>

                                                            <a href=""
                                                               class="ajax-addtocart button-single-cart mobile-add-cart"
                                                               data-id="{{ $prod['id'] }}" data-price="0"
                                                               style="display: none"><i
                                                                        class="fa fa-cart-plus"
                                                                        aria-hidden="true"></i>
                                                                Giỏ hàng</a>

                                                            <a href=""
                                                               class="mh ajax-addtocart hidden-box"
                                                               data-redirect="redirect"
                                                               data-quantity="1"
                                                               data-id="1478"
                                                               data-price="0">Mua hàng</a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>