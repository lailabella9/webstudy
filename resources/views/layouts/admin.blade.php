<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — WebStudy CBT</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}">
    <style>
        :root {
            --sidebar-w: 210px;
            --brand: #1a56db;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #f1f5f9;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            background: #0f172a;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 200;
            overflow-y: auto;
        }

        .sb-logo {
            padding: 20px 16px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .sb-logo-inner {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .sb-logo-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .sb-logo-text {
            font-size: 14px;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
        }

        .sb-logo-sub {
            font-size: 10px;
            color: rgba(255, 255, 255, .35);
        }

        .sb-nav {
            padding: 12px 10px;
            flex: 1;
        }

        .sb-section-label {
            font-size: 9.5px;
            font-weight: 700;
            color: rgba(255, 255, 255, .28);
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 10px 10px 5px;
        }

        .sb-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 12px;
            border-radius: 8px;
            color: rgba(255, 255, 255, .62);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 1px;
            transition: background .15s, color .15s;
        }

        .sb-item i {
            font-size: 15px;
            width: 18px;
            text-align: center;
        }

        .sb-item:hover {
            background: rgba(255, 255, 255, .07);
            color: #fff;
        }

        .sb-item.active {
            background: var(--brand);
            color: #fff;
        }

        .sb-divider {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, .07);
            margin: 8px 10px;
        }

        .sb-footer {
            padding: 12px 10px;
            border-top: 1px solid rgba(255, 255, 255, .08);
        }

        .sb-user {
            display: flex;
            align-items: center;
            gap: 9px;
            background: rgba(255, 255, 255, .06);
            border-radius: 10px;
            padding: 10px 11px;
        }

        .sb-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            flex-shrink: 0;
            background: #1a56db;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            overflow: hidden;
        }

        .sb-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sb-uname {
            font-size: 12px;
            font-weight: 600;
            color: #fff;
            line-height: 1.3;
        }

        .sb-urole {
            font-size: 10px;
            color: rgba(255, 255, 255, .35);
        }

        /* ── MAIN ── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e9edf2;
            padding: 13px 26px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar h1 {
            font-size: 17px;
            font-weight: 700;
            color: #0f172a;
        }

        .topbar p {
            font-size: 12px;
            color: #64748b;
            margin-top: 1px;
        }

        .topbar-right {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-primary-sm {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--brand);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: opacity .15s;
        }

        .btn-primary-sm:hover {
            opacity: .88;
            color: #fff;
        }

        .btn-icon-sm {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 16px;
            text-decoration: none;
            transition: background .15s;
        }

        .btn-icon-sm:hover {
            background: #e2e8f0;
            color: #374151;
        }

        /* ── PAGE CONTENT ── */
        .page-content {
            padding: 22px 26px;
            flex: 1;
        }

        /* ── FLASH MESSAGES ── */
        .flash {
            border-radius: 10px;
            padding: 11px 16px;
            margin-bottom: 18px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .flash-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
        }

        .flash-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }

        /* Quill toolbar & editor styling */
        #quill-editor {
            min-height: 220px;
            max-height: 480px;
            overflow-y: auto;
            font-size: 13.5px;
            font-family: inherit;
            line-height: 1.7;
            background: #f8fafc;
            border-radius: 0 0 9px 9px;
            border: none;
        }

        .ql-toolbar.ql-snow {
            border: 1.5px solid #e2e8f0;
            border-bottom: 1px solid #e9edf2;
            border-radius: 9px 9px 0 0;
            background: #fff;
            padding: 8px 10px;
        }

        .ql-container.ql-snow {
            border: 1.5px solid #e2e8f0;
            border-top: none;
            border-radius: 0 0 9px 9px;
            background: #f8fafc;
        }

        /* Focus ring matches the other inputs */
        .ql-editor-focused .ql-toolbar.ql-snow,
        .ql-editor-focused .ql-container.ql-snow {
            border-color: #1a56db;
        }

        .quill-wrapper:focus-within .ql-toolbar.ql-snow,
        .quill-wrapper:focus-within .ql-container.ql-snow {
            border-color: #1a56db;
        }

        .ql-editor.ql-blank::before {
            color: #94a3b8;
            font-style: normal;
            font-size: 13px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* SweetAlert2 Premium Custom Styles */
        .swal2-premium-popup {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border-radius: 16px !important;
            padding: 24px !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
            border: 1px solid #f1f5f9 !important;
        }
        .swal2-premium-popup .swal2-title {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            margin-top: 10px !important;
        }
        .swal2-premium-popup .swal2-html-container {
            font-size: 14px !important;
            color: #475569 !important;
            line-height: 1.6 !important;
            margin: 12px 0 0 0 !important;
        }
        .swal2-premium-popup .swal2-actions {
            margin-top: 24px !important;
            gap: 8px !important;
        }
        .swal2-premium-popup .swal2-confirm, 
        .swal2-premium-popup .swal2-cancel {
            border-radius: 9px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            padding: 10px 20px !important;
            margin: 0 !important;
            box-shadow: none !important;
            transition: all 0.15s ease-in-out !important;
        }
        .swal2-premium-popup .swal2-confirm:hover {
            opacity: 0.9 !important;
        }
        .swal2-premium-popup .swal2-cancel:hover {
            background-color: #cbd5e1 !important;
        }
    </style>
    @stack('styles')
</head>

<body>

    <aside class="sidebar">
        <div class="sb-logo">
            <div class="sb-logo-inner">
                <div class="sb-logo-icon"><img src="{{ asset('logo.png') }}" alt="" width="32"
                        height="32"></div>
                <div>
                    <div class="sb-logo-text">WebStudy</div>
                    <div class="sb-logo-sub">CBT Platform</div>
                </div>
            </div>
        </div>

        <nav class="sb-nav">
            <div class="sb-section-label">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}"
                class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>
            <a href="{{ route('admin.guru.index') }}"
                class="sb-item {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge-fill"></i> Kelola Guru
            </a>
            <a href="{{ route('admin.siswa.index') }}"
                class="sb-item {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Kelola Siswa
            </a>
            <a href="{{ route('admin.statistik') }}"
                class="sb-item {{ request()->routeIs('admin.statistik') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-fill"></i> Statistik
            </a>
            <hr class="sb-divider">
            <a href="#" class="sb-item" onclick="alert('Profil Admin belum tersedia')">
                <i class="bi bi-person-circle"></i> Profil Admin
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sb-item w-100 border-0 bg-transparent text-start" style="cursor:pointer;">
                    <i class="bi bi-box-arrow-left"></i> Keluar
                </button>
            </form>
        </nav>

        <div class="sb-footer">
            <div class="sb-user">
                <div class="sb-avatar">
                    @if (auth()->user()->foto_profil)
                        <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="">
                    @else
                        {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="sb-uname">{{ auth()->user()->nama }}</div>
                    <div class="sb-urole">Administrator</div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main-wrap">
        <div class="topbar">
            <div>
                <h1>@yield('page-title', 'Dashboard')</h1>
                <p>@yield('page-subtitle', 'Selamat datang di panel guru WebStudy CBT')</p>
            </div>
            <div class="topbar-right">
                @yield('topbar-actions')
            </div>
        </div>

        <div style="padding: 0 26px; margin-top: 16px;">
            @if (session('success'))
                <div class="flash flash-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="flash flash-error"><i class="bi bi-x-circle-fill"></i> {{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="flash flash-error">
                    <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="page-content">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        // Global SweetAlert2 confirm interceptor
        document.addEventListener('DOMContentLoaded', function() {
            // Click listener for inline onclick="return confirm(...)"
            document.addEventListener('click', function(e) {
                let target = e.target.closest('[onclick*="confirm("]');
                if (!target) return;

                if (target.dataset.swalConfirmed === 'true') {
                    return;
                }

                const onclickAttr = target.getAttribute('onclick');
                const match = onclickAttr.match(/confirm\(['"](.*?)['"]\)/);
                if (match) {
                    e.preventDefault();
                    e.stopPropagation();

                    const confirmMsg = match[1];
                    const isDelete = confirmMsg.toLowerCase().includes('hapus') || confirmMsg.toLowerCase().includes('delete') || confirmMsg.toLowerCase().includes('reset');

                    Swal.fire({
                        title: isDelete ? 'Konfirmasi Tindakan' : 'Konfirmasi',
                        text: confirmMsg.replace(/\\'/g, "'").replace(/\\"/g, '"'),
                        icon: isDelete ? 'warning' : 'question',
                        showCancelButton: true,
                        confirmButtonColor: isDelete ? '#dc2626' : '#1a56db',
                        cancelButtonColor: '#94a3b8',
                        confirmButtonText: isDelete ? 'Ya, Lanjutkan' : 'Ya',
                        cancelButtonText: 'Batal',
                        customClass: {
                            popup: 'swal2-premium-popup'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            target.dataset.swalConfirmed = 'true';
                            const origConfirm = window.confirm;
                            window.confirm = () => true;
                            target.click();
                            window.confirm = origConfirm;
                        }
                    });
                }
            }, true);

            // Submit listener for forms with inline onsubmit or logout
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (form.dataset.swalConfirmed === 'true' || form.querySelector('[data-swal-confirmed="true"]')) {
                    return;
                }

                const onsubmitAttr = form.getAttribute('onsubmit');
                let confirmMsg = '';

                if (onsubmitAttr && onsubmitAttr.includes('confirm(')) {
                    const match = onsubmitAttr.match(/confirm\(['"](.*?)['"]\)/);
                    if (match) {
                        confirmMsg = match[1];
                    }
                }

                // Check if the form is a logout form
                const action = form.getAttribute('action') || '';
                const isLogout = action.includes('logout');
                if (!confirmMsg && isLogout) {
                    confirmMsg = 'Apakah Anda yakin ingin keluar dari aplikasi?';
                }

                if (confirmMsg) {
                    e.preventDefault();
                    e.stopPropagation();

                    const isDelete = confirmMsg.toLowerCase().includes('hapus') || confirmMsg.toLowerCase().includes('delete') || confirmMsg.toLowerCase().includes('reset');

                    Swal.fire({
                        title: isLogout ? 'Keluar Aplikasi' : (isDelete ? 'Konfirmasi Hapus' : 'Konfirmasi'),
                        text: confirmMsg.replace(/\\'/g, "'").replace(/\\"/g, '"'),
                        icon: isLogout ? 'question' : (isDelete ? 'warning' : 'question'),
                        showCancelButton: true,
                        confirmButtonColor: isDelete ? '#dc2626' : '#1a56db',
                        cancelButtonColor: '#94a3b8',
                        confirmButtonText: isLogout ? 'Ya, Keluar' : (isDelete ? 'Ya, Hapus' : 'Ya, Lanjutkan'),
                        cancelButtonText: 'Batal',
                        customClass: {
                            popup: 'swal2-premium-popup'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.dataset.swalConfirmed = 'true';
                            form.submit();
                        }
                    });
                }
            }, true);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>

</html>
