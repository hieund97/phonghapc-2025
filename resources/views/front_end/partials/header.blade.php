@if (isset($mainSettings['info_header_status']) && $mainSettings['info_header_status'] == 'on')
    <div class="top-header topbar-banner p-0 d-lg-block d-xl-block d-none">
        <div class="list-banners">
            <div class="item-banner fade-box active" data-bg="background-color:#191B3B;">
                <a style="width: 100%" class="aspect-ratio" href="{{ $mainSettings['info_header_url'] ?? '' }}" aria-label="{{ $mainSettings['seo_meta_title'] ?? '' }}"
                   title="{{ $mainSettings['seo_meta_title'] ?? '' }}">
                    <img style="width: 100%" data-sizes="auto" class="lazyautosizes lazyloaded"
                         src="{{ $mainSettings['info_header'] ?? '' }}"
                         data-src="{{ $mainSettings['info_header'] ?? '' }}" alt="{{ $mainSettings['seo_meta_title'] ?? '' }}" sizes="1200px">
                </a>
            </div>
        </div>
    </div>
@endif
<header class="main-header">
    <div class="main-header--top">
        <div class="container-fluid">
            <div class="row-header">
                <div class="coll-header main-header--left header-action">
                    <div class="header-action-item main-header--cate" id="main-header-cate-btn">
                        <div class="header-action_text">
                            <a class="header-action__link" href="javascript:0" id="site-menu-handle"
                               aria-label="Danh mục" title="Danh mục">
                                <span class="box-icon">
                                    <svg width="18" height="14" viewBox="0 0 18 14" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect x="-0.00012207" y="0.000190735" width="18" height="2"
                                              rx="1" fill="white"></rect>
                                        <rect x="-0.00012207" y="5.99999" width="18" height="2" rx="1"
                                              fill="white"></rect>
                                        <rect x="-0.00012207" y="12.0001" width="18" height="2" rx="1"
                                              fill="white"></rect>
                                    </svg>
                                </span>
                                <span class="box-text"><span class="txtnw">Danh mục</span></span>
                            </a>
                            <div class="banner-home-left is-pc">
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
                            </div>
                            <div class="wrapper cf is-mobile">
                                <nav id="main-nav" style="display: none">
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
                                                        <a
                                                                href="{{ route('fe.product.category', ['slug' => $menu->slug, 'id' => $menu->id]) }}">
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
                            </div>
                        </div>
                    </div>
                    <div class="main-header--logo" itemscope="" itemtype="http://schema.org/Organization">

                        <a href="/" itemprop="url">
                            <picture>
                                <source media="(max-width: 1023px)"
                                        srcset="{{ $mainSettings['info_logo_mobile'] ?? '' }}">
                                <source media="(min-width: 1024px)" srcset="{{ $mainSettings['info_logo'] }}">
                                <img class="img-responsive logoimg ls-is-cached lazyloaded"
                                     data-src="{{ $mainSettings['info_logo'] }}"
                                     src="{{ $mainSettings['info_logo'] }}"
                                     alt="{{ $mainSettings['info_site_name'] }}">
                            </picture>
                        </a>
                        <h1 class="d-none"><a href="https://phonghacomputer.vn"
                                              itemprop="url">PHONGHACOMPUTER.COM</a></h1>

                    </div>
                </div>
                <div class="coll-header main-header--right header-action"
                     style="--header-dropdown-mheight: 72.6875px;">
                    <div class="header-action-item main-header--search">
                        <div class="header-action_dropdown_mb search-box wpo-wrapper-search">
                            <form action="{{ route('fe.search.index') }}"
                                  class="searchform-product searchform-categoris ultimate-search"
                                  id="searchform-product">
                                <div class="wpo-search-inner">
                                    <input type="hidden" name="type" value="product">
                                    <input required="" id="inputSearchAuto"
                                           class="input-search input-search-global" name="q" maxlength="40"
                                           autocomplete="off" type="text" size="20"
                                           placeholder="Bạn cần tìm gì?">
                                </div>
                                <button type="submit" class="btn-search btn" id="btn-search">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                                d="M10.9999 19C15.4182 19 18.9999 15.4183 18.9999 11C18.9999 6.58172 15.4182 3 10.9999 3C6.5816 3 2.99988 6.58172 2.99988 11C2.99988 15.4183 6.5816 19 10.9999 19Z"
                                                stroke="#111111" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        <path d="M20.9999 21L16.6499 16.65" stroke="#111111" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                            </form>
                            <div id="ajaxSearchResults" class="smart-search-wrapper ajaxSearchResults"
                                 style="display: none">
                                <div class="resultsContent searchResult"></div>
                            </div>
                        </div>
                    </div>
                    @if (isset($mainSettings['contact_hotline']) && !empty($mainSettings['contact_hotline']))
                        <div class="header-action-item main-header--info hide-mb">
                            <div class="header-action_text">
                                <a class="header-action__link" href="tel:19005301" aria-label="Hotline"
                                   title="Hotline">
                                    <span class="box-icon">
                                        <svg viewBox="0 0 20 25" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                    d="M4.37476 11.9262H3.24976C2.00711 11.9262 0.999756 12.9386 0.999756 14.1876V17.5797C0.999756 18.8286 2.00711 19.8411 3.24976 19.8411H4.37476C5.6174 19.8411 6.62475 18.8286 6.62475 17.5797V14.1876C6.62475 12.9386 5.6174 11.9262 4.37476 11.9262Z"
                                                    stroke="white" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            <path
                                                    d="M16.7497 11.9264H15.6247C14.3821 11.9264 13.3747 12.9389 13.3747 14.1878V17.5799C13.3747 18.8289 14.3821 19.8413 15.6247 19.8413H16.7497C17.9923 19.8413 18.9997 18.8289 18.9997 17.5799V14.1878C18.9997 12.9389 17.9923 11.9264 16.7497 11.9264Z"
                                                    stroke="white" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            <path
                                                    d="M1 14.1876V10.7955C1 8.39644 1.94821 6.09564 3.63604 4.39925C5.32387 2.70287 7.61305 1.74985 10 1.74985C12.3869 1.74985 14.6761 2.70287 16.364 4.39925C18.0518 6.09564 19 8.39644 19 10.7955V14.1876"
                                                    stroke="white" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            <path
                                                    d="M8.19063 23.9014C5.34558 24.0148 1.68793 22.801 1.86299 19.2078L3.79676 19.2078C3.79676 21.729 5.88816 22.4163 8.19063 22.2935C8.25136 21.9719 8.52587 21.729 8.85602 21.729H11.7511C12.1258 21.729 12.3484 22.2388 12.3484 22.6244V23.5522C12.3484 23.9377 12.0447 24.2502 11.67 24.2502H8.77488C8.5245 24.2502 8.30818 24.1093 8.19063 23.9014Z"
                                                    fill="white"></path>
                                        </svg>
                                    </span>
                                    <span class="box-text">
                                        <span class="txtnw">Hotline</span>
                                        <span class="txtbl"><span
                                                    class="txt-overflow"><span>{{ $mainSettings['contact_hotline'] }}</span></span></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="header-action-item main-header--ordertracking hide-mb">
                        <div class="header-action_text">
                            <a class="header-action__link js-account" data-box="acc-login-box" href="/build-pc"
                               aria-label="Xây dựng cấu hình" title="Xây dựng cấu hình">
                                <span class="box-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24">
                                        <path
                                                d="M22.7 19.3l-6.6-6.6c.6-1.1 1-2.3 1-3.7 0-4.4-3.6-8-8-8-1.4 0-2.6.4-3.7 1l4.5 4.5-3 3-4.5-4.5c-.6 1.1-1 2.3-1 3.7 0 4.4 3.6 8 8 8 1.4 0 2.6-.4 3.7-1l6.6 6.6c.4.4 1 .4 1.4 0l1.3-1.3c.4-.4.4-1 0-1.4z"/>
                                    </svg>

                                </span>
                                <span class="box-text">
                                    <span class="txtnw">Xây dựng</span>
                                    <span class="txtbl"><span class="txt-overflow"><span>cấu
                                                hình</span></span></span>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="header-action-item main-header--cart">
                        <div class="header-action_text">
                            <a class="header-action__link header-action_clicked" id="site-cart-handle"
                               href="{{ route('fe.cart') }}" aria-label="Giỏ hàng" title="Giỏ hàng">
                                <span class="box-icon">
                                    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                                d="M4.22111 3L3.84216 1H1M4.22111 3H19L15.2105 12.0455H5.73689M4.22111 3L5.73689 12.0455M5.73689 12.0455L3.56458 13.293C2.96774 13.923 3.5309 14.9091 4.375 14.9091H9.625H12.25L15.2105 15M15.2105 15C14.708 15 14.2261 15.2107 13.8708 15.5858C13.5154 15.9609 13.3158 16.4696 13.3158 17C13.3158 17.5304 13.5154 18.0391 13.8708 18.4142C14.2261 18.7893 14.708 19 15.2105 19C15.7131 19 16.195 18.7893 16.5503 18.4142C16.9056 18.0391 17.1053 17.5304 17.1053 17C17.1053 16.4696 16.9056 15.9609 16.5503 15.5858C16.195 15.2107 15.7131 15 15.2105 15ZM7.63162 17C7.63162 17.5304 7.432 18.0391 7.07667 18.4142C6.72134 18.7893 6.2394 19 5.73689 19C5.23438 19 4.75245 18.7893 4.39711 18.4142C4.04178 18.0391 3.84216 17.5304 3.84216 17C3.84216 16.4696 4.04178 15.9609 4.39711 15.5858C4.75245 15.2107 5.23438 15 5.73689 15C6.2394 15 6.72134 15.2107 7.07667 15.5858C7.432 15.9609 7.63162 16.4696 7.63162 17Z"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="count-holder"><span class="count">
                                            @if (!\Cart::isEmpty())
                                                {{ \Cart::getTotalQuantity() }}
                                            @else
                                                0
                                            @endif
                                        </span></span>
                                </span>
                                <span class="box-text">
                                    <span class="txtnw">Giỏ</span>
                                    <span class="txtbl"><span class="txt-overflow"><span>hàng</span></span></span>
                                </span>
                            </a>
                            <span class="box-triangle">
                                <svg viewBox="0 0 20 9" role="presentation">
                                    <path
                                            d="M.47108938 9c.2694725-.26871321.57077721-.56867841.90388257-.89986354C3.12384116 6.36134886 5.74788116 3.76338565 9.2467995.30653888c.4145057-.4095171 1.0844277-.40860098 1.4977971.00205122L19.4935156 9H.47108938z"
                                            fill="#ffffff"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="header-action_dropdown cart-dropdown">
                            <div class="header-dropdown-cover">
                                <div class="line-stt">Thêm vào giỏ hàng thành công</div>
                                <div class="line-item-add"></div>
                                <div class="line-btn"><a href="/cart#cart-buy-order-box">XEM GIỎ HÀNG</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="header-action-item main-header--account hide-mb">
                        <div class="header-action_text">
                            <a class="header-action__link" href="{{ auth()->user() ? route('fe.profile') : '#' }}"
                               rel="nofollow" id="site-account-handle" aria-label="Tài khoản"
                               title="Tài khoản">
                                <span class="box-icon">
                                    <svg viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                                d="M11.9999 11.9091C10.5412 11.9091 9.14224 11.3344 8.11079 10.3115C7.07934 9.28857 6.49988 7.90118 6.49988 6.45455C6.49988 5.00791 7.07934 3.62052 8.11079 2.5976C9.14224 1.57467 10.5412 1 11.9999 1C13.4586 1 14.8575 1.57467 15.889 2.5976C16.9204 3.62052 17.4999 5.00791 17.4999 6.45455C17.4999 7.90118 16.9204 9.28857 15.889 10.3115C14.8575 11.3344 13.4586 11.9091 11.9999 11.9091Z"
                                                stroke="white" stroke-width="2" stroke-linecap="round"></path>
                                        <path
                                                d="M0.999878 25.0001V23.5975C0.999878 20.7923 4.49988 15.1819 11.9999 15.1819C19.4999 15.1819 22.9999 20.7923 22.9999 23.5975V25.0001"
                                                stroke="white" stroke-width="2" stroke-linecap="round"></path>
                                    </svg>
                                    <span class="box-icon--close">
                                        <svg viewBox="0 0 19 19" role="presentation">
                                            <path
                                                    d="M9.1923882 8.39339828l7.7781745-7.7781746 1.4142136 1.41421357-7.7781746 7.77817459 7.7781746 7.77817456L16.9705627 19l-7.7781745-7.7781746L1.41421356 19 0 17.5857864l7.7781746-7.77817456L0 2.02943725 1.41421356.61522369 9.1923882 8.39339828z"
                                                    fill-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                </span>
                                <span class="box-text">
                                    <span class="txtnw">{{ Auth::user() ? Auth::user()->name : 'Đăng nhập' }}</span>
                                </span>
                            </a>

                            <span class="box-triangle">
                                <svg viewBox="0 0 20 9" role="presentation">
                                    <path
                                            d="M.47108938 9c.2694725-.26871321.57077721-.56867841.90388257-.89986354C3.12384116 6.36134886 5.74788116 3.76338565 9.2467995.30653888c.4145057-.4095171 1.0844277-.40860098 1.4977971.00205122L19.4935156 9H.47108938z"
                                            fill="#ffffff"></path>
                                </svg>
                            </span>

                        </div>

                        <div class="header-action_dropdown account-dropdown">
                            <div class="header-dropdown-cover not-logged-account-dropdown">
                                <div class="greeting block--1">
                                    <div class="thing">
                                        <div class="thing-img">
                                            <svg width="24" height="23" viewBox="0 0 24 23"
                                                 fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_102:3778)">
                                                    <path
                                                            d="M3.73909 2.42375L3.62936 2.8938C3.09762 5.15004 2.22365 7.41897 1.02676 9.63384C0.151328 11.2668 -0.175951 13.1255 0.0909153 14.9487C0.400975 17.0265 1.47017 18.9262 3.10282 20.3001C4.73546 21.6741 6.82234 22.4303 8.98149 22.4305H8.98777C10.169 22.4329 11.339 22.2072 12.4298 21.7666C13.5207 21.3259 14.5107 20.6791 15.3425 19.8635L17.1919 18.0604L22.9027 12.5275C23.1619 12.2758 23.3531 11.9658 23.4594 11.625C23.5657 11.2842 23.5838 10.9231 23.5121 10.5739C23.4403 10.2246 23.281 9.89804 23.0482 9.62309C22.8154 9.34815 22.5163 9.13338 22.1776 8.99786L21.9079 8.89069L23.1062 7.72779C23.3136 7.52718 23.4782 7.28876 23.5907 7.02619C23.7031 6.76361 23.7612 6.48205 23.7615 6.19762C23.7619 5.91319 23.7045 5.63148 23.5928 5.36864C23.481 5.1058 23.317 4.86699 23.1101 4.66589L23.0845 4.64097C22.772 4.33651 22.3727 4.13019 21.9384 4.04871L21.7527 4.0144L21.7885 3.83014C21.8143 3.69732 21.8274 3.56247 21.8277 3.4273C21.8282 3.14265 21.7706 2.86073 21.6582 2.59791C21.5457 2.33509 21.3807 2.09662 21.1727 1.89635L21.1408 1.86533C20.7932 1.52722 20.3402 1.31066 19.8526 1.24951C19.365 1.18836 18.8703 1.28607 18.4458 1.52736L18.2467 1.64065L18.1689 1.42912C18.0577 1.13684 17.8826 0.871558 17.6555 0.651661L17.6342 0.630038C17.2172 0.224597 16.6517 -0.00317383 16.062 -0.00317383C15.4723 -0.00317383 14.9068 0.224597 14.4898 0.630038L7.54388 7.38653L8.50776 3.51426C8.58622 3.20813 8.60136 2.88988 8.55231 2.57801C8.50325 2.26614 8.39097 1.96685 8.22199 1.69751C8.05301 1.42818 7.8307 1.19417 7.56795 1.00906C7.3052 0.823961 7.00726 0.691452 6.69142 0.619232C6.37558 0.547012 6.04813 0.536518 5.72808 0.58836C5.40804 0.640203 5.10177 0.753348 4.82706 0.921228C4.55235 1.08911 4.31467 1.30838 4.12782 1.56631C3.94097 1.82424 3.80867 2.11569 3.7386 2.42375H3.73909ZM5.48172 1.79999C5.64955 1.70979 5.83543 1.65592 6.02665 1.64204C6.21788 1.62817 6.40992 1.65463 6.58966 1.71961C6.9019 1.82981 7.16136 2.04815 7.31834 2.33281C7.47533 2.61747 7.5188 2.94843 7.44043 3.26232L6.01442 8.98846C5.94626 9.22349 6.09708 9.45851 6.28077 9.57038C6.3818 9.63055 6.64766 9.74195 6.94157 9.48295L15.2666 1.38776C15.3708 1.28587 15.4948 1.20511 15.6314 1.15017C15.768 1.09522 15.9144 1.06717 16.0622 1.06765C16.2098 1.0672 16.356 1.09517 16.4924 1.14995C16.6288 1.20473 16.7527 1.28523 16.8569 1.38682L16.8777 1.4075C17.0885 1.61275 17.2068 1.89093 17.2068 2.18097C17.2068 2.471 17.0885 2.74918 16.8777 2.95443L11.76 7.93085C11.661 8.03182 11.6065 8.16644 11.6082 8.30596C11.6098 8.44548 11.6676 8.57883 11.769 8.67752C11.8704 8.77621 12.0075 8.83242 12.151 8.83413C12.2945 8.83585 12.433 8.78293 12.5368 8.68669L18.7726 2.62305C18.877 2.52142 19.001 2.44079 19.1375 2.38578C19.274 2.33077 19.4203 2.30246 19.568 2.30246C19.7158 2.30246 19.8621 2.33077 19.9986 2.38578C20.1351 2.44079 20.259 2.52142 20.3635 2.62305L20.3992 2.65125C20.5039 2.75292 20.5869 2.87364 20.6435 3.00652C20.7001 3.1394 20.7293 3.28182 20.7293 3.42566C20.7293 3.5695 20.7001 3.71192 20.6435 3.8448C20.5869 3.97768 20.5039 4.0984 20.3992 4.20007L18.7267 5.81986C17.1823 7.31556 15.4802 8.96355 14.1465 10.2562C14.0917 10.3047 14.0476 10.3635 14.0168 10.4291C13.9859 10.4947 13.9691 10.5656 13.9673 10.6377C13.9654 10.7098 13.9786 10.7815 14.006 10.8484C14.0334 10.9154 14.0745 10.9763 14.1267 11.0274C14.179 11.0786 14.2413 11.1189 14.31 11.146C14.3788 11.173 14.4524 11.1863 14.5265 11.1849C14.6006 11.1836 14.6737 11.1676 14.7413 11.1381C14.809 11.1085 14.8697 11.066 14.92 11.013L14.9238 11.0092C16.1662 9.80588 19.5369 6.54091 20.7212 5.3954C20.9324 5.19126 21.2181 5.07668 21.5159 5.07668C21.8137 5.07668 22.0994 5.19126 22.3106 5.3954L22.3362 5.42032C22.4413 5.52196 22.5247 5.64281 22.5816 5.77591C22.6386 5.90902 22.6679 6.05175 22.6679 6.1959C22.6679 6.34005 22.6386 6.48278 22.5816 6.61588C22.5247 6.74898 22.4413 6.86983 22.3362 6.97148L21.5662 7.71745C19.7858 9.43877 17.4278 11.7232 15.8752 13.2274C15.7722 13.3276 15.7144 13.4634 15.7144 13.6051C15.7144 13.7467 15.7722 13.8825 15.8752 13.9827C15.9261 14.0324 15.9867 14.0718 16.0533 14.0987C16.12 14.1256 16.1914 14.1394 16.2636 14.1394C16.3357 14.1394 16.4072 14.1256 16.4738 14.0987C16.5405 14.0718 16.601 14.0324 16.652 13.9827L20.0575 10.6835L20.5409 10.2172C20.7525 10.0144 21.038 9.90098 21.3352 9.90168C21.6323 9.90239 21.9172 10.0171 22.1279 10.2209C22.3388 10.4263 22.4572 10.7046 22.4572 10.9949C22.4572 11.2851 22.3388 11.5635 22.1279 11.7688L16.4151 17.3051L14.5647 19.1091C13.8347 19.8249 12.9658 20.3927 12.0083 20.7794C11.0509 21.1662 10.024 21.3642 8.98729 21.3621H8.98149C7.08659 21.3618 5.25514 20.698 3.82228 19.4923C2.38941 18.2865 1.45093 16.6194 1.17855 14.7959C0.943867 13.1952 1.23127 11.5633 2.00032 10.1297C3.24167 7.83261 4.15045 5.47625 4.70152 3.13023L4.81125 2.66018C4.85293 2.4784 4.93439 2.30747 5.05008 2.15904C5.16578 2.01061 5.313 1.88815 5.48172 1.79999Z"
                                                            fill="black"></path>
                                                    <path
                                                            d="M21.9702 17.1911C21.9299 17.0929 21.8606 17.0086 21.7709 16.9487C21.6813 16.8889 21.5754 16.8563 21.4667 16.855C21.358 16.8538 21.2513 16.8839 21.1602 16.9417C21.0692 16.9994 20.9978 17.0821 20.9551 17.1794C20.6669 17.8309 20.2407 18.416 19.7043 18.8965C19.1679 19.377 18.5333 19.7422 17.842 19.9682C17.7735 19.9904 17.7101 20.0255 17.6555 20.0715C17.6009 20.1175 17.5561 20.1735 17.5238 20.2364C17.4914 20.2992 17.4721 20.3676 17.467 20.4377C17.4618 20.5078 17.4709 20.5781 17.4937 20.6448C17.5166 20.7115 17.5527 20.7731 17.6 20.8262C17.6473 20.8793 17.7049 20.9228 17.7695 20.9543C17.8341 20.9857 17.9045 21.0045 17.9766 21.0095C18.0486 21.0145 18.121 21.0057 18.1896 20.9835C19.0285 20.7097 19.7985 20.2667 20.4492 19.6835C21.0999 19.1002 21.6165 18.39 21.9654 17.5991C21.9939 17.5348 22.009 17.4656 22.0098 17.3956C22.0106 17.3256 21.9972 17.2561 21.9702 17.1911Z"
                                                            fill="black"></path>
                                                    <path
                                                            d="M23.6674 17.8925C23.599 17.8641 23.5253 17.8494 23.4509 17.8492C23.3434 17.8495 23.2384 17.8802 23.1487 17.9378C23.0591 17.9953 22.9887 18.0771 22.9462 18.1731C22.559 19.0467 21.9916 19.8337 21.2791 20.4856C20.5666 21.1375 19.7243 21.6403 18.804 21.9631C18.7361 21.9868 18.6737 22.0232 18.6203 22.0704C18.5669 22.1175 18.5235 22.1744 18.4928 22.2378C18.462 22.3012 18.4443 22.3699 18.4408 22.44C18.4373 22.51 18.4481 22.5801 18.4724 22.6461C18.4968 22.7121 18.5342 22.7728 18.5827 22.8248C18.6312 22.8767 18.6897 22.9188 18.7549 22.9488C18.8201 22.9787 18.8908 22.9959 18.9628 22.9993C19.0349 23.0027 19.1069 22.9922 19.1748 22.9686C20.2368 22.5961 21.2089 22.0158 22.031 21.2634C22.853 20.511 23.5076 19.6025 23.9541 18.5943C24.0114 18.4642 24.0134 18.3174 23.9597 18.1859C23.906 18.0544 23.8009 17.9489 23.6674 17.8925Z"
                                                            fill="black"></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_102:3778">
                                                        <rect width="24" height="23" fill="white"></rect>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </div>
                                        <div class="d-flex flex-column">
                                            @if (Auth::user())
                                                <div class="thing-name">Xin chào, {{ Auth::user()->name }}</div>
                                            @else
                                                <div class="thing-name">Xin chào, vui lòng đăng nhập</div>
                                            @endif
                                        </div>
                                    </div>
                                    @if (!Auth::user())
                                        <div class="actions">
                                            <button class="js-account open-login" data-box="acc-login-box">ĐĂNG NHẬP
                                            </button>
                                            <button class="js-account open-register"
                                                    data-box="acc-register-box">ĐĂNG
                                                KÝ
                                            </button>
                                        </div>
                                    @else
                                        <div class="thing-name" style="margin-bottom: 10px">
                                            <a href="{{ route('fe.history') }}">Lịch sử đơn hàng</a>
                                        </div>
                                        <div class="actions">
                                            <button class="js-account"
                                                    onclick="window.location.href='{{ route('fe.logout') }}'"
                                                    data-box="acc-login-box">ĐĂNG XUẤT
                                            </button>
                                        </div>
                                    @endif
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
        let searchRequest = null
        let timer;
        $(document).ready(function () {
            const minlength = 2
            const delay = 500;
            $('.input-search-global').keyup(function () {
                clearTimeout(timer);
                var that = this,
                    value = $(this).val();

                if (value.length <= minlength) {
                    $('.searchResult').hide();
                    $('.ajaxSearchResults').hide();
                }

                timer = setTimeout(function () {
                    if (value.length >= minlength) {
                        if (searchRequest != null) {
                            searchRequest.abort()
                        }
                        searchRequest = $.ajax({
                            type    : 'GET',
                            url     : "{{ route('fe.search.suggest') }}",
                            data    : {
                                'q': value,
                            },
                            dataType: 'text',
                            success : function (msg) {
                                const searchResult = jQuery('.searchResult');
                                //we need to check if the value is the same
                                if (value == $(that).val()) {
                                    $('.ajaxSearchResults').show();
                                    searchResult.show();

                                    msg ? searchResult.html(msg) : searchResult.html(
                                        `<p style="text-align: center">Không tìm thấy sản phẩm phù hợp!</p>`
                                    );
                                }
                            },
                        })
                    }
                }, delay);
            })

            $('.input-search-global').on('focus', function () {
                $('.header-overlay').addClass('active')
                $('.search-top').addClass('z-index-31');
                $('.search-autocomplete').show()
            });
            $('.input-search-global').on('input', function () {
                if (this.value === '') {
                    $('.search-autocomplete').hide()
                } else {
                    $('.search-autocomplete').show()
                }
            })

            const cateHeaderButton = $('#main-header-cate-btn');
            const cateHeaderList = $('.header-action_text .banner-home-left');

            // Handle show button cate when scroll behind
            $(window).scroll(function () {
                if ($(window).width() > 1024) {
                    if ($(this).scrollTop() > 50) {
                        cateHeaderButton.fadeIn();
                    } else {
                        cateHeaderButton.fadeOut();
                    }
                } else {
                    cateHeaderButton.fadeIn();
                }
            });

            // Handle hover button show list
            if ($(window).width() > 1024) {
                cateHeaderButton.hover(function () {
                    cateHeaderList.fadeIn()
                }, function () {
                    cateHeaderList.fadeOut()
                });
            }
        })
    </script>
@endpush
