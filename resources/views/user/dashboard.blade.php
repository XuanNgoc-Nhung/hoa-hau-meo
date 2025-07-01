@extends('user.layouts.components.app-layout')
@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Trang chủ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item active" aria-current="page">Trang chủ</li>
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
                        <h4 class="card-title">Danh mục diễn đàn</h4>
                        <p class="text-muted mb-0">Chọn danh mục để xem các diễn đàn liên quan</p>
                    </div>
                    <div class="card-body">
                        @if($danhMucs->count() > 0)
                            <div class="row">
                                @foreach($danhMucs as $danhMuc)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100 shadow-sm border-0">
                                            <div class="card-body text-center">
                                                <div class="mb-3">
                                                    <i class="fas fa-folder text-primary" style="font-size: 3rem;"></i>
                                                </div>
                                                <h5 class="card-title">{{ $danhMuc->ten_danh_muc }}</h5>
                                                @if($danhMuc->ghi_chu)
                                                    <p class="card-text text-muted">{{ Str::limit($danhMuc->ghi_chu, 100) }}</p>
                                                @endif
                                                <div class="mt-3">
                                                    <a href="{{ route('dien-dan-theo-danh-muc', $danhMuc->slug) }}" 
                                                       class="btn btn-primary">
                                                        <i class="fas fa-eye me-2"></i>Xem diễn đàn
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-folder-open text-muted" style="font-size: 4rem;"></i>
                                <h5 class="mt-3 text-muted">Chưa có danh mục diễn đàn nào</h5>
                                <p class="text-muted">Vui lòng liên hệ quản trị viên để thêm danh mục</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<!--end::App Content-->
@endsection

@push('scripts')
@endpush
