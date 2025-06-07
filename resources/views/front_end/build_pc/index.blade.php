@extends('front_end.layouts.app')
@if(!empty($mainSettings['seo_schema']))
    @section('seo_schema')
        {!! $mainSettings['seo_schema'] !!}
    @endsection
@endif
@section('page-title', 'Xây dựng cấu hình')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/buildpcNew.css') }}">
@endpush
@section('content')
    <div class="build-pc pc bg-white" id="build-2020">
        <div class="content container">
            <div class="clear"></div>
            <div class="build-pc_content">
                <div class="build-pc-title">
                    <h1>
                        Xây Dựng Cấu Hình Máy Tính - Build PC Chuyên Nghiệp
                    </h1>
                    @if(isset($mainSettings['banner_build_pc_status']) && $mainSettings['banner_build_pc_status'] == 'on')
                        <div class="container pd-10 my-3">
                            <img data-sizes="auto" class="lazyautosizes lazyloaded" style="border-radius: 8px;width: 100%;"
                                 src="{{ $mainSettings['banner_build_PC'] ?? '' }}"
                                 data-src="{{ $mainSettings['banner_build_PC'] ?? '' }}"
                                 alt="Build PC tại Phong Hà Computer" sizes="1200px">
                        </div>

                    @endif
                    <input type="hidden" id="id_tab" name="id_tab" value="1">

                    <ul class="list-btn-action" style="width:100%">
                        <li id="tab_1" style="width:auto;" class="tab_build_pc active" >
                            <span onclick="changeTab(1)" class="config-tab">Cấu hình 1</span>
                        </li>
                        <li id="tab_2" style="width:auto;" class="tab_build_pc">
                            <span onclick="changeTab(2)" class="config-tab">Cấu hình 2</span>
                        </li>
                        <li id="tab_3" style="width:auto;" class="tab_build_pc">
                            <span onclick="changeTab(3)" class="config-tab">Cấu hình 3</span>
                        </li>
                        <li id="tab_4" style="width:auto;" class="tab_build_pc">
                            <span onclick="changeTab(4)" class="config-tab">Cấu hình 4</span>
                        </li>
                        <li id="tab_5" style="width:auto;" class="tab_build_pc">
                            <span onclick="changeTab(5)" class="config-tab">Cấu hình 5</span>
                        </li>
                        <li style="width:auto;">
                        <span id="rebuild-product" style="padding:0 20px;">
                            Làm mới
                            <i class="fa fa-undo" aria-hidden="true"></i>
                        </span>
                        </li>
                    </ul>
                </div>
                <hr color="#ccc">

                <div class="clearfix"></div>

                <p class="estimate-price">Chi phí dự tính:
                    <span class="js-config-summary">
                        <span class="total-price-config" data-estimate="">
                            0 đ
                        </span>
                        <p> </p>
                    </span>
                </p>

                <div class="clear"></div>

                <div class="km-buildpc justify-content-end mt-2">
                    <div class="js-buildpc-promotion-content" style="margin-bottom: 0px;"></div>
                </div>

                <div class="list-drive" id="js-buildpc-layout">
                    @foreach($arrCateBuildPC as $key => $cateBuildPC)
                        @if(empty($cateBuildPC->attribute))
                            @continue
                        @endif
                        <div class="item-drive">
                            <h3 class="d-name"
                                style="">
                                {{ $key + 1 }} . {{ $cateBuildPC->title }}
                            </h3>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection"
                                      id="js-category-info-2"
                                      data-info="{id:2,name:Bộ vi xử lý}"
                                      data-id="{{ $cateBuildPC->id  }}">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Chọn {{ $cateBuildPC->title }}
                                </span>
                                <div id="js-selected-item-{{ $cateBuildPC->id }}" data-sort="{{ $loop->index + 1 }}" data-id="{{ $cateBuildPC->id }}"
                                     class="js-item-row">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="clear"></div>

                <input type="hidden" id="sumEstimatePrice" name="">
                <p style="float:right; font-size:18px; color:#d00; margin:15px 0;">Chi phí dự tính:
                    <span class="js-config-summary">
                        <span class="total-price-config" data-estimate="">
                            0 đ
                        </span>
                        <p> </p>
                    </span>
                </p>

                <div class="clear"></div>

                <div class="clearfix">
                    <div class="js-buildpc-promotion-content"
                         style="margin-bottom: 0px;float: none;display: flex;justify-content: end;">
                    </div>

                    <ul class="list-btn-action" id="js-buildpc-action" style="width: 100%;margin-top: 15px;">
                        <li>
                            <textarea name="generate_image" style="display:none;" id="generate_image"></textarea>
{{--                            <input type="hidden" name="generate_image" id="generate_image">--}}
                            <button type="button" id="download-image">
                                <i class="fa fa-image" aria-hidden="true"></i> tải ảnh cấu hình
                            </button>
                        </li>
                        <li>
                            <form id="view_and_print_form" action="{{ route('fe.page.view-and-print') }}" method="POST">
                                @csrf
{{--                                <input type="hidden" name="build_pc" id="view_and_print">--}}
                                <textarea name="build_pc" style="display:none;" id="view_and_print"></textarea>
                                <button type="submit">
                                    <i class="fa fa-print" aria-hidden="true"></i> Xem &amp; In
                                </button>
                            </form>
                        </li>
                        <li>
                            <form id="excel_download_form" action="{{ route('fe.page.download-excel') }}" method="GET">
{{--                                <input type="hidden" name="excel_build_pc" id="excel_download">--}}
                                <textarea name="excel_build_pc" style="display:none;" id="excel_download"></textarea>
                                <button type="submit">
                                    <i class="fa fa-file-excel" aria-hidden="true"></i>
                                    Tải file excel cấu hình
                                </button>
                            </form>
                        </li>
                        <li style="background: #ce0707;">
                            <form id="add_to_cart_build_pc_form" action="{{ route('fe.cart.add.buildpc') }}"
                                  method="POST">
                                @csrf
                                <button type="submit" id="button_add_to_cart">
{{--                                    <input type="hidden" name="add_to_cart_build_pc" id="add_to_cart_buildpc_input">--}}
                                    <textarea name="add_to_cart_build_pc" style="display:none;" id="add_to_cart_buildpc_input"></textarea>
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    Thêm vào giỏ hàng
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="js-modal-popup"></div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="{{ asset('js/buildPc.js') }}"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.esm.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.js"></script>

    <script type="text/javascript">

        $(document).ready(function () {
            $("#download-image").click(function (e) {
                e.preventDefault()
                let idTab    = $('#id_tab').val();
                let dataProd = localStorage.getItem("list_item_build_pc_"+idTab);
                let srcImg   = `<img src="'{{ asset('images/loading-3.svg') }}'">`;
                $('#download-image').html('Loading.....');

                if (dataProd == null || typeof dataProd == "undefined" || dataProd.length === 0 || !dataProd ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Bạn chưa chọn sản phẩm nào!',
                    })
                    $('#download-image').html('<i class="fa fa-image" aria-hidden="true"></i> TẢI ẢNH CẤU HÌNH');
                    return;
                }
                $.ajax({
                    url    : '{{ route('fe.page.generate-image') }}',
                    type   : 'GET',
                    data   : ({
                        generate_image: dataProd,
                    }),
                    success: function (result) {
                        $('#download-image').html('<i class="fa fa-image" aria-hidden="true"></i> TẢI ẢNH CẤU HÌNH');
                        result = $.parseHTML(result);
                        screenshot(result);
                        $('#build-pc-image').remove();
                    },
                    error  : function (error) {

                    }
                });
            });
        });

        function screenshot(html) {
            document.body.appendChild(html[0]);
            html2canvas(html[0]).then(function (canvas) {
                downloadImage(canvas.toDataURL(), "phonghacomputer_buildPc.png");
            });
        }

        function downloadImage(uri, filename) {
            var link = document.createElement('a');
            if (typeof link.download !== 'string') {
                window.open(uri);
            } else {
                link.href = uri;
                link.download = filename;
                accountForFirefox(clickLink, link);
            }
        }

        function clickLink(link) {
            link.click();
        }

        function accountForFirefox(click) {
            var link = arguments[1];
            document.body.appendChild(link);
            click(link);
            document.body.removeChild(link);
        }

        @if( session()->has('add_to_cart_success') )
        Swal.fire({
            position         : 'top',
            icon             : 'success',
            title            : 'Thêm vào giỏ hàng thành công',
            showConfirmButton: false,
            timer            : 1500
        })
        @endif


    </script>
@endpush