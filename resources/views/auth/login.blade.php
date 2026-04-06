<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HR Portal') }} - Login</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --surface: rgba(255, 255, 255, 0.05);
            --surface-border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f8fafc;
        }

        /* Glassmorphism Card */
        .glass-card {
            background: var(--surface);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--surface-border);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.6);
            border-color: rgba(255,255,255,0.15);
        }

        .brand-logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary), #818cf8);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 28px;
            color: #fff;
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
        }

        /* Custom Inputs */
        .form-control {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(0, 0, 0, 0.3);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .input-group-text {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-right: none;
            color: rgba(255, 255, 255, 0.6);
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        .form-control.with-icon {
            border-left: none;
            padding-left: 0;
        }

        /* Custom Checkbox */
        .form-check-input {
            background-color: rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 255, 255, 0.2);
            width: 18px;
            height: 18px;
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        /* Submit Button */
        .btn-login {
            background: linear-gradient(135deg, var(--primary), #6366f1);
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.5px;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--primary-hover), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(79, 70, 229, 0.5);
            color: #fff;
        }

        .auth-link {
            color: #818cf8;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .auth-link:hover {
            color: #c7d2fe;
        }

        .error-message {
            color: #f87171;
            font-size: 13px;
            margin-top: 6px;
            display: block;
        }

        /* Decorational Blob */
        .blob-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: var(--primary);
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.15;
            z-index: -1;
            animation: float 10s ease-in-out infinite;
        }

        .blob-2 {
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: #ec4899;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.1;
            z-index: -1;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
            100% { transform: translateY(0px) scale(1); }
        }
    </style>
</head>
<body>

    <!-- Background Ornaments -->
    <div class="blob-1"></div>
    <div class="blob-2"></div>

    <div class="container d-flex justify-content-center p-3 p-md-0">
        <div class="glass-card p-4 p-md-5">
            
            <div class="text-center mb-4">
                <div class="brand-logo">
                    <i class="bi bi-fingerprint"></i>
                </div>
                <h4 class="fw-bold mb-1">Welcome Back</h4>
                <p class="text-muted small" style="color: #94a3b8 !important;">Enter your credentials to access the portal</p>
            </div>

            <!-- Validation Errors (Global) -->
            @if ($errors->any())
                <div class="alert alert-danger rounded-3 border-0 bg-danger bg-opacity-10 text-danger mb-4 py-2 px-3 shadow-none">
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success rounded-3 border-0 bg-success bg-opacity-10 text-success mb-4 py-2 px-3 shadow-none small">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Employee ID Input -->
                <div class="mb-4">
                    <label for="employee_id" class="form-label ms-1 small fw-medium" style="color: #cbd5e1;">Employee ID</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input id="employee_id" type="text" class="form-control with-icon" name="employee_id" value="{{ old('employee_id') }}" required autofocus autocomplete="username" placeholder="e.g. EMP-001">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center ms-1 mb-2">
                        <label for="password" class="form-label mb-0 small fw-medium" style="color: #cbd5e1;">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
                        @endif
                    </div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input id="password" type="password" class="form-control with-icon" name="password" required autocomplete="current-password" placeholder="••••••••">
                        <!-- Optional password toggle button can be added here -->
                    </div>
                </div>

                <!-- Remember Me & Submit -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                        <label class="form-check-label small" for="remember_me" style="color: #94a3b8; cursor: pointer;">
                            Remember this device
                        </label>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn-login">
                        Sign In <i class="bi bi-arrow-right-short ms-1" style="font-size: 1.2em; vertical-align: middle;"></i>
                    </button>
                </div>
            </form>
            
        </div>
    </div>

    <!-- Bootstrap JS (Optional, but good for interactive components if added later) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
