<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title')</title>
    <meta name="revisit-after" content="1 days">
    <meta name="rating" content="general">
    <meta property="og:type" content="article" />
    <meta property="fb:admins" content=""/>
    <meta property="fb:app_id" content="" />
    <meta name="twitter:card" content="summary" />
    <meta name="facebook-domain-verification" content="v1ihepcict7dat54xhl08gtx93isue" />
    {!! meta()->toHtml() !!}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fonts/font.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.theme.default.css') }}">
    <link rel="stylesheet" href="{{ asset('css/demo.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.32/sweetalert2.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bk.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/loginPopup.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/rightSideButton.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}">

    @stack('css')
    <?php echo $mainSettings['script_header']; ?>
</head>

<body>
<div class="page-body-buong">
    <?php echo $mainSettings['script_body']; ?>

    @include('front_end.partials.header')
    <!-- end header -->

    <div id="main" class="wrapper">
        @yield('content')
    </div>

    @include('front_end.partials.footer')
    <div class="holine-footer">
        <div class="holine-footer1">
            <span class="title-holine">Holine</span>
            <span class="holine-phone">{{ $mainSettings['contact_hotline'] }}</span>
        </div>
    </div>
    <div id="btn-top">
        <button><i class="fa fa-chevron-up"></i></button>
{{--        <img src="{{ asset('images/back-to-top-icon.jpg') }}" alt="">--}}
    </div>

    @include('front_end.partials.banner')

</div>

@stack('footer')
<!-- div end site -->
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/wow.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/owl.carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/BannerFloat.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.32/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.10/jquery.lazy.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.10/jquery.lazy.plugins.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
<script src="{{ asset('js/hc-offcanvas-nav.js?ver=3.3.0') }}"></script>
<script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/swiper-bundle.min.js') }}"></script>

<script>
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#btn-top').stop().show().fadeIn(200);
            } else {
                $('#btn-top').stop().fadeOut(200);
            }
        });

        initTippyForProductImages();

        $('#btn-top').on('click', function (e) {
            e.preventDefault()
            $('html, body').animate({scrollTop: 0}, 'fast')
            return false
        })

        $(document).on('click', '.attr-checkbox-filter', function () {
            if ( $(this).data('build') == true) {
                return;
            }

            let categoryId   = $(this).data('category') ?? null;

            filterProduct(categoryId);
        });

        $(document).on('change', '#select_sort', function (e){
            e.preventDefault();
            let categoryID = $(this).find(':selected').data('cateid');
            let column = $(this).find(':selected').data('column');
            let sort = $(this).find(':selected').data('sort');

            filterProduct(categoryID, column, sort, true);
        })

        $('.ajax-addtocart').on('click', function (e) {
            e.preventDefault()
            let id = $(this).data('id');
            let configType = $(this).data('config');
            let hasConfig = $(this).data('checkconfig');
            let needCheckOut = $('#needCheckOut').val();
            const buyNowFlag = $(this).data('buynow');

            if(needCheckOut == 1) {
                Swal.fire({
                    position         : 'top',
                    icon             : 'info',
                    title            : 'Bạn cần thanh toán cấu hình đã đặt trước đó',
                    showConfirmButton: false,
                    timer            : 1300
                })
                return;
            }

            if (typeof configType  === 'undefined' || configType == null) {
                configType = 'original';
            }

            addOneProductToCart(id, configType, hasConfig);

            setTimeout(function (){
                if (buyNowFlag !== undefined) {
                    window.location.href = window.location.origin + "/gio-hang";
                } else {
                    location.reload()
                }
            }, 2000)
        })
    });

    function addOneProductToCart(productId, configType = 'original', hasConfig = 0) {
        $.ajax({
            url    : "{{ route('fe.cart.add') }}",
            type   : 'POST',
            data   : {
                productId  : productId,
                configType : configType,
                _token     : '{{ csrf_token() }}'
            },
            success: function (data) {
                $('.js-cart-count ').html(data);
                if (hasConfig == 1) {
                   $('.ajax-addtocart').prop('disabled', true);
                   $('.radio_config').prop('disabled', true);
                   $('.label-config').css("opacity", "0.5");

                   $('#needCheckOut').val(1);
                }
                Swal.fire({
                    position         : 'top',
                    icon             : 'success',
                    title            : 'Thêm vào giỏ hàng thành công',
                    showConfirmButton: false,
                    timer            : 1500
                })
            }
        })
    }

    function checkMobile() {
        var isMobile = false;
        if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
            || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
            isMobile = true;
        }

        return isMobile;
    }

    function filterProduct(categoryId = null, columnSort = null, currentSort = null, isOnlySort = false) {
        let selectedSort = $('.selected-sort');
        let search       = '{{ request()->get('q') ?? null }}'
        let arrAttribute = [];

        let checkbox     = $(".is-pc .attr-checkbox-filter");
        if(checkMobile()) {
            checkbox     = $(".is-mobile .attr-checkbox-filter");
            selectedSort = $('#select_sort').find(":selected");
        }
        checkbox.each(function (index, item) {
            if ($(item).is(":checked")) {
                arrAttribute.push($(item).val());
            }
        });

        if(columnSort == null && currentSort == null) {
            columnSort  = selectedSort.data('column');
            currentSort = selectedSort.data('sort');
        }


        if(categoryId == null) {
            categoryId = selectedSort.data('cateid');
        }

        if (arrAttribute.length == 0 && !isOnlySort) {
            location.reload();
        }

        arrAttribute = JSON.stringify(arrAttribute);
        if (isOnlySort) {
            if (localStorage.getItem("filter_array_attribute") === null) {
                arrAttribute = localStorage.getItem("filter_array_attribute");
            }



            if(categoryId == null) {
                categoryId = localStorage.getItem("filter_category_id");
            }
        }

        $.ajax({
            url    : '{{ route('fe.category.filter.new') }}',
            type   : 'GET',
            data   : ({
                id             : categoryId,
                array_attribute: arrAttribute,
                q              : search,
                column         : columnSort,
                sortFilter     : currentSort
            }),
            success: function (result) {
                $('.product-catalogue-product').html(result)
                localStorage.setItem("filter_array_attribute", arrAttribute);
                localStorage.setItem("filter_category_id", categoryId);
                initTippyForProductImages();
            },
            error  : function (error) {

            }
        });
    }

    // Tooltip for product items
    function initTippyForProductImages() {
        $('.item-product .image').each(function () {
            const image = $(this);

            if (this._tippy) return;

            const tooltip = image.closest('.item-product').find('.tooltip-wrapper');

            tippy(this, {
                content: tooltip.html(),
                allowHTML: true,
                followCursor: true,
                placement: 'right',
                theme: 'default',
                trigger: 'mouseenter focus',
                arrow: false,
                maxWidth: 'none',
            });
        });
    }
</script>
<script>
    $(function ($){
        $("img.lazy").Lazy({
            effect: 'fadeIn',

        });
    })
</script>
<script>
    //hieu ung wow------------------------------------------
    wow = new WOW({
        animateClass: 'animated',
        offset: 100,
        callback: function(box) {
            console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
        }
    });
    wow.init();
</script>
@stack('script')

@include('front_end.partials.login-popup')


@if(!empty($mainSettings['footer']))
    {!! $mainSettings['footer'] !!}
@endif
</body>
</html>
