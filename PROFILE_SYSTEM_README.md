# Hệ thống Thông tin Cá nhân

## Tổng quan
Hệ thống thông tin cá nhân cho phép người dùng cập nhật thông tin cá nhân bao gồm avatar, tên, số điện thoại và địa chỉ.

## Tính năng

### 1. Cập nhật Avatar
- Upload ảnh avatar mới
- Hỗ trợ định dạng: JPG, PNG, GIF
- Kích thước tối đa: 2MB
- Preview ảnh trước khi upload
- Tự động xóa avatar cũ khi upload avatar mới

### 2. Cập nhật Thông tin Cá nhân
- **Họ và tên**: Bắt buộc, tối đa 255 ký tự
- **Email**: Chỉ đọc, không thể thay đổi
- **Số điện thoại**: Tùy chọn, tối đa 20 ký tự
- **Địa chỉ**: Tùy chọn, tối đa 500 ký tự

## Cấu trúc Database

### Bảng `users`
Cần thêm các trường sau vào bảng `users`:
```sql
ALTER TABLE users ADD COLUMN so_dien_thoai VARCHAR(20) NULL;
ALTER TABLE users ADD COLUMN dia_chi VARCHAR(500) NULL;
ALTER TABLE users ADD COLUMN avatar VARCHAR(255) NULL;
```

## Routes

### GET `/tai-khoan`
- Hiển thị trang thông tin cá nhân
- Route name: `user.tai-khoan`

### PUT `/tai-khoan/update-profile`
- Cập nhật thông tin cá nhân
- Route name: `user.update-profile`
- Middleware: `auth`

## Controller Methods

### UserController::taiKhoan()
- Hiển thị view `user.tai-khoan`

### UserController::updateProfile(Request $request)
- Validate dữ liệu đầu vào
- Xử lý upload avatar
- Cập nhật thông tin người dùng
- Redirect với thông báo thành công/lỗi

## Views

### `resources/views/user/tai-khoan.blade.php`
- Form cập nhật thông tin cá nhân
- Preview avatar
- Validation errors
- Success/error messages

## JavaScript Features

### Avatar Preview
- Preview ảnh trước khi upload
- Kiểm tra kích thước file (2MB)
- Kiểm tra định dạng file
- Hiển thị thông báo lỗi nếu cần

## CSS Styling

### Custom Styles
- Hover effects cho avatar
- Transition animations
- Responsive design
- Bootstrap 5 compatible

## Cách sử dụng

### 1. Truy cập trang thông tin cá nhân
- Đăng nhập vào hệ thống
- Click vào avatar/tên người dùng trên navbar
- Chọn "Thông tin" hoặc "Tài khoản"

### 2. Cập nhật thông tin
- Chỉnh sửa các trường thông tin
- Chọn ảnh avatar mới (nếu muốn)
- Click "Cập nhật thông tin"

### 3. Xem kết quả
- Hệ thống sẽ hiển thị thông báo thành công
- Avatar mới sẽ được hiển thị trên navbar
- Thông tin đã được cập nhật

## Bảo mật

### Validation
- Validate tất cả input từ người dùng
- Kiểm tra kích thước và định dạng file
- Sanitize dữ liệu trước khi lưu

### File Upload
- Chỉ cho phép upload ảnh
- Giới hạn kích thước file
- Tạo tên file unique để tránh conflict
- Xóa file cũ khi upload file mới

### Authentication
- Yêu cầu đăng nhập để truy cập
- Chỉ cho phép cập nhật thông tin của chính mình

## Troubleshooting

### Lỗi thường gặp

1. **File quá lớn**
   - Giảm kích thước ảnh trước khi upload
   - Sử dụng định dạng JPG thay vì PNG

2. **Không thể upload avatar**
   - Kiểm tra quyền ghi thư mục `public/uploads/avatars/`
   - Đảm bảo thư mục tồn tại

3. **Avatar không hiển thị**
   - Kiểm tra đường dẫn file
   - Đảm bảo file tồn tại trong thư mục uploads

## Tương lai

### Tính năng có thể thêm
- Crop ảnh avatar
- Upload nhiều ảnh
- Backup thông tin
- Export thông tin cá nhân
- Thay đổi mật khẩu
- Xác thực 2 yếu tố 