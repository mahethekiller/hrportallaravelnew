<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Careers') }} - Job Openings</title>

    <script>
        // Critical Theme Engine: Run ASAP to prevent flash
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', savedTheme || systemTheme);
        })();
    </script>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom Premium Styling (Guest Version) -->
    <style>
        :root {
            /* Light Theme (Default) */
            --bg-primary: #f8fafc;
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.5);
            --glass-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --text-main: #1e293b;
            --text-muted: #64748b;
            --accent: #4f46e5;
            --border-muted: #f1f5f9;
        }

        [data-theme="dark"] {
            /* Dark Theme Overrides */
            --bg-primary: #020617;
            --glass-bg: rgba(15, 23, 42, 0.75);
            --glass-border: rgba(255, 255, 255, 0.1);
            --glass-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border-muted: #1e293b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-main);
            transition: background-color 0.3s ease;
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent);
        }

        /* Nav Bar */
        .careers-nav {
            height: 80px;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid var(--glass-border);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .hero-section {
            padding: 100px 0 60px 0;
            background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.1), transparent 50%),
                        radial-gradient(circle at bottom left, rgba(6, 182, 212, 0.05), transparent 50%);
        }

        .btn-primary { background: var(--accent); border: none; box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3); border-radius: 12px; padding: 0.75rem 2rem; font-weight: 600; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4); }

        .theme-toggle-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            border: none;
            background: rgba(255,255,255,0.1);
            color: var(--text-main);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-control, .form-select {
            background-color: var(--glass-bg);
            color: var(--text-main);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
        }

        .form-control::placeholder {
            color: var(--text-muted);
            opacity: 0.8;
        }

        .form-control:focus {
            background-color: var(--glass-bg);
            color: var(--text-main);
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.1);
        }

        [data-theme="dark"] .glass-card {
            background: rgba(15, 23, 42, 0.8);
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: rgba(255, 255, 255, 0.04) !important;
            color: #f1f5f9 !important;
            border-color: rgba(255, 255, 255, 0.12) !important;
        }

        [data-theme="dark"] .form-control::placeholder {
            color: rgba(148, 163, 184, 0.7) !important;
        }

        [data-theme="dark"] .form-control:focus {
            background-color: rgba(255, 255, 255, 0.07) !important;
            color: #fff !important;
        }

        [data-theme="dark"] .input-group-text {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.12);
            color: var(--text-muted);
        }

        [data-theme="dark"] .text-muted { color: #94a3b8 !important; }

        [data-theme="dark"] .btn-light {
            background-color: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.1);
            color: var(--text-main);
        }

        [data-theme="dark"] .alert-success {
            background-color: rgba(16, 185, 129, 0.12);
            border-color: rgba(16, 185, 129, 0.3);
            color: #34d399;
        }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="careers-nav d-flex align-items-center">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('careers.index') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                <i class="bi bi-hexagon-fill text-primary" style="font-size: 1.5rem; color:#6366f1 !important;"></i>
                <span class="fw-bold fs-4 text-main" style="color: var(--text-main);">i2u2 Careers</span>
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-link text-decoration-none text-muted fw-semibold d-none d-md-block">Employee Login</a>
                <button class="theme-toggle-btn" id="themeToggle" title="Toggle Light/Dark Mode">
                    <i class="bi bi-moon-stars" id="themeIcon"></i>
                </button>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="py-5 border-top" style="border-color: var(--glass-border) !important;">
        <div class="container text-center">
            <p class="text-muted small">&copy; {{ date('Y') }} i2u2 Group. Powered by i2u2 2.0 Recruitment Suite.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Theme Toggle Logic
        $(document).ready(function() {
            const themeBtn = $('#themeToggle');
            const themeIcon = $('#themeIcon');
            const html = $('html');

            function updateIcon(theme) {
                if (theme === 'dark') {
                    themeIcon.removeClass('bi-moon-stars').addClass('bi-sun');
                } else {
                    themeIcon.removeClass('bi-sun').addClass('bi-moon-stars');
                }
            }

            updateIcon(html.attr('data-theme'));

            themeBtn.on('click', function() {
                const currentTheme = html.attr('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

                html.attr('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateIcon(newTheme);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
