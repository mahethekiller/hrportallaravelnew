<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HRMS') }} - Admin</title>

    <script>
        // Critical Theme Engine: Run ASAP to prevent flash
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', savedTheme || systemTheme);
        })();
    </script>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Custom Premium Styling -->
    <style>
        :root {
            /* Light Theme (Default) */
            --bg-primary: #f8fafc;
            --bg-sidebar: #ffffff;
            --sidebar-color: #64748b;
            --sidebar-active-bg: #f1f5f9;
            --sidebar-active-text: #4f46e5;
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.5);
            --glass-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --text-main: #334155;
            --text-muted: #64748b;
            --accent: #4f46e5;
            --header-bg: rgba(255, 255, 255, 0.9);
            --border-muted: #f1f5f9;
        }

        [data-theme="dark"] {
            /* Dark Theme Overrides */
            --bg-primary: #020617;
            --bg-sidebar: #0f172a;
            --sidebar-color: #94a3b8;
            --sidebar-active-bg: rgba(255, 255, 255, 0.05);
            --sidebar-active-text: #818cf8;
            --glass-bg: rgba(15, 23, 42, 0.75);
            --glass-border: rgba(255, 255, 255, 0.1);
            --glass-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --header-bg: rgba(2, 6, 23, 0.85);
            --border-muted: #1e293b;
        }

        /* Dark Mode Utility Overrides */
        [data-theme="dark"] .text-dark { color: var(--text-main) !important; }
        [data-theme="dark"] .text-muted { color: var(--text-muted) !important; }
        [data-theme="dark"] .bg-light { background-color: var(--border-muted) !important; }
        [data-theme="dark"] .bg-white { background-color: var(--bg-sidebar) !important; }
        [data-theme="dark"] .border { border-color: var(--border-muted) !important; }
        [data-theme="dark"] .form-control, [data-theme="dark"] .form-select {
            background-color: var(--bg-sidebar) !important;
            color: var(--text-main) !important;
            border-color: var(--border-muted) !important;
        }
        /* Fix placeholder text in dark mode */
        [data-theme="dark"] .form-control::placeholder,
        [data-theme="dark"] textarea::placeholder,
        [data-theme="dark"] input::placeholder {
            color: rgba(148, 163, 184, 0.6) !important;
            opacity: 1;
        }
        [data-theme="dark"] .form-control:focus, [data-theme="dark"] .form-select:focus {
            background-color: var(--bg-sidebar) !important;
            color: #fff !important;
            box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.25);
        }
        [data-theme="dark"] .list-group-item {
            background-color: transparent;
            color: var(--text-main);
            border-color: var(--border-muted);
        }
        [data-theme="dark"] .modal-content {
            background-color: var(--bg-sidebar);
            color: var(--text-main);
            border: 1px solid var(--border-muted);
        }
        [data-theme="dark"] .btn-light {
            background-color: var(--border-muted);
            color: var(--text-main);
            border: none;
        }
        [data-theme="dark"] .btn-white {
            background-color: rgba(255,255,255,0.05);
            color: #fff;
            border: 1px solid var(--border-muted);
        }

        /* Dark Mode Specific Overrides */
        [data-theme="dark"] .badge.bg-primary-subtle {
            background-color: rgba(79, 70, 229, 0.1) !important;
            color: #818cf8 !important;
            border-color: rgba(79, 70, 229, 0.3) !important;
        }
        [data-theme="dark"] .badge.bg-success-subtle {
            background-color: rgba(16, 185, 129, 0.1) !important;
            color: #34d399 !important;
            border-color: rgba(16, 185, 129, 0.3) !important;
        }
        [data-theme="dark"] .badge.bg-danger-subtle {
            background-color: rgba(239, 68, 68, 0.1) !important;
            color: #f87171 !important;
            border-color: rgba(239, 68, 68, 0.3) !important;
        }
        [data-theme="dark"] .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.02) !important;
        }
        [data-theme="dark"] .pagination .page-link {
            background-color: var(--bg-sidebar);
            border-color: var(--border-muted);
            color: var(--text-main);
        }
        [data-theme="dark"] .pagination .page-item.active .page-link {
            background-color: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        /* Breadcrumb fix for dark mode */
        [data-theme="dark"] .breadcrumb-item { color: var(--text-muted); }
        [data-theme="dark"] .breadcrumb-item.active { color: var(--text-main) !important; }
        [data-theme="dark"] .breadcrumb-item a { color: var(--accent); }
        [data-theme="dark"] .breadcrumb-item + .breadcrumb-item::before { color: var(--text-muted); }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-main);
            overflow-x: hidden;
            display: flex;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 280px;
            height: 100vh;
            overflow-y: auto;
            background: var(--bg-sidebar);
            color: var(--sidebar-color);
            padding: 2.5rem 1.5rem;
            position: fixed;
            transition: all 0.3s ease;
            z-index: 1030;
            border-right: 1px solid var(--border-muted);
        }

        /* Custom scrollbar for sidebar */
        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.3); border-radius: 10px; }
        .sidebar::-webkit-scrollbar-thumb:hover { background: rgba(148, 163, 184, 0.5); }


        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-item { margin-bottom: 0.5rem; }
        .nav-link {
            color: var(--sidebar-color);
            padding: 0.8rem 1rem;
            border-radius: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease-in-out;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--sidebar-active-text);
            background: var(--sidebar-active-bg);
            transform: translateX(5px);
        }
        .nav-link i { font-size: 1.2rem; }

        /* Main Content wrapper */
        .main-wrapper {
            flex-grow: 1;
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Header */
        .top-header {
            height: 80px;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--header-bg);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-muted);
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .page-content {
            padding: 2.5rem;
            flex-grow: 1;
        }

        /* DataTables Custom Polish */
        .table > :not(caption) > * > * { background-color: transparent !important; color: inherit; }
        .table thead th {
            background: var(--border-muted) !important;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border-muted) !important;
        }
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background-color: var(--bg-sidebar);
            color: var(--text-main);
            border: 1px solid var(--border-muted);
        }

        /* Buttons */
        .btn-primary { background: var(--accent); border: none; box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3); border-radius: 10px; padding: 0.6rem 1.5rem;}
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4); }

        /* Theme Toggle Button */
        .theme-toggle-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            border: none;
            background: var(--border-muted);
            color: var(--text-main);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .theme-toggle-btn:hover { background: var(--accent); color: white; }

        /* Select2 Premium Customization */
        .select2-container--default .select2-selection--single {
            background-color: var(--bg-sidebar) !important;
            border: 1px solid var(--border-muted) !important;
            border-radius: 10px !important;
            height: 42px !important;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-main) !important;
            padding-left: 12px !important;
            font-size: 0.9rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
            right: 10px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: var(--text-muted) transparent transparent transparent !important;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: var(--bg-primary) !important;
            border: 1px solid var(--border-muted) !important;
            border-radius: 8px !important;
            color: var(--text-main) !important;
        }
        .select2-dropdown {
            background-color: var(--glass-bg) !important;
            backdrop-filter: blur(15px) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 12px !important;
            box-shadow: var(--glass-shadow) !important;
            overflow: hidden;
            z-index: 9999;
        }
        .select2-results__option {
            padding: 8px 12px !important;
            font-size: 0.85rem;
            color: var(--text-main);
        }
        .select2-results__option--highlighted[aria-selected],
        .select2-results__option[aria-selected="true"] {
            background-color: var(--accent) !important;
            color: #fff !important;
        }
        .select2-container--open .select2-dropdown--below {
            margin-top: 5px;
        }

        /* Dark mode tweaks for select2 */
        [data-theme="dark"] .select2-container--default .select2-selection--single {
            background-color: rgba(255, 255, 255, 0.05) !important;
        }
        [data-theme="dark"] .select2-results__option {
            color: #cbd5e1;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-hexagon-fill text-primary" style="color:#6366f1 !important;"></i>
            i2u2 2.0
        </div>
        <ul class="nav flex-column">
            @if(isset($sidebarGrouped) && $sidebarGrouped->count() > 0)
                {{-- Dynamic Database-Driven Sidebar --}}
                @php
                    $sectionLabels = [
                        'general' => null,
                        'core_hr' => 'Core HR',
                        'recruitment' => 'Talent Acquisition',
                        'access_control' => 'Access Control',
                    ];
                @endphp

                @foreach($sectionLabels as $sectionKey => $sectionLabel)
                    @if(isset($sidebarGrouped[$sectionKey]))
                        @if($sectionLabel)
                            <li class="nav-item mt-4 mb-2 {{ $sectionKey === 'access_control' ? 'border-top pt-4' : '' }}">
                                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.1em; padding-left: 1rem;">{{ $sectionLabel }}</small>
                            </li>
                        @endif

                        @foreach($sidebarGrouped[$sectionKey] as $module)
                            <li class="nav-item">
                                @php
                                    $isActive = false;
                                    $matchParts = explode(':', $module->active_match, 2);
                                    if (count($matchParts) === 2) {
                                        if ($matchParts[0] === 'routeIs') {
                                            $isActive = request()->routeIs($matchParts[1]);
                                        } elseif ($matchParts[0] === 'is') {
                                            $isActive = request()->is($matchParts[1]);
                                        }
                                    }
                                @endphp
                                <a class="nav-link {{ $isActive ? 'active' : '' }}" href="{{ route($module->route) }}" {{ $module->is_external ? 'target=_blank' : '' }}>
                                    <i class="bi {{ $module->icon }}"></i> {{ $module->name }}
                                    @if($module->is_external)
                                        <i class="bi bi-box-arrow-up-right ms-auto" style="font-size: 0.7rem; opacity: 0.5;"></i>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    @endif
                @endforeach
            @else
                {{-- Fallback: Basic sidebar if modules not seeded yet --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-grid-1x2"></i> Dashboard
                    </a>
                </li>
            @endif
        </ul>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Top Header -->
        <header class="top-header">
            <div>
                <h5 class="mb-0 fw-bold">@yield('page_title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                @php
                    $allTodayRecords = collect();
                    $totalMinutes = 0;
                    $elapsedTime = '0h 0m';
                    $firstInRecord = null;
                    $lastOutRecord = null;
                    $userTz = 'Asia/Kolkata';

                    if (Auth::check() && Auth::user()->card_no) {
                        $allTodayRecords = \App\Models\EmpTodayAttendance::where('card_no', Auth::user()->card_no)
                            ->whereDate('punch_date', \Carbon\Carbon::today($userTz))
                            ->orderBy('id', 'asc')
                            ->get();

                        foreach($allTodayRecords as $record) {
                            if (!empty($record->check_in_time) && $record->check_in_time != '00:00:00') {
                                try {
                                    $pDate = $record->punch_date instanceof \Carbon\Carbon ? $record->punch_date->format('Y-m-d') : $record->punch_date;
                                    $in = \Carbon\Carbon::parse($pDate . ' ' . $record->check_in_time, $userTz);
                                    $out = (!empty($record->check_out_time) && $record->check_out_time != '00:00:00')
                                           ? \Carbon\Carbon::parse($pDate . ' ' . $record->check_out_time, $userTz)
                                           : \Carbon\Carbon::now($userTz);

                                    // Ensure absolute positive difference
                                    $totalMinutes += $in->diffInMinutes($out, true);
                                } catch (\Exception $e) { continue; }
                            }
                        }

                        $h = floor($totalMinutes / 60);
                        $m = $totalMinutes % 60;
                        $elapsedTime = $h . 'h ' . $m . 'm';

                        $firstInRecord = $allTodayRecords->first();
                        $lastOutRecord = $allTodayRecords->whereNotNull('check_out_time')->where('check_out_time', '!=', '00:00:00')->last();
                    }
                @endphp

                @if($allTodayRecords->isNotEmpty())
                    <div class="d-none d-lg-flex align-items-center me-2 gap-2">
                        <div class="d-flex flex-column align-items-end me-1" style="font-size: 0.7rem; line-height: 1.2;">
                            <span class="text-muted text-uppercase fw-bold">Daily Total</span>
                            <span class="fw-bold text-primary">{{ $elapsedTime }}</span>
                        </div>
                        <div class="vr mx-1 opacity-25" style="height: 25px;"></div>
                        <div class="d-flex gap-2">
                            @if($firstInRecord)
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill" style="font-size: 0.75rem;">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                IN: {{ \Carbon\Carbon::parse($firstInRecord->check_in_time)->format('h:i A') }}
                            </span>
                            @endif
                            @if($lastOutRecord)
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill" style="font-size: 0.75rem;">
                                    <i class="bi bi-box-arrow-right me-1"></i>
                                    OUT: {{ \Carbon\Carbon::parse($lastOutRecord->check_out_time)->format('h:i A') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="d-none d-md-flex align-items-center me-2">
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill" style="font-size: 0.75rem;">
                            <i class="bi bi-clock me-1"></i> Not Punched In
                        </span>
                    </div>
                @endif

                <!-- Theme Toggle -->
                <button class="theme-toggle-btn" id="themeToggle" title="Toggle Light/Dark Mode">
                    <i class="bi bi-moon-stars" id="themeIcon"></i>
                </button>

                <div class="dropdown">
                    <button class="btn btn-light rounded-pill px-3 py-2 dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">

                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/profiles/'.Auth::user()->profile_picture ) }}" class="avatar rounded-circle" style="width: 32px; height: 32px;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->first_name ?? 'Admin') }}&background=e2e8f0" class="avatar rounded-circle" style="width: 32px; height: 32px;">
                        @endif
                        <span class="fw-semibold">{{ Auth::user()->first_name ?? 'Admin' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2" style="border-radius: 12px;">
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Dynamic Content -->
        <main class="page-content">
            @yield('content')
        </main>

    </div>

    <!-- jQuery & Bootstrap 5 Native JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

            // Sync icon on load
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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-popup {
            background: var(--glass-bg) !important;
            backdrop-filter: blur(20px) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 24px !important;
            color: var(--text-main) !important;
        }
        .swal2-title, .swal2-html-container { color: var(--text-main) !important; }
    </style>

    <!-- DataTables JS & Plugins -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    @stack('scripts')
</body>
</html>
