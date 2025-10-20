<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Jembayan Muarabara - Login</title>
    <link rel="icon" href="{{ asset('jembayan-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root {
            --navy-primary: #001f3f;
            --navy-secondary: #003366;
            --navy-accent: #004080;
            --navy-light: #e6f0ff;
            --white: #ffffff;
            --danger: #dc3545;
            --success: #28a745;
            --border-radius: 16px;
            --shadow: 0 20px 60px rgba(0, 31, 63, 0.1);
            --shadow-hover: 0 30px 80px rgba(0, 31, 63, 0.15);
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            max-width: 420px;
            width: 100%;
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: var(--transition);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--navy-primary), var(--navy-secondary), var(--navy-accent));
        }

        .login-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
        }

        /* Logo Header */
        .logo-header {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .logo-container {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--navy-primary), var(--navy-secondary));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 31, 63, 0.2);
            position: relative;
            overflow: hidden;
        }

        .logo-container::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: rotate(45deg);
            transition: var(--transition);
        }

        .logo-container:hover::after {
            animation: shine 1.5s ease-in-out;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .logo-header img {
            width: 50px;
            height: auto;
            z-index: 2;
            position: relative;
        }

        .login-title {
            color: var(--navy-primary);
            font-size: 2rem;
            font-weight: 800;
            margin: 0 0 0.5rem;
            background: linear-gradient(135deg, var(--navy-primary), var(--navy-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
        }

        .login-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
            margin: 0;
            font-weight: 400;
            line-height: 1.5;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.75rem;
            position: relative;
        }

        .form-label {
            display: block;
            color: var(--navy-primary);
            font-weight: 600;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: var(--navy-accent);
            width: 18px;
            opacity: 0.8;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid rgba(0, 31, 63, 0.1);
            border-radius: 12px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            transition: var(--transition);
            font-family: inherit;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--navy-primary);
            box-shadow: 0 0 0 4px rgba(0, 31, 63, 0.08);
            background: var(--white);
            transform: translateY(-2px);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--navy-accent);
            z-index: 2;
            font-size: 1.1rem;
            transition: var(--transition);
        }

        .form-input:focus + .input-icon,
        .form-input:not(:placeholder-shown) + .input-icon {
            color: var(--navy-primary);
        }

        /* Remember Me */
        .remember-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding: 0.75rem;
            background: rgba(0, 31, 63, 0.02);
            border-radius: 10px;
            border: 1px solid rgba(0, 31, 63, 0.05);
        }

        .remember-checkbox {
            width: 18px;
            height: 18px;
            accent-color: var(--navy-primary);
            cursor: pointer;
        }

        .remember-label {
            color: var(--navy-primary);
            font-weight: 500;
            font-size: 0.9rem;
            margin: 0;
            cursor: pointer;
            flex: 1;
        }

        /* Buttons */
        .btn {
            width: 100%;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--navy-primary), var(--navy-secondary));
            color: var(--white);
            box-shadow: 0 8px 25px rgba(0, 31, 63, 0.2);
            font-size: 1.05rem;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 31, 63, 0.3);
            background: linear-gradient(135deg, var(--navy-secondary), var(--navy-primary));
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: transparent;
            color: var(--navy-primary);
            border: 2px solid var(--navy-primary);
            margin-top: 1rem;
        }

        .btn-secondary:hover {
            background: var(--navy-primary);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 31, 63, 0.2);
        }

        /* Forgot Password */
        .forgot-password {
            display: block;
            text-align: center;
            margin: 1.5rem 0;
            color: var(--navy-accent);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            position: relative;
            transition: var(--transition);
        }

        .forgot-password::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--navy-accent), var(--navy-primary));
            transition: var(--transition);
            transform: translateX(-50%);
        }

        .forgot-password:hover::after {
            width: 100%;
        }

        .forgot-password:hover {
            color: var(--navy-primary);
            transform: translateY(-1px);
        }

        /* Error Messages */
        .error-message {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.2);
            color: var(--danger);
            padding: 0.75rem;
            border-radius: 8px;
            margin-top: 0.5rem;
            font-size: 0.85rem;
            display: block;
        }

        /* Session Status */
        .session-status {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.2);
            color: var(--success);
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }
            
            .logo-container {
                width: 70px;
                height: 70px;
            }
            
            .login-title {
                font-size: 1.75rem;
            }
            
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            }
        }

        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .logo-container {
            animation: float 6s ease-in-out infinite;
        }

        /* Loading State for Button */
        .btn-loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid transparent;
            border-top-color: var(--white);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 31, 63, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--navy-primary);
            border-radius: 3px;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="login-container">
        <div class="login-card">
            <!-- Logo + Header -->
            <div class="logo-header">
                <div class="logo-container">
                    <img src="{{ asset('logo.png') }}" alt="Logo PT Jembayan Muarabara" class="relative z-10">
                </div>
                <h1 class="login-title">Welcome Back</h1>
                <p class="login-subtitle">Sign in to your Maintenance System</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="session-status" :status="session('status')" />

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope"></i>
                        Email Address
                    </label>
                    <div class="input-wrapper">
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus
                               placeholder="Enter your email"
                               class="form-input">
                        <i class="bi bi-envelope input-icon"></i>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="error-message" />
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock"></i>
                        Password
                    </label>
                    <div class="input-wrapper">
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required
                               placeholder="Enter your password"
                               class="form-input">
                        <i class="bi bi-lock input-icon"></i>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="error-message" />
                </div>

                <!-- Remember Me -->
                <div class="remember-group">
                    <input id="remember_me" type="checkbox" name="remember" class="remember-checkbox">
                    <label for="remember_me" class="remember-label">Remember me</label>
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Sign In</span>
                </button>

                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-password">
                    <i class="bi bi-key"></i>
                    Forgot your password?
                </a>
                @endif

                <!-- Register Button -->
                <a href="{{ route('register') }}" class="btn btn-secondary">
                    <i class="bi bi-person-plus"></i>
                    <span>Create New Account</span>
                </a>
            </form>
        </div>
    </div>

    <script>
        // Enhanced form interactions
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = document.querySelectorAll('.form-input');
            const submitBtn = document.querySelector('.btn-primary');

            // Input focus animations
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });

            // Form submission with loading state
            form.addEventListener('submit', function() {
                submitBtn.classList.add('btn-loading');
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i><span>Signing In...</span>';
                
                // Re-enable after 3 seconds (or handle via backend response)
                setTimeout(() => {
                    submitBtn.classList.remove('btn-loading');
                    submitBtn.innerHTML = '<i class="bi bi-box-arrow-in-right"></i><span>Sign In</span>';
                }, 3000);
            });

            // Auto-focus email input
            document.getElementById('email').focus();

            // Password visibility toggle (bonus enhancement)
            const passwordInput = document.getElementById('password');
            const passwordIcon = passwordInput.nextElementSibling;
            
            passwordIcon.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        });

        // Enter key navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && document.activeElement.tagName !== 'BUTTON') {
                const form = document.querySelector('form');
                const submitBtn = form.querySelector('.btn-primary');
                submitBtn.click();
            }
        });
    </script>
</body>
</html>