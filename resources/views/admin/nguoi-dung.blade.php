@extends('user.layouts.components.app-layout')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Quản lý người dùng </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Người dùng</li>
                </ol>
            </div>
        </div>
        <!-- Form tìm kiếm -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="search-form">
                    <form method="GET" action="{{ route('admin.nguoi-dung') }}" class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" 
                                       name="search" 
                                       class="form-control" 
                                       placeholder="Nhập từ khoá..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>
                                    Tìm kiếm
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('admin.nguoi-dung') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Xóa bộ lọc
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách người dùng</h3>
                    </div>
                    <div class="card-body">
                        <!-- Thông tin kết quả tìm kiếm -->
                        <div class="row mb-3">
                            <div class="col-md-12 text-end">
                                <span class="text-muted">
                                    @if(request('search'))
                                        Tìm thấy {{ $nguoiDung->total() }} kết quả cho "{{ request('search') }}"
                                    @else
                                        Tổng cộng: {{ $nguoiDung->total() }} người dùng
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        @if(request('search') && $nguoiDung->total() == 0)
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle"></i>
                                Không tìm thấy người dùng nào phù hợp với từ khóa "{{ request('search') }}"
                                <br>
                                <a href="{{ route('admin.nguoi-dung') }}" class="btn btn-sm btn-outline-primary mt-2">
                                    Xem tất cả người dùng
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Tên người dùng</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Vai trò</th>
                                        <th class="text-center">Ngày tạo</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($nguoiDung as $index => $user)
                                    <tr>
                                        <td class="text-center">{{ ($nguoiDung->currentPage() - 1) * $nguoiDung->perPage() + $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td><code>{{ $user->email }}</code></td>
                                        <td>{{ $user->phone ?: 'Không có số điện thoại' }}</td>
                                        <td>
                                            @if($user->role == 'admin')
                                                <span class="badge bg-danger">Admin</span>
                                            @else
                                                <span class="badge bg-primary">Người dùng</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-info" onclick="editNguoiDung({{ $user->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteNguoiDung({{ $user->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Không có người dùng nào</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            </div>
                            
                            <!-- Phân trang -->
                            @if($nguoiDung->hasPages())
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $nguoiDung->links() }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    let currentDanhMucId = null;

    function showToast(message, type = 'success') {
        const toastContainer = document.querySelector('.toast-container') || createToastContainer();
        const toast = document.createElement('div');
        toast.className = `toast ${type === 'error' ? 'error' : ''}`;
        toast.textContent = message;
        
        toastContainer.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);
        
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }
    
    function createToastContainer() {
        const container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
        return container;
    }

    function resetForm() {
        document.getElementById('danhMucForm').reset();
        document.getElementById('danhMucId').value = '';
        document.getElementById('danhMucModalLabel').textContent = 'Thêm danh mục mới';
        document.getElementById('submitBtn').textContent = 'Lưu';
        currentDanhMucId = null;
        
        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
    }

    function editDanhMuc(id) {
        currentDanhMucId = id;
        axios.get(`/admin/dien-dan/danh-muc/${id}`)
            .then(response => {
                const danhMuc = response.data;
                document.getElementById('danhMucId').value = danhMuc.id;
                document.getElementById('tenDanhMuc').value = danhMuc.ten_danh_muc;
                document.getElementById('ghiChu').value = danhMuc.ghi_chu || '';
                document.getElementById('danhMucModalLabel').textContent = 'Sửa danh mục';
                document.getElementById('submitBtn').textContent = 'Cập nhật';
                
                const modal = new bootstrap.Modal(document.getElementById('danhMucModal'));
                modal.show();
            })
            .catch(error => {
                showToast('Có lỗi xảy ra khi tải thông tin danh mục', 'error');
            });
    }

    function deleteDanhMuc(id) {
        currentDanhMucId = id;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (currentDanhMucId) {
            axios.delete(`/admin/dien-dan/danh-muc/${currentDanhMucId}`)
                .then(response => {
                    showToast(response.data.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                })
                .catch(error => {
                    showToast('Có lỗi xảy ra khi xóa danh mục', 'error');
                });
        }
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
        modal.hide();
    });

    document.getElementById('danhMucForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
        
        const url = currentDanhMucId 
            ? `/admin/dien-dan/danh-muc/${currentDanhMucId}`
            : '/admin/dien-dan/danh-muc';
        
        axios.post(url, formData)
            .then(response => {
                showToast(response.data.message);
                const modal = bootstrap.Modal.getInstance(document.getElementById('danhMucModal'));
                modal.hide();
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            })
            .catch(error => {
                if (error.response && error.response.data.errors) {
                    const errors = error.response.data.errors;
                    Object.keys(errors).forEach(field => {
                        const input = document.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                            const errorDiv = document.getElementById(`${field}Error`);
                            if (errorDiv) {
                                errorDiv.textContent = errors[field][0];
                            }
                        }
                    });
                } else {
                    showToast('Có lỗi xảy ra', 'error');
                }
            });
    });

    // Auto-submit form khi nhấn Enter trong ô tìm kiếm
    document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            this.form.submit();
        }
    });
    
    // Focus vào ô tìm kiếm khi trang load
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput && !searchInput.value) {
            searchInput.focus();
        }
    });
</script>

<style>
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
    }
    .toast {
        background: #28a745;
        color: white;
        padding: 12px 20px;
        border-radius: 4px;
        margin-bottom: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateX(100%);
        transition: transform 0.3s ease;
    }
    .toast.show {
        transform: translateX(0);
    }
    .toast.error {
        background: #dc3545;
    }
    
    .table th {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .btn-group .btn {
        margin-right: 5px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    .badge {
        font-size: 0.75em;
    }
    
    .table th {
        font-weight: 600;
        color: #495057;
    }
    
    .alert-info {
        background-color: #d1ecf1;
        border-color: #bee5eb;
        color: #0c5460;
    }
</style>
@endpush
