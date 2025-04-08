<style>
    .notified:after {
        content: "";
        position: absolute;
        top: 3px;
        right: 11px;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: red;
        animation: blink 1s ease-in-out infinite;
    }

    @keyframes blink {
        0% {
            opacity: 0;
        }

        50% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }
</style>

<div class="nk-header nk-header-fixed">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-header-logo ms-n1">
                <div class="nk-sidebar-toggle"><button class="btn btn-sm btn-icon btn-zoom sidebar-toggle d-sm-none">
                    <em class="icon ni ni-menu"></em></button><button class="btn btn-md btn-icon btn-zoom sidebar-toggle d-none d-sm-inline-flex">
                        <em class="icon ni ni-menu"></em></button>
                </div>

                <a href="index-2.html" class="logo-link">
                    <div class="logo-wrap">
                        <img class="logo-svg" src="{{ asset('assets/images/ecddca.png') }}" alt="">
                    </div>
                </a>
            </div>
            @auth
                <nav class="nk-header-menu nk-navbar"></nav>
                <div class="nk-header-tools">
                    <ul class="nk-quick-nav ms-2">
                        <li>
                            <button class="btn btn-icon btn-md btn-zoom d-sm-inline-flex" data-bs-toggle="offcanvas" data-bs-target="#notify">
                                <em class="icon ni ni-bell"></em>
                            </button>
                        </li>
                        <li class="dropdown">
                            <a href="#" data-bs-toggle="dropdown">
                                <div class="d-sm-none">
                                    <div class="media media-md media-circle"><img class="img-thumbnail" src="{{ asset('assets/images/' . auth()->user()->image) }}" alt="" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"></div>
                                </div>
                                <div class="d-none d-sm-block">
                                    <div class="media media-circle"><img class="img-thumbnail" src="{{ asset('assets/images/' . auth()->user()->image) }}" alt="" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                    </div>
                                </div>
                            </a>

                            <div class="dropdown-menu dropdown-menu-md">
                                <div class="dropdown-content dropdown-content-x-lg py-3 border-bottom border-light">
                                    <div class="media-group">
                                        <div class="media media-xl media-middle media-circle"><img class="img-thumbnail" src="{{ asset('assets/images/' . auth()->user()->image) }}" alt="" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                        </div>
                                        <div class="media-text">
                                            <div class="lead-text">{{ auth()->user()->Name }}</div>
                                            <span class="sub-text">{{ auth()->user()->Role == 'Admin' ? 'Admin' : 'Nhân viên' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-content dropdown-content-x-lg py-3 border-bottom border-light">
                                <ul class="link-list">
                                    <li><a href="{{ route('user.show', auth()->id()) }}"><em class="icon ni ni-user"></em><span>Thông tin cá nhân</span></a></li>
                                </ul>

                                </div>
                                <div class="dropdown-content dropdown-content-x-lg py-3">
                                    <ul class="link-list">
                                        <li>
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><em class="icon ni ni-signout"></em><span>Đăng xuất</span></a></li>
                                    </ul>
                                </div>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end offcanvas-size-lg" id="notify">
    <div class="offcanvas-header border-bottom border-light">
        <h5 class="offcanvas-title" id="offcanvasTopLabel">Thông tin mới</h5><button type="button" class="btn-close" data-bs-dismiss="offcanvas"aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" data-simplebar>
        <ul class="nk-schedule">
            <li class="nk-schedule-item">
                <div class="nk-schedule-item-inner">
                    <div class="nk-schedule-symbol active"></div>
                    <div class="nk-schedule-content"><span class="smaller">4:23 PM</span>
                        <a href="">
                            <div class="h6">Invitation for creative designs pattern</div>
                        </a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
