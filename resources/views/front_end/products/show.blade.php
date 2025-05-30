@extends('front_end.layouts.app')
@if(!empty($mainSettings['seo_schema']))
    @section('seo_schema')
        {!! $mainSettings['seo_schema'] !!}
    @endsection
@endif
@section('page-title', $product->name)

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/detailProduct.css') }}">
    <link rel="stylesheet" href="https://pc.baokim.vn/css/bk.css">
@endpush

@section('content')
    <input type="hidden" data-view_count="{{ $product->view_count}}" data-id="{{ $product->id}}"
           class="view_count_data">
    <div id="main" class="wrapper main-product main-product-detail">
        <div class="bres">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-edit-4 pd-pc-15">
                        <ul>
                            <li><a href="{{ route('fe.home') }}">Trang chủ</a>/</li>
                            <li>{{ \App\Models\ProductCategory::where('id', $product->product_category_id)->get()->first()->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <section class="main-content">
            <div class="container">
                <div class="inner-page-detail" style="background: #fff">
                    <div class="row">
                        <div class="col-md-9 col-sm-12 col-xs-12">
                            <div class="nav-main-content">
                                <div class="content-product">
                                    <div class="content-detail-product">
                                        <div class="row">
                                            <div class="col-lg-12 col-12">
                                                <div class="title-page-detail">
                                                    <h1 class="name-product bk-product-name">{{ $product->name }}</h1>
                                                </div>
                                            </div>
                                            <div style="display: none">
                                                <img class="bk-product-image"
                                                     src="{{ get_image_url($product->feature_img, "") }}">
                                            </div>
                                            <input type="hidden" value="1" class="bk-product-qty">
                                            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                                                <div class="slider">
                                                    <div class="slider__flex flex flex-wrap justify-between">
                                                        <div class="slider__images pl-0 md:pl-[20px]">
                                                            <div class="slider__image" id="zoom">
                                                                <img src="{{ get_image_url($product->feature_img, '') }}"
                                                                     style="height: 300px;width: 100%;object-fit: contain">
                                                            </div>
                                                        </div>
                                                        <div class="slider__col">
                                                            <div class="slider__prev">
                                                                <i class="fa fa-angle-left"></i>
                                                            </div>
                                                            @php
                                                                $images[0] = $product->feature_img;
                                                                foreach ($product->productMedias as $key => $img){
                                                                    $images[$key + 1] = $img->url;
                                                                }
                                                            @endphp
                                                            <div class="slider__thumbs md:h-[520px]">
                                                                <div class="swiper-container">
                                                                    <div class="swiper-wrapper">
                                                                        @for($i = 0; $i < count($images); $i++)
                                                                            <div
                                                                                class="swiper-slide swiper-slide-{{ $i + 1 }}"
                                                                                style="border: 1px solid #dddddd">
                                                                                <div
                                                                                    class="slider__image slider__image_select"
                                                                                    data-image="{{ $images[$i] }}">
                                                                                    <img
                                                                                        src="{{ get_image_url($images[$i], '') }}"
                                                                                        style="height: 60px;width: 100%;object-fit: border">
                                                                                </div>
                                                                            </div>
                                                                        @endfor
                                                                    </div>
                                                                    <span class="swiper-notification"
                                                                          aria-live="assertive"
                                                                          aria-atomic="true">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="slider__next">
                                                                <i class="fa fa-angle-right"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                                                <div class="nav-img-detail">
                                                    <div class="pd-info-rating d-flex flex-wrap"
                                                         style="align-items: center;margin-bottom: 10px; display:flex">
                                                        <p> Đánh giá:
                                                            <a href="javascript:void(0)">
                                                            <span class="write-review__stars">
                                                                <i class="fa fa-star-o rating-color"></i>
                                                                <i class="fa fa-star-o rating-color"></i>
                                                                <i class="fa fa-star-o rating-color"></i>
                                                                <i class="fa fa-star-o rating-color"></i>
                                                                <i class="fa fa-star-o rating-color"></i>
                                                            </span>
                                                                <span class="blue-2">{{ $product->rate_count }}</span>
                                                            </a>
                                                        </p>
                                                        <p>
                                                            Bình luận: <span class="blue-2">0</span>
                                                        </p>
                                                        <p>Lượt xem: <span
                                                                class="blue-2">{{ $product->view_count }}</span>
                                                        </p>
                                                    </div>
                                                    <form action="#" method="post">
                                                        <div class="pd-price-group">
                                                        <span class="pd-price">
                                                            @if(!empty($product->sale_price))
                                                                {{ number_format($product->sale_price,0,'.',',') }}đ
                                                            @else
                                                                {{  number_format($product->price,0,'.',',') }}đ
                                                            @endif
                                                        </span>
                                                            @if(!empty($product->sale_price))
                                                                <del class="pd-old-price">
                                                                    {{ number_format($product->price,0,'.',',') }} đ
                                                                </del>
                                                                <span class="pd-price-off">Tiết kiệm {{ number_format((int)$product->price - (int)$product->sale_price,0,'.',',') }} đ</span>
                                                            @endif
                                                        </div>

                                                        <div class="p-short-description">
                                                            {!! $product->description !!}
                                                        </div>
                                                        <a href="javascript:" class="viewmoretskt"
                                                           data-content="#js-tskt-item">Xem thêm <i
                                                                class="far fa-angle-down"></i></a>

                                                        <br>
                                                        <div style="clear: both;"></div>

                                                        @include('front_end.products.element.config')

                                                        @if(!empty($htmlGift))
                                                            <div class="pd-offer-group">
                                                                <p class="title"><i class="fa-solid fa-gift">&nbsp</i>
                                                                    Quà tặng và ưu đãi kèm theo
                                                                </p>
                                                                <div class="pd-offer-list">
                                                                    <p>
                                                                        {!! $htmlGift !!}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 20px">
                                                            <div class="buy-now-btn col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <a href="{{ route("fe.cart") }}"
                                                                   class="action-button ajax-addtocart"
                                                                   data-id="{{ $product->id }}"
                                                                   data-config="original"
                                                                   data-checkConfig="{{ checkHasConfig($product->config) ? 1 : 0 }}"
                                                                   data-buyNow="1"
                                                                >
                                                                    Đặt mua ngay
                                                                </a>
                                                            </div>
                                                            <div class="buy-item col-md-6 col-sm-6 col-xs-6 col-lg-6" style="cursor: pointer">
                                                                <a class="action-button">Trả góp</a>
                                                            </div>
                                                            <div class="buy-item col-md-6 col-sm-6 col-xs-6 col-lg-6">
                                                                <a href="javascript:void(0)"
                                                                   class="action-button ajax-addtocart"
                                                                   data-id="{{ $product->id }}"
                                                                   data-config="original"
                                                                   data-checkConfig="{{ checkHasConfig($product->config) ? 1 : 0 }}"
                                                                >Thêm vào giỏ hàng</a>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="needCheckOut" id="needCheckOut"
                                                               value="{{ checkNeedCheckOut($product) ? 1 : 0 }}">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            @include('front_end.partials.content-right', ['contacts' => $contacts])
                        </div>
                    </div>
                    <div class="row row-col row-mobile" style="margin-top: 30px">
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <div class="nav-main-content wow fadeInUp">
                                <div class="content-product">
                                    <div class="content-detail-product">
                                        <div class="product-tabs" style="margin-top: 0px">
                                            <div class="tab-content clearfix">

                                                <div class="content-box" id="2a">
                                                    <h3 style="margin-top: 0px">Đặc điểm nổi bật</h3>
                                                    <div class="content-dac-diem">
                                                        {!! $product->outstanding_features !!}
                                                    </div>
                                                    <div class="viewmore-area">
                                                        <a href="javascript:void(0)" class="viewmore"
                                                           id="viewmore-dd-nb">Xem thêm <i
                                                                class="far fa-angle-down"></i></a>
                                                    </div>
                                                </div>
                                                <div class="content-box" id="5a">
                                                    <div class="form-cmt form-group">
                                                        <h2 class="h2-title" style="font-weight: bold;font-size: 20px">
                                                            Đánh giá bình luận</h2>
                                                        <form id="rateform"
                                                              action=""
                                                              method="post">
                                                            <div id="notification">
                                                                <div
                                                                    class="callout callout-success comment-success uk-margin-bottom hidden"
                                                                    style="background:#53A653;padding:8px;color:#fff;margin-bottom:10px">
                                                                    Gửi bình luận thành công
                                                                </div>
                                                                <div id="error-full_name"
                                                                     class="callout callout-success comment-fail uk-margin-bottom hidden"
                                                                     style="background:#AB5858;padding:8px;color:#fff;margin-bottom:10px">
                                                                </div>
                                                                <div id="error-email"
                                                                     class="callout callout-success comment-fail uk-margin-bottom hidden"
                                                                     style="background:#AB5858;padding:8px;color:#fff;margin-bottom:10px">
                                                                </div>
                                                                <div id="error-body"
                                                                     class="callout callout-success comment-fail uk-margin-bottom hidden"
                                                                     style="background:#AB5858;padding:8px;color:#fff;margin-bottom:10px">
                                                                </div>
                                                            </div>
                                                            <div class="write-review__stars">
                                                                <input
                                                                    type="hidden" class="rating-disabled" value="5"
                                                                    name="rating">
                                                            </div>
                                                            <div class="form-group row d-flex">
                                                                <div class="col-md-6 col-sm-6 col-xs-12 wp-input-form">
                                                                    <input type="text" name="fullname" id="rate-name"
                                                                           class="form-control"
                                                                           value="{{ auth()->user()->name ?? null }}"
                                                                           placeholder="Họ và tên">
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 col-xs-12 wp-input-form">
                                                                    <input type="text" name="email" id="rate-email"
                                                                           class="form-control"
                                                                           value="{{ auth()->user()->email ?? null }}"
                                                                           placeholder="Email">
                                                                </div>
                                                            </div>
                                                            <textarea name="message" id="rate-content" rows="4"
                                                                      class="form-control form-group"
                                                                      placeholder="Bình luận"></textarea>
                                                            <button type="button" class="btn btn-comment">Bình
                                                                luận
                                                            </button>
                                                        </form>
                                                        <br>
                                                        <div class="wp-cmt-kh form-group comment-list">
                                                            <div class="wp-item-cmt padding-15 border1 po-re">
                                                                @foreach($customerReview as $comment)
                                                                    <div class="hoi">
                                                                        <div class="top-cmt">
                                                                            <div class="img-avt"><img
                                                                                    src="{{ asset('images/avatar.jpg') }}">
                                                                            </div>
                                                                            <div class="text-cmt-top"><p class="p1">
                                                                                    <b>{{ $comment->full_name }}</b>
                                                                                    ({{ $comment->created_at }})
                                                                                    đã bình luận:</p>
                                                                                <p class="p2"><a
                                                                                        href="javascript:void(0)">
                                                                                            <span
                                                                                                class="write-review__stars">
                                                                                                @for($i = 1;$i <= $comment->rating;$i++)
                                                                                                    <i class="fa fa-star rating-color"></i>
                                                                                                @endfor
                                                                                                @for($i = 1;$i <= 5 - $comment->rating;$i++)
                                                                                                    <i class="fa fa-star-o rating-color"></i>
                                                                                                @endfor
                                                                                            </span>
                                                                                    </a></p>
                                                                                <div class="post-cmt"
                                                                                     style="margin-bottom:30px">
                                                                                    <p>{!! $comment->body !!}</p></div>
                                                                                {{--                                                                                <div class="amenu uk-flex uk-flex-middle lib-grid-20">--}}
                                                                                {{--                                                                                <span class="item-reply" data-id="5"><i--}}
                                                                                {{--                                                                                            class="fa fa-reply"></i> Trả lời</span>--}}
                                                                                {{--                                                                                </div>--}}
                                                                                {{--                                                                                <div class="reply-comment"></div>--}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="ajax-pagination"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="sidebar wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                                <div class="content-box content-box-tskt">
                                    <h3 style="margin-top: 0px">Thông số kỹ thuật</h3>
                                    <div class="content-thong-so-2">
                                        {!! $product->technical_specification !!}
                                    </div>
                                </div>
                                <div class="readmore">
                                    <button type="button" class="btn btn-lg" data-toggle="modal"
                                            data-target="#myModal">Xem đầy đủ thông số kỹ thuật <i
                                            class="far fa-angle-down"></i>
                                    </button>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                            <div class="tlqcontent" style="max-height: 500px;overflow: scroll">
                                                {!! $product->technical_specification !!}
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                @include('front_end.partials.newpost_sidebar', ['newestPost' => $newestPost])
                            </div>
                        </div>
                    </div>
                    @include('front_end.partials.related_and_viewed_product', ['similarProducts' => $similarProducts, 'recentlyViewed' => $recentlyViewed ?? []])
                </div>
            </div>
        </section>
    </div>
    <div style="display: none">
        <?php
        if (isset($var) && is_array($var) && count($var)) { ?>

            <?php
            $price_final = 0; ?>
            <?php
        if (!empty($product->price) && !empty($product->sale_price)) {
            $price_final = $product->sale_price; ?>
        <span class="price-no-sale bk-product-price"><?php
                                                         echo number_format($product->sale_price) ?></span>
        <span class="price-sale"><?php
                                     echo number_format($product->price) ?></span>
            <?php
        } elseif (empty($product->price)) { ?>
        <span class="price-no-sale">Liên hệ</span>
            <?php
        } elseif (!empty($product->price)) {
            $price_final = $product->price ?>
        <span class="price-no-sale bk-product-price"><?php
                                                         echo number_format($product->price) ?></span>
            <?php
        } ?>
            <?php
        } else { ?>
        <span id="ProductPrice" class="h2 ProductPrice  bk-product-price" itemprop="price" style="display: none">
                                                        <?php
                if ($product->sale_price > 0) {
                    echo number_format($product->sale_price);
                } elseif ($product->sale_price == 0 && $product->price > 0) {
                    echo number_format($product->price);
                } elseif ($product->sale_price == 0 && $product->price == 0) {
                    echo 'Liên hệ';
                } ?>

    </span>

            <?php
        } ?>


        @if(isset($var) && is_array($var) && count($var))
            @php($price_final = 0)
            @if(!empty($product->price) && !empty($product->sale_price))
                @php($price_final = $product->sale_price)
                <span class="price-no-sale bk-product-price"><?php
                                                                 echo number_format($product->sale_price) ?></span>
                <span class="price-sale"><?php
                                             echo number_format($product->price) ?></span>
            @elseif(empty($product->price))
                <span class="price-no-sale">Liên hệ</span>
            @elseif(!empty($product->price))
                @php($price_final = $product->price)
                <span class="price-no-sale bk-product-price"><?php
                                                                 echo number_format($product->price) ?></span>
            @endif
        @else
            <span id="ProductPrice" class="h2 ProductPrice  bk-product-price" itemprop="price" style="display: none">
                @if($product->sale_price > 0)
                    {{ number_format($product->sale_price) }}
                @elseif($product->sale_price == 0 && $product->price > 0)
                    {{ number_format($product->price) }}
                @elseif($product->sale_price == 0 && $product->price == 0)
                    Liên hệ
                @endif
            </span>
        @endif
    </div>
    <div id='bk-modal'></div>
@endsection

@push('footer')
    @if(!empty($mainSettings['is_popup']) && $mainSettings['is_popup']==1 && !empty($mainSettings['popup']))
        <!-- Modal -->
        <div class="modal fade" id="notifyModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="notifyModalCenterTitle"
             aria-hidden="true" data-time="2">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! $mainSettings['popup'] !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
    @endif
@endpush

@push('script')
    <script src="https://pc.baokim.vn/js/bk_plus_v2.popup.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rating/1.5.0/bootstrap-rating.min.js"
            integrity="sha512-lkR6W+b0KWeWiHHK7LH3gf1/Qh4r5vF7xzWnH3GQXFIcdxpg4jcw/JsKIab1rKmTecsJgEAcZZAEf/ei1MiPFw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $("input.rating-disabled").rating({
            filled: 'fa fa-star rating-color',
            empty: 'fa fa-star-o'
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rating/1.5.0/bootstrap-rating.min.js"
            integrity="sha512-lkR6W+b0KWeWiHHK7LH3gf1/Qh4r5vF7xzWnH3GQXFIcdxpg4jcw/JsKIab1rKmTecsJgEAcZZAEf/ei1MiPFw=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function () {
            let viewCount = $('.view_count_data').data('view_count');
            let id = $('.view_count_data').data('id');

            setTimeout(() => {
                $.ajax({
                    type: "POST",
                    url: "{{ route('fe.product.viewCount') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        view_count: viewCount,
                    },
                    success: function (response) {
                        console.log('counted');
                    }
                });
            }, 5000);
        })

        $(document).on('click', '.slider__image_select', function (e) {
            var urlImg = $(this).attr('data-image')
            $('#zoom img').attr('src', urlImg)
        })

        $(document).on('click', '.btn-comment', function (e) {
            $('.comment-success').addClass('hidden')
            $('.comment-fail').addClass('hidden');

            var fullname = $('#rate-name').val();
            var email = $('#rate-email').val();
            var contents = $('#rate-content').val();
            var star = $('input[name="rating"]').val();
            var prodId = $('.view_count_data').data('id');

            $.ajax({
                type: "POST",
                url: '{{ route('fe.product.rateProduct') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: prodId,
                    body: contents,
                    full_name: fullname,
                    email: email,
                    rating: star,
                },
                success: function (response) {
                    $('.comment-success').removeClass('hidden')
                },
                error: function (xhr) {
                    $.each(xhr.responseJSON.errors, function (prop, val) {
                        $('#error-' + prop).removeClass('hidden');
                        $('#error-' + prop).html(val);
                    });
                }
            });
        })
    </script>

    <script>
        $("input.rating-disabled").rating({
            filled: 'fa fa-star rating-color',
            empty: 'fa fa-star-o'
        });
    </script>
    <script>
        const sliderThumbs = new Swiper(".slider__thumbs .swiper-container", {

            direction: "vertical",
            slidesPerView: 4,
            spaceBetween: 10,
            hashNavigation: {
                watchState: true,
            },
            navigation: {
                nextEl: ".slider__next",
                prevEl: ".slider__prev",
            },
            freeMode: true,
            breakpoints: {
                0: {
                    direction: "horizontal",
                    slidesPerView: 3,
                },
                768: {
                    direction: "horizontal",
                    slidesPerView: 4,
                },
            },
        });
        const sliderImages = new Swiper(".slider__images .swiper-container", {
            direction: "horizontal",
            slidesPerView: 1,
            spaceBetween: 0,
            mousewheel: true,
            hashNavigation: {
                watchState: true,
            },
            navigation: {
                nextEl: ".slider__next",
                prevEl: ".slider__prev",
            },
            grabCursor: true,
            thumbs: {
                swiper: sliderThumbs,
            },
            breakpoints: {
                0: {
                    direction: "horizontal",
                },
                768: {
                    direction: "horizontal",
                },
            },
        });

        var countI = 0;
        $('#viewmore-ts-kt').click(function () {
            $('.content-thong-so').toggleClass('active');
            if (countI % 2 == 0) {
                $(this).html('').html('Thu gọn <i class="far fa-angle-up"></i>')
            } else {
                $(this).html('').html('Xem thêm <i class="far fa-angle-down"></i>')
            }
            countI++;
        })
        $('#viewmore-dd-nb').click(function () {
            $('.content-dac-diem').toggleClass('active');
            if (countI % 2 == 0) {
                $(this).html('').html('Thu gọn <i class="far fa-angle-up"></i>')
            } else {
                $(this).html('').html('Xem thêm <i class="far fa-angle-down"></i>')
            }
            countI++;
        })
        $('.viewmoretskt').click(function () {
            $('.p-short-description').toggleClass('active');
            if (countI % 2 == 0) {
                $(this).html('').html('Thu gọn <i class="far fa-angle-up"></i>')
            } else {
                $(this).html('').html('Xem thêm <i class="far fa-angle-down"></i>')
            }
            countI++;
        })
    </script>

@endpush
