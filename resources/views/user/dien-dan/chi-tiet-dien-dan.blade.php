@extends('user.layouts.components.app-layout')

@push('styles')
<style>
    .card-body {
        max-height: 1000px;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-collapsed .card-body,
    .collapsed .card-body {
        max-height: 0 !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        overflow: hidden;
    }

    .card-tools .btn-tool {
        cursor: pointer;
    }

    .card-tools .btn-tool:hover {
        background-color: rgba(0, 0, 0, 0.1);
    }

    /* CSS cho phần bình luận */
    .comment-item {
        transition: all 0.3s ease;
        border-left: 3px solid transparent !important;
        position: relative;
    }

    .comment-item:hover {
        border-left-color: #007bff !important;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1);
    }

    .comment-item .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }

    .comment-item .btn-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .comment-item .btn-outline-primary:hover {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .comment-item .btn-outline-danger:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    /* Cố định nút sửa/xóa ở góc phải trên */
    .comment-item .comment-actions {
        position: absolute;
        top: 10px;
        right: 15px;
        z-index: 10;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        border-radius: 6px;
        padding: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        opacity: 1;
        transition: opacity 0.3s ease;
    }

    /* Đảm bảo nội dung comment không bị che bởi nút */
    .comment-item .flex-grow-1 {
        /* padding-right: 80px; */
    }

    /* Căn phải các nút sửa/xóa */
    .comment-item .d-flex.gap-1 {
        margin-left: auto;
        justify-content: flex-end;
    }

    /* Đảm bảo container chứa tên và nút được căn phải */
    .comment-item .d-flex.justify-content-between {
        justify-content: space-between;
    }

    .comment-item .d-flex.justify-content-between .d-flex.align-items-center {
        flex: 1;
        min-width: 0;
    }

    /* Style cho layout mới của comment */
    .comment-item .row {
        align-items: flex-start;
    }

    /* Responsive cho mobile */
    @media (max-width: 767.98px) {
        .comment-item .col-md-3 {
            display: none; /* Ẩn phần avatar và tên người dùng ở bên trái trên mobile */
        }
        
        .comment-item .col-md-9 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        /* Style cho header mobile */
        .comment-item .d-md-none {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 0.75rem;
            margin-bottom: 0.75rem;
        }
        
        .comment-item .d-md-none .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }
        
        .comment-item .d-md-none h6 {
            font-size: 0.9rem;
            margin-bottom: 0;
        }
        
        .comment-item .d-md-none small {
            font-size: 0.75rem;
        }
    }

    /* Responsive cho desktop - luôn hiển thị nút */
    @media (min-width: 769px) {
        .comment-item .d-flex.gap-1 {
            opacity: 1;
            transition: opacity 0.3s ease;
        }
    }

    /* Style cho avatar trong comment */
    .comment-item .flex-shrink-0 img {
        width: 40px !important;
        height: 40px !important;
        border: 2px solid #e9ecef;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .comment-item .flex-shrink-0 img:hover {
        border-color: #007bff;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        transform: scale(1.05);
    }

    /* Animation cho bình luận mới */
    .comment-item.new-comment {
        animation: slideInFromTop 0.5s ease-out;
    }

    @keyframes slideInFromTop {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Style cho form đăng nhập */
    .border-warning {
        border-color: #ffc107 !important;
    }

    .bg-warning.bg-opacity-10 {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }

    /* Style cho alert notifications */
    .alert.position-fixed {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border: none;
        border-radius: 8px;
    }

    /* Loading spinner */
    .fa-spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        /* Giữ nguyên layout như PC, chỉ điều chỉnh kích thước */
        .comment-item .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }

        /* Đảm bảo tên người dùng không bị tràn */
        .comment-item h6 {
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .comment-item small {
            font-size: 0.75rem;
        }

        /* Điều chỉnh padding cho mobile */
        .comment-item {
            padding: 0.75rem !important;
        }

        /* Đảm bảo avatar không quá lớn trên mobile */
        .comment-item .flex-shrink-0 img {
            width: 40px !important;
            height: 40px !important;
        }

        /* Điều chỉnh khoảng cách giữa avatar và nội dung */
        .comment-item .flex-grow-1 {
            /* padding-right: 70px; */
        }
    }

    /* Style cho textarea */
    #commentContent {
        resize: vertical;
        min-height: 100px;
        border-radius: 8px;
        border: 1px solid #ced4da;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    #commentContent:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Style cho hình ảnh preview */
    .card-img-top {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-img-top:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Style cho modal hình ảnh */
    #imageModal .modal-dialog {
        max-width: 95vw;
        max-height: 95vh;
        margin: 2.5vh auto;
    }

    #imageModal .modal-content {
        height: 95vh;
        display: flex;
        flex-direction: column;
    }

    #imageModal .modal-header {
        flex-shrink: 0;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    #imageModal .modal-body {
        flex: 1;
        background-color: #000;
        padding: 0;
        overflow: auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #imageModal .modal-footer {
        flex-shrink: 0;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    #modalImage {
        transition: opacity 0.3s ease;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 4px;
    }

    /* Responsive cho modal */
    @media (max-width: 768px) {
        #imageModal .modal-dialog {
            max-width: 100vw;
            max-height: 100vh;
            margin: 0;
        }

        #imageModal .modal-content {
            height: 100vh;
            border-radius: 0;
        }

        #imageModal .modal-header {
            padding: 0.5rem;
        }

        #imageModal .modal-footer {
            padding: 0.5rem;
        }
    }

    @media (max-width: 576px) {
        #imageModal .modal-header .modal-title {
            font-size: 1rem;
        }

        #imageModal .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
    }

    /* Style cho form đăng nhập */
    #loginForm .form-control {
        border-radius: 8px;
        border: 1px solid #ced4da;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    #loginForm .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Hover effects */
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    }

    .btn-outline-primary:hover {
        transform: translateY(-1px);
    }

    .btn-outline-secondary:hover {
        transform: translateY(-1px);
    }

    /* Border bottom cho header bình luận */
    .comment-header {
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 0.5rem;
        margin-bottom: 0.75rem;
    }

    /* Căn giữa avatar và tên người dùng theo chiều dọc ở PC */
    @media (min-width: 768px) {
        .comment-item .col-md-3 .d-flex.flex-column {
            height: 100%;
            justify-content: center;
        }
    }

</style>
@endpush

@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-start">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('dien-dan-theo-danh-muc', ['slug' => $danhMuc->slug]) }}">{{ $danhMuc->ten_danh_muc }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $dienDan->ten_dien_dan }}</li>
                </ol>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<!--end::App Content Header-->

<!--begin::App Content-->
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-4">
                <!--begin::Card-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> #{{ $dienDan->id }} - {{ $dienDan->ten_dien_dan }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin::Thông tin cơ bản-->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-2 col-sm-4 col-6 mb-2">
                                        <strong>Người đăng:</strong>
                                        <p class="text-muted mb-0">{{ $dienDan->user->name ?? 'Không xác định' }}</p>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-6 mb-2">
                                        <strong>Ngày đăng:</strong>
                                        <p class="text-muted mb-0">
                                            {{ $dienDan->created_at ? $dienDan->created_at->format('d/m/Y H:i') : 'Không xác định' }}
                                        </p>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-6 mb-2">
                                        <strong>Danh mục:</strong>
                                        <p class="text-muted mb-0">{{ $danhMuc->ten_danh_muc }}</p>
                                    </div>
                                    @if($dienDan->vi_tri)
                                    <div class="col-md-2 col-sm-4 col-6 mb-2">
                                        <strong>Vị trí:</strong>
                                        <p class="text-muted mb-0">{{ $dienDan->vi_tri }}</p>
                                    </div>
                                    @endif
                                    @if($dienDan->so_dien_thoai)
                                    <div class="col-md-2 col-sm-4 col-6 mb-2">
                                        <strong>Số điện thoại:</strong>
                                        <p class="text-muted mb-0">{{ $dienDan->so_dien_thoai }}</p>
                                    </div>
                                    @endif
                                    @if($dienDan->muc_gia)
                                    <div class="col-md-2 col-sm-4 col-6 mb-2">
                                        <strong>Mức giá:</strong>
                                        <p class="text-muted mb-0">{{ $dienDan->muc_gia }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--end::Thông tin cơ bản-->


                        <!--begin::Danh sách hình ảnh-->
                        @if($dienDan->hinh_anh)
                        <div class="mb-4">
                            <h5>Hình ảnh:</h5>
                            <div class="row">
                                @php
                                $hinhAnhs = explode("\n", $dienDan->hinh_anh);
                                $hinhAnhs = array_filter($hinhAnhs, function($item) {
                                return !empty(trim($item));
                                });
                                @endphp
                                @foreach($hinhAnhs as $hinhAnh)
                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                    <div class="card">
                                        <img src="{{ $hinhAnh }}" class="card-img-top" alt="Hình ảnh diễn đàn"
                                            style="height: 200px; object-fit: cover; cursor: pointer;"
                                            onclick="openImageModal('{{ json_encode($hinhAnh) }}')"
                                            title="Click để xem ảnh lớn">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        <!--end::Danh sách hình ảnh-->

                        <!--begin::Chi tiết-->
                        @if($dienDan->chi_tiet)
                        <div class="mb-4">
                            <h5>Chi tiết:</h5>
                            <div class="border rounded p-3 bg-light">
                                {!! $dienDan->chi_tiet !!}
                            </div>
                        </div>
                        @endif
                        <!--end::Chi tiết-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách thảo luận</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin::Phần bình luận-->
                        <div class="row">
                            <div class="col-12">
                                <!--begin::Form bình luận-->
                                @auth
                                    <!-- Người dùng đã đăng nhập - Hiển thị form bình luận -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-comment me-2 text-primary"></i>
                                                Viết bình luận
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <form id="commentForm">
                                                <input type="hidden" name="post_id" value="{{ $dienDan->id }}">
                                                <div class="mb-3">
                                                    <label for="commentContent" class="form-label">Nội dung bình luận <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="commentContent" name="content" rows="2" 
                                                        placeholder="Viết bình luận của bạn..." required></textarea>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-paper-plane me-2"></i>
                                                        Gửi bình luận
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <!-- Người dùng chưa đăng nhập - Hiển thị form đăng nhập -->
                                    <div class="card mb-4 border-warning">
                                        <div class="card-header bg-warning bg-opacity-10">
                                            <h5 class="card-title mb-0 text-warning">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                Đăng nhập để bình luận
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="text-center mb-3">
                                                        <i class="fas fa-user-lock fa-3x text-muted mb-3"></i>
                                                        <h6>Bạn cần đăng nhập để có thể bình luận</h6>
                                                        <p class="text-muted">Đăng nhập để tham gia thảo luận và tương tác với cộng đồng</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <form id="loginForm">
                                                        <div class="mb-3">
                                                            <label for="loginEmail" class="form-label">Email <span class="text-danger">*</span></label>
                                                            <input type="email" class="form-control" id="loginEmail" name="email" 
                                                                placeholder="Nhập email của bạn" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="loginPassword" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                                                            <input type="password" class="form-control" id="loginPassword" name="password" 
                                                                placeholder="Nhập mật khẩu" required>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                                                                <label class="form-check-label" for="rememberMe">
                                                                    Ghi nhớ đăng nhập
                                                                </label>
                                                            </div>
                                                            <a href="{{ route('register') }}" class="text-decoration-none">
                                                                Chưa có tài khoản?
                                                            </a>
                                                        </div>
                                                        <div class="d-grid">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fas fa-sign-in-alt me-2"></i>
                                                                Đăng nhập
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endauth

                                <!--begin::Danh sách bình luận-->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-comments me-2 text-success"></i>
                                            Bình luận (<span id="commentCount">{{ $binhLuans->count() }}</span>)
                                        </h5>
                                    </div>
                                    <div class="card-body" id="commentsContainer">
                                        @if($binhLuans->count() > 0)
                                            @foreach($binhLuans as $binhLuan)
                                                <div class="comment-item mb-4 p-3 pt-0 border rounded bg-light" data-comment-id="{{ $binhLuan->id }}">
                                                    <div class="row">
                                                        <!-- Phần bên trái: Avatar và tên người dùng -->
                                                        <div class="col-md-3 col-12 mb-3 pt-3 mb-md-0 text-center">
                                                            <div class="d-flex flex-column align-items-center text-center">
                                                                <div class="mb-2">
                                                                    <img src="{{  $binhLuan->user->avatar ? asset('uploads/avatars/' . $binhLuan->user->avatar) : asset('uploads/images/default-avatar.png') }}" 
                                                                         class="rounded-circle" alt="User Avatar" width="50" height="50">
                                                                </div>
                                                                <div class="text-center">
                                                                    <h6 class="mb-1 fw-bold">{{ $binhLuan->user->name ?? 'Người dùng' }}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Phần bên phải: Header (thời gian + nút thao tác) và nội dung bình luận -->
                                                        <div class="col-md-9 col-12">
                                                            <!-- Header cho mobile: Avatar + tên + nút thao tác -->
                                                            <div class="d-flex justify-content-between align-items-start mb-2 d-md-none comment-header">
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ $binhLuan->user->avatar ? asset('uploads/avatars/' . $binhLuan->user->avatar) : asset('uploads/images/default-avatar.png') }}" 
                                                                         class="rounded-circle me-2" alt="User Avatar" width="40" height="40">
                                                                    <div>
                                                                        <h6 class="mb-0 fw-bold">{{ $binhLuan->user->name ?? 'Người dùng' }}</h6>
                                                                        <small class="text-muted">
                                                                            <i class="fas fa-clock me-1"></i>
                                                                            <span class="comment-time">{{ $binhLuan->created_at->diffForHumans() }}</span>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                @auth
                                                                    @if(auth()->id() == $binhLuan->user_id || $user->role == 'admin')
                                                                        <div class="d-flex gap-2">
                                                                            <i class="fas fa-edit text-primary edit-comment"
                                                                               data-comment-id="{{ $binhLuan->id }}"
                                                                               data-content="{{ $binhLuan->content }}"
                                                                               title="Sửa bình luận"
                                                                               style="cursor: pointer; font-size: 16px;"></i>
                                                                            <i class="fas fa-trash text-danger delete-comment"
                                                                               data-comment-id="{{ $binhLuan->id }}"
                                                                               title="Xóa bình luận"
                                                                               style="cursor: pointer; font-size: 16px;"></i>
                                                                        </div>
                                                                    @endif
                                                                @endauth
                                                                <div class="d-flex gap-2" style="font-size: 18px; margin-top: -5px; margin-left: 8px;">
                                                                    #{{ $binhLuan->id }}
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Header cho desktop: Thời gian bên trái, nút thao tác bên phải -->
                                                            <div class="d-flex justify-content-between align-items-center mb-2 d-none d-md-flex comment-header">
                                                                <div class="text-muted">
                                                                    <small>
                                                                        <i class="fas fa-clock me-1"></i>
                                                                        <span class="comment-time">{{ $binhLuan->created_at->diffForHumans() }}</span>
                                                                    </small>
                                                                </div>
                                                                @auth
                                                                    @if(auth()->id() == $binhLuan->user_id || $user->role == 'admin')
                                                                        <div class="d-flex gap-2 " style="margin-top: 10px;">
                                                                            <i class="fas fa-edit text-primary edit-comment"
                                                                               data-comment-id="{{ $binhLuan->id }}"
                                                                               data-content="{{ $binhLuan->content }}"
                                                                               title="Sửa bình luận"
                                                                               style="cursor: pointer; font-size: 16px;"></i>
                                                                            <i class="fas fa-trash text-danger delete-comment"
                                                                               data-comment-id="{{ $binhLuan->id }}"
                                                                               title="Xóa bình luận"
                                                                               style="cursor: pointer; font-size: 16px;"></i>
                                                                            <div class="d-flex gap-2" style="font-size: 18px; margin-top: -5px;">
                                                                                #{{ $binhLuan->id }}
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endauth
                                                            </div>
                                                            
                                                            <!-- Nội dung bình luận -->
                                                            <div class="comment-content">
                                                                <p class="mb-0">{{ $binhLuan->content }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <!--begin::Không có bình luận-->
                                            <div class="text-center py-5" id="noComments">
                                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">Chưa có bình luận nào</h5>
                                                <p class="text-muted">Hãy là người đầu tiên bình luận về chủ đề này!</p>
                                                @guest
                                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                                        <i class="fas fa-sign-in-alt me-2"></i>
                                                        Đăng nhập để bình luận
                                                    </a>
                                                @endguest
                                            </div>
                                            <!--end::Không có bình luận-->
                                        @endif
                                    </div>
                                </div>
                                <!--end::Danh sách bình luận-->
                            </div>
                        </div>
                        <!--end::Phần bình luận-->
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
</div>
<!--end::App Content-->

<!--begin::Modal xem hình ảnh-->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">
                    <i class="fas fa-image me-2"></i>Xem hình ảnh
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" class="img-fluid" alt="Hình ảnh">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Đóng
                </button>
                <a id="downloadImage" href="" class="btn btn-primary" download>
                    <i class="fas fa-download me-2"></i>Tải xuống
                </a>
            </div>
        </div>
    </div>
</div>
<!--end::Modal xem hình ảnh-->
@endsection

@push('scripts')
<script>
    function openImageModal(src) {
        console.log('openImageModal');

        //xoá bỏ dấu nháy đầu và cuối
        let imageSrc = src.replace(/^"|"$/g, '');
        console.log(imageSrc);
        const modalImage = document.getElementById('modalImage');
        const downloadLink = document.getElementById('downloadImage');
        
        // Hiển thị loading
        modalImage.src = '';
        modalImage.style.opacity = '0.5';
        
        // Tạo một image object để kiểm tra khi nào ảnh load xong
        const img = new Image();
        img.onload = function() {
            modalImage.src = imageSrc;
            modalImage.style.opacity = '1';
            
            // Cập nhật link download
            downloadLink.href = imageSrc;
            downloadLink.download = imageSrc.split('/').pop() || 'image.jpg';
        };
        
        img.onerror = function() {
            modalImage.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjhmOGY4Ii8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlIG5vdCBmb3VuZDwvdGV4dD48L3N2Zz4=';
            modalImage.style.opacity = '1';
            downloadLink.style.display = 'none';
        };
        
        img.src = imageSrc;
        
        // Hiển thị modal
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Xử lý collapse card
        document.querySelectorAll('[data-lte-toggle="card-collapse"]').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const card = this.closest('.card');
                const icon = this.querySelector('i');
                card.classList.toggle('card-collapsed');
                if (card.classList.contains('card-collapsed')) {
                    if (icon) icon.className = 'fas fa-plus';
                } else {
                    if (icon) icon.className = 'fas fa-minus';
                }
            });
        });

        // Xử lý form bình luận
        const commentForm = document.getElementById('commentForm');
        if (commentForm) {
            commentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const content = document.getElementById('commentContent').value.trim();
                const postId = this.querySelector('input[name="post_id"]').value;
                
                if (!content) {
                    showAlert('Vui lòng nhập nội dung bình luận!', 'warning');
                    return;
                }

                // Hiển thị loading
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang gửi...';
                submitBtn.disabled = true;

                // Gửi AJAX request
                fetch('{{ route("comments.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        post_id: postId,
                        content: content
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        document.getElementById('commentContent').value = '';
                        
                        // Cập nhật số lượng bình luận
                        updateCommentCount(1);
                        
                        // Thêm bình luận mới vào danh sách
                        addNewCommentFromData(data.comment);
                    } else {
                        showAlert(data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Có lỗi xảy ra khi gửi bình luận!', 'danger');
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            });
        }

        // Xử lý form đăng nhập
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = document.getElementById('loginEmail').value.trim();
                const password = document.getElementById('loginPassword').value;
                
                if (!email || !password) {
                    showAlert('Vui lòng nhập đầy đủ thông tin đăng nhập!', 'warning');
                    return;
                }

                // Hiển thị loading
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang đăng nhập...';
                submitBtn.disabled = true;

                // Giả lập đăng nhập (sẽ thay bằng AJAX thật sau)
                setTimeout(() => {
                    showAlert('Đăng nhập thành công! Đang chuyển hướng...', 'success');
                    
                    // Reload trang sau khi đăng nhập thành công
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }, 1500);
            });
        }

        // Xử lý sửa bình luận
        document.addEventListener('click', function(e) {
            if (e.target.closest('.edit-comment')) {
                e.preventDefault();
                const commentId = e.target.closest('.edit-comment').getAttribute('data-comment-id');
                const content = e.target.closest('.edit-comment').getAttribute('data-content');
                
                // Tạo form edit
                const commentItem = e.target.closest('.comment-item');
                const commentContent = commentItem.querySelector('.comment-content');
                const originalContent = commentContent.innerHTML;
                
                commentContent.innerHTML = `
                    <div class="edit-form">
                        <textarea class="form-control mb-2" rows="3">${content}</textarea>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-primary save-edit" data-comment-id="${commentId}">
                                <i class="fas fa-save me-1"></i>Lưu
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary cancel-edit">
                                <i class="fas fa-times me-1"></i>Hủy
                            </button>
                        </div>
                    </div>
                `;
                
                // Focus vào textarea
                commentContent.querySelector('textarea').focus();
            }
        });

        // Xử lý lưu bình luận đã sửa
        document.addEventListener('click', function(e) {
            if (e.target.closest('.save-edit')) {
                const commentId = e.target.closest('.save-edit').getAttribute('data-comment-id');
                const textarea = e.target.closest('.edit-form').querySelector('textarea');
                const newContent = textarea.value.trim();
                
                if (!newContent) {
                    showAlert('Nội dung bình luận không được để trống!', 'warning');
                    return;
                }

                // Gửi AJAX request để cập nhật
                fetch(`/comments/${commentId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        content: newContent
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        // Cập nhật nội dung hiển thị
                        const commentItem = e.target.closest('.comment-item');
                        const commentContent = commentItem.querySelector('.comment-content');
                        commentContent.innerHTML = `<p class="mb-0">${newContent}</p>`;
                    } else {
                        showAlert(data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Có lỗi xảy ra khi cập nhật bình luận!', 'danger');
                });
            }
        });

        // Xử lý hủy sửa bình luận
        document.addEventListener('click', function(e) {
            if (e.target.closest('.cancel-edit')) {
                const commentItem = e.target.closest('.comment-item');
                const commentContent = commentItem.querySelector('.comment-content');
                const originalContent = commentItem.querySelector('.edit-comment').getAttribute('data-content');
                commentContent.innerHTML = `<p class="mb-0">${originalContent}</p>`;
            }
        });

        // Xử lý xóa bình luận
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-comment')) {
                e.preventDefault();
                const commentId = e.target.closest('.delete-comment').getAttribute('data-comment-id');
                
                if (confirm('Bạn có chắc chắn muốn xóa bình luận này?')) {
                    // Gửi AJAX request để xóa
                    fetch(`/comments/${commentId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showAlert(data.message, 'success');
                            // Xóa element khỏi DOM
                            const commentItem = e.target.closest('.comment-item');
                            commentItem.remove();
                            
                            // Cập nhật số lượng bình luận
                            updateCommentCount(-1);
                            
                            // Kiểm tra nếu không còn bình luận nào
                            const remainingComments = document.querySelectorAll('.comment-item');
                            if (remainingComments.length === 0) {
                                const noComments = document.getElementById('noComments');
                                if (noComments) {
                                    noComments.style.display = 'block';
                                }
                            }
                        } else {
                            showAlert(data.message, 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('Có lỗi xảy ra khi xóa bình luận!', 'danger');
                    });
                }
            }
        });
    });

    // Hàm hiển thị thông báo
    function showAlert(message, type = 'info') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Tự động ẩn sau 3 giây
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 3000);
    }

    // Hàm cập nhật số lượng bình luận
    function updateCommentCount(increment = 0) {
        const commentTitle = document.querySelector('.card-title');
        const currentText = commentTitle.textContent;
        const match = currentText.match(/Bình luận \((\d+)\)/);
        
        if (match) {
            const currentCount = parseInt(match[1]);
            const newCount = currentCount + increment;
            commentTitle.innerHTML = `<i class="fas fa-comments me-2 text-success"></i>Bình luận (${newCount})`;
        }
    }

    // Hàm thêm bình luận mới từ dữ liệu server
    function addNewCommentFromData(commentData) {
        const noComments = document.getElementById('noComments');
        if (noComments) {
            noComments.style.display = 'none';
        }

        const commentContainer = document.getElementById('commentsContainer');
        const newComment = document.createElement('div');
        newComment.className = 'comment-item mb-4 p-3 border rounded bg-light new-comment';
        newComment.setAttribute('data-comment-id', commentData.id);
        newComment.innerHTML = `
            <div class="row">
                <!-- Phần bên trái: Avatar và tên người dùng -->
                <div class="col-md-3 col-12 mb-3 mb-md-0">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="mb-2">
                            <img src="{{ $user->avatar ? asset('uploads/avatars/' . $user->avatar) : asset('uploads/images/default-avatar.png') }}" 
                                 class="rounded-circle" alt="User Avatar" width="50" height="50">
                        </div>
                        <div class="text-center">
                            <h6 class="mb-1 fw-bold">${commentData.user.name}</h6>
                        </div>
                    </div>
                </div>
                
                <!-- Phần bên phải: Header (thời gian + nút thao tác) và nội dung bình luận -->
                <div class="col-md-9 col-12">
                    <!-- Header cho mobile: Avatar + tên + nút thao tác -->
                    <div class="d-flex justify-content-between align-items-start mb-2 d-md-none comment-header">
                        <div class="d-flex align-items-center">
                            <img src="{{ $user->avatar ? asset('uploads/avatars/' . $user->avatar) : asset('uploads/images/default-avatar.png') }}" 
                                 class="rounded-circle me-2" alt="User Avatar" width="40" height="40">
                            <div>
                                <h6 class="mb-0 fw-bold">${commentData.user.name}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    <span class="comment-time">Vừa xong</span>
                                </small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <i class="fas fa-edit text-primary edit-comment"
                               data-comment-id="${commentData.id}"
                               data-content="${commentData.content}"
                               title="Sửa bình luận"
                               style="cursor: pointer; font-size: 16px;"></i>
                            <i class="fas fa-trash text-danger delete-comment"
                               data-comment-id="${commentData.id}"
                               title="Xóa bình luận"
                               style="cursor: pointer; font-size: 16px;"></i>
                            <div class="d-flex gap-2" style="font-size: 18px; margin-top: -5px; margin-left: 8px;">
                                #${commentData.id}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Header cho desktop: Thời gian bên trái, nút thao tác bên phải -->
                    <div class="d-flex justify-content-between align-items-center mb-2 d-none d-md-flex comment-header">
                        <div class="text-muted">
                            <small>
                                <i class="fas fa-clock me-1"></i>
                                <span class="comment-time">Vừa xong</span>
                            </small>
                        </div>
                        <div class="d-flex gap-2" style="margin-top: 10px;">
                            <i class="fas fa-edit text-primary edit-comment"
                               data-comment-id="${commentData.id}"
                               data-content="${commentData.content}"
                               title="Sửa bình luận"
                               style="cursor: pointer; font-size: 16px;"></i>
                            <i class="fas fa-trash text-danger delete-comment"
                               data-comment-id="${commentData.id}"
                               title="Xóa bình luận"
                               style="cursor: pointer; font-size: 16px;"></i>
                            <div class="d-flex gap-2" style="font-size: 18px; margin-top: -5px;">
                                #${commentData.id}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nội dung bình luận -->
                    <div class="comment-content">
                        <p class="mb-0">${commentData.content}</p>
                    </div>
                </div>
            </div>
        `;
        
        commentContainer.insertBefore(newComment, commentContainer.firstChild);
    }

</script>
@endpush
