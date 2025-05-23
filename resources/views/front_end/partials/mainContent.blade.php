<section class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="nav-main-content nav-main-content1 home-row-product">
                    @foreach($categories as $category)
                        <div class="content-product">
                            <div class="title-primary wow fadeInUp">
                                <a href="{{ route('fe.product.category', ['slug' => $category['slug'], 'id' => $category['id']]) }}">
                                    <h3 class="title1">{{ $category['title'] }}</h3>
                                </a>
                                <ul>
                                    @foreach($category['children_enable'] as $child)
                                        <li>
                                            <a href="{{ route('fe.product.category', ['slug' => $child['slug'], 'id' => $child['id']]) }}">{{ $child['title'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @php
                                switch ($category['id']) {
                                    case 228:
                                        $typeImage = 'full_featured';
                                        break;
                                    case 224:
                                        $typeImage = '';
                                        break;
                                    case 151:
                                        $typeImage = '';
                                        break;

                                    default:
                                        $typeImage = 'default';
                                        break;
                                }
                            @endphp
                            <div class="nav-product">
                                <div class="row">
                                    @foreach($category['many_products'] as $product)
                                        <div class="col-md-2 col-sm-6 col-xs-6 box-item-product wow fadeInUp">
                                            <div class="item-product">
                                                <div class="image border-image-namha">
                                                    <a href="{{ route('fe.product', ['slug' => $product['slug']]) }}"
                                                       class="thubmail-img">
                                                        <img class="lazy"
                                                             data-src="{{ get_image_url($product['feature_img'],  $typeImage) }}"
                                                             alt=" {{ $product['name'] }}"
                                                             data-ll-status="loaded"
                                                             src=""
                                                        >
                                                    </a>
                                                    <div class="new-pr {{ $product['status'] != config('front_end.product_status.new') ? 'hidden' : '' }}">
                                                        <img src="{{ asset('images/new.png') }}"
                                                             alt="new">
                                                    </div>
                                                    <div class="sale-pr {{ !isset($product['sale_price']) ? 'hidden' : '' }} {{ $product['status'] != config('front_end.product_status.new') ? 'top-0' : '' }}">
                                                        <img src="{{ asset('images/sale.png') }}"
                                                             alt="sale">
                                                    </div>
                                                </div>

                                                <h3 class="title">
                                                    <a href="{{ route('fe.product', ['slug' => $product['slug']]) }}">
                                                        {{ $product['name'] }}
                                                    </a>
                                                </h3>


                                                <div class="price-c"><p class="price">
                                                        @if(!empty($product['sale_price']))
                                                            <span class="gia-moi">{{ number_format($product['sale_price'], 0, '', ',') }} đ</span>
                                                            <span class="gia-cu">{{ number_format($product['price'], 0, '', ',') }} đ</span>
                                                            <span class="tiet-kiem">(Tiết kiệm: {{ round(($product['price'] - $product['sale_price']) / $product['price'] * 100) }}%)</span>
                                                        @else
                                                            <span class="gia-moi">{{ number_format($product['price'], 0, '', ',') }} đ</span>
                                                        @endif
                                                    </p>
                                                    <div class="sale-off-show">-100%</div>
                                                </div>

                                                <div class="add-cart">
                                                    <a class="is-stock">
                                                        @if(isset($product))
                                                            @switch($product['status'])
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
                                                       data-id="{{ $product['id'] }}">
                                                        <i class="fa fa-cart-plus" aria-hidden="true"></i> Thêm vào
                                                        giỏ
                                                    </a>

                                                    <a href="javascript:void(0)"
                                                       class="ajax-addtocart button-single-cart mobile-add-cart"
                                                       data-quantity="1" data-id="{{ $product['id'] }}" data-price="0"
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>