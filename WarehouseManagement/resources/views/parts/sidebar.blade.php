<div class="nk-sidebar nk-sidebar-fixed is-theme" id="sidebar">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="{{ route('dashboard') }}" class="logo-link">
                <div class="logo-wrap">
                    <img class="logo-svg" src="{{ asset('assets/images/ecddca.png') }}" alt="">
                </div>
            </a>
            <div class="nk-compact-toggle me-n1"><button class="btn btn-md btn-icon text-light btn-no-hover compact-toggle"><em class="icon off ni ni-chevrons-left"></em><em class="icon on ni ni-chevrons-right"></em></button>
            </div>
            <div class="nk-sidebar-toggle me-n1"><button class="btn btn-md btn-icon text-light btn-no-hover sidebar-toggle"><em class="icon ni ni-arrow-left"></em></button></div>
        </div>
    </div>
    <div class="nk-sidebar-element nk-sidebar-body">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="{{ request()->is('/') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-home"></em>
                            </span>
                            <span class="nk-menu-text">Trang chủ</span>
                        </a>
                    </li>
                    @auth
                        <li class="{{ request()->is('nguyen-lieu*') ? 'active' : '' }}">
                            <a href="{{ route('nguyen-lieu.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon">
                                    <em class="icon ni ni-package"></em>
                                </span><span class="nk-menu-text">Quản lý nguyên liêu</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('loai-nguyen-lieu*') ? 'active' : '' }}">
                            <a href="{{ route('loai-nguyen-lieu.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon">
                                    <em class="icon ni ni-layers"></em>
                                </span>
                                <span class="nk-menu-text">Quản lý loại nguyên liệu</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('nha-cung-cap*') ? 'active' : '' }}">
                            <a href="{{ route('nha-cung-cap.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon">
                                    <em class="icon ni ni-building"></em>
                                </span>
                                <span class="nk-menu-text">Quản lý nhà cung cấp</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('co-so*') ? 'active' : '' }}">
                            <a href="{{ route('co-so.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon">
                                    <em class="icon ni ni-building"></em>
                                </span>
                                <span class="nk-menu-text">Quản lý cơ sở</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('nhap-kho*') ? 'active' : '' }}">
                            <a href="{{ route('nhap-kho.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon">
                                    <em class="icon ni ni-archive"></em>
                                </span>
                                <span class="nk-menu-text">Quản lý nhập kho</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('xuat-kho*') ? 'active' : '' }}">
                            <a href="{{ route('xuat-kho.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon">
                                    <em class="icon ni ni-unarchive"></em>
                                </span>
                                <span class="nk-menu-text">Quản lý xuất kho</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('thong-ke*') ? 'active' : '' }}">
                            <a href="{{ route('thong-ke.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon">
                                    <em class="icon ni ni-todo"></em>
                                </span>
                                <span class="nk-menu-text">Thống kê</span>
                            </a>
                        </li>
                        @can('user')
                            <li class="{{ request()->is('tai-khoan*') ? 'active' : '' }}">
                                <a href="{{ route('tai-khoan.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon">
                                        <em class="icon ni ni-users"></em>
                                    </span>
                                    <span class="nk-menu-text">Quản lý tài khoản</span>
                                </a>
                            </li>
                        @endcan
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div>
