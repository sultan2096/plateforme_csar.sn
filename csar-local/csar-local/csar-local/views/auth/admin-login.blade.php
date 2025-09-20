<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - CSAR</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logos/LOGO CSAR vectoriel-01.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 480px;
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .logo img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }
        
        .login-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }
        
        .login-header p {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 300;
        }
        
        .login-body {
            padding: 40px 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 500;
            font-size: 14px;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 18px;
            transition: color 0.3s ease;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #f9fafb;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #059669;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }
        
        .form-control:focus + i {
            color: #059669;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #059669;
            cursor: pointer;
        }
        
        .remember-me label {
            color: #6b7280;
            font-size: 14px;
            cursor: pointer;
            user-select: none;
        }
        
        .forgot-link {
            color: #059669;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .forgot-link:hover {
            color: #047857;
            text-decoration: underline;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(5, 150, 105, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-error {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        .alert i {
            font-size: 18px;
        }
        
        .login-footer {
            text-align: center;
            padding: 30px;
            background-color: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }
        
        .login-footer p {
            color: #6b7280;
            font-size: 14px;
        }
        
        /* Admin specific styling */
        .admin-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            margin-top: 10px;
            letter-spacing: 0.5px;
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                margin: 0;
                border-radius: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }
            
            .login-body {
                flex: 1;
            }
            
            .login-header h1 {
                font-size: 24px;
            }
            
            .login-header p {
                font-size: 14px;
            }
        }
        
        /* Loading state */
        .btn-login.loading {
            color: transparent;
        }
        
        .btn-login.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spinner 0.8s linear infinite;
        }
        
        @keyframes spinner {
            to {
                transform: rotate(360deg);
            }
        }
        
        /* Error shake animation */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
            20%, 40%, 60%, 80% { transform: translateX(10px); }
        }
        
        .shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo">
                <img src="{{ asset('images/logos/LOGO CSAR vectoriel-01.png') }}" alt="CSAR Logo">
            </div>
            <h1>Connexion Admin</h1>
            <p>Accédez à votre espace d'administration</p>
            <span class="admin-badge">ZONE SÉCURISÉE</span>
            </div>
            
        <div class="login-body">
            <form method="POST" action="{{ route('admin.login.submit') }}" id="loginForm">
                @csrf
                
                @if (session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                
                <div class="form-group">
                    <label for="email">Adresse Email</label>
                    <div class="input-wrapper">
                        <input type="email" 
                               class="form-control @error('email') shake @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', 'admin@csar.sn') }}" 
                               placeholder="admin@csar.sn"
                               required 
                               autofocus>
                        <i class="fas fa-envelope"></i>
                    </div>
                    @error('email')
                        <span class="text-danger" style="font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-wrapper">
                        <input type="password" 
                               class="form-control @error('password') shake @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="••••••••"
                               required>
                        <i class="fas fa-lock"></i>
                    </div>
                    @error('password')
                        <span class="text-danger" style="font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Se souvenir de moi</label>
                    </div>
                    <a href="#" class="forgot-link">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn-login" id="submitBtn">
                    <span>Se connecter</span>
                </button>
            </form>
        </div>
        
        <div class="login-footer">
            <p>© {{ date('Y') }} CSAR – Tous droits réservés</p>
        </div>
    </div>
    
    <script>
        // Add loading state to button on form submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
</body>
</html>