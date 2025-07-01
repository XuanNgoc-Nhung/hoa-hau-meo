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
                        <h4 class="card-title">Tổng quan về hệ thống</h4>
                        <br>
                        <small class="text-muted mb-0">Các thành phần ở đây có thể tuỳ biến, bổ sung theo yêu cầu của bạn</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Tổng danh mục</span>
                                        <span class="info-box-number">{{ $thongKe['totalDanhMuc'] }}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Tổng diễn đàn</span>
                                        <span class="info-box-number">{{ $thongKe['totalDienDan'] }}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Tổng người dùng</span>
                                        <span class="info-box-number">{{ $thongKe['totalNguoiDung'] }}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Tổng bình luận</span>
                                        <span class="info-box-number">{{ $thongKe['totalComment'] }}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                        </div>
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
