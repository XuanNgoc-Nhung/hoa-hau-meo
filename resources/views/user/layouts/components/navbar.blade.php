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
            <!--begin::Navbar Search-->
            <li class="nav-item">
            </li>
            <!--end::Notifications Dropdown Menu-->
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>
            <!--end::Fullscreen Toggle-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img src="{{ auth()->user()->avatar ? asset('uploads/avatars/' . auth()->user()->avatar) : asset('uploads/avatars/default-avatar.png') }}" 
                     class="user-image rounded-circle shadow" alt="User Image" style="width: 32px; height: 32px; object-fit: cover;">
                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header text-bg-primary">
                  <img src="{{ auth()->user()->avatar ? asset('uploads/avatars/' . auth()->user()->avatar) : asset('uploads/avatars/default-avatar.png') }}" 
                       class="rounded-circle shadow" alt="User Image" style="width: 90px; height: 90px; object-fit: cover;">
                  <p>
                    {{ auth()->user()->name }}
                    <small>Thành viên từ {{ auth()->user()->created_at->format('M Y') }}</small>
                  </p>
                </li>
                <!--end::User Image-->
                <!--begin::Menu Body-->
                <li class="user-body">
                  <!--begin::Row-->
                  <div class="row">
                    <div class="col-4 text-center">
                      <a href="{{ route('user.upload-file') }}">
                        <i class="fas fa-upload"></i><br>
                        <small>Upload ảnh</small>
                      </a>
                    </div>
                    <div class="col-4 text-center">
                      <a href="{{ route('user.dashboard') }}">
                        <i class="fas fa-home"></i><br>
                        <small>Trang chủ</small>
                      </a>
                    </div>
                    <div class="col-4 text-center">
                      <a href="{{ route('user.tai-khoan') }}">
                        <i class="fas fa-user"></i><br>
                        <small>Tài khoản</small>
                      </a>
                    </div>
                  </div>
                  <!--end::Row-->
                </li>
                <!--end::Menu Body-->
                <!--begin::Menu Footer-->
                <li class="user-footer">
                  <a href="{{ route('user.tai-khoan') }}" class="btn btn-default btn-flat">
                    <i class="fas fa-user-edit"></i> Thông tin
                  </a>
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-end" 
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </li>
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>