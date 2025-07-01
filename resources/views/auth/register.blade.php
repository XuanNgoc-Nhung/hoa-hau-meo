<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 600px;
        }
        
        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .register-header h2 {
            margin: 0;
            font-weight: 600;
            font-size: 2rem;
        }
        
        .register-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        
        .register-body {
            padding: 40px;
        }
        
        .form-label {
            color: #495057;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            padding: 12px 15px;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        
        .form-control.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        
        .btn-outline-secondary {
            border: 2px solid #6c757d;
            border-radius: 10px;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            color: #6c757d;
            background: transparent;
        }
        
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
        }
        
        .form-check {
            margin: 20px 0;
        }
        
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 30px;
            bottom: 0;
            margin: auto 0;
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            z-index: 10;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s ease;
        }
        
        .password-toggle:hover {
            color: #667eea;
            background-color: rgba(102, 126, 234, 0.1);
        }
        
        .password-toggle i {
            font-size: 14px;
            line-height: 1;
            display: block;
        }
        
        .form-floating {
            position: relative;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .text-danger.small {
            font-size: 0.875rem;
            margin-top: -10px;
            margin-bottom: 15px;
        }
        
        .text-danger.small i {
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <h2><i class="fas fa-user-plus me-2"></i>Đăng ký</h2>
                <p>Tạo tài khoản mới để bắt đầu</p>
            </div>
            
            <div class="register-body">
                <!-- Alert Messages -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('register.post') }}" id="registerForm">
                    @csrf
                    
                    <!-- Tên -->
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-user me-2"></i>Họ và tên
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               placeholder="Nhập họ và tên"
                               value="{{ old('name') }}"
                               required>
                    </div>
                    @error('name')
                        <div class="text-danger small mb-3">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               placeholder="Nhập email"
                               value="{{ old('email') }}"
                               required>
                    </div>
                    @error('email')
                        <div class="text-danger small mb-3">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    
                    <!-- Mật khẩu -->
                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Mật khẩu
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Nhập mật khẩu"
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mb-3">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    <div id="password-error" class="text-danger small mb-3" style="display: none;">
                        <i class="fas fa-exclamation-circle me-1"></i><span id="password-error-text"></span>
                    </div>
                    
                    <!-- Nhập lại mật khẩu -->
                    <div class="mb-3 position-relative">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock me-2"></i>Nhập lại mật khẩu
                        </label>
                        <input type="password" 
                               class="form-control @error('password_confirmation') is-invalid @enderror" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Nhập lại mật khẩu"
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="text-danger small mb-3">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    <div id="password_confirmation-error" class="text-danger small mb-3" style="display: none;">
                        <i class="fas fa-exclamation-circle me-1"></i><span id="password_confirmation-error-text"></span>
                    </div>
                    
                    <!-- Đồng ý điều khoản -->
                    <div class="form-check">
                        <input class="form-check-input @error('terms') is-invalid @enderror" 
                               type="checkbox" 
                               id="terms" 
                               name="terms" 
                               required>
                        <label class="form-check-label" for="terms">
                            Tôi đồng ý với <a href="#" class="text-decoration-none">Điều khoản sử dụng</a> và 
                            <a href="#" class="text-decoration-none">Chính sách bảo mật</a>
                        </label>
                    </div>
                    @error('terms')
                        <div class="text-danger small mb-3">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    <div id="terms-error" class="text-danger small mb-3" style="display: none;">
                        <i class="fas fa-exclamation-circle me-1"></i>Vui lòng đồng ý với điều khoản sử dụng
                    </div>
                    
                    <!-- Nút đăng ký -->
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary btn-register flex-grow-1">
                            <i class="fas fa-user-plus me-2"></i>Đăng ký
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="fillSampleData()">
                            <i class="fas fa-magic me-2"></i>Dữ liệu mẫu
                        </button>
                    </div>
                </form>
                
                <!-- Link đăng nhập -->
                <div class="login-link">
                    <p class="mb-0">
                        Đã có tài khoản? 
                        <a href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập ngay
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // Fill sample data
        function fillSampleData() {
            document.getElementById('name').value = 'Nguyễn Văn A';
            document.getElementById('email').value = 'nguyenvana@example.com';
            document.getElementById('password').value = 'Password123!';
            document.getElementById('password_confirmation').value = 'Password123!';
            document.getElementById('terms').checked = true;
            
            // Clear any existing error states
            document.querySelectorAll('.is-invalid').forEach(element => {
                element.classList.remove('is-invalid');
            });
            
            // Hide any error messages
            document.querySelectorAll('[id$="-error"]').forEach(element => {
                element.style.display = 'none';
            });
            
            // Show success message
            showNotification('Đã điền dữ liệu mẫu thành công!', 'success');
        }
        
        // Show notification
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'info'} alert-dismissible fade show position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 3000);
        }
        
        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const terms = document.getElementById('terms').checked;
            
            // Clear previous error states
            document.querySelectorAll('.is-invalid').forEach(element => {
                element.classList.remove('is-invalid');
            });
            
            // Hide all custom error messages
            document.querySelectorAll('[id$="-error"]').forEach(element => {
                element.style.display = 'none';
            });
            
            let isValid = true;
            
            // Check password match
            if (password !== confirmPassword) {
                document.getElementById('password_confirmation').classList.add('is-invalid');
                document.getElementById('password_confirmation-error').style.display = 'block';
                document.getElementById('password_confirmation-error-text').textContent = 'Mật khẩu không khớp';
                isValid = false;
            }
            
            // Check password length
            if (password.length < 8) {
                document.getElementById('password').classList.add('is-invalid');
                document.getElementById('password-error').style.display = 'block';
                document.getElementById('password-error-text').textContent = 'Mật khẩu phải có ít nhất 8 ký tự';
                isValid = false;
            }
            
            // Check terms
            if (!terms) {
                document.getElementById('terms').classList.add('is-invalid');
                document.getElementById('terms-error').style.display = 'block';
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>