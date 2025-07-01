# Hệ thống Bình luận - WebChecker

## Tổng quan
Hệ thống bình luận cho phép người dùng đã đăng nhập thêm, sửa, xóa bình luận trên các diễn đàn. Hệ thống sử dụng AJAX để tương tác real-time mà không cần reload trang.

## Cấu trúc Database

### Bảng `binh_luan`
- `id` - Primary key
- `post_id` - ID của diễn đàn (foreign key đến bảng `dien_dan`)
- `user_id` - ID của người bình luận (foreign key đến bảng `users`)
- `content` - Nội dung bình luận
- `created_at` - Thời gian tạo
- `updated_at` - Thời gian cập nhật

## API Endpoints

### 1. Tạo bình luận mới
```
POST /comments
```
**Headers:**
- `Content-Type: application/json`
- `X-CSRF-TOKEN: {csrf_token}`

**Body:**
```json
{
    "post_id": 1,
    "content": "Nội dung bình luận"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Bình luận đã được gửi thành công!",
    "comment": {
        "id": 1,
        "content": "Nội dung bình luận",
        "created_at": "01/01/2024 10:00",
        "user": {
            "id": 1,
            "name": "Tên người dùng",
            "avatar": null
        }
    }
}
```

### 2. Lấy danh sách bình luận
```
GET /comments/{postId}
```

**Response:**
```json
{
    "success": true,
    "comments": [
        {
            "id": 1,
            "content": "Nội dung bình luận",
            "created_at": "01/01/2024 10:00",
            "user": {
                "id": 1,
                "name": "Tên người dùng",
                "avatar": null
            }
        }
    ],
    "total": 1
}
```

### 3. Cập nhật bình luận
```
PUT /comments/{commentId}
```
**Headers:**
- `Content-Type: application/json`
- `X-CSRF-TOKEN: {csrf_token}`

**Body:**
```json
{
    "content": "Nội dung bình luận đã cập nhật"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Bình luận đã được cập nhật thành công!",
    "comment": {
        "id": 1,
        "content": "Nội dung bình luận đã cập nhật",
        "updated_at": "01/01/2024 10:30"
    }
}
```

### 4. Xóa bình luận
```
DELETE /comments/{commentId}
```
**Headers:**
- `X-CSRF-TOKEN: {csrf_token}`

**Response:**
```json
{
    "success": true,
    "message": "Bình luận đã được xóa thành công!"
}
```

## Quyền truy cập

### Tạo bình luận
- Yêu cầu đăng nhập
- Validation: nội dung không được để trống, tối đa 1000 ký tự

### Sửa bình luận
- Chỉ người tạo bình luận mới được sửa
- Yêu cầu đăng nhập

### Xóa bình luận
- Người tạo bình luận hoặc admin mới được xóa
- Yêu cầu đăng nhập

## Tính năng Frontend

### 1. Form bình luận
- Hiển thị cho người dùng đã đăng nhập
- Validation real-time
- Loading state khi gửi

### 2. Danh sách bình luận
- Hiển thị theo thứ tự mới nhất
- Avatar placeholder với chữ cái đầu của tên
- Thời gian tương đối (ví dụ: "2 giờ trước")

### 3. Tương tác bình luận
- Nút Like (chưa implement backend)
- Nút Reply (chưa implement backend)
- Menu dropdown cho sửa/xóa (chỉ hiển thị cho người có quyền)

### 4. Chỉnh sửa inline
- Click "Sửa" để chuyển sang chế độ edit
- Textarea với nội dung hiện tại
- Nút "Lưu" và "Hủy"

### 5. Xác nhận xóa
- Confirm dialog trước khi xóa
- Cập nhật số lượng bình luận sau khi xóa

## Cách sử dụng

### 1. Truy cập trang chi tiết diễn đàn
```
/chi-tiet-dien-dan/{slug}.html
```

### 2. Đăng nhập để bình luận
- Nếu chưa đăng nhập, sẽ hiển thị form đăng nhập
- Sau khi đăng nhập, form bình luận sẽ xuất hiện

### 3. Viết và gửi bình luận
- Nhập nội dung vào textarea
- Click "Gửi bình luận"
- Bình luận sẽ xuất hiện ngay lập tức

### 4. Sửa/xóa bình luận
- Click vào menu dropdown (3 chấm) bên cạnh bình luận
- Chọn "Sửa" hoặc "Xóa"
- Thực hiện thao tác tương ứng

## Lưu ý kỹ thuật

### CSRF Protection
- Tất cả AJAX requests đều cần CSRF token
- Token được lấy từ meta tag trong head

### Error Handling
- Hiển thị thông báo lỗi dạng alert
- Tự động ẩn sau 3 giây
- Log lỗi vào console cho debugging

### Responsive Design
- Tương thích với mobile
- Layout thích ứng theo kích thước màn hình

## Mở rộng trong tương lai

1. **Reply comments** - Trả lời bình luận
2. **Like/Dislike** - Thích/không thích bình luận
3. **Report comments** - Báo cáo bình luận không phù hợp
4. **Rich text editor** - Editor với định dạng văn bản
5. **File attachments** - Đính kèm file trong bình luận
6. **Email notifications** - Thông báo qua email khi có bình luận mới
7. **Moderation** - Hệ thống kiểm duyệt bình luận
8. **Pagination** - Phân trang cho bình luận
9. **Search comments** - Tìm kiếm trong bình luận
10. **Comment analytics** - Thống kê bình luận 