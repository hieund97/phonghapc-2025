<header id="header-site">
    <!-- begin mobile -->
    <div class="wrapper cf is-mobile">
        <nav id="main-nav" style="display:none;">
            <ul class="second-nav">
                @if (auth()->user())
                        <li><a href="{{ route('fe.profile') }}">Xin
                                chào {{ auth()->user()->name }}</a>
                        </li>
                        <li><a href="{{ route('fe.logout') }}">Đăng xuất</a>
                        </li>
                @else
                        <li><a href="javascript:void(0)" class="open-register">Đăng ký</a>
                        </li>
                        <li><a href="javascript:void(0)" class="open-login">Đăng nhập</a>
                        </li>
                @endif
                @if ($mainHeaders)
                    @foreach ($mainHeaders as $menu)
                        @if ($menu->parent == null)
                            <li class="devices">
                                <a href="{{ route('fe.product.category', ['slug' => $menu->slug, 'id' => $menu->id]) }}">
                                    <span>{{ $menu->title }}</span>
                                    <ul>
                                        @foreach ($menu->children as $child)
                                            <li>
                                                <a
                                                    href="{{ route('fe.product.category', ['slug' => $child->slug, 'id' => $child->id]) }}">{{ $child->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif

            </ul>
        </nav>
        <a href="javascript:void(0)" class="toggle">
            <span></span>
        </a>
    </div>
    <!-- end mobile -->
    <div class="top-header is-pc">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-sm-6 col-xs-12">
                    <div class="item-top left-top">
                        <ul>
                            @if ($mainMenus)
                                @foreach ($mainMenus as $menu)
                                    @if ($menu->id == config('front_end.menu.top_header'))
                                        @foreach ($menu->items as $item)
                                            <li><a href="{{ $item->link }}">{{ $item->label }}</a>
                                            </li>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12 login-option">
                    <div class="item-top right-top login-option">
                        @if (auth()->user())
                            <ul>
                                <li><a style="font-size:12px" href="{{ route('fe.profile') }}">Xin
                                        chào {{ auth()->user()->name }}</a>
                                </li>
                                <li><a style="font-size:12px" href="{{ route('fe.logout') }}">Đăng xuất</a>
                                </li>
                            </ul>
                        @else
                            <ul>
                                <li><a href="javascript:void(0)" class="open-register">Đăng ký</a>
                                </li>
                                <li><a href="javascript:void(0)" class="open-login">Đăng nhập</a>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-logo-shop">
        <div class="container pd-10">
            <div class="row">
                <div class="col-md-2 col-sm-12 col-xs-12 logo-mobile">
                    <a href="{{ route('fe.home') }}" class="logo lazy">
                        <img src="{{ $mainSettings['info_logo'] }}" alt="{{ $mainSettings['info_site_name'] }}">
                    </a>
                </div>
                <div class="col-md-10 col-sm-12 col-xs-12">
                    <div class="search-shop-holine">
                        <div class="row center-flex">
                            <div class="col-md-8 col-xs-12">
                                <div class="search">
                                    <form action="{{ route('fe.search.index') }}" method="GET" class="form">
                                        <input type="text" name="q" class="keyword input-search-global"
                                            value="{{ request('q') }}" placeholder="Nhập từ khóa tìm kiếm"
                                            aria-label="Search">
                                        <input type="submit" value="Tìm kiếm">
                                        <div class="searchResult"></div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 col-xs-3 col-lg-1 cart-mobile-order">
                                <div class="cart d-flex center-flex">
                                    <a href="{{ route('fe.cart') }}" class="d-block" title="Giỏ hàng của bạn">
                                        <i class="fas fa-shopping-cart" style="color: #0069c7; font-size:25px"></i>
                                        <span class="js-cart-count cart-count">
                                            @if (!\Cart::isEmpty())
                                                {{ \Cart::getTotalQuantity() }}
                                            @else
                                                0
                                            @endif
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 col-xs-6">
                                <div class="holine">
                                    <span class="title-holine">Hotline</span>
                                    <span class="phone-holine">{{ $mainSettings['contact_hotline'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="category-menu">
                    <div class="container-box-category">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div id="main-menu1">
                                    <ul>
                                        <li class="menu-item first-category-box">
                                            <a>
                                                <div class="nav_horizontal_item">
                                                    <div class="nav_horizontal_text">
                                                        <p class="newBigText">Danh mục sản phẩm <i
                                                                class="fa fa-angle-down" aria-hidden="true"></i>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="header-new-bot">
                                                <div class="list-content">
                                                    <div class="item-n menu-main item-n-first">
                                                        <ul class="menu-main-sub">
                                                            @foreach ($mainHeaders as $cate)
                                                                @if ($cate->parent == null)
                                                                    <li>
                                                                        <a href="{{ route('fe.product.category', ['slug' => $cate->slug, 'id' => $cate->id]) }}"
                                                                            class="itop"
                                                                            style="background: url('{{ get_image_url($cate->icon, '') }}') no-repeat;">{{ $cate->title }}</a>
                                                                        <div class="box-sub-cat">
                                                                            @foreach ($cate->childrenEnable as $child)
                                                                                <div class="box-cat">
                                                                                    <a href="{{ route('fe.product.category', ['slug' => $child->slug, 'id' => $child->id]) }}"
                                                                                        class="cat2">{{ $child->title }}</a>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @if ($mainMenus)
                                            @foreach ($mainMenus as $menu)
                                                @if ($menu->id == config('front_end.menu.main_menu'))
                                                    @foreach ($menu->items as $item)
                                                        <li class="menu-item">
                                                            <a href="{{ $item->link }}">
                                                                <div class="nav_horizontal_item">
                                                                    <div class="nav_horizontal_text">
                                                                        <p class="newBigText">{{ $item->label }}</p>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@push('script')
    <script defer="">
        var searchRequest = null
        $(document).ready(function() {
            var minlength = 3
            $('.input-search-global').keyup(function() {
                var that = this,
                    value = $(this).val();

                if (value.length <= minlength) {
                    $('.searchResult').hide();
                }

                if (value.length >= minlength) {
                    if (searchRequest != null) {
                        searchRequest.abort()
                    }
                    searchRequest = $.ajax({
                        type: 'GET',
                        url: "{{ route('fe.search.suggest') }}",
                        data: {
                            'q': value,
                        },
                        dataType: 'text',
                        success: function(msg) {
                            //we need to check if the value is the same
                            if (value == $(that).val()) {
                                //jQuery('.search-autocomplete').html(msg)
                                jQuery('.searchResult').show();
                                jQuery('.searchResult').html(msg);
                                // console.log($(that))
                            }
                        },
                    })
                }
            })

            $('.input-search-global').on('focus', function() {
                $('.header-overlay').addClass('active')
                $('.search-top').addClass('z-index-31');
                $('.search-autocomplete').show()
            });
            $('.input-search-global').on('input', function() {
                if (this.value === '') {
                    $('.search-autocomplete').hide()
                } else {
                    $('.search-autocomplete').show()
                }
            })

        })
    </script>
@endpush
