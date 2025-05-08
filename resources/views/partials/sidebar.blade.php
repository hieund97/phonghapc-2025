<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('theme/dist/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8;">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false" id="nav-chungauto">
                @foreach($navigation as $nav)
                    @php
                        $childPermissions = array_filter(!empty($nav['children']) ? array_column($nav['children'], 'permission') : [$nav['permission']]);
                        $childHasCurrentUrl = !empty($nav['children']) && in_array(url()->current(), array_column($nav['children'], 'link'));
                        $activeByInclude = in_array(Route::currentRouteName(), array_merge($nav['include'] ?? [], Arr::flatten(array_column($nav['children'] ?? [], 'include'))));
                    @endphp

                    @canany($childPermissions) @else @continue @endcanany

                    <li class="nav-item {{ $childHasCurrentUrl || $activeByInclude ? 'menu-open' : '' }} {{ !empty($nav['children']) ? 'has-treeview' : '' }}">
                        <a href="{{ $nav['link'] }}" class="nav-link @if($childHasCurrentUrl || $activeByInclude || url()->current() == $nav['link']) active @endif">
                            <i class="nav-icon fas {{ $nav['icon'] }}"></i>
                            <p>
                                {{ $nav['name'] }}

                                @if (!empty($nav['children']))
                                    <i class="right fas fa-angle-left"></i>
                                @endif
                            </p>
                        </a>

                        @if (!empty($nav['children']))
                            <ul class="nav nav-treeview">
                                @foreach($nav['children'] as $child)
                                    @if (!empty($child['permission']) && !request()->user()->can($child['permission']))
                                        @continue
                                    @endif

                                    <li class="nav-item">
                                        <a href="{{ $child['link'] }}" class="nav-link @if(url()->current() == $child['link'] || in_array(Route::currentRouteName(), $child['include'] ?? [])) active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ $child['name'] }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
