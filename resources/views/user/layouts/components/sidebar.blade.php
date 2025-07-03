<aside id="sidebar" class="app-sidebar bg-body-secondary shadow sticky-sidebar open" data-bs-theme="dark">
    <!-- Nút đóng/mở -->
    <!-- Đã xóa nút toggleSidebar vì đã có data-lte-toggle="sidebar" -->
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img src="../../dist/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Trang web</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper" data-overlayscrollbars="host">
        <div class="os-size-observer">
            <div class="os-size-observer-listener"></div>
        </div>
        <div class="" data-overlayscrollbars-viewport="scrollbarHidden overflowXHidden overflowYScroll" tabindex="-1"
            style="margin-right: -16px; margin-bottom: -16px; margin-left: 0px; top: -8px; right: auto; left: -8px; width: calc(100% + 16px); padding: 8px;">
            <nav class="mt-2">
                <!--begin::Sidebar Menu-->
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">
                            <i class="nav-icon bi bi-palette"></i>
                            <p>Tổng quan</p>
                        </a>
                    </li>
                    <li class="nav-item parent-menu {{ Route::is('dien-dan-theo-danh-muc') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Route::is('dien-dan-theo-danh-muc') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-box-seam-fill"></i>
                            <p>
                                Diễn đàn
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if ($danhMucDienDan->count() > 0)
                            @foreach ($danhMucDienDan as $danhMuc)
                            <li class="nav-item">
                                <a href="{{ route('dien-dan-theo-danh-muc', ['slug' => $danhMuc->slug]) }}"
                                    class="nav-link {{ str_contains(request()->fullUrl(), $danhMuc->slug) ? 'active' : '' }}">
                                    <i class="bi bi-geo-alt"></i>
                                    <p>{{ $danhMuc->ten_danh_muc }}
                                    </p>
                                </a>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item parent-menu {{ (Route::is('dien-dan.moi') || Route::is('dien-dan.quan-tam') || Route::is('dien-dan.binh-luan-moi')) ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Route::is('dien-dan.moi') || Route::is('dien-dan.quan-tam') || Route::is('dien-dan.binh-luan-moi') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-clipboard-fill"></i>
                            <p>
                                Khu giải trí
                                <span class="nav-badge badge text-bg-secondary me-3">3</span>
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('dien-dan.moi') }}" class="nav-link {{ Route::is('dien-dan-moi') ? 'active' : '' }}">
                                    <i class="bi bi-image-alt"></i>
                                    <p>Diễn đàn mới</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dien-dan.quan-tam') }}" class="nav-link {{ Route::is('dien-dan.quan-tam') ? 'active' : '' }}">
                                    <i class="bi bi-cup-hot"></i>
                                    <p>Diễn đàn hot</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dien-dan.binh-luan-moi') }}" class="nav-link {{ Route::is('dien-dan.binh-luan-moi') ? 'active' : '' }}">
                                    <i class="bi bi-chat-heart"></i>
                                    <p>Nhộn nhịp</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-header parent-menu ">Mỹ nhân làng Mèo</li>
                    <li class="nav-item">
                        <a href="#"
                            class="nav-link">
                            <i>👄</i>
                            <p>Bé Mun Hoa hậu mới nổi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#"
                            class="nav-link">
                            <i>👙</i>
                            <p>Bé Chip - Trăm năm khó tìm</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#"
                            class="nav-link">
                            <i>💋</i>
                            <p>Bé Po, bé Po - Chị chị em em</p>
                        </a>    
                    </li><li class="nav-header parent-menu ">Quản trị viên</li>
                    <li class="nav-item {{ Route::is('admin.nguoi-dung') ? 'active' : '' }}">
                        <a href="{{ route('admin.nguoi-dung') }}"
                            class="nav-link {{ Route::is('admin.nguoi-dung') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-lines-fill"></i>
                            <p>Người dùng</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('admin.danh-muc-dien-dan') ? 'active' : '' }}">
                        <a href="{{ route('admin.danh-muc-dien-dan') }}"
                            class="nav-link {{ Route::is('admin.danh-muc-dien-dan') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-lines-fill"></i>
                            <p>Danh mục diễn đàn</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('admin.danh-sach-dien-dan') ? 'active' : '' }}">
                        <a href="{{ route('admin.danh-sach-dien-dan') }}"
                            class="nav-link {{ Route::is('admin.danh-sach-dien-dan') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-lines-fill"></i>
                            <p>Danh sách diễn đàn</p>
                        </a>
                    </li>
                    <li class="nav-header parent-menu  {{ request()->is('upload-file') ? 'menu-open' : '' }}">Tiện ích</li>
                    <li class="nav-item {{ request()->is('upload-file') ? 'active' : '' }}">
                        <a href="{{ route('user.upload-file') }}"
                            class="nav-link {{ request()->is('upload-file') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-upload"></i>
                            <p>Tải ảnh</p>
                        </a>
                    </li>
                    <li class="nav-header">Hệ thống</li>
                    <li class="nav-item parent-menu {{ (Route::is('user.tai-khoan') || Route::is('dien-dan.cua-toi')) ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Route::is('user.tai-khoan') || Route::is('dien-dan.cua-toi') ? 'active' : '' }}">
                            <i class="bi bi-person-badge-fill"></i>
                            <p>
                                Cá nhân
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('user.tai-khoan') }}" class="nav-link {{ Route::is('user.tai-khoan') ? 'active' : '' }}">
                                    <i class="bi bi-person-lines-fill"></i>
                                    <p>Tài khoản</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dien-dan.cua-toi') }}" class="nav-link {{ Route::is('dien-dan.cua-toi') ? 'active' : '' }}">
                                    <i class="bi bi-person-vcard-fill"></i>
                                    <p>Diễn đàn</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.doi-mat-khau') }}" class="nav-link {{ Route::is('user.doi-mat-khau') ? 'active' : '' }}">
                                    <i class="bi bi-gear-wide-connected"></i>
                                    <p>Mật khẩu</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link" 
                           onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                            <i class="nav-icon bi bi-box-arrow-right"></i>
                            <p>Đăng xuất</p>
                        </a>
                        <form id="sidebar-logout-form" action="{{ route('logout') }}" method="GET" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
                <!--end::Sidebar Menu-->
            </nav>
        </div>
        <div class="os-scrollbar os-scrollbar-horizontal os-theme-light os-scrollbar-auto-hide os-scrollbar-handle-interactive os-scrollbar-track-interactive os-scrollbar-cornerless os-scrollbar-unusable os-scrollbar-auto-hide-hidden"
            style="--os-viewport-percent: 1; --os-scroll-direction: 0;">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle"></div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-vertical os-theme-light os-scrollbar-auto-hide os-scrollbar-handle-interactive os-scrollbar-track-interactive os-scrollbar-visible os-scrollbar-cornerless os-scrollbar-auto-hide-hidden"
            style="--os-viewport-percent: 0.1967; --os-scroll-direction: 0;">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle"></div>
            </div>
        </div>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
