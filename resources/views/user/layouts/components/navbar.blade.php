<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li>
            <!--end::Fullscreen Toggle-->
            @if(auth()->check())
            <!--begin::User Menu Dropdown-->
            <li class="nav-item user-menu">
                <a href="{{ route('user.tai-khoan') }}" class="nav-link d-flex align-items-center gap-2">
                    <img src="{{ auth()->user()->avatar ? asset('uploads/avatars/' . auth()->user()->avatar) : asset('uploads/avatars/default-avatar.png') }}"
                        class="user-image rounded-circle shadow" alt="User Image"
                        style="width: 32px; height: 32px; object-fit: cover;">
                    <span>{{ auth()->user()->name }}</span>
                </a>
            </li>
            <!--end::User Menu Dropdown-->
            @else
            <li class="nav-item">
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Đăng nhập</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('register') }}" class="btn btn-primary">Đăng ký</a>
            </li>
            @endif
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>
