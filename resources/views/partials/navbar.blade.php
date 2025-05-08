<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light" id="navigation">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/"  target="_blank" class="nav-link">Xem trang web</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('dashboard')}}" class="nav-link">Dashboard</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a target="_blank" href="javascript:void()" class="clear-cache nav-link">Xóa cache</a>
        </li>
        @yield('preview-page')
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('theme/dist/img/user2-160x160.jpg') }}" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="{{ asset('theme/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">

                    <p>{{ auth()->user()->name }}</p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="{{ route('profile.password') }}" class="btn btn-default btn-flat">
                        {{ __('Change Password') }}
                    </a>

                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Sign out') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->


@push('scripts')
    <script>
        $(document).on('click', '.clear-cache', function (e) {    
           e.preventDefault();
            $.ajax({
               url: "{{ route('clear-cache') }}",
               method: "get",
               data: {
                },
               success: function (response) {
                    Toast.fire({
                                type: 'success',
                                title: '{{__('Clear Cache successfully')}}',
                        });
               }
            });
        });

        $('.copy_text').click(function (e) {
            e.preventDefault();
            var copyText = $(this).attr('href');

            document.addEventListener('copy', function(e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);
            document.execCommand('copy');  
            alert('copied text: ' + copyText); 
        });

    </script>
@endpush
