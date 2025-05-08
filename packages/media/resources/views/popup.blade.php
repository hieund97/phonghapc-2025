@if (request()->input('media-action') === 'select-files')
    <html>
        <head>
            <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <!-- Toastr -->
        <link rel="stylesheet" href="{{ asset('theme/plugins/toastr/toastr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('theme/plugins/fancybox/jquery.fancybox.min.css') }}">
        <!-- Jquery UI -->
        <!--<link rel="stylesheet" href="{{ asset('theme/plugins/jquery-ui/jquery-ui.min.css') }}"> -->
        <link href="{{ asset('theme/plugins/jquery-ui/1.12.0/jquery-ui.css') }}" rel="stylesheet"/>

    
        <script>
            var csrf_token = '{{ csrf_token() }}';
        var base_url   = '{{config("app.url")}}';
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
        <script src="{{ asset('theme/plugins/moment/moment.min.js')}}"></script>
        <!-- date-range-picker -->
        <script src="{{ asset('theme/plugins/daterangepicker/daterangepicker.js')}}"></script>
        <script src="{{ asset('theme/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('theme/plugins/kv-bootstrap-fileinput/js/fileinput.min.js') }}"></script>
        <script src="{{ asset('theme/plugins/kv-bootstrap-fileinput/themes/fas/theme.min.js') }}"></script>
        
        <!-- sortable -->
        <script src="{{ asset('theme/plugins/jquery-ui/1.12.0/jquery-ui.js') }}"></script>
    
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
            {!! RvMedia::renderHeader() !!}
        </head>
        <body>
            {!! RvMedia::renderContent() !!}
            {!! RvMedia::renderFooter() !!}
        </body>
    </html>
@else
    {!! RvMedia::renderHeader() !!}

    {!! RvMedia::renderContent() !!}

    {!! RvMedia::renderFooter() !!}
@endif
