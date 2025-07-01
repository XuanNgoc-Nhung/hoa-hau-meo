@extends('user.layouts.components.app-layout')
@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Thông tin tài khoản</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thông tin tài khoản</li>
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
        <!--begin::Row-->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Cập nhật thông tin cá nhân</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.update-profile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <!-- Avatar Section -->
                                <div class="col-md-4 text-center mb-4">
                                    <div class="avatar-section">
                                        <div class="avatar-preview mb-3">
                                            <img id="avatar-preview" 
                                                 src="{{ auth()->user()->avatar ? asset('uploads/avatars/' . auth()->user()->avatar) : asset('uploads/images/default-avatar.png') }}" 
                                                 alt="Avatar" 
                                                 class="rounded-circle border"
                                                 style="width: 150px; height: 150px; object-fit: cover;">
                                        </div>
                                        <div class="avatar-upload">
                                            <label for="avatar" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-camera"></i> Chọn ảnh
                                            </label>
                                            <input type="file" id="avatar" name="avatar" class="d-none" accept="image/*">
                                        </div>
                                        <small class="text-muted d-block mt-2">Hỗ trợ: JPG, PNG, GIF (Tối đa 2MB)</small>
                                    </div>
                                </div>

                                <!-- Profile Information -->
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" 
                                                   value="{{ old('name', auth()->user()->name) }}" 
                                                   placeholder="Nhập họ và tên của bạn"
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" value="{{ auth()->user()->email }}" disabled>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                                            <input type="text" class="form-control @error('so_dien_thoai') is-invalid @enderror" 
                                                   id="so_dien_thoai" name="so_dien_thoai" 
                                                   value="{{ old('so_dien_thoai', auth()->user()->so_dien_thoai) }}"
                                                   placeholder="Nhập số điện thoại của bạn">
                                            @error('so_dien_thoai')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="dia_chi" class="form-label">Địa chỉ</label>
                                            <input type="text" class="form-control @error('dia_chi') is-invalid @enderror" 
                                                   id="dia_chi" name="dia_chi" 
                                                   value="{{ old('dia_chi', auth()->user()->dia_chi) }}"
                                                   placeholder="Nhập địa chỉ của bạn">
                                            @error('dia_chi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Cập nhật thông tin
                                            </button>
                                            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left"></i> Quay lại
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<!--end::App Content-->

<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-check-circle me-2"></i>
                <span id="successMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    
    <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-exclamation-circle me-2"></i>
                <span id="errorMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hiển thị toast thông báo
    @if(session('success'))
        showToast('success', '{{ session('success') }}');
    @endif

    @if(session('error'))
        showToast('error', '{{ session('error') }}');
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            showToast('error', '{{ $error }}');
        @endforeach
    @endif

    // Preview avatar khi chọn file
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatar-preview');

    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Kiểm tra kích thước file (2MB)
            if (file.size > 2 * 1024 * 1024) {
                showToast('error', 'File quá lớn. Vui lòng chọn file nhỏ hơn 2MB.');
                this.value = '';
                return;
            }

            // Kiểm tra loại file
            if (!file.type.match('image.*')) {
                showToast('error', 'Vui lòng chọn file hình ảnh.');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                avatarPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Hàm hiển thị toast
    function showToast(type, message) {
        const toastId = type === 'success' ? 'successToast' : 'errorToast';
        const messageId = type === 'success' ? 'successMessage' : 'errorMessage';
        
        document.getElementById(messageId).textContent = message;
        
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, {
            autohide: true,
            delay: 5000
        });
        
        toast.show();
    }
});
</script>
@endpush
