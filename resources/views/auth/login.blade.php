<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    
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
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 600px;
        }
        
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .login-header h2 {
            margin: 0;
            font-weight: 600;
            font-size: 2rem;
        }
        
        .login-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        
        .login-body {
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
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
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
        
        .register-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-link a:hover {
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
        
        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }
        
        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2><i class="fas fa-sign-in-alt me-2"></i>Đăng nhập</h2>
                <p>Chào mừng bạn quay trở lại</p>
            </div>
            
            <div class="login-body">
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
                
                <form method="POST" action="{{ route('login.post') }}" id="loginForm">
                    @csrf
                    
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
                    
                    <!-- Quên mật khẩu -->
                    <div class="forgot-password">
                        <a href="#" onclick="showForgotPassword()">
                            <i class="fas fa-question-circle me-1"></i>Quên mật khẩu?
                        </a>
                    </div>
                    
                    <!-- Ghi nhớ đăng nhập -->
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="remember" 
                               name="remember">
                        <label class="form-check-label" for="remember">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>
                    
                    <!-- Nút đăng nhập -->
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary btn-login flex-grow-1">
                            <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="fillSampleData()">
                            <i class="fas fa-magic me-2"></i>Dữ liệu mẫu
                        </button>
                    </div>
                </form>
                
                <!-- Link đăng ký -->
                <div class="register-link">
                    <p class="mb-0">
                        Chưa có tài khoản? 
                        <a href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>Đăng ký ngay
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
            document.getElementById('email').value = 'nguyenvana@example.com';
            document.getElementById('password').value = 'Password123!';
            document.getElementById('remember').checked = true;
            
            // Clear any existing error states
            document.querySelectorAll('.is-invalid').forEach(element => {
                element.classList.remove('is-invalid');
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
        
        // Show forgot password message
        function showForgotPassword() {
            showNotification('Tính năng quên mật khẩu sẽ được phát triển trong phiên bản tiếp theo!', 'info');
        }
        
        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // Clear previous error states
            document.querySelectorAll('.is-invalid').forEach(element => {
                element.classList.remove('is-invalid');
            });
            
            let isValid = true;
            
            // Basic email validation
            if (!email || !email.includes('@')) {
                document.getElementById('email').classList.add('is-invalid');
                isValid = false;
            }
            
            // Basic password validation
            if (!password || password.length < 1) {
                document.getElementById('password').classList.add('is-invalid');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
        
        // Auto focus on email field when page loads
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('email').focus();
        });
    </script>
</body>
</html>
