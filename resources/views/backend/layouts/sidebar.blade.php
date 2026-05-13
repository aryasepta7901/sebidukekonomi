<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="{{ asset('template/backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SEbiduk Ekonomi</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('template/backend/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <nav class="mt-2">

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('backend') }}" class="nav-link {{ request()->is('backend*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt text-danger"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if (in_array(Auth::user()->role, ['admin', 'viewer']))
                    <li
                        class="nav-item {{ request()->is(['persiapan*', 'DashboardGC*', 'CetakPeta*']) ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is(['persiapan*', 'DashboardGC*', 'CetakPeta*']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>
                                Persiapan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('DashboardGC') }}"
                                    class="nav-link {{ request()->is('DashboardGC*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon text-info"></i>
                                    <p>Ground Check</p>
                                </a>
                            </li>
                            @if (in_array(Auth::user()->role, ['admin']))
                                <li class="nav-item">
                                    <a href="{{ url('CetakPeta') }}"
                                        class="nav-link {{ request()->is('CetakPeta*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-info"></i>
                                        <p>Cetak Peta</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (in_array(Auth::user()->role, ['admin']))
                    <li
                        class="nav-item {{ request()->is('MonitoringLapangan*') || request()->is('EarlyWarningSystem*') || request()->is('Anomali*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('pelaksanaan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-map-marked-alt"></i>
                            <p>
                                Pelaksanaan Lapangan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item {{ request()->is('MonitoringLapangan*') ? 'menu-open' : '' }}"">
                                <a href="{{ url('MonitoringLapangan') }}"
                                    class="nav-link  {{ request()->is('MonitoringLapangan*') ? 'active' : '' }} ">
                                    <i class="far fa-circle nav-icon text-warning"></i>
                                    <p>Monitoring Lapangan</p>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('EarlyWarningSystem*') ? 'menu-open' : '' }}"">
                                <a href="{{ url('EarlyWarningSystem') }}"
                                    class="nav-link  {{ request()->is('EarlyWarningSystem*') ? 'active' : '' }} ">
                                    <i class="far fa-circle nav-icon text-warning"></i>
                                    <p>Early Warning System</p>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->is('Anomali*') ? 'menu-open' : '' }}"">
                                <a href="{{ url('Anomali') }}"
                                    class="nav-link  {{ request()->is('Anomali*') ? 'active' : '' }} ">
                                    <i class="far fa-circle nav-icon text-warning"></i>
                                    <p>Anomali</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (in_array(Auth::user()->role, ['admin']))
                    <li class="nav-item {{ request()->is('pengolahan*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('pengolahan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-database"></i>
                            <p>
                                Pengolahan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon text-success"></i>
                                    <p>Anomali Lanjutan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon text-success"></i>
                                    <p>Diseminasi</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                        <p>
                            Logout
                        </p>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </li>
            </ul>
        </nav>
    </div>
</aside>
