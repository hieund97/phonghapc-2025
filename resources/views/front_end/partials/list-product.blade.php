<div class="nav-main-content">
    <div class="content-product">
        <div class="is-mobile">
            @include('front_end.partials.order-product', ['type' => $type ?? 0])
        </div>
        <div class="title-primary">
            <h1 class="title1">{{ $title ?? $category->title }}</h1>
            <div class="is-pc">
                @include('front_end.partials.order-product', ['type' => $type ?? 0])
            </div>
        </div>
        <div class="nav-product" id="list-filter-ajax">
            <div class="row">
                @foreach($aryProduct as $product)
                    @php
                        $checkSale = false;
                        $price = $product->price;
                        if(!empty($product->sale_price)) {
                            $checkSale = true;
                            $price = $product->sale_price;
                            $percent = round(($product->price - $product->sale_price) * 100 / ($product->price));
                        }
                    @endphp
                    <div class="col-md-3 col-sm-6 col-xs-6 box-item-product wow fadeInUp"
                         style="visibility: visible; animation-name: fadeInUp;">
                        <div class="item-product">
                            <div class="image border-image-namha">
                                <a href="{{ route("fe.product",["slug"=>$product->slug]) }}"
                                   class="thubmail-img">
                                    <img class=""
                                         alt="{{ $product->name }}"
                                         src="{{ get_image_url($product->feature_img, '') }}"
                                    >
                                </a>
                                <div class="new-pr {{ $product->status != config('front_end.product_status.new') ? 'hidden' : '' }}">
                                    <img src="{{ asset('images/new.png') }}"
                                         alt="new">
                                </div>
                                <div class="sale-pr {{ !isset($product->sale_price) ? 'hidden' : '' }} {{ $product->status != config('front_end.product_status.new') ? 'top-0' : '' }}">
                                    <img src="{{ asset('images/sale.png') }}"
                                         alt="sale">
                                </div>
                            </div>

                            <h3 class="title">
                                <a href="{{ route("fe.product",["slug"=>$product->slug]) }}l">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            <div class="price-c">
                                <p class="price">
                                    <span class="gia-moi">@money($price)</span>
                                    @if($checkSale)
                                        <span class="gia-cu">@money($product->price)</span>
                                        <span class="tiet-kiem">(Tiết kiệm: {{ $percent }}%)</span>
                                    @endif
                                </p>
                                <div class="sale-off-show">-100%</div>
                            </div>

                            <div class="add-cart">
                                <a class="is-stock">
                                    @if(isset($product))
                                        @switch($product->status)
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

                                <a href="javascript:void(0)" class="ajax-addtocart button-single-cart pc-add-cart"
                                   data-id="{{ $product->id }}">
                                    <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                    Thêm vào giỏ
                                </a>

                                <a href="javascript:void(0)" class="ajax-addtocart button-single-cart mobile-add-cart"
                                   data-id="{{ $product->id }}"
                                   style="display: none">
                                    <i class="fa fa-cart-plus" aria-hidden="true"></i> Giỏ hàng
                                </a>

                                <a href="" class="mh ajax-addtocart hidden-box"
                                   data-redirect="redirect"
                                   data-quantity="1" data-id="1693" data-price="0">Mua hàng
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if(!isset($isAjax))
                <div class="pagenavi">
                    {{ $aryProduct->links('front_end.partials.custom-pagination') }}
                </div>
            @endif
            <div class="description" style="margin-bottom: 20px;">
            </div>
        </div>
    </div>
</div>