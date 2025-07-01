@extends('user.layouts.components.app-layout')

@section('title', 'Quản lý Diễn đàn')

@section('content')
<style>
    .carousel-image-clickable {
        transition: transform 0.2s ease-in-out;
    }
    
    .carousel-image-clickable:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }
    
    #imagePreviewModal .modal-body {
        background-color: #f8f9fa;
    }
    
    #previewImage {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background-color: rgba(0,0,0,0.9) !important;
        transform: translateY(-50%) scale(1.1);
    }
    
    /* Tăng khoảng cách giữa các input trong modal */
    #modalDienDan .row {
        margin-bottom: 1.5rem;
    }
    
    #modalDienDan .form-group {
        margin-bottom: 1.25rem;
    }
    
    #modalDienDan .form-group label {
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    
    #modalDienDan .form-control {
        margin-bottom: 0.5rem;
    }
    
    /* Tăng khoảng cách giữa các hàng */
    #modalDienDan .row + .row {
        margin-top: 1rem;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quản lý Diễn đàn</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDienDan">
                            <i class="fas fa-plus"></i> Thêm Diễn đàn
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="tableDienDan">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="10%">Danh mục</th>
                                    <th width="15%">Tên diễn đàn</th>
                                    <th width="10%">Slug</th>
                                    <th width="8%">Hình ảnh</th>
                                    <th width="10%">Vị trí</th>
                                    <th width="8%">Thẻ tìm kiếm</th>
                                    <th width="10%">Số điện thoại</th>
                                    <th width="8%">Mức giá</th>
                                    <th width="8%">Người tạo</th>
                                    <th width="10%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($danhSachDienDan as $dienDan)
                                <tr>
                                    <td>{{ $dienDan->id }}</td>
                                    <td>{{ $dienDan->danhMucDienDan->ten_danh_muc ?? 'N/A' }}</td>
                                    <td>{{ $dienDan->ten_dien_dan }}</td>
                                    <td>{{ $dienDan->slug }}</td>
                                    <td>
                                        @if($dienDan->hinh_anh)
                                            @php
                                                $hinhAnhArray = explode("\n", $dienDan->hinh_anh);
                                                $hinhAnhArray = array_filter($hinhAnhArray, function($url) {
                                                    return !empty(trim($url));
                                                });
                                            @endphp
                                            @if(count($hinhAnhArray) > 0)
                                                <div id="carousel-{{ $dienDan->id }}" class="carousel slide" data-bs-ride="false" style="width: 200px; height: 150px; position: relative;">
                                                    <div class="carousel-inner" style="height: 100%;">
                                                        @foreach($hinhAnhArray as $index => $hinhAnh)
                                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" style="height: 100%;">
                                                                <img src="{{ trim($hinhAnh) }}" alt="Hình ảnh {{ $index + 1 }}" 
                                                                     class="d-block w-100 h-100 carousel-image-clickable" style="object-fit: cover; width: 200px; height: 150px; cursor: pointer;"
                                                                     data-image-url="{{ trim($hinhAnh) }}" 
                                                                     data-image-title="Hình ảnh {{ $index + 1 }} - {{ $dienDan->ten_dien_dan }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @if(count($hinhAnhArray) > 1)
                                                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $dienDan->id }}" data-bs-slide="prev" 
                                                                style="width: 40px; height: 40px; top: 50%; transform: translateY(-50%); left: 5px; background-color: rgba(0,0,0,0.7); border-radius: 50%; border: 2px solid white;">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true" style="width: 20px; height: 20px;"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $dienDan->id }}" data-bs-slide="next" 
                                                                style="width: 40px; height: 40px; top: 50%; transform: translateY(-50%); right: 5px; background-color: rgba(0,0,0,0.7); border-radius: 50%; border: 2px solid white;">
                                                            <span class="carousel-control-next-icon" aria-hidden="true" style="width: 20px; height: 20px;"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button>
                                                        <div class="carousel-indicators" style="bottom: 5px; margin-bottom: 0;">
                                                            @foreach($hinhAnhArray as $index => $hinhAnh)
                                                                <button type="button" data-bs-target="#carousel-{{ $dienDan->id }}" data-bs-slide-to="{{ $index }}" 
                                                                        class="{{ $index === 0 ? 'active' : '' }}" 
                                                                        style="width: 10px; height: 10px; border-radius: 50%; margin: 0 3px; background-color: rgba(255,255,255,0.5); border: 2px solid white;"></button>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">Không có</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Không có</span>
                                        @endif
                                    </td>
                                    <td>{{ $dienDan->vi_tri }}</td>
                                    <td>{{ $dienDan->the_tim_kiem ?: 'N/A' }}</td>
                                    <td>{{ $dienDan->so_dien_thoai ?: 'N/A' }}</td>
                                    <td>{{ $dienDan->muc_gia ?: 'N/A' }}</td>
                                    <td>{{ $dienDan->user->name ?? 'N/A' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" onclick="editDienDan({{ $dienDan->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteDienDan({{ $dienDan->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm/Sửa Diễn đàn -->
<div class="modal fade" id="modalDienDan" tabindex="-1" role="dialog" aria-labelledby="modalDienDanLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="min-width:900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDienDanLabel">Thêm Diễn đàn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formDienDan" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="dienDanId" name="id">
                    
                    <!-- Hàng 1: Danh mục, Tên diễn đàn, Vị trí, Số điện thoại -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="danh_muc_id">Danh mục <span class="text-danger">*</span></label>
                                <select class="form-control" id="danh_muc_id" name="danh_muc_id" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach($danhMucDienDan as $danhMuc)
                                        <option value="{{ $danhMuc->id }}">{{ $danhMuc->ten_danh_muc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ten_dien_dan">Tên diễn đàn <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ten_dien_dan" name="ten_dien_dan" placeholder="Nhập tên diễn đàn" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="vi_tri">Vị trí <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="vi_tri" name="vi_tri" placeholder="Ví dụ: Hà Nội, TP.HCM, Đà Nẵng" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="so_dien_thoai">Số điện thoại</label>
                                <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" placeholder="Ví dụ: 0123456789">
                            </div>
                        </div>
                    </div>

                    <!-- Hàng 2: Thẻ tìm kiếm, Mức giá, Trạng thái, (trống) -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="the_tim_kiem">Thẻ tìm kiếm</label>
                                <input type="text" class="form-control" id="the_tim_kiem" name="the_tim_kiem" placeholder="Ví dụ: tag1, tag2, tag3">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="muc_gia">Mức giá</label>
                                <input type="text" class="form-control" id="muc_gia" name="muc_gia" placeholder="Ví dụ: 100,000 - 500,000 VNĐ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="trang_thai">Trạng thái <span class="text-danger">*</span></label>
                                <select class="form-control" id="trang_thai" name="trang_thai" required>
                                    <option value="1">Hiện</option>
                                    <option value="0">Ẩn</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <!-- Ô trống -->
                        </div>
                    </div>

                    <!-- Hàng 3: Danh sách hình ảnh (100% width) -->
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="hinh_anh">Danh sách hình ảnh</label>
                                <textarea class="form-control" id="hinh_anh" name="hinh_anh" rows="4" placeholder="Nhập URL hình ảnh, mỗi URL một dòng&#10;Ví dụ:&#10;https://example.com/image1.jpg&#10;https://example.com/image2.png"></textarea>
                                <small class="form-text text-muted">Nhập URL hình ảnh, mỗi URL một dòng. Tối đa 12 hình ảnh.</small>
                            </div>
                            <!-- Preview hình ảnh -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <h6>Preview hình ảnh:</h6>
                                <div id="imagePreviewContainer" class="row g-2">
                                    <!-- Hình ảnh sẽ được hiển thị ở đây -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hàng 4: Chi tiết -->
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="chi_tiet">Chi tiết</label>
                                <textarea class="form-control" id="chi_tiet" name="chi_tiet" rows="5" placeholder="Nhập mô tả chi tiết về diễn đàn..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-warning" id="btnFillSample">Điền dữ liệu mẫu</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Preview Hình ảnh -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewModalLabel">Preview Hình ảnh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Preview" class="img-fluid" style="max-height: 70vh; max-width: 100%;">
                <p id="previewImageTitle" class="mt-3 text-muted"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <a id="downloadImageLink" href="" download class="btn btn-primary">
                    <i class="fas fa-download"></i> Tải xuống
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
<script>
console.log('=== SCRIPT ĐÃ ĐƯỢC TẢI ===');

// Thiết lập CSRF token cho mọi AJAX request
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
console.log('Đã thiết lập CSRF token');

let editor;
let modalDienDan;
let imagePreviewModal;

$(document).ready(function() {
    console.log('=== BẮT ĐẦU KHỞI TẠO TRANG ===');
    
    // Khởi tạo Bootstrap 5 modal
    modalDienDan = new bootstrap.Modal(document.getElementById('modalDienDan'));
    imagePreviewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    console.log('Đã khởi tạo Bootstrap modal:', modalDienDan);
    console.log('Đã khởi tạo Image Preview modal:', imagePreviewModal);
    
    // Xử lý click vào hình ảnh trong carousel
    $(document).on('click', '.carousel-image-clickable', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const imageUrl = $(this).data('image-url');
        const imageTitle = $(this).data('image-title');
        
        console.log('Click vào hình ảnh:', imageUrl);
        console.log('Tiêu đề hình ảnh:', imageTitle);
        
        // Cập nhật modal preview
        $('#previewImage').attr('src', imageUrl);
        $('#previewImageTitle').text(imageTitle);
        $('#downloadImageLink').attr('href', imageUrl);
        
        // Hiển thị modal
        imagePreviewModal.show();
    });
    
    // Khởi tạo CKEditor
    const chiTietElement = document.querySelector('#chi_tiet');
    console.log('Tìm thấy phần tử CKEditor:', chiTietElement);
    
    if (chiTietElement) {
        ClassicEditor
            .create(chiTietElement, {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo']
            })
            .then(newEditor => {
                editor = newEditor;
                console.log('Đã khởi tạo CKEditor thành công:', editor);
            })
            .catch(error => {
                console.error('Khởi tạo CKEditor thất bại:', error);
            });
    }

    // Xử lý preview hình ảnh
    $('#hinh_anh').on('input', function() {
        console.log('Phát hiện nhập liệu textarea, gọi updateImagePreview()');
        updateImagePreview();
    });

    // Xử lý form submit
    $('#formDienDan').on('submit', function(e) {
        console.log('=== BẮT ĐẦU GỬI FORM ===');
        e.preventDefault();
        
        let formData = new FormData(this);
        let dienDanId = $('#dienDanId').val();
        let url = dienDanId ? `/admin/dien-dan/${dienDanId}` : "{{ route('admin.dien-dan.store') }}";
        let method = dienDanId ? 'POST' : 'POST';
        
        console.log('Đã chuẩn bị dữ liệu form:');
        console.log('- ID Diễn đàn:', dienDanId);
        console.log('- URL:', url);
        console.log('- Phương thức:', method);
        
        // Thêm chi tiết từ CKEditor
        const editorData = editor.getData();
        formData.set('chi_tiet', editorData);
        console.log('Đã thêm dữ liệu CKEditor vào form:', editorData);
        
        console.log('Đang gửi yêu cầu AJAX...');
        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('=== AJAX THÀNH CÔNG ===');
                console.log('Nhận được phản hồi:', response);
                if (response.success) {
                    console.log('Thông báo thành công:', response.message);
                    toastr.success(response.message);
                    modalDienDan.hide();
                    console.log('Đã ẩn modal, tải lại trang sau 1 giây...');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(xhr) {
                console.log('=== AJAX LỖI ===');
                console.log('Phản hồi lỗi:', xhr);
                let errors = xhr.responseJSON.errors;
                if (errors) {
                    console.log('Tìm thấy lỗi validation:', errors);
                    Object.keys(errors).forEach(function(key) {
                        console.log('Lỗi cho trường', key, ':', errors[key][0]);
                        toastr.error(errors[key][0]);
                    });
                } else {
                    console.log('Đã xảy ra lỗi chung');
                    toastr.error('Có lỗi xảy ra!');
                }
            }
        });
    });

    // Reset form khi đóng modal
    document.getElementById('modalDienDan').addEventListener('hidden.bs.modal', function() {
        console.log('=== SỰ KIỆN ẨN MODAL ===');
        $('#formDienDan')[0].reset();
        $('#dienDanId').val('');
        $('#modalDienDanLabel').text('Thêm Diễn đàn');
        console.log('Đã reset form');
        
        if (editor) {
            editor.setData('');
            console.log('Đã xóa nội dung CKEditor');
        }
        
        // Ẩn preview hình ảnh
        $('#imagePreview').hide();
        $('#imagePreviewContainer').empty();
        console.log('Đã ẩn và xóa preview hình ảnh');
    });

    // Nút điền dữ liệu mẫu
    $('#btnFillSample').on('click', function() {
        console.log('=== BẮT ĐẦU ĐIỀN DỮ LIỆU MẪU ===');
        
        const danhMucValue = $('#danh_muc_id option:eq(1)').val();
        $('#danh_muc_id').val(danhMucValue);
        console.log('Đã đặt danh mục thành:', danhMucValue);
        
        $('#ten_dien_dan').val('Diễn đàn mẫu');
        console.log('Đã đặt tên diễn đàn thành: Diễn đàn mẫu');
        
        $('#vi_tri').val('Hà Nội');
        console.log('Đã đặt vị trí thành: Hà Nội');
        
        $('#the_tim_kiem').val('mau, demo, test');
        console.log('Đã đặt thẻ tìm kiếm thành: mau, demo, test');
        
        $('#so_dien_thoai').val('0123456789');
        console.log('Đã đặt số điện thoại thành: 0123456789');
        
        $('#muc_gia').val('200,000 - 500,000 VNĐ');
        console.log('Đã đặt mức giá thành: 200,000 - 500,000 VNĐ');
        
        $('#trang_thai').val('1');
        console.log('Đã đặt trạng thái thành: 1');
        
        $('#hinh_anh').val('https://via.placeholder.com/150\nhttps://via.placeholder.com/100\nhttps://via.placeholder.com/200');
        console.log('Đã đặt URL hình ảnh');
        
        if (editor) {
            const sampleContent = '<p>Đây là nội dung chi tiết mẫu cho diễn đàn.</p><ul><li>Điểm nổi bật 1</li><li>Điểm nổi bật 2</li></ul>';
            editor.setData(sampleContent);
            console.log('Đã đặt nội dung CKEditor thành dữ liệu mẫu');
        }
        
        updateImagePreview();
        console.log('=== HOÀN THÀNH ĐIỀN DỮ LIỆU MẪU ===');
    });
    
    console.log('=== HOÀN THÀNH KHỞI TẠO TRANG ===');
});

// Hàm cập nhật preview hình ảnh
function updateImagePreview() {
    console.log('=== BẮT ĐẦU CẬP NHẬT PREVIEW HÌNH ẢNH ===');
    console.log('Giá trị textarea hiện tại:', $('#hinh_anh').val());
    
    const imageUrls = $('#hinh_anh').val().split('\n').filter(url => url.trim() !== '');
    console.log('URL hình ảnh đã lọc:', imageUrls);
    
    const previewContainer = $('#imagePreviewContainer');
    const previewSection = $('#imagePreview');
    
    // Xóa preview cũ
    previewContainer.empty();
    console.log('Đã xóa preview cũ');
    
    if (imageUrls.length === 0) {
        previewSection.hide();
        console.log('Không có hình ảnh, ẩn phần preview');
        return;
    }
    
    // Giới hạn tối đa 12 hình ảnh
    const limitedUrls = imageUrls.slice(0, 12);
    console.log('URL giới hạn (tối đa 12):', limitedUrls);
    
    limitedUrls.forEach((url, index) => {
        const trimmedUrl = url.trim();
        console.log(`Đang xử lý URL ${index + 1}:`, trimmedUrl);
        
        if (trimmedUrl) {
            const colDiv = $('<div class="col-md-1 col-sm-2 col-3"></div>');
            const imgDiv = $('<div class="position-relative"></div>');
            const img = $('<img>', {
                src: trimmedUrl,
                class: 'img-thumbnail',
                style: 'width: 80px; height: 80px; object-fit: cover;',
                alt: `Hình ảnh ${index + 1}`,
            });
            
            // Thêm nút xóa
            const removeBtn = $('<button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" style="font-size: 8px; padding: 2px 4px;">×</button>');
            removeBtn.on('click', function() {
                console.log(`Đã nhấn nút xóa cho hình ảnh ${index + 1}`);
                removeImageUrl(index);
            });
            
            imgDiv.append(img).append(removeBtn);
            colDiv.append(imgDiv);
            previewContainer.append(colDiv);
            console.log(`Đã thêm hình ảnh ${index + 1} vào preview`);
        }
    });
    
    previewSection.show();
    console.log('Đã hiển thị phần preview');
    console.log('=== HOÀN THÀNH CẬP NHẬT PREVIEW HÌNH ẢNH ===');
}

// Hàm xóa URL hình ảnh
function removeImageUrl(index) {
    console.log('=== BẮT ĐẦU XÓA URL HÌNH ẢNH ===');
    console.log('Đang xóa hình ảnh tại vị trí:', index);
    
    const textarea = $('#hinh_anh');
    const lines = textarea.val().split('\n');
    console.log('Các dòng ban đầu:', lines);
    
    lines.splice(index, 1);
    console.log('Các dòng sau khi xóa:', lines);
    
    textarea.val(lines.join('\n'));
    console.log('Đã cập nhật textarea');
    
    updateImagePreview();
    console.log('=== HOÀN THÀNH XÓA URL HÌNH ẢNH ===');
}

function editDienDan(id) {
    console.log('=== BẮT ĐẦU CHỈNH SỬA DIỄN ĐÀN ===');
    console.log('Đang chỉnh sửa diễn đàn có ID:', id);
    
    console.log('Đang gửi yêu cầu GET đến:', `/admin/dien-dan/${id}`);
    $.get(`/admin/dien-dan/${id}`, function(data) {
        console.log('=== YÊU CẦU GET THÀNH CÔNG ===');
        console.log('Dữ liệu nhận được:', data);
        
        $('#dienDanId').val(data.id);
        console.log('Đã đặt dienDanId thành:', data.id);
        
        $('#danh_muc_id').val(data.danh_muc_id);
        console.log('Đã đặt danh_muc_id thành:', data.danh_muc_id);
        
        $('#ten_dien_dan').val(data.ten_dien_dan);
        console.log('Đã đặt ten_dien_dan thành:', data.ten_dien_dan);
        
        $('#vi_tri').val(data.vi_tri);
        console.log('Đã đặt vi_tri thành:', data.vi_tri);
        
        $('#the_tim_kiem').val(data.the_tim_kiem);
        console.log('Đã đặt the_tim_kiem thành:', data.the_tim_kiem);
        
        $('#so_dien_thoai').val(data.so_dien_thoai);
        console.log('Đã đặt so_dien_thoai thành:', data.so_dien_thoai);
        
        $('#muc_gia').val(data.muc_gia);
        console.log('Đã đặt muc_gia thành:', data.muc_gia);
        
        $('#trang_thai').val(data.trang_thai);
        console.log('Đã đặt trang_thai thành:', data.trang_thai);
        
        $('#hinh_anh').val(data.hinh_anh);
        console.log('Đã đặt hinh_anh thành:', data.hinh_anh);
        
        if (editor) {
            editor.setData(data.chi_tiet || '');
            console.log('Đã đặt nội dung CKEditor thành:', data.chi_tiet || '');
        }
        
        // Cập nhật preview hình ảnh
        updateImagePreview();
        
        $('#modalDienDanLabel').text('Sửa Diễn đàn');
        console.log('Đã đổi tiêu đề modal thành: Sửa Diễn đàn');
        
        modalDienDan.show();
        console.log('Đã hiển thị modal');
        console.log('=== HOÀN THÀNH CHỈNH SỬA DIỄN ĐÀN ===');
    }).fail(function(xhr, status, error) {
        console.log('=== YÊU CẦU GET THẤT BẠI ===');
        console.log('Chi tiết lỗi:', {xhr, status, error});
        toastr.error('Không thể tải dữ liệu diễn đàn!');
    });
}

function deleteDienDan(id) {
    console.log('=== BẮT ĐẦU XÓA DIỄN ĐÀN ===');
    console.log('Đang cố gắng xóa diễn đàn có ID:', id);
    
    if (confirm('Bạn có chắc chắn muốn xóa diễn đàn này?')) {
        console.log('Người dùng đã xác nhận xóa');
        
        console.log('Đang gửi yêu cầu DELETE đến:', `/admin/dien-dan/${id}`);
        $.ajax({
            url: `/admin/dien-dan/${id}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('=== YÊU CẦU DELETE THÀNH CÔNG ===');
                console.log('Phản hồi nhận được:', response);
                
                if (response.success) {
                    console.log('Thông báo thành công:', response.message);
                    toastr.success(response.message);
                    console.log('Tải lại trang sau 1 giây...');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(xhr, status, error) {
                console.log('=== YÊU CẦU DELETE THẤT BẠI ===');
                console.log('Chi tiết lỗi:', {xhr, status, error});
                toastr.error('Có lỗi xảy ra khi xóa!');
            }
        });
    } else {
        console.log('Người dùng đã hủy xóa');
    }
    console.log('=== HOÀN THÀNH XÓA DIỄN ĐÀN ===');
}
</script>
@endpush
