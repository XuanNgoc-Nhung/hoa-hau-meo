@extends('user.layouts.components.app-layout')
@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Quản lý danh mục diễn đàn</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Danh mục diễn đàn</li>
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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách danh mục diễn đàn</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#danhMucModal" onclick="resetForm()">
                                <i class="fas fa-plus"></i> Thêm danh mục
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="25%">Tên danh mục</th>
                                        <th width="25%">Slug</th>
                                        <th width="30%">Ghi chú</th>
                                        <th width="15%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($danhMucDienDan as $index => $danhMuc)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $danhMuc->ten_danh_muc }}</td>
                                        <td><code>{{ $danhMuc->slug }}</code></td>
                                        <td>{{ $danhMuc->ghi_chu ?: 'Không có ghi chú' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" onclick="editDanhMuc({{ $danhMuc->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteDanhMuc({{ $danhMuc->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Không có danh mục nào</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::App Content-->

<!-- Modal Thêm/Sửa Danh Mục -->
<div class="modal fade" id="danhMucModal" tabindex="-1" aria-labelledby="danhMucModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="danhMucModalLabel">Thêm danh mục mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="danhMucForm">
                <div class="modal-body">
                    <input type="hidden" id="danhMucId" name="id">
                    <div class="mb-3">
                        <label for="tenDanhMuc" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tenDanhMuc" name="ten_danh_muc" required>
                        <div class="invalid-feedback" id="tenDanhMucError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="ghiChu" class="form-label">Ghi chú</label>
                        <textarea class="form-control" id="ghiChu" name="ghi_chu" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Xác nhận xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa danh mục này không?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Xóa</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Setup CSRF token for all axios requests
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    let currentDanhMucId = null;

    // Toast notification function
    function showToast(message, type = 'success') {
        const toastContainer = document.querySelector('.toast-container') || createToastContainer();
        const toast = document.createElement('div');
        toast.className = `toast ${type === 'error' ? 'error' : ''}`;
        toast.textContent = message;
        
        toastContainer.appendChild(toast);
        
        // Show toast
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);
        
        // Hide and remove toast
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }
    
    // Create toast container if not exists
    function createToastContainer() {
        const container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
        return container;
    }

    // Reset form
    function resetForm() {
        document.getElementById('danhMucForm').reset();
        document.getElementById('danhMucId').value = '';
        document.getElementById('danhMucModalLabel').textContent = 'Thêm danh mục mới';
        document.getElementById('submitBtn').textContent = 'Lưu';
        currentDanhMucId = null;
        
        // Clear validation errors
        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
    }

    // Edit danh mục
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

    // Delete danh mục
    function deleteDanhMuc(id) {
        currentDanhMucId = id;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    // Confirm delete
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

    // Handle form submission
    document.getElementById('danhMucForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Clear previous errors
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

    // Auto-generate slug from ten_danh_muc
    document.getElementById('tenDanhMuc').addEventListener('input', function() {
        const tenDanhMuc = this.value;
        const slug = tenDanhMuc
            .toLowerCase()
            .replace(/đ/g, 'd')
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        
        // You can add a hidden input for slug if needed
        // document.getElementById('slug').value = slug;
    });
</script>

<style>
    /* Toast notification */
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
    
    /* Table styles */
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
</style>
@endpush
