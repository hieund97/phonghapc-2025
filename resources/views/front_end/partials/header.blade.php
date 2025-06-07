@if (isset($mainSettings['info_header_status']) && $mainSettings['info_header_status'] == 'on')
    <div class="top-header topbar-banner p-0 d-lg-block d-xl-block d-none">
        <div class="list-banners">
            <div class="container-fluid p-0">
                <div class="item-banner fade-box active" data-bg="background-color:#191B3B;">
                    <a style="width: 100%" class="aspect-ratio" href="/pages/pc-gvn" aria-label="PC GVN KM T02"
                        title="PC GVN KM T02">
                        <img style="width: 100%" data-sizes="auto" class="lazyautosizes lazyloaded"
                            src="{{ $mainSettings['info_header'] ?? '' }}"
                            data-src="{{ $mainSettings['info_header'] ?? '' }}" alt="PC GVN KM T02" sizes="1200px">
                    </a>
                </div>
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
                        <div class="header-action_boxfull menu-desktop" id="menu-desktop-ajax">
                            <div class="sidebar-menu" id="sidebar-menu-ajax">
                                <nav class="megamenu-nav">
                                    <ul class="megamenu-nav-main">

                                        <li class="megamenu-item mg-1">
                                            <a class="megamenu-link" href="/pages/laptop-van-phong">
                                                <span class="megamenu-icon" data-hover="laptop">
                                                    <svg width="20" height="13" viewBox="0 0 20 13"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <mask id="path-1-inside-1_5068_8551" fill="currentcolor">
                                                            <path
                                                                d="M4.00002 1C3.44774 1 3.00002 1.44772 3.00002 2V8.5C3.00002 9.05229 3.44774 9.5 4.00002 9.5H16C16.5523 9.5 17 9.05229 17 8.5V2C17 1.44772 16.5523 1 16 1H4.00002ZM3.70002 0H10H16.3C16.7774 0 17.2353 0.184374 17.5728 0.512563C17.9104 0.840752 18.1 1.28587 18.1 1.75V8.75C18.1 9.21413 17.9104 9.65925 17.5728 9.98744C17.2353 10.3156 16.7774 10.5 16.3 10.5H3.70002C3.22263 10.5 2.7648 10.3156 2.42723 9.98744C2.08967 9.65925 1.90002 9.21413 1.90002 8.75V1.75C1.90002 1.28587 2.08967 0.840752 2.42723 0.512563C2.7648 0.184374 3.22263 0 3.70002 0Z">
                                                            </path>
                                                        </mask>
                                                        <path
                                                            d="M4.00002 1C3.44774 1 3.00002 1.44772 3.00002 2V8.5C3.00002 9.05229 3.44774 9.5 4.00002 9.5H16C16.5523 9.5 17 9.05229 17 8.5V2C17 1.44772 16.5523 1 16 1H4.00002ZM3.70002 0H10H16.3C16.7774 0 17.2353 0.184374 17.5728 0.512563C17.9104 0.840752 18.1 1.28587 18.1 1.75V8.75C18.1 9.21413 17.9104 9.65925 17.5728 9.98744C17.2353 10.3156 16.7774 10.5 16.3 10.5H3.70002C3.22263 10.5 2.7648 10.3156 2.42723 9.98744C2.08967 9.65925 1.90002 9.21413 1.90002 8.75V1.75C1.90002 1.28587 2.08967 0.840752 2.42723 0.512563C2.7648 0.184374 3.22263 0 3.70002 0Z"
                                                            fill="currentcolor"></path>
                                                        <path d="M1 12L19 12" stroke="currentcolor"
                                                            stroke-linecap="round"></path>
                                                    </svg>
                                                </span>
                                                <span class="megamenu-name">Laptop</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop">Thương
                                                            hiệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-asus-hoc-tap-va-lam-viec">ASUS</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-acer-hoc-tap-va-lam-viec">ACER</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-msi-hoc-tap-va-lam-viec">MSI</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-lenovo-hoc-tap-va-lam-viec">LENOVO</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-dell-hoc-tap-va-lam-viec">DELL</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-hp-pavilion">HP - Pavilion</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-lg-gram">LG - Gram</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop">Giá
                                                            bán</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-hoc-tap-va-lam-viec-duoi-15tr">Dưới
                                                            15 triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-hoc-tap-va-lam-viec-tu-15tr-den-20tr">Từ
                                                            15 đến 20 triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-hoc-tap-va-lam-viec-tren-20-trieu">Trên
                                                            20 triệu</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop">CPU
                                                            Intel - AMD</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-intel-core-i3">Intel Core i3</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-intel-core-i5">Intel Core i5</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-intel-core-i7">Intel Core i7</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-cpu-amd-ryzen">AMD Ryzen</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-4">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop">Nhu
                                                            cầu sử dụng</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-do-hoa">Đồ họa - Studio</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-hoc-sinh-sinh-vien">Học sinh -
                                                            Sinh
                                                            viên</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-mong-nhe-cao-cap">Mỏng nhẹ cao
                                                            cấp</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-5">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/linh-kien-phu-kien-laptop">Linh phụ kiện
                                                            Laptop</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ram-laptop">Ram laptop</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ssd-laptop">SSD laptop</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/o-cung-di-dong-hdd-box">Ổ cứng di
                                                            động</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-6">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop-asus-hoc-tap-va-lam-viec">Laptop
                                                            ASUS</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-asus-oled">ASUS OLED Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-asus-vivobook-series">Vivobook
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-asus-zenbook-series">Zenbook
                                                            Series</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-7">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop-acer-hoc-tap-va-lam-viec">Laptop
                                                            ACER</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-acer-aspire-series">Aspire
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/acer-swift-series">Swift Series</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-8">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop-msi-hoc-tap-va-lam-viec">Laptop
                                                            MSI</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/msi-modern-14-series">Modern Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/prestige-series">Prestige Series</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-9">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop-lenovo-hoc-tap-va-lam-viec">Laptop
                                                            Lenovo</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/lenovo-thinkbook">Thinkbook Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-ideapad-pro">Ideapad Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/lenovo-thinkpad">Thinkpad Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-lenovo-yoga-series">Yoga
                                                            Series</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-10">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop-dell-hoc-tap-va-lam-viec">Laptop
                                                            Dell</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-dell-inspiron-series">Inspiron
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-dell-vostro-series">Vostro
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-dell-latitude-series">Latitude
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-dell-xps-chinh-hang">XPS
                                                            Series</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-11">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop-ai">Laptop
                                                            AI</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>

                                        <li class="megamenu-item mg-2">
                                            <a class="megamenu-link" href="/pages/laptop-gaming">
                                                <span class="megamenu-icon" data-hover="laptop-gaming"><svg
                                                        width="23" height="16" viewBox="0 0 23 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <mask id="path-1-inside-1_5068_8558" fill="white">
                                                            <path
                                                                d="M3.96432 4C3.41203 4 2.96432 4.44772 2.96432 5V11.5C2.96432 12.0523 3.41203 12.5 3.96432 12.5H15.9643C16.5166 12.5 16.9643 12.0523 16.9643 11.5V4H3.96432ZM3.66432 3H9.96432H16.2643C16.7417 3 17.1995 3.18437 17.5371 3.51256C17.8747 3.84075 18.0643 4.28587 18.0643 4.75V11.75C18.0643 12.2141 17.8747 12.6592 17.5371 12.9874C17.1995 13.3156 16.7417 13.5 16.2643 13.5H3.66432C3.18693 13.5 2.72909 13.3156 2.39153 12.9874C2.05396 12.6592 1.86432 12.2141 1.86432 11.75V4.75C1.86432 4.28587 2.05396 3.84075 2.39153 3.51256C2.72909 3.18437 3.18693 3 3.66432 3Z">
                                                            </path>
                                                        </mask>
                                                        <path
                                                            d="M3.96432 4C3.41203 4 2.96432 4.44772 2.96432 5V11.5C2.96432 12.0523 3.41203 12.5 3.96432 12.5H15.9643C16.5166 12.5 16.9643 12.0523 16.9643 11.5V4H3.96432ZM3.66432 3H9.96432H16.2643C16.7417 3 17.1995 3.18437 17.5371 3.51256C17.8747 3.84075 18.0643 4.28587 18.0643 4.75V11.75C18.0643 12.2141 17.8747 12.6592 17.5371 12.9874C17.1995 13.3156 16.7417 13.5 16.2643 13.5H3.66432C3.18693 13.5 2.72909 13.3156 2.39153 12.9874C2.05396 12.6592 1.86432 12.2141 1.86432 11.75V4.75C1.86432 4.28587 2.05396 3.84075 2.39153 3.51256C2.72909 3.18437 3.18693 3 3.66432 3Z"
                                                            fill="currentcolor"></path>
                                                        <path d="M0.964294 15L18.9643 15" stroke="currentcolor"
                                                            stroke-linecap="round"></path>
                                                        <path
                                                            d="M10.9754 1.87868C11.5771 1.31607 12.3931 1 13.244 1H17.8274C18.2487 1 18.6659 1.0776 19.0551 1.22836C19.4444 1.37913 19.7981 1.6001 20.096 1.87868C20.3939 2.15726 20.6303 2.48797 20.7915 2.85195C20.9527 3.21593 21.0357 3.60603 21.0357 4C21.0357 4.39397 20.9527 4.78407 20.7915 5.14805C20.6303 5.51203 20.3939 5.84274 20.096 6.12132C19.7981 6.3999 19.4444 6.62087 19.0551 6.77164C18.6659 6.9224 18.2487 7 17.8274 7H13.244C12.3931 7 11.5771 6.68393 10.9754 6.12132C10.3737 5.55871 10.0357 4.79565 10.0357 4C10.0357 3.20435 10.3737 2.44129 10.9754 1.87868Z"
                                                            fill="white" stroke="white" stroke-width="2"></path>
                                                        <path
                                                            d="M10.9754 1.87868C11.5771 1.31607 12.3931 1 13.244 1H17.8274C18.2487 1 18.6659 1.0776 19.0551 1.22836C19.4444 1.37913 19.7981 1.6001 20.096 1.87868C20.3939 2.15726 20.6303 2.48797 20.7915 2.85195C20.9527 3.21593 21.0357 3.60603 21.0357 4C21.0357 4.39397 20.9527 4.78407 20.7915 5.14805C20.6303 5.51203 20.3939 5.84274 20.096 6.12132C19.7981 6.3999 19.4444 6.62087 19.0551 6.77164C18.6659 6.9224 18.2487 7 17.8274 7H13.244C12.3931 7 11.5771 6.68393 10.9754 6.12132C10.3737 5.55871 10.0357 4.79565 10.0357 4C10.0357 3.20435 10.3737 2.44129 10.9754 1.87868Z"
                                                            stroke="currentcolor"></path>
                                                        <path
                                                            d="M17.625 3.79696C17.5852 3.75567 17.5379 3.72292 17.486 3.70056C17.434 3.67821 17.3782 3.66669 17.322 3.66667C17.2657 3.66665 17.2099 3.67813 17.1579 3.70044C17.1059 3.72276 17.0587 3.75548 17.0189 3.79674C16.9791 3.83799 16.9475 3.88698 16.9259 3.94089C16.9044 3.9948 16.8933 4.05259 16.8932 4.11096C16.8932 4.16932 16.9043 4.22712 16.9258 4.28105C16.9473 4.33498 16.9789 4.38399 17.0187 4.42527C17.099 4.50865 17.208 4.55552 17.3217 4.55556C17.4353 4.5556 17.5443 4.50882 17.6247 4.4255C17.7051 4.34218 17.7503 4.22915 17.7504 4.11127C17.7504 3.9934 17.7053 3.88034 17.625 3.79696Z"
                                                            fill="currentcolor"></path>
                                                        <path
                                                            d="M17.871 2.91345C17.9105 2.87101 17.9578 2.83715 18.0101 2.81385C18.0624 2.79056 18.1186 2.7783 18.1755 2.77779C18.2324 2.77727 18.2888 2.78852 18.3415 2.81087C18.3942 2.83321 18.442 2.86622 18.4823 2.90795C18.5225 2.94968 18.5543 2.9993 18.5759 3.05392C18.5974 3.10854 18.6083 3.16706 18.6078 3.22608C18.6073 3.28509 18.5955 3.34341 18.573 3.39763C18.5505 3.45186 18.5179 3.5009 18.477 3.5419C18.3961 3.62286 18.2879 3.66766 18.1755 3.66664C18.0631 3.66563 17.9556 3.61889 17.8762 3.53648C17.7967 3.45408 17.7516 3.34261 17.7507 3.22608C17.7497 3.10955 17.7929 2.99728 17.871 2.91345Z"
                                                            fill="currentcolor"></path>
                                                        <path
                                                            d="M19.343 3.80236C19.3034 3.75991 19.2561 3.72605 19.2039 3.70275C19.1516 3.67946 19.0953 3.6672 19.0384 3.66669C18.9815 3.66618 18.9251 3.67742 18.8724 3.69977C18.8197 3.72212 18.7719 3.75512 18.7317 3.79685C18.6914 3.83858 18.6596 3.8882 18.638 3.94282C18.6165 3.99744 18.6056 4.05597 18.6061 4.11498C18.6066 4.17399 18.6185 4.23231 18.6409 4.28654C18.6634 4.34076 18.696 4.3898 18.737 4.4308C18.8178 4.51176 18.9261 4.55656 19.0384 4.55554C19.1508 4.55453 19.2583 4.50779 19.3377 4.42539C19.4172 4.34298 19.4623 4.23151 19.4633 4.11498C19.4642 3.99845 19.421 3.88618 19.343 3.80236Z"
                                                            fill="currentcolor"></path>
                                                        <path
                                                            d="M17.8763 4.68562C17.9161 4.64436 17.9634 4.61164 18.0154 4.58933C18.0674 4.56701 18.1231 4.55554 18.1794 4.55556C18.2357 4.55558 18.2914 4.56709 18.3434 4.58945C18.3954 4.6118 18.4426 4.64456 18.4824 4.68584C18.5222 4.72713 18.5537 4.77614 18.5752 4.83007C18.5968 4.884 18.6078 4.94179 18.6078 5.00016C18.6078 5.05852 18.5967 5.11631 18.5751 5.17023C18.5536 5.22414 18.522 5.27313 18.4822 5.31438C18.4018 5.3977 18.2927 5.44449 18.1791 5.44445C18.0654 5.4444 17.9564 5.39754 17.8761 5.31416C17.7957 5.23078 17.7506 5.11772 17.7507 4.99984C17.7507 4.88197 17.7959 4.76894 17.8763 4.68562Z"
                                                            fill="currentcolor"></path>
                                                        <path
                                                            d="M12.6058 4.55555H11.7487V3.66666H12.6058V2.77777H13.463V3.66666H14.3201V4.55555H13.463V5.44444H12.6058V4.55555Z"
                                                            fill="currentcolor"></path>
                                                    </svg></span>
                                                <span class="megamenu-name">Laptop Gaming</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop">Thương
                                                            hiệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-gaming-acer">ACER / PREDATOR</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-gaming-asus">ASUS / ROG</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-msi-gaming">MSI</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-gaming-lenovo">LENOVO</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-gaming-dell">DELL</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-gaming-gigabyte">GIGABYTE /
                                                            AORUS</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-gaming-hp">HP</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop">Giá
                                                            bán</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-gaming-gia-duoi-20-trieu">Dưới 20
                                                            triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-gaming-gia-tu-20-den-25-trieu">Từ
                                                            20 đến 25 triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-gaming-gia-tu-25-den-35-trieu">Từ
                                                            25 đến 30 triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-gaming-tren-35-trieu">Trên 30
                                                            triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-gaming-rtx-50-series">Gaming RTX
                                                            50
                                                            Series</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop-gaming-acer">ACER | PREDATOR</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-acer-nitro-series">Nitro
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-acer-aspire-7">Aspire Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-acer-predator-series">Predator
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-acer-rtx-50-series">ACER RTX 50
                                                            Series</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-4">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop-gaming-asus">ASUS | ROG
                                                            Gaming</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-asus-rog-series">ROG Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-asus-tuf-gaming-series">TUF
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-asus-gaming-zephyrus-series">Zephyrus
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/asus-rtx-50-series">ASUS RTX 50
                                                            Series</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-5">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop-msi-gaming">MSI Gaming</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-msi-gt-series">Titan GT
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-msi-gs-series">Stealth GS
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-msi-ge-series">Raider GE
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-msi-gp-series">Vector GP
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-msi-gl-series">Crosshair / Pulse
                                                            GL
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-msi-sword-katana-series">Sword /
                                                            Katana GF66 Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-msi-gf-series">Cyborg / Thin GF
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-msi-rtx-50-series">MSI RTX 50
                                                            Series</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-6">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop-gaming-lenovo">LENOVO Gaming</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-lenovo-legion">Legion Gaming</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-gaming-lenovo-loq">LOQ series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-lenovo-rtx-50-series">RTX 50
                                                            Series</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-7">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop-gaming-dell">Dell Gaming</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/dell-gaming-g-series">Dell Gaming G
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-alienware">Alienware Series</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-8">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop-gaming-hp">HP Gaming</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-hp-victus">HP Victus</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-hp-omen">Hp Omen</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-9">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/laptop">Cấu
                                                            hình</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-gaming-rtx-50-series">RTX 50
                                                            Series</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-intel-core-ultra">CPU Core
                                                            Ultra</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/laptop-amd-radeon-rx">CPU AMD</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-10">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/linh-kien-phu-kien-laptop/">Linh - Phụ
                                                            kiện Laptop</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ram-laptop">Ram laptop</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ssd-laptop">SSD laptop</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/o-cung-di-dong-hdd-box">Ổ cứng di
                                                            động</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>

                                        <li class="megamenu-item mg-3">
                                            <a class="megamenu-link" href="/pages/pc-gvn">
                                                <span class="megamenu-icon" data-hover="pc-gvn"><svg width="20"
                                                        height="20" viewBox="0 0 20 20" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect x="1" y="19" width="18" height="10"
                                                            rx="1" transform="rotate(-90 1 19)"
                                                            stroke="currentcolor"></rect>
                                                        <path
                                                            d="M13 3H17C18.1046 3 19 3.89543 19 5V13C19 14.1046 18.1046 15 17 15H13"
                                                            stroke="currentcolor"></path>
                                                        <path
                                                            d="M16.5 18.5C16.7761 18.5 17 18.2761 17 18C17 17.7239 16.7761 17.5 16.5 17.5V18.5ZM13 18.5H16.5V17.5H13V18.5Z"
                                                            fill="currentcolor"></path>
                                                        <circle cx="6" cy="5" r="1"
                                                            fill="currentcolor"></circle>
                                                        <circle cx="6" cy="9" r="1"
                                                            fill="currentcolor"></circle>
                                                    </svg></span>
                                                <span class="megamenu-name">PC GVN</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/pc-gvn">KHUYẾN
                                                            MÃI HOT</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn-rtx-5090">PC RTX 5090</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn-rtx-5080">PC RTX 5080</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="https://gearvn.com/collections/pc-gvn-rtx-5070">PC
                                                            RTX
                                                            5070</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn-rtx-5070ti">PC GVN RTX 5070Ti</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/pages/thu-cu-doi-moi">Thu cũ đổi mới VGA</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/pc-gvn">PC
                                                            KHUYẾN MÃI</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/products/pc-gvn-intel-i7k-rtx-4070-ti-super">BTF i7
                                                            -
                                                            4070Ti Super</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/products/pc-gvn-intel-i5-4060">I5 - 4060</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/products/pc-gvn-intel-i5k-4060ti">I5 - 4060Ti</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn?vga=rx6600">PC RX 6600 -
                                                            12TR690</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn?vga=rx6500xt">PC RX 6500 -
                                                            9TR990</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/pc-gvn">PC
                                                            theo cấu hình VGA</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn?vga=rtx3050 ">PC sử dụng VGA
                                                            3050</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn?vga=rtx3060">PC sử dụng VGA
                                                            3060</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn?vga=rx6600">PC sử dụng VGA RX
                                                            6600</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn?vga=rx6500xt">PC sử dụng VGA RX
                                                            6500</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-4">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/pc-gvn">PC
                                                            theo cấu hình VGA</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn?vga=rtx4060,rtx4060ti">PC sử dụng
                                                            VGA 4060</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn?vga=rtx4070,rtx4070super,rtx4070ti,rtx4070tisuper ">PC
                                                            sử dụng VGA 4070</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn">Xem
                                                            tất cả PC GVN</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-5">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/ai-pc-gvn/">A.I PC - GVN</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gearvn-powered-by-asus/">PC GVN X
                                                            ASUS
                                                            - PBA</a>

                                                        <a class="sub-megamenu-item-filter" href="/">PC GVN X
                                                            MSI</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-msi-powered-by-msi">PC MSI - Powered
                                                            by
                                                            MSI</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-6">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/pc-gvn?cpu=athlon,intelcorei3,intelcorei5,intelcorei7,intelcorei9">PC
                                                            theo CPU Intel</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn-i3">PC Core I3</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn-i5">PC Core I5</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn-i7">PC Core I7</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn-i9">PC Core I9</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-7">
                                                        <a class="sub-megamenu-item-name" href="/">PC theo CPU
                                                            Intel</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn-core-ultra-7">PC Ultra 7</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn-ultra-9">PC Ultra 9</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-8">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/pc-gvn?cpu=amdryzen5,amdryzen7,amdryzen9">PC
                                                            theo CPU AMD</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn-r3">PC AMD R3</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn-r5">PC AMD R5</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn-r7">PC AMD R7</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/pc-gvn-r9">PC AMD R9</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-9">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/pc-gvn-homework">PC Văn phòng</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/products/pc-gvn-homework-amd-athlon">Homework Athlon
                                                            -
                                                            Giá chỉ 3.990k</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/products/pc-gvn-homework-amd-r3">Homework R3 - Giá
                                                            chỉ
                                                            5,690k</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/products/pc-gvn-homework-amd-r5">Homework R5 - Giá
                                                            chỉ
                                                            5,690k</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/products/pc-gvn-homework-intel-i5">Homework I5 - Giá
                                                            chỉ 5,690k</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-10">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/phan-mem/">Phần
                                                            mềm bản quyền</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/window">Window
                                                            bản quyền - Chỉ từ 2.990K</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/pages/microsoft-office-365">Office 365 bản quyền -
                                                            Chỉ
                                                            từ 990K</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>

                                        <li class="megamenu-item mg-4">
                                            <a class="megamenu-link" href="#">
                                                <span class="megamenu-icon" data-hover="main-cpu-vga"><svg
                                                        width="20" height="20" viewBox="0 0 20 20"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect x="1" y="19" width="18" height="10"
                                                            rx="1" transform="rotate(-90 1 19)"
                                                            stroke="currentcolor"></rect>
                                                        <path
                                                            d="M13 3H17C18.1046 3 19 3.89543 19 5V13C19 14.1046 18.1046 15 17 15H13"
                                                            stroke="currentcolor"></path>
                                                        <path
                                                            d="M16.5 18.5C16.7761 18.5 17 18.2761 17 18C17 17.7239 16.7761 17.5 16.5 17.5V18.5ZM13 18.5H16.5V17.5H13V18.5Z"
                                                            fill="currentcolor"></path>
                                                        <circle cx="6" cy="5" r="1"
                                                            fill="currentcolor"></circle>
                                                        <circle cx="6" cy="9" r="1"
                                                            fill="currentcolor"></circle>
                                                    </svg></span>
                                                <span class="megamenu-name">Main, CPU, VGA</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/vga-rtx-50-series">VGA RTX 50 SERIES</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/vga-rtx-5090-series">RTX 5090</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/vga-rtx-5080">RTX 5080</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/vga-rtx-5070-ti-series">RTX 5070Ti</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/vga-rtx-5070-series">RTX 5070</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/vga-rtx-5060-ti-series">RTX 5060Ti</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/vga-rtx-5060-series">RTX 5060</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/vga-card-man-hinh">VGA (Trên 12 GB
                                                            VRAM)</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/vga-card-man-hinh?dongvga=rtx4070super">RTX
                                                            4070 SUPER (12GB)</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/vga-rtx-4070-ti-super">RTX 4070Ti SUPER
                                                            (16GB)</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/vga-card-man-hinh?dongvga=rtx4080super">RTX
                                                            4080 SUPER (16GB)</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/vga-card-man-hinh?dongvga=rtx4090">RTX
                                                            4090 SUPER (24GB)</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/vga-card-man-hinh">VGA (Dưới 12 GB
                                                            VRAM)</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/vga-rtx-4060-ti">RTX 4060Ti (8 -
                                                            16GB)</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/vga-rtx-4060">RTX 4060 (8GB)</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/vga-rtx-ampere-3060-12gb">RTX 3060
                                                            (12GB)</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/vga-rtx-ampere-3050">RTX 3050 (6 -
                                                            8GB)</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/vga-gtx-1650-4g">GTX 1650 (4GB)</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/gt-710-gt-1030-gtx-1050-ti">GT 710 / GT
                                                            1030 (2-4GB)</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-4">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/vga-card-man-hinh">VGA - Card màn
                                                            hình</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/nvidia-quadro">NVIDIA Quadro</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/radeon-rx">AMD Radeon</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-5">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/mainboard-bo-mach-chu">Bo mạch chủ
                                                            Intel</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/mainboard-intel-z890">Z890 (Mới)</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/mainboard-intel-z790-raptor-lake">Z790</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/mainboard-intel-b760-raptor-lake">B760</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/mainboard-intel-h610-alder-lake">H610</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/mainboard-x299x-lga2066">X299X</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/mainboard-bo-mach-chu">Xem tất cả</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-6">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/mainboard-bo-mach-chu">Bo mạch chủ
                                                            AMD</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/mainboard-amd-x870">AMD X870 (Mới)</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/mainboard-amd-x670">AMD X670</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/mainboard-ryzen-x570">AMD X570</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/mainboard-amd-b650">AMD B650 (Mới)</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/main-amd-ryzen-b550-socket-am4">AMD
                                                            B550</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/main-amd-ryzen-a320-socket-am4">AMD
                                                            A320</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/main-amd-ryzen-trx40-socket-str4">AMD
                                                            TRX40</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-7">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/cpu-bo-vi-xu-ly?hang=intel">CPU - Bộ vi
                                                            xử
                                                            lý Intel</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/cpu-intel-core-ultra-series-2">CPU Intel
                                                            Core Ultra Series 2 (Mới)</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/cpu-intel-core-i9">CPU Intel 9</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/cpu-intel-core-i7">CPU Intel 7</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/cpu-intel-core-i5">CPU Intel 5</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/cpu-intel-core-i3">CPU Intel 3</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-8">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/cpu-bo-vi-xu-ly?hang=amd">CPU - Bộ vi xử
                                                            lý AMD</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/cpu-bo-vi-xu-ly?dongcpu=athlon">CPU AMD
                                                            Athlon</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/cpu-bo-vi-xu-ly?dongcpu=amdryzen3">CPU
                                                            AMD
                                                            R3</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/cpu-bo-vi-xu-ly?dongcpu=amdryzen5">CPU
                                                            AMD
                                                            R5</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/cpu-bo-vi-xu-ly?dongcpu=amdryzen7">CPU
                                                            AMD
                                                            R7</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/cpu-bo-vi-xu-ly?dongcpu=amdryzen9">CPU
                                                            AMD
                                                            R9</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>

                                        <li class="megamenu-item mg-5">
                                            <a class="megamenu-link" href="#">
                                                <span class="megamenu-icon" data-hover="case-nguon-tan"><svg
                                                        width="20" height="20" viewBox="0 0 20 20"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect x="1" y="19" width="18" height="10"
                                                            rx="1" transform="rotate(-90 1 19)"
                                                            stroke="currentcolor"></rect>
                                                        <path
                                                            d="M13 3H17C18.1046 3 19 3.89543 19 5V13C19 14.1046 18.1046 15 17 15H13"
                                                            stroke="currentcolor"></path>
                                                        <path
                                                            d="M16.5 18.5C16.7761 18.5 17 18.2761 17 18C17 17.7239 16.7761 17.5 16.5 17.5V18.5ZM13 18.5H16.5V17.5H13V18.5Z"
                                                            fill="currentcolor"></path>
                                                        <circle cx="6" cy="5" r="1"
                                                            fill="currentcolor"></circle>
                                                        <circle cx="6" cy="9" r="1"
                                                            fill="currentcolor"></circle>
                                                    </svg></span>
                                                <span class="megamenu-name">Case, Nguồn, Tản</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/case-thung-may-tinh">Case - Theo
                                                            hãng</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/case-asus">Case ASUS</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/case-corsair">Case Corsair</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/case-lian-li">Case Lianli</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/case-nzxt">Case NZXT</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/case-in-win">Case Inwin</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/case-thung-may-tinh?hang=thermaltake">Case
                                                            Thermaltake</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/case-thung-may-tinh">Xem tất cả</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/case-thung-may-tinh">Case - Theo
                                                            giá</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/case-duoi-1-trieu">Dưới 1 triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/case-tu-1-trieu-den-2-trieu">Từ 1
                                                            triệu
                                                            đến 2 triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/case-tren-2-trieu">Trên 2 triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/case-thung-may-tinh">Xem tất cả</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/psu-nguon-may-tinh">Nguồn - Theo
                                                            Hãng</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/nguon-may-tinh-asus">Nguồn ASUS</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/psu-nguon-may-tinh?hang=deepcool">Nguồ̀n
                                                            DeepCool</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/psu-nguon-may-tinh?hang=corsair">Nguồn
                                                            Corsair</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/psu-nguon-may-tinh?hang=nzxt">Nguồn
                                                            NZXT</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/psu-nguon-may-tinh?hang=msi">Nguồn
                                                            MSI</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/psu-nguon-may-tinh">Xem tất cả</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-4">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/psu-nguon-may-tinh">Nguồn - Theo công
                                                            suất</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/400-500w">Từ 400w - 500w</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/500-600w">Từ 500w - 600w</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/700w-800w">Từ 700w - 800w</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tren-1000w">Trên 1000w</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/psu-nguon-may-tinh">Xem tất cả</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-5">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/phu-kien-may-tinh">Phụ kiện PC</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/phu-kien-may-tinh?loaisanpham=dayledganpc">Dây
                                                            LED</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/phu-kien-may-tinh?loaisanpham=dayriserdungvga">Dây
                                                            rise - Dựng VGA</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/phu-kien-may-tinh?loaisanpham=giadovga">Giá
                                                            đỡ VGA</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/phu-kien-may-tinh?loaisanpham=keotannhiet">Keo
                                                            tản nhiệt</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/phu-kien-may-tinh">Xem tất cả</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-6">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/tan-nhiet-may-tinh">Loại tản
                                                            nhiệt</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tan-nhiet-nuoc-240mm">Tản nhiệt AIO
                                                            240mm</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tan-nhiet-nuoc-280mm">Tản nhiệt AIO
                                                            280mm</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tan-nhiet-nuoc-360mm">Tản nhiệt AIO
                                                            360mm</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tan-nhiet-nuoc-420mm">Tản nhiệt AIO
                                                            420mm</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tan-nhiet-khi">Tản nhiệt khí</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/fan-rgb-tan-nhiet-pc">Fan RGB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/fan-rgb-tan-nhiet-pc">Xem tất cả</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>

                                        <li class="megamenu-item mg-6">
                                            <a class="megamenu-link" href="#">
                                                <span class="megamenu-icon" data-hover="o-cung-ram-the-nho"><svg
                                                        width="20" height="14" viewBox="0 0 20 14"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M18 1C18.5523 1 19 1.44772 19 2L19 3.5C19 3.5 17.5 3.75127 17.5 5.5C17.5 7.24873 19 7.5 19 7.5L19 9C19 9.55229 18.5523 10 18 10L2 10C1.44772 10 1 9.55228 1 9L1 7.5C1 7.5 2.5 7.27709 2.5 5.5C2.5 3.72291 1 3.5 1 3.5L1 2C1 1.44771 1.44772 0.999999 2 0.999999L18 1Z"
                                                            stroke="currentColor"></path>
                                                        <path
                                                            d="M3 10H17V12C17 12.5523 16.5523 13 16 13H4C3.44772 13 3 12.5523 3 12V10Z"
                                                            stroke="currentColor"></path>
                                                        <rect x="5" y="3" width="1" height="5"
                                                            fill="currentColor"></rect>
                                                        <rect x="5" y="10" width="1" height="3"
                                                            fill="currentColor"></rect>
                                                        <rect x="8" y="10" width="1" height="3"
                                                            fill="currentColor"></rect>
                                                        <rect x="11" y="10" width="1" height="3"
                                                            fill="currentColor"></rect>
                                                        <rect x="14" y="10" width="1" height="3"
                                                            fill="currentColor"></rect>
                                                        <rect x="9.5" y="3" width="1" height="5"
                                                            fill="currentColor"></rect>
                                                        <rect x="14" y="3" width="1" height="5"
                                                            fill="currentColor"></rect>
                                                    </svg></span>
                                                <span class="megamenu-name">Ổ cứng, RAM, Thẻ nhớ</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/ram-pc">Dung
                                                            lượng RAM</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ddr4-8gb">8 GB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ddr4-16g">16 GB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ram-pc?dungluong=32gb2x16gb">32 GB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ram-pc?dungluong=64gb2x32gb">64 GB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ram-pc">Xem
                                                            tất cả</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/ram-pc">Loại
                                                            RAM</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ram-ddr4">DDR4</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ram-pc-ddr5">DDR5</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ram-pc">Xem
                                                            tất cả</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/ram-pc">Hãng
                                                            RAM</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ram-pc?hang=corsair">Corsair</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ram-pc?hang=kingston">Kingston</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ram-pc?hang=gskill">G.Skill</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ram-pc?hang=pny">PNY</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ram-pc">Xem
                                                            tất cả</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-4">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/hdd-o-cung-pc">Dung lượng HDD</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/hdd-1tb">HDD
                                                            1 TB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/hdd-2tb">HDD
                                                            2 TB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/hdd-6tb">HDD
                                                            4 TB - 6 TB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/hdd-8tb">HDD
                                                            trên 8 TB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/hdd-o-cung-pc">Xem tất cả</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-5">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/hdd-o-cung-pc">Hãng HDD</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/hdd-o-cung-pc?hang=westerndigital">WesterDigital</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/hdd-o-cung-pc?hang=seagate">Seagate</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/hdd-o-cung-pc?hang=toshiba">Toshiba</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/hdd-o-cung-pc">Xem tất cả</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-6">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/ssd-o-cung-the-ran">Dung lượng SSD</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ssd-o-cung-the-ran?dungluong=120128gb">120GB
                                                            - 128GB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ssd-o-cung-the-ran?dungluong=240256gb">250GB
                                                            - 256GB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ssd-o-cung-the-ran?dungluong=480512gb">480GB
                                                            - 512GB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ssd-o-cung-the-ran?dungluong=9601tb">960GB
                                                            - 1TB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ssd-o-cung-the-ran?dungluong=2tb">2TB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ssd-o-cung-the-ran?dungluong=tren2tb">Trên
                                                            2TB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ssd-o-cung-the-ran">Xem tất cả</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-7">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/ssd-o-cung-the-ran">Hãng SSD</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ssd-o-cung-the-ran?hang=samsung">Samsung</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ssd-o-cung-the-ran?hang=westerndigital">Wester
                                                            Digital</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ssd-o-cung-the-ran?hang=kingston">Kingston</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ssd-o-cung-the-ran?hang=corsair">Corsair</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ssd-o-cung-the-ran?hang=pny">PNY</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ssd-o-cung-the-ran">Xem tất cả</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-8">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/the-nho">Thẻ
                                                            nhớ / USB</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/the-nho-usb-sandisk">Sandisk</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-9">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/o-cung-di-dong-hdd-box">Ổ cứng di
                                                            động</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>

                                        <li class="megamenu-item mg-7">
                                            <a class="megamenu-link" href="#">
                                                <span class="megamenu-icon" data-hover="loa-micro-webcam"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M17.437 21.938H6.56201C5.89897 21.938 5.26309 21.6746 4.79424 21.2058C4.3254 20.7369 4.06201 20.101 4.06201 19.438V4.562C4.06201 3.89895 4.3254 3.26307 4.79424 2.79423C5.26309 2.32539 5.89897 2.062 6.56201 2.062H17.437C18.1001 2.062 18.7359 2.32539 19.2048 2.79423C19.6736 3.26307 19.937 3.89895 19.937 4.562V19.438C19.937 20.101 19.6736 20.7369 19.2048 21.2058C18.7359 21.6746 18.1001 21.938 17.437 21.938ZM6.56201 3.062C6.16419 3.062 5.78266 3.22003 5.50135 3.50134C5.22005 3.78264 5.06201 4.16417 5.06201 4.562V19.438C5.06201 19.8358 5.22005 20.2174 5.50135 20.4987C5.78266 20.78 6.16419 20.938 6.56201 20.938H17.437C17.8348 20.938 18.2164 20.78 18.4977 20.4987C18.779 20.2174 18.937 19.8358 18.937 19.438V4.562C18.937 4.16417 18.779 3.78264 18.4977 3.50134C18.2164 3.22003 17.8348 3.062 17.437 3.062H6.56201Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M12 18.939C11.2583 18.939 10.5333 18.7191 9.91661 18.307C9.29993 17.895 8.81928 17.3093 8.53545 16.6241C8.25163 15.9388 8.17736 15.1848 8.32206 14.4574C8.46675 13.73 8.8239 13.0618 9.34835 12.5374C9.8728 12.0129 10.541 11.6558 11.2684 11.5111C11.9958 11.3664 12.7498 11.4406 13.4351 11.7245C14.1203 12.0083 14.706 12.4889 15.118 13.1056C15.5301 13.7223 15.75 14.4473 15.75 15.189C15.7487 16.1832 15.3532 17.1362 14.6502 17.8392C13.9472 18.5422 12.9942 18.9377 12 18.939ZM12 12.439C11.4561 12.439 10.9244 12.6003 10.4722 12.9025C10.0199 13.2046 9.66747 13.6341 9.45933 14.1366C9.25119 14.6391 9.19673 15.1921 9.30284 15.7255C9.40895 16.259 9.67086 16.749 10.0555 17.1335C10.4401 17.5181 10.9301 17.7801 11.4635 17.8862C11.997 17.9923 12.5499 17.9378 13.0524 17.7297C13.5549 17.5215 13.9844 17.1691 14.2865 16.7168C14.5887 16.2646 14.75 15.7329 14.75 15.189C14.7495 14.4598 14.4596 13.7607 13.944 13.245C13.4283 12.7294 12.7292 12.4395 12 12.439ZM12 9.563C11.555 9.563 11.12 9.43104 10.75 9.18381C10.38 8.93658 10.0916 8.58518 9.92127 8.17404C9.75098 7.76291 9.70642 7.31051 9.79323 6.87405C9.88005 6.43759 10.0943 6.03668 10.409 5.72201C10.7237 5.40735 11.1246 5.19305 11.561 5.10624C11.9975 5.01942 12.4499 5.06398 12.861 5.23428C13.2722 5.40457 13.6236 5.69296 13.8708 6.06297C14.118 6.43298 14.25 6.868 14.25 7.313C14.2492 7.9095 14.0119 8.48133 13.5901 8.90312C13.1683 9.3249 12.5965 9.56221 12 9.563ZM12 6.063C11.7528 6.063 11.5111 6.13632 11.3055 6.27367C11.1 6.41102 10.9398 6.60624 10.8452 6.83465C10.7505 7.06306 10.7258 7.31439 10.774 7.55687C10.8223 7.79934 10.9413 8.02207 11.1161 8.19689C11.2909 8.3717 11.5137 8.49075 11.7561 8.53899C11.9986 8.58722 12.2499 8.56246 12.4784 8.46785C12.7068 8.37324 12.902 8.21303 13.0393 8.00747C13.1767 7.80191 13.25 7.56023 13.25 7.313C13.2497 6.98157 13.118 6.66378 12.8836 6.42941C12.6492 6.19505 12.3314 6.06327 12 6.063Z"
                                                            fill="currentColor"></path>
                                                    </svg></span>
                                                <span class="megamenu-name">Loa, Micro, Webcam</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/loa">Thương
                                                            hiệu loa</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/loa-edifier">Edifier</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/loa?hang=razer">Razer</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/loa?hang=logitech">Logitech</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/loa?hang=soundmax">SoundMax</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name" href="/collections/loa">Kiểu
                                                            Loa</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/loa?loaisanpham=loavitinh">Loa vi
                                                            tính</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/loa?bluetooth=co">Loa Bluetooth</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/loa?loaisanpham=loasoundbar">Loa
                                                            Soundbar</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/loa?loaisanpham=loamini">Loa mini</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/loa?loaisanpham=loasub">Sub phụ (Loa
                                                            trầm)</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/webcam">Webcam</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/webcam-4k">Độ phân giải 4k</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/webcam-1080p ">Độ phân giải Full HD
                                                            (1080p)</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/webcam-720p">Độ phân giải 720p</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-4">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/microphone">Microphone</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/microphone?hang=hyperx">Micro HyperX</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>

                                        <li class="megamenu-item mg-8">
                                            <a class="megamenu-link" href="/pages/man-hinh">
                                                <span class="megamenu-icon" data-hover="man-hinh"><svg width="18"
                                                        height="16" viewBox="0 0 18 16" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M2 1.03226C1.44772 1.03226 1 1.47997 1 2.03226V10.3548C1 10.9071 1.44772 11.3548 2 11.3548H16C16.5523 11.3548 17 10.9071 17 10.3548V2.03226C17 1.47997 16.5523 1.03226 16 1.03226H2ZM2 0H16C16.5304 0 17.0391 0.217511 17.4142 0.604683C17.7893 0.991854 18 1.51697 18 2.06452V10.3226C18 10.8701 17.7893 11.3952 17.4142 11.7824C17.0391 12.1696 16.5304 12.3871 16 12.3871H2C1.46957 12.3871 0.960859 12.1696 0.585786 11.7824C0.210714 11.3952 0 10.8701 0 10.3226V2.06452C0 1.51697 0.210714 0.991854 0.585786 0.604683C0.960859 0.217511 1.46957 0 2 0Z"
                                                            fill="currentcolor"></path>
                                                        <rect x="8" y="11.871" width="2" height="4.12903"
                                                            fill="currentcolor"></rect>
                                                        <path d="M5 15.4839L13 15.4839" stroke="currentcolor"
                                                            stroke-linecap="round"></path>
                                                    </svg></span>
                                                <span class="megamenu-name">Màn hình</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name" href="/pages/man-hinh">Hãng
                                                            sản xuất</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/monitor-lg">LG</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-asus">Asus</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-viewsonic">ViewSonic</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-dell">Dell</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-gigabyte">Gigabyte</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-aoc">AOC</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-acer">Acer</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/hkc">HKC</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/pages/man-hinh">Hãng
                                                            sản xuất</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-msi">MSI</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-lenovo">Lenovo</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-samsung">Samsung</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-philips">Philips</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-e-dra/">E-Dra</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-dahua">Dahua</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name" href="/pages/man-hinh">Giá
                                                            tiền</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-duoi-5-trieu">Dưới 5 triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-tu-5-den-10-trieu">Từ 5 triệu
                                                            đến
                                                            10 triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-tu-10-den-20-trieu">Từ 10
                                                            triệu
                                                            đến 20 triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-tu-20-trieu-den-30-trieu">Từ
                                                            20
                                                            triệu đến 30 triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-tren-30-trieu">Trên 30
                                                            triệu</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-4">
                                                        <a class="sub-megamenu-item-name" href="/pages/man-hinh">Độ
                                                            Phân
                                                            giải</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/do-phan-giai-full-hd-1080p">Màn hình
                                                            Full
                                                            HD</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/do-phan-giai-2k-1440p">Màn hình 2K
                                                            1440p</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-may-tinh-4k-uhd">Màn hình 4K
                                                            UHD</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-may-tinh-6k">Màn hình 6K</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-5">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/man-hinh-144hz">Tần số quét</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-60hz">60Hz</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-75hz">75Hz</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-100hz">100Hz</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-144hz">144Hz</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-240hz">240Hz</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-6">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/man-hinh-cong">Màn hình cong</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/24-curve">24" Curved</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/27-curve">27" Curved</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/32-curve">32" Curved</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tren-32-curve">Trên 32" Curved</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-7">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/pages/man-hinh">Kích
                                                            thước</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-22-inch">Màn hình 22"</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-24-inch">Màn hình 24"</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-27-inch">Màn hình 27"</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-29">Màn hình 29"</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-32">Màn hình 32"</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-tren-32">Màn hình Trên 32"</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-co-chuan-vesa-treo-tuong">Hỗ
                                                            trợ
                                                            giá treo (VESA)</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-8">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/man-hinh-do-hoa">Màn hình đồ họa</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-do-hoa-24-inch">Màn hình đồ
                                                            họa
                                                            24"</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-do-hoa-27-inch">Màn hình đồ
                                                            họa
                                                            27"</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-do-hoa-32-inch">Màn hình đồ
                                                            họa
                                                            32"</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-9">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/phu-kien-man-hinh">Phụ kiện màn
                                                            hình</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/gia-treo-man-hinh">Giá treo màn
                                                            hình</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/phu-kien-day-cap-hdmi-dp-lan-usbc">Phụ
                                                            kiện dây HDMI,DP,LAN</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-10">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/man-hinh-di-dong">Màn hình di động</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-di-dong-do-phan-giai-full-hd-1080p">Full
                                                            HD 1080p</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-di-dong-do-phan-giai-2k-1440p">2K
                                                            1440p</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/man-hinh-di-dong-co-cam-ung">Có cảm
                                                            ứng</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-11">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/man-hinh-oled">Màn hình Oled</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>

                                        <li class="megamenu-item mg-9">
                                            <a class="megamenu-link" href="/collections/ban-phim-may-tinh">
                                                <span class="megamenu-icon" data-hover="ban-phim"><svg
                                                        width="20" height="14" viewBox="0 0 20 14"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect x="1" y="1" width="18" height="12"
                                                            rx="1" stroke="currentcolor"></rect>
                                                        <rect x="4" y="8" width="7" height="2"
                                                            fill="currentcolor"></rect>
                                                        <rect x="4" y="4" width="2" height="2"
                                                            fill="currentcolor"></rect>
                                                        <rect x="9" y="4" width="2" height="2"
                                                            fill="currentcolor"></rect>
                                                        <rect x="14" y="4" width="2" height="2"
                                                            fill="currentcolor"></rect>
                                                        <rect x="14" y="8" width="2" height="2"
                                                            fill="currentcolor"></rect>
                                                    </svg></span>
                                                <span class="megamenu-name">Bàn phím</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/ban-phim-may-tinh">Thương hiệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-akko">AKKO</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-aula">AULA</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-dare-u">Dare-U</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-ikbc-durgod">Durgod</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-leobog">Leobog</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-co-fl-esports">FL-Esports</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-choi-game-corsair">Corsair</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-e-dra">E-Dra</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-cidoo">Cidoo</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-machenike">Machenike</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/ban-phim-may-tinh">Thương hiệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-asus">ASUS</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-logitech">Logitech</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-choi-game-razer">Razer</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-leopold">Leopold</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-steelseries">Steelseries</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-rapoo">Rapoo</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-vgn">VGN</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/ban-phim-co">Giá tiền</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-duoi-1-trieu">Dưới 1 triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-1-den-2-trieu">1 triệu - 2
                                                            triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-2-den-3-trieu">2 triệu - 3
                                                            triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-tu-3-den-4-trieu">3 triệu - 4
                                                            triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-tren-4-trieu">Trên 4 triệu</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-4">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/ban-phim-co">Kết nối</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-bluetooth">Bluetooth</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-phim-wireless">Wireless</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-5">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/keycaps">Phụ
                                                            kiện bàn phím cơ</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/keycaps">Keycaps</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/keycap-dwarf-factory">Dwarf Factory</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ke-tay">Kê
                                                            tay</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>

                                        <li class="megamenu-item mg-10">
                                            <a class="megamenu-link" href="/collections/chuot-may-tinh">
                                                <span class="megamenu-icon" data-hover="chuot-lot-chuot"><svg
                                                        version="1.1" id="Layer_1"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                        viewBox="0 0 14 20" width="18" height="20"
                                                        xml:space="preserve">
                                                        <style type="text/css">
                                                            .st0 {
                                                                fill: currentcolor;
                                                            }
                                                        </style>
                                                        <path class="st0" d="M7,19.5L7,19.5c-3.6,0-6.5-3.1-6.5-6.8V7.3c0-3.7,2.9-6.8,6.5-6.8c3.6,0,6.5,3.1,6.5,6.8v5.4
 C13.5,16.4,10.6,19.5,7,19.5z M7,1.5C4,1.5,1.5,4.1,1.5,7.3v5.4c0,3.2,2.5,5.8,5.5,5.8h0c3,0,5.5-2.6,5.5-5.8V7.3
 C12.5,4.1,10,1.5,7,1.5z"></path>
                                                        <path class="st0"
                                                            d="M7,10L7,10c-0.3,0-0.5-0.2-0.5-0.5v-5C6.5,4.2,6.7,4,7,4h0c0.3,0,0.5,0.2,0.5,0.5v5C7.5,9.8,7.3,10,7,10z">
                                                        </path>
                                                    </svg></span>
                                                <span class="megamenu-name">Chuột + Lót chuột</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/chuot-may-tinh">Thương hiệu chuột</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-logitech">Logitech</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-razer">Razer</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-corsair">Corsair</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-pulsar">Pulsar</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-microsoft">Microsoft</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-dare-u">Dare U</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/chuot-may-tinh">Thương hiệu chuột</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-asus">ASUS</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-steelseries">Steelseries</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-glorious">Glorious</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-rapoo">Rapoo</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/chuot-may-tinh">Chuột theo giá tiền</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-duoi-500-nghin">Dưới 500
                                                            nghìn</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-500-nghin-den-1-trieu">Từ 500
                                                            nghìn
                                                            - 1 triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-1-den-2-trieu">Từ 1 triệu - 2
                                                            triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-2-den-3-trieu">Trên 2 triệu - 3
                                                            triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-tren-3-trieu">Trên 3 triệu</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-4">
                                                        <a class="sub-megamenu-item-name" href="#">Loại
                                                            Chuột</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-may-tinh/">Chuột chơi game</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-van-phong/">Chuột văn phòng</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-5">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/chuot-logitech">Logitech</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-logitech-gaming">Logitech
                                                            Gaming</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/chuot-logitech-van-phong">Logitech Văn
                                                            phòng</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-6">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/mouse-pad">Thương
                                                            hiệu lót chuột</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/mouse-pad?hang=gearvn">GEARVN</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/lot-chuot-asus">ASUS</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/lot-chuot-steelseries">Steelseries</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/lot-chuot-dare-u">Dare-U</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/lot-chuot-razer">Razer</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-7">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/mouse-pad">Các
                                                            loại lót chuột</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/lot-chuot-mem">Mềm</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/lot-chuot-cung">Cứng</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/lot-chuot-day">Dày</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/lot-chuot-mong">Mỏng</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/lot-chuot-co-led">Viền có led</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-8">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/mouse-pad">Lót
                                                            chuột theo size</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/lot-chuot-kich-thuoc-nho">Nhỏ</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/lot-chuot-kich-thuoc-vua">Vừa</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/lot-chuot-kich-thuoc-lon">Lớn</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>

                                        <li class="megamenu-item mg-11">
                                            <a class="megamenu-link" href="/collections/tai-nghe-may-tinh">
                                                <span class="megamenu-icon" data-hover="tai-nghe"><svg
                                                        width="20" height="18" viewBox="0 0 20 18"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M2.12753 12.7623C2.35 9.44444 4.96063 9 6.0625 9H6.90625C7.37225 9 7.75 9.38375 7.75 9.85714V16.1429C7.75 16.6162 7.37225 17 6.90625 17H6.0625C3.93277 17 2.19823 15.2822 2.12753 13.1362L1.62188 12.8794C1.43501 12.7844 1.27785 12.6385 1.16801 12.458C1.05817 12.2774 0.999997 12.0694 1 11.8571V10.1429C1 5.08914 5.02609 1 10 1C14.9748 1 19 5.09003 19 10.1429V11.8571C19 12.0694 18.9418 12.2774 18.832 12.458C18.7221 12.6385 18.565 12.7844 18.3781 12.8794L17.8725 13.1362C17.8018 15.2822 16.0672 17 13.9375 17H13.0938C12.6278 17 12.25 16.6162 12.25 16.1429V9.85714C12.25 9.38375 12.6278 9 13.0938 9H13.9375C17.65 9 17.8725 11.6667 17.8725 12.7623"
                                                            stroke="currentcolor"></path>
                                                    </svg></span>
                                                <span class="megamenu-name">Tai Nghe</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/tai-nghe-may-tinh">Thương hiệu tai
                                                            nghe</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-asus">ASUS</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-hyperx">HyperX</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-corsair">Corsair</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-razer">Razer</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/tai-nghe-may-tinh">Thương hiệu tai
                                                            nghe</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-steelseries">Steelseries</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-rapoo">Rapoo</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-logitech">Logitech</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-edifier">Edifier</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/tai-nghe-may-tinh">Tai nghe theo
                                                            giá</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-duoi-1-trieu">Tai nghe dưới 1
                                                            triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-1-trieu-den-2-trieu">Tai nghe
                                                            1
                                                            triệu đến 2 triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-2-den-3-trieu">Tai nghe 2 đến
                                                            3
                                                            triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-3-den-4-trieu">Tai nghe 3 đến
                                                            4
                                                            triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-tren-4-trieu">Tai nghe trên 4
                                                            triệu</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-4">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/tai-nghe-may-tinh">Kiểu kết nối</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-wireless">Tai nghe
                                                            Wireless</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-gaming-bluetooth">Tai nghe
                                                            Bluetooth</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-5">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/tai-nghe-may-tinh">Kiểu tai nghe</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-over-ear">Tai nghe
                                                            Over-ear</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tai-nghe-gaming-in-ear">Tai nghe Gaming
                                                            In-ear</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>

                                        <li class="megamenu-item mg-12">
                                            <a class="megamenu-link" href="/collections/ghe-gia-tot/">
                                                <span class="megamenu-icon" data-hover="ghe-ban"><svg
                                                        width="16" height="21" viewBox="0 0 16 21"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M3.42375 13.6057H12.5762" stroke="currentcolor">
                                                        </path>
                                                        <path
                                                            d="M3.4238 10.5999V14.6879C3.4238 15.2402 3.87151 15.6879 4.4238 15.6879H11.5763C12.1286 15.6879 12.5763 15.2402 12.5763 14.6879V10.6C12.5763 9.85202 12.3071 9.12907 11.8179 8.56331C11.706 8.43393 11.6913 8.24664 11.7753 8.09763C12.0408 7.62651 12.5763 6.57918 12.5763 5.79604C12.5763 5.02711 11.5738 3.90031 11.0494 3.36352C10.8544 3.16391 10.7346 2.89476 10.637 2.63335C10.545 2.38712 10.3694 2.04387 10.034 1.631C9.32994 0.76449 6.3573 0.815216 5.80972 1.63104C5.544 2.02692 5.40722 2.37444 5.33682 2.62732C5.26197 2.89614 5.14568 3.16391 4.95069 3.36352C4.42631 3.90031 3.4238 5.02711 3.4238 5.79604C3.4238 6.57918 3.95929 7.62651 4.22477 8.09764C4.30873 8.24664 4.29406 8.43393 4.18219 8.56331C3.693 9.12907 3.4238 9.85201 3.4238 10.5999Z"
                                                            stroke="currentcolor"></path>
                                                        <path
                                                            d="M12.6666 14.6291H13.7406C14.2929 14.6291 14.7406 14.1814 14.7406 13.6291V11.4437"
                                                            stroke="currentcolor"></path>
                                                        <path
                                                            d="M3.33347 14.6291H2.25942C1.70713 14.6291 1.25942 14.1814 1.25942 13.6291V11.4437"
                                                            stroke="currentcolor"></path>
                                                        <path d="M15.7777 11.4437H13.7036" stroke="currentcolor">
                                                        </path>
                                                        <path d="M2.29638 11.4437H0.222336" stroke="currentcolor">
                                                        </path>
                                                        <path d="M8.00002 15.6906V18.876" stroke="currentcolor">
                                                        </path>
                                                        <rect x="3.31494" y="18.3146" width="2.11107"
                                                            height="2.18544" rx="1.05554" stroke="currentcolor">
                                                        </rect>
                                                        <rect x="10.5741" y="18.3146" width="2.11107"
                                                            height="2.18544" rx="1.05554" stroke="currentcolor">
                                                        </rect>
                                                        <path d="M4.37036 18.3452H11.6295" stroke="currentcolor">
                                                        </path>
                                                    </svg></span>
                                                <span class="megamenu-name">Ghế - Bàn</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/pages/ghe-gaming-gia-re-gearvn">Thương hiệu ghế
                                                            Gaming</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ghe-corsair">Corsair</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ghe-warrior">Warrior</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ghe-e-dra">E-DRA</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ghe-dxracer">DXRacer</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/cougar-chair">Cougar</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/akracing">AKRaing</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/ghe-cong-thai-hoc">Thương hiệu ghế
                                                            CTH</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ghe-cong-thai-hoc-warrior/">Warrior</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ghe-sihoo">Sihoo</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ghe-e-dra">E-Dra</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/pages/ghe-gaming-gia-re-gearvn">Kiểu ghế</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ghe-cong-thai-hoc">Ghế Công thái
                                                            học</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ghe-gaming">Ghế Gaming</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-4">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/ban-gaming">Bàn Gaming</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-dxracer">Bàn Gaming DXRacer</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-gaming-e-dra">Bàn Gaming E-Dra</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-warrior">Bàn Gaming Warrior</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-5">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/ban-cong-thai-hoc">Bàn công thái
                                                            học</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ban-cth-warrior">Bàn CTH Warrior</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/phu-kien-trang-tri">Phụ kiện bàn
                                                            ghế</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-6">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/pages/ghe-gaming-gia-re-gearvn">Giá tiền</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ghe-duoi-5-trieu">Dưới 5 triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ghe-gaming-tu-5-10-trieu">Từ 5 đến 10
                                                            triệu</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/ghe-tren-10-trieu">Trên 10 triệu</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>

                                        <li class="megamenu-item mg-13">
                                            <a class="megamenu-link" href="/collections/thiet-bi-mang">
                                                <span class="megamenu-icon" data-hover="phan-mem-mang"><svg
                                                        width="18" height="19" viewBox="0 0 18 19"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M4 16H3.5C1.84315 16 0.5 14.6569 0.5 13V7C0.5 5.34315 1.84315 4 3.5 4H14.5C16.1569 4 17.5 5.34315 17.5 7V13C17.5 14.6569 16.1569 16 14.5 16H14"
                                                            stroke="currentcolor" stroke-linecap="round"></path>
                                                        <path
                                                            d="M14.5 4V3C14.5 1.89543 13.6046 1 12.5 1H5.5C4.39543 1 3.5 1.89543 3.5 3L3.5 4"
                                                            stroke="currentcolor" stroke-linecap="round"></path>
                                                        <rect x="4" y="12.5" width="10" height="6"
                                                            rx="1.5" stroke="currentcolor"></rect>
                                                        <path d="M2.5 7L5.5 7" stroke="currentcolor"
                                                            stroke-linecap="round"></path>
                                                    </svg></span>
                                                <span class="megamenu-name">Phần mềm, mạng</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/thiet-bi-mang">Hãng sản xuất</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/asus">Asus</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/linksys">LinkSys</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tp-link">TP-LINK</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/mercusys">Mercusys</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/thiet-bi-phat-wifi">Router Wi-Fi</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/router-gaming">Gaming</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/router-pho-thong">Phổ thông</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/router-xuyen-tuong">Xuyên tường</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/router-mesh-pack">Router Mesh Pack</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/router-wifi-5">Router WiFi 5</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/router-ax-wifi-6">Router WiFi 6</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/usb-card-mang">USB Thu sóng - Card
                                                            mạng</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/usb-wifi">Usb WiFi</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/card-mang-wifi">Card WiFi</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/day-cap-mang-lan">Dây cáp mạng</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-4">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/pages/microsoft-office-365">Microsoft Office</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/pages/microsoft-office-365">Microsoft Office
                                                            365</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/office-home-2024">Office Home 2024</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-5">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/window">Microsoft
                                                            Windows</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/products/phan-mem-windows-11-home-online-dwnld-nr-kw9-00664">Windows
                                                            11 Home</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/products/phan-mem-windows-11-pro-online-dwnld-nr-fqc-10572">Windows
                                                            11 Pro</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>

                                        <li class="megamenu-item mg-14">
                                            <a class="megamenu-link" href="/collections/may-choi-game">
                                                <span class="megamenu-icon" data-hover="handheld-console"><svg
                                                        width="20" height="14" viewBox="0 0 20 14"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M4 6H8.90909M6.5 3.5V8.3M10 1C12.0438 1.0352 13.2776 1 14.0909 1C15.7273 1 17.3636 1.4 18.1818 4.2C19 7 19 8.6 19 10.6C19 12.6 17.3636 13 15.7273 13C14.0909 13 13.2285 9.8 10 9.8C6.77145 9.8 5.90909 13 4.27273 13C2.63636 13 1 12.6 1 10.6C1 8.6 1 7 1.81818 4.2C2.63636 1.4 4.27273 1 5.90909 1C6.72236 1 7.95618 1.0352 10 1Z"
                                                            stroke="currentcolor"></path>
                                                        <circle cx="13" cy="5" r="1"
                                                            fill="currentcolor"></circle>
                                                        <circle cx="15" cy="7" r="1"
                                                            fill="currentcolor"></circle>
                                                    </svg></span>
                                                <span class="megamenu-name">Handheld, Console</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/may-choi-game">Handheld PC</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/may-choi-game-cam-tay-asus">Rog
                                                            Ally</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/products/may-choi-game-msi-claw-a1m">MSI Claw</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/products/may-choi-game-cam-tay-lenovo-legion-go">Legion
                                                            Go</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/tay-cam-vo-lang">Tay cầm</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tay-cam-msi//collections/tay-cam-ps4">Tay
                                                            cầm Playstation</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tay-cam-choi-game/?hang=rapoo">Tay cầm
                                                            Rapoo</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tay-cam-choi-game/?hang=dareu">Tay cầm
                                                            DareU</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tay-cam-vo-lang">Xem tất cả</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/tay-cam-vo-lang">Vô lăng lái xe, máy
                                                            bay</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-4">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/sony-playstation">Sony Playstation</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/sony-playstation-5">Sony PS5 (Máy)
                                                            chính
                                                            hãng</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/tay-cam-choi-game">Tay cầm chính
                                                            hãng</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>

                                        <li class="megamenu-item mg-15">
                                            <a class="megamenu-link" href="/collections/phu-kien">
                                                <span class="megamenu-icon" data-hover="phu-kien-hub-sac-cap"><svg
                                                        width="20" height="14" viewBox="0 0 20 14"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M4 6H8.90909M6.5 3.5V8.3M10 1C12.0438 1.0352 13.2776 1 14.0909 1C15.7273 1 17.3636 1.4 18.1818 4.2C19 7 19 8.6 19 10.6C19 12.6 17.3636 13 15.7273 13C14.0909 13 13.2285 9.8 10 9.8C6.77145 9.8 5.90909 13 4.27273 13C2.63636 13 1 12.6 1 10.6C1 8.6 1 7 1.81818 4.2C2.63636 1.4 4.27273 1 5.90909 1C6.72236 1 7.95618 1.0352 10 1Z"
                                                            stroke="currentcolor"></path>
                                                        <circle cx="13" cy="5" r="1"
                                                            fill="currentcolor"></circle>
                                                        <circle cx="15" cy="7" r="1"
                                                            fill="currentcolor"></circle>
                                                    </svg></span>
                                                <span class="megamenu-name">Phụ kiện (Hub, sạc, cáp..)</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/phu-kien">Hub,
                                                            sạc, cáp</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/phu-kien/?loaisanpham=hubcongchuyen">Hub
                                                            chuyển đổi</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/phu-kien/?loaisanpham=capsac">Dây
                                                            cáp</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/phu-kien/?loaisanpham=sac">Củ sạc</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/quat-cam-tay-quat-mini">Quạt cầm tay,
                                                            Quạt
                                                            mini</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/collections/quat-jisulife">Jisulife</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/collections/phu-kien-elgato">Phụ kiện Elgato</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>

                                        <li class="megamenu-item mg-16">
                                            <a class="megamenu-link" href="/">
                                                <span class="megamenu-icon"
                                                    data-hover="dich-vu-va-thong-tin-khac"><svg width="18"
                                                        height="20" viewBox="0 0 18 20" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9 3.5V6M9 3.5C9 3.00555 9.14662 2.5222 9.42133 2.11108C9.69603 1.69995 10.0865 1.37952 10.5433 1.1903C11.0001 1.00108 11.5028 0.951575 11.9877 1.04804C12.4727 1.1445 12.9181 1.3826 13.2678 1.73223C13.6174 2.08187 13.8555 2.52732 13.952 3.01228C14.0484 3.49723 13.9989 3.99989 13.8097 4.45671C13.6205 4.91352 13.3 5.30397 12.8889 5.57867C12.4778 5.85338 11.9945 6 11.5 6H9M9 3.5C9 3.00555 8.85338 2.5222 8.57867 2.11108C8.30397 1.69995 7.91352 1.37952 7.45671 1.1903C6.99989 1.00108 6.49723 0.951575 6.01227 1.04804C5.52732 1.1445 5.08187 1.3826 4.73223 1.73223C4.3826 2.08187 4.1445 2.52732 4.04804 3.01228C3.95157 3.49723 4.00108 3.99989 4.1903 4.45671C4.37952 4.91352 4.69995 5.30397 5.11108 5.57867C5.5222 5.85338 6.00555 6 6.5 6H9"
                                                            stroke="currentcolor" stroke-miterlimit="10"
                                                            stroke-linecap="round"></path>
                                                        <path
                                                            d="M15.6667 6H2.33333C1.59695 6 1 6.63959 1 7.42857V9.57143C1 10.3604 1.59695 11 2.33333 11H15.6667C16.403 11 17 10.3604 17 9.57143V7.42857C17 6.63959 16.403 6 15.6667 6Z"
                                                            stroke="currentcolor" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                        <path
                                                            d="M16 10.7895V16.9474C16 17.4918 15.7788 18.0139 15.3849 18.3988C14.9911 18.7837 14.457 19 13.9 19H4.1C3.54305 19 3.0089 18.7837 2.61508 18.3988C2.22125 18.0139 2 17.4918 2 16.9474V10.7895M9 6V19"
                                                            stroke="currentcolor" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg></span>
                                                <span class="megamenu-name">Dịch vụ và thông tin khác</span>
                                                <span class="megamenu-ic-right">
                                                    <svg viewBox="0 0 6 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 1.5L4.5 4L1.5 6.5" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="megamenu-content absolute-center level0 xlab_grid_container">
                                                <div class="column xlab_column_5_5">

                                                    <div class="sub-megamenu-item smg-1">
                                                        <a class="sub-megamenu-item-name" href="/">Dịch vụ</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/pages/gearvn-vs-ald-service">Dịch vụ kỹ thuật tại
                                                            nhà</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/pages/dich-vu-sua-chua-gearvn-nese">Dịch vụ sửa
                                                            chữa</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-2">
                                                        <a class="sub-megamenu-item-name" href="/">Chính
                                                            sách</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/pages/gearvn-chinh-sach-bang-gia-thu-vga-qua-su-dung">Chính
                                                            sách &amp; bảng giá thu VGA qua sử dụng</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/pages/bao-hanh">Chính
                                                            sách bảo hành</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/pages/chinh-sach-giao-hang">Chính sách giao
                                                            hàng</a>

                                                        <a class="sub-megamenu-item-filter"
                                                            href="/pages/chinh-sach-doi-tra">Chính sách đổi trả</a>

                                                    </div>

                                                    <div class="sub-megamenu-item smg-3">
                                                        <a class="sub-megamenu-item-name"
                                                            href="/pages/build-pc">Build
                                                            PC</a>

                                                    </div>

                                                </div>

                                            </div>
                                        </li>
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
                                            d="M22.7 19.3l-6.6-6.6c.6-1.1 1-2.3 1-3.7 0-4.4-3.6-8-8-8-1.4 0-2.6.4-3.7 1l4.5 4.5-3 3-4.5-4.5c-.6 1.1-1 2.3-1 3.7 0 4.4 3.6 8 8 8 1.4 0 2.6-.4 3.7-1l6.6 6.6c.4.4 1 .4 1.4 0l1.3-1.3c.4-.4.4-1 0-1.4z" />
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
                                    {{--					<span class="txtbl">nhập</span> --}}
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
                                {{-- <div class="block block--3">
                                    <ul>
                                        <li><a href="/pages/faq" class="thing">
                                                <div class="thing-img">
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10 0C4.47305 0 0 4.47266 0 10C0 15.5273 4.47266 20 10 20C15.5273 20 20 15.5273 20 10C20 4.47266 15.5273 0 10 0ZM10 18.6047C5.25547 18.6047 1.39531 14.7445 1.39531 10C1.39531 5.25547 5.25547 1.39531 10 1.39531C14.7445 1.39531 18.6047 5.25547 18.6047 10C18.6047 14.7445 14.7445 18.6047 10 18.6047Z"
                                                              fill="black"></path>
                                                        <path d="M9.7045 12.6531C9.43777 12.656 9.18298 12.7641 8.99561 12.954C8.80824 13.1438 8.70347 13.4 8.7041 13.6667C8.7041 14.2066 9.13809 14.6804 9.7045 14.6804C9.96247 14.6644 10.2046 14.5506 10.3816 14.3623C10.5586 14.1739 10.6572 13.9252 10.6572 13.6667C10.6572 13.4083 10.5586 13.1595 10.3816 12.9712C10.2046 12.7829 9.96247 12.6691 9.7045 12.6531Z"
                                                              fill="black"></path>
                                                        <path d="M9.87519 4.97937C8.09824 4.97937 7.28223 6.03406 7.28223 6.74304C7.28223 7.25671 7.7166 7.49343 8.07207 7.49343C8.783 7.49343 8.49316 6.47781 9.83574 6.47781C10.4939 6.47781 11.0205 6.76765 11.0205 7.37312C11.0205 8.08406 10.2834 8.49187 9.84863 8.86062C9.46699 9.18953 8.9666 9.72937 8.9666 10.8614C8.9666 11.5458 9.15097 11.743 9.69081 11.743C10.3357 11.743 10.4674 11.4536 10.4674 11.2036C10.4674 10.5188 10.4803 10.1243 11.2045 9.55828C11.5599 9.28171 12.6787 8.3864 12.6787 7.14929C12.6787 5.91218 11.5603 4.97937 9.87519 4.97937Z"
                                                              fill="black"></path>
                                                    </svg>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <div class="thing-name">Trợ giúp</div>
                                                </div>
                                            </a></li>
                                    </ul>
                                </div> --}}
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
        $(document).ready(function() {
            const minlength = 2
            const delay = 500;
            $('.input-search-global').keyup(function() {
                clearTimeout(timer);
                var that = this,
                    value = $(this).val();

                if (value.length <= minlength) {
                    $('.searchResult').hide();
                    $('.ajaxSearchResults').hide();
                }

                timer = setTimeout(function() {
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

            const cateHeaderButton = $('#main-header-cate-btn');
            const cateHeaderList = $('.header-action_text .banner-home-left');

            // Handle show button cate when scroll behind
            $(window).scroll(function() {
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
                cateHeaderButton.hover(function() {
                    cateHeaderList.fadeIn()
                }, function() {
                    cateHeaderList.fadeOut()
                });
            }
        })
    </script>
@endpush
