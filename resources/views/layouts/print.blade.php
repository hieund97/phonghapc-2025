<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="{{ asset('theme/favicon.ico')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('theme/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('theme/plugins/ionicons/css/ionicons.min.css') }}">
    
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('theme/dist/css/adminlte.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="{{ asset('theme/dist/css/google.font.css') }}" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            @yield('content')
        </section>
    </div>    
    <script type="text/javascript"> 
        window.addEventListener("load", window.print());
    </script>
</body>
</html>
