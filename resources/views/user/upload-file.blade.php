@extends('user.layouts.components.app-layout')
@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tải ảnh </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tải ảnh</li>
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
                    <div class="card-body">
                        <h5 class="card-title">Tải ảnh</h5>
                        <form id="uploadForm" method="POST" action="{{ route('user.upload-file.post') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="images" class="form-label">Chọn hình ảnh</label>
                                <input class="form-control" type="file" id="images" name="images[]" multiple accept="image/*">
                                <small class="form-text text-muted d-block mt-2">Mỗi lần upload tối đa <b>12 hình ảnh</b>, mỗi hình ảnh tối đa <b>3MB</b>.</small>
                            </div>
                            <div id="error-message" class="text-danger mb-2"></div>
                            <div id="success-message" class="text-success mb-2"></div>
                            <div id="preview" class="mb-3 d-flex flex-wrap gap-2"></div>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                Tải lên
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mt-3">
                <h5 class="mb-1">Hình ảnh đã upload</h5>
                <div class="card">
                    <div class="card-body">
                        @if($images->count() > 0)
                            <div class="uploaded-images-grid" id="uploaded-images">
                                @foreach($images as $image)
                                    <div class="image-item position-relative">
                                        <img src="{{ asset('uploads/images/' . $image->path) }}" 
                                             class="img-fluid rounded" 
                                             alt="Uploaded image"
                                             style="width: 100%; height: 200px; object-fit: cover; border: 1px solid #ddd;">
                                        <div class="image-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
                                             style="background: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.3s; border-radius: 0.375rem;">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-light" onclick="copyImageUrl('{{ asset('uploads/images/' . $image->path) }}')">
                                                    <i class="fas fa-copy"></i> Copy URL
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteImage({{ $image->id }})">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <small class="text-muted">{{ $image->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Chưa có hình ảnh nào được upload</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection

<!-- Modal hiển thị URL đã upload -->
<div class="modal fade" id="uploadSuccessModal" tabindex="-1" aria-labelledby="uploadSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadSuccessModalLabel">Danh sách URL ảnh đã upload</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <textarea id="uploadedUrls" class="form-control mb-3" rows="6" readonly></textarea>
        <button class="btn btn-outline-primary" id="copyUrlsBtn">Copy</button>
        <span id="copySuccessMsg" class="text-success ms-2" style="display:none;">Đã copy!</span>
      </div>
    </div>
  </div>
</div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Thêm Bootstrap JS nếu chưa có -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        #preview {
            display: grid !important;
            grid-template-columns: repeat(6, 1fr) !important;
            gap: 12px !important;
        }
        .preview-item {
            position: relative !important;
            width: 100% !important;
        }
        #preview img {
            width: 100% !important;
            height: 18vw !important;
            max-height: 160px !important;
            object-fit: cover !important;
            border: 1px solid #ddd !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05) !important;
            background: #f8f9fa !important;
        }
        .delete-btn {
            position: absolute !important;
            top: 5px !important;
            right: 5px !important;
            background: rgba(220, 53, 69, 0.9) !important;
            color: white !important;
            border: none !important;
            border-radius: 50% !important;
            width: 25px !important;
            height: 25px !important;
            font-size: 12px !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: background-color 0.2s !important;
        }
        .delete-btn:hover {
            background: rgba(220, 53, 69, 1) !important;
        }
        
        /* CSS cho danh sách hình ảnh đã upload */
        .uploaded-images-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
        }
        @media (max-width: 1200px) {
            .uploaded-images-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
        @media (max-width: 992px) {
            .uploaded-images-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media (max-width: 768px) {
            .uploaded-images-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 576px) {
            .uploaded-images-grid {
                grid-template-columns: 1fr;
            }
        }
        .image-item {
            cursor: pointer;
            transition: transform 0.2s;
        }
        .image-item:hover {
            transform: translateY(-2px);
        }
        .image-item:hover .image-overlay {
            opacity: 1 !important;
        }
        .image-item .btn-group {
            opacity: 0;
            transition: opacity 0.3s;
        }
        .image-item:hover .btn-group {
            opacity: 1;
        }
        
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
    </style>
    <script>
        let selectedFiles = [];
        
        document.getElementById('images').addEventListener('change', function(event) {
            const preview = document.getElementById('preview');
            const errorMessage = document.getElementById('error-message');
            const successMessage = document.getElementById('success-message');
            const input = event.target;
            preview.innerHTML = '';
            errorMessage.innerHTML = '';
            successMessage.innerHTML = '';
            selectedFiles = [];
            
            let files = Array.from(input.files);
            let errors = [];
            
            if (files.length > 12) {
                errors.push('Chỉ được chọn tối đa 12 hình ảnh. Vui lòng chọn lại.');
                errorMessage.innerHTML = errors.join('<br>');
                input.value = '';
                return;
            }
            
            let validFiles = [];
            files.forEach((file, idx) => {
                if (file.size > 3 * 1024 * 1024) {
                    errors.push(`Hình ảnh "${file.name}" vượt quá 3MB và sẽ bị bỏ qua.`);
                } else {
                    validFiles.push(file);
                }
            });
            
            if (errors.length > 0) {
                errorMessage.innerHTML = errors.join('<br>');
            }
            
            validFiles.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'preview-item';
                        previewItem.dataset.index = index;
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        
                        const deleteBtn = document.createElement('button');
                        deleteBtn.className = 'delete-btn';
                        deleteBtn.innerHTML = '×';
                        deleteBtn.onclick = function() {
                            removeFile(index);
                        };
                        
                        previewItem.appendChild(img);
                        previewItem.appendChild(deleteBtn);
                        preview.appendChild(previewItem);
                    };
                    reader.readAsDataURL(file);
                    selectedFiles.push(file);
                }
            });
        });
        
        function removeFile(index) {
            selectedFiles.splice(index, 1);
            updatePreview();
        }
        
        function updatePreview() {
            const preview = document.getElementById('preview');
            preview.innerHTML = '';
            
            selectedFiles.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'preview-item';
                        previewItem.dataset.index = index;
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        
                        const deleteBtn = document.createElement('button');
                        deleteBtn.className = 'delete-btn';
                        deleteBtn.innerHTML = '×';
                        deleteBtn.onclick = function() {
                            removeFile(index);
                        };
                        
                        previewItem.appendChild(img);
                        previewItem.appendChild(deleteBtn);
                        preview.appendChild(previewItem);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
        
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (selectedFiles.length === 0) {
                document.getElementById('error-message').innerHTML = 'Vui lòng chọn ít nhất một hình ảnh.';
                return;
            }
            
            const submitBtn = document.getElementById('submitBtn');
            const spinner = submitBtn.querySelector('.spinner-border');
            const originalText = submitBtn.innerHTML;
            
            // Hiển thị loading
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang tải lên...';
            
            // Tạo FormData
            const formData = new FormData();
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            
            selectedFiles.forEach((file, index) => {
                formData.append(`images[${index}]`, file);
            });
            
            // Gửi request bằng axios
            axios.post('{{ route("user.upload-file.post") }}', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function (response) {
                document.getElementById('success-message').innerHTML = response.data.message || 'Tải lên thành công!';
                document.getElementById('error-message').innerHTML = '';
                
                // Reset form
                selectedFiles = [];
                document.getElementById('images').value = '';
                document.getElementById('preview').innerHTML = '';
                
                // Ẩn loading
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
                submitBtn.innerHTML = originalText;

                // Hiển thị modal với danh sách URL
                if (response.data.urls && Array.isArray(response.data.urls)) {
                    const urls = response.data.urls.join('\n');
                    document.getElementById('uploadedUrls').value = urls;
                    document.getElementById('copySuccessMsg').style.display = 'none';
                    const modal = new bootstrap.Modal(document.getElementById('uploadSuccessModal'));
                    modal.show();
                }
                
                // Reload danh sách hình ảnh
                setTimeout(() => {
                    location.reload();
                }, 2000);
            })
            .catch(function (error) {
                let errorMessage = 'Có lỗi xảy ra khi tải lên.';
                
                if (error.response && error.response.data) {
                    if (error.response.data.message) {
                        errorMessage = error.response.data.message;
                    } else if (error.response.data.errors) {
                        errorMessage = Object.values(error.response.data.errors).flat().join('<br>');
                    }
                }
                
                document.getElementById('error-message').innerHTML = errorMessage;
                document.getElementById('success-message').innerHTML = '';
                
                // Ẩn loading
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
                submitBtn.innerHTML = originalText;
            });
        });

    // Copy URLs
    document.getElementById('copyUrlsBtn').addEventListener('click', function() {
        const textarea = document.getElementById('uploadedUrls');
        textarea.select();
        textarea.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand('copy');
        document.getElementById('copySuccessMsg').style.display = 'inline';
        setTimeout(() => {
            document.getElementById('copySuccessMsg').style.display = 'none';
        }, 1500);
    });
    
    // Copy image URL function
    function copyImageUrl(url) {
        navigator.clipboard.writeText(url).then(function() {
            showToast('Đã copy URL ảnh!', 'success');
        }).catch(function() {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = url;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showToast('Đã copy URL ảnh!', 'success');
        });
    }
    
    // Delete image function
    function deleteImage(imageId) {
        if (confirm('Bạn có chắc chắn muốn xóa hình ảnh này?')) {
            axios.delete(`/user/delete-image/${imageId}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function (response) {
                showToast('Đã xóa hình ảnh thành công!', 'success');
                // Reload page to update the list
                setTimeout(() => {
                    location.reload();
                }, 1000);
            })
            .catch(function (error) {
                showToast('Có lỗi xảy ra khi xóa hình ảnh!', 'error');
            });
        }
    }
    
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
    </script>
    @endpush
