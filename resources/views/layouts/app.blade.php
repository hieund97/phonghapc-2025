<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="{{ asset('theme/favicon.png')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title') - {{ config('app.name') }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Pace -->
    <link rel="stylesheet" href="{{ asset('theme/plugins/pace-progress/themes/blue/pace-theme-flash.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('theme/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('theme/plugins/ionicons/css/ionicons.min.css') }}">

    <!-- Ladifire -->
    <link rel="stylesheet" href="{{ asset('theme/dist/css/ladifire.css') }}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('theme/dist/css/adminlte.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="{{ asset('theme/dist/css/google.font.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('theme/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('theme/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/plugins/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/plugins/kv-bootstrap-fileinput/css/fileinput.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('theme/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('theme/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/plugins/fancybox/jquery.fancybox.min.css') }}">
    <!-- Jquery UI -->
<!--<link rel="stylesheet" href="{{ asset('theme/plugins/jquery-ui/jquery-ui.min.css') }}"> -->
    <link href="{{ asset('theme/plugins/jquery-ui/1.12.0/jquery-ui.css') }}" rel="stylesheet" />

    <link href="{{ asset('theme/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />

    @stack('styles')
    <script>
        var csrf_token = '{{ csrf_token() }}';
        var base_url = '{{config("app.url")}}';
        var formatter = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
        });
    </script>
    <!-- jQuery -->
    <script src="{{ asset('theme/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('theme/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('theme/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('theme/dist/js/adminlte.min.js') }}"></script>

    <!-- Pace -->
    <script src="{{ asset('theme/plugins/pace-progress/pace.min.js') }}"></script>
    <script src="{{ asset('theme/dist/js/jquery.pjax.js') }}"></script>
    <script src="{{ asset('theme/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/moment/locale/'.app()->getLocale().'.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('theme/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{ asset('theme/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

    <script src="{{ asset('theme/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/kv-bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/kv-bootstrap-fileinput/themes/fas/theme.min.js') }}"></script>

    <!-- sortable -->
    <script src="{{ asset('theme/plugins/jquery-ui/1.12.0/jquery-ui.js') }}"></script>
    <script src="{{ asset('theme/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

    <script src="{{ asset('theme/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

    <script src="{{ asset('theme/dist/js/ladifire.js') }}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('theme/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('theme/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/fancybox/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/ckeditor/ckeditor.js') }}"></script>
    @include('media::config')
    <link href="{{ asset('vendor/core/media/css/media.css?v=' . time()) }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('vendor/core/media/js/integrate.js?v=' . time()) }}"></script>
    @if(config('admin.pjax_show'))
        <script>
            $(document).ready(function () {
                $(document).pjax('a', '#pjax-container');

                // does current browser support PJAX
                if ($.support.pjax) {
                    $.pjax.defaults.timeout = 1000; // time in milliseconds
                }
            });
        </script>
    @endif
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
    @include('partials.navbar')
    @include('partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper text-sm" id="pjax-container">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <script>
                    var selectedMenu = "{!! url()->current() !!}";
                </script>

                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('page-title')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard') }}">
                                        {{ __('Home') }}
                                    </a>
                                </li>

                                <li class="breadcrumb-item active">@yield('page-title')</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                @yield('content')
                @stack('footer')
            </section>
            <!-- /.content -->


            @stack('scripts')

            <script>
                function updatePriceByCrawlPrice(product_id, price, crawl_id = null, isEdit = false) {
                    $.ajax({
                        url    : "{{ route('crawl-data.quick_update') }}",
                        type   : 'POST',
                        data   : ({
                            product_id: product_id,
                            price     : price,
                            crawl_id  : crawl_id,
                        }),
                        success: function (data) {
                            $('#match_price').show()
                            $('#not_match_price').hide()
                            if(isEdit) {
                                $('.my_product_price').html(formatMoney(price));
                                $('#status_crawl').val(1);
                            }
                            if (data.status == 'success') {
                                Toast.fire({
                                    type : 'success',
                                    title: '{{__('Update data successfully.')}}',
                                })
                            } else {
                                Toast.fire({
                                    type : 'error',
                                    title: '{{__('Update error data.')}}',
                                })
                            }
                        },
                    })
                };
            </script>
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 2
            </div>

            <strong>Copyright &copy; {{date('Y')}} <a
                        href="{{ config('admin.copy_right.url') }}">{{ config('admin.copy_right.name') }}</a>.</strong>
            All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @include('partials.toast')

    {{--<script src="https://unpkg.com/imask"></script>
    <script>
        $(document).ready(function () {
            $('input[type="number"]').each(function () {
                let el = this;
                let inputMask = $(el).clone().attr('data-mask-to', $(el).attr('name')).attr('id', null).attr('name', null).attr('type', 'text');

                $(el).hide().after(inputMask);

                let numberMask = IMask(inputMask[0], {
                    mask: Number,
                    thousandsSeparator: ',',
                }).on('accept', function () {
                    $(el).val(numberMask.masked.number);
                });
            });
        });
    </script>--}}
</body>
</html>
