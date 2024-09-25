<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-light">PBKK (B)</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @foreach (config('sidebar') as $item)
                    <li class="nav-item has-treeview {{ request()->is('*'.explode('.', $item['route'])[0].'/*') ? 'menu-open' : '' }}">
                        <a href="{{ $item['route'] }}" class="nav-link {{ request()->is('*'.explode('.', $item['route'])[0].'/*') ? 'active' : '' }}">
                            <i class="nav-icon {{ $item['icon'] }}"></i>
                            <p>
                                {{ $item['title'] }}
                                @if (isset($item['children']))
                                    <i class="right fas fa-angle-left"></i>
                                @endif
                            </p>
                        </a>
                        @if (isset($item['children']))
                            <ul class="nav nav-treeview">
                                @foreach ($item['children'] as $child)
                                    <li class="nav-item">
                                        <a href="{{ $child['route'] !== '#' ? route($child['route']) : '#' }}" class="nav-link {{ request()->routeIs($child['route']) || (isset($child['is_param']) && request()->is('*'.$child['route'].'*')) ? 'active' : '' }}">
                                            <i class="{{ $child['icon'] }} nav-icon"></i>
                                            <p>{{ $child['title'] }}</p>
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
