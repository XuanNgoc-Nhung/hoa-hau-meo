@extends('user.layouts.components.app-layout')
@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Diễn của tôi
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
                        <h4 class="card-title">Danh sách diễn đàn của tôi
                    </div>
                    <div class="card-body">
                        @if($dienDanCuaToi->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        @foreach($dienDanCuaToi as $dien)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-start">
                                                        <!-- Hình ảnh -->
                                                        <div class="me-3 flex-shrink-0">
                                                            @if($dien->hinh_anh)
                                                                @php
                                                                    // Xử lý hinh_anh - lấy URL đầu tiên từ danh sách
                                                                    $hinhAnhArray = explode("\n", $dien->hinh_anh);
                                                                    $hinhAnhArray = array_filter($hinhAnhArray, function($url) {
                                                                        return !empty(trim($url));
                                                                    });
                                                                    $imagePath = !empty($hinhAnhArray) ? trim($hinhAnhArray[0]) : null;
                                                                @endphp
                                                                @if($imagePath)
                                                                <a href="{{ route('dien-dan.chi-tiet', [ 'slug' => $dien->slug]) }}">
                                                                    <img src="{{ $imagePath }}"
                                                                         class="img-fluid rounded"
                                                                         alt="{{ $dien->ten_dien_dan }}"
                                                                         style="width: 60px; height: 60px; object-fit: cover;">
                                                                </a>
                                                                @else
                                                                    <div class="d-flex align-items-center justify-content-center bg-light rounded"
                                                                         style="width: 60px; height: 60px;">
                                                                        <i class="fas fa-image text-muted" style="font-size: 1.2rem;"></i>
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <div class="d-flex align-items-center justify-content-center bg-light rounded"
                                                                     style="width: 60px; height: 60px;">
                                                                    <i class="fas fa-image text-muted" style="font-size: 1.2rem;"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        
                                                        <!-- Thông tin diễn đàn -->
                                                        <div class="flex-grow-1">
                                                            <!-- Tên diễn đàn có thể click -->
                                                            <h5 class="mb-2 fw-bold">
                                                                <a href="{{ route('dien-dan.chi-tiet', [ 'slug' => $dien->slug]) }}" 
                                                                   class="text-primary text-decoration-none">
                                                                    {{ $dien->ten_dien_dan }}
                                                                </a>
                                                                <small class="text-success ms-2 fst-italic" style="font-size: 0.75rem;">
                                                                    <i class="fas fa-comments me-2 text-success"></i>
                                                                    {{ $dien->last_comment }}
                                                                </small>
                                                            </h5>
                                                            
                                                            <!-- Vị trí, giá, trạng thái -->
                                                            <div>
                                                                @if($dien->vi_tri)
                                                                    <span class="badge bg-info me-2"><i class="fas fa-map-marker-alt"></i> {{ $dien->vi_tri }}</span>
                                                                @endif
                                                                @if($dien->muc_gia)
                                                                    <span class="badge bg-warning text-dark me-2"><i class="fas fa-coins"></i> {{ $dien->muc_gia }}</span>
                                                                @endif
                                                                @if($dien->trang_thai)
                                                                    <span class="badge bg-success">Hoạt động</span>
                                                                @else
                                                                    <span class="badge bg-secondary">Không hoạt động</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column text-muted small">
                                                        <div class="mb-1">
                                                            <i class="fas fa-eye me-2 text-info"></i>
                                                            <span>{{ $dien->total_view ?? rand(10, 500) }}</span>
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-comments me-2 text-success"></i>
                                                            <span>{{ $dien->total_comment ?? rand(0, 50) }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column text-muted small">
                                                        <div class="mb-1">
                                                            <i class="fas fa-user me-2 text-primary"></i>
                                                            <span>{{ $dien->user->name ?? 'Admin' }}</span>
                                                        </div>
                                                        <div class="mb-1">
                                                            <i class="fas fa-clock me-2 text-warning"></i>
                                                            <span>{{ $dien->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        {{-- <div>
                                                            <i class="fas fa-calendar me-2 text-secondary"></i>
                                                            <span>{{ $dien->created_at->format('d/m/Y H:i') }}</span>
                                                        </div> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            @if($dienDanCuaToi->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $dienDanCuaToi->links() }}
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox text-muted" style="font-size: 4rem;"></i>
                                <h5 class="mt-3 text-muted">Chưa có diễn đàn nào trong danh mục này</h5>
                                <p class="text-muted">Hãy quay lại sau hoặc chọn danh mục khác</p>
                                <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Quay về trang chủ
                                </a>
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
<script>
function viewDetail(id) {
    // Có thể thêm modal hoặc chuyển hướng đến trang chi tiết
    alert('Xem chi tiết diễn đàn ID: ' + id);
    // window.location.href = '/dien-dan-detail/' + id;
}
</script>
@endpush
