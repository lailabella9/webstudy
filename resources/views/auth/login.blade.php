<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — WebStudy CBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;1,9..40,400&display=swap"
        rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}">
    <style>
        :root {
            --brand: #1a56db;
            --brand-dark: #1e429f;
            --hero-bg: #0f172a;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
        }

        /* TOP BAR */
        .top-bar {
            background: #0f172a;
            color: rgba(255, 255, 255, .45);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .14em;
            text-transform: uppercase;
            text-align: center;
            padding: 10px;
        }

        /* LAYOUT */
        .page-wrap {
            display: flex;
            min-height: calc(100vh - 40px);
        }

        /* ── HERO SIDE ── */
        .hero-side {
            flex: 1 1 58%;
            background: linear-gradient(145deg, #0f172a 0%, #1e3a8a 65%, #1d4ed8 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 64px;
            overflow: hidden;
        }

        .hero-side::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 70% 60% at 80% 15%, rgba(147, 197, 253, .15) 0%, transparent 60%),
                radial-gradient(ellipse 50% 50% at 15% 85%, rgba(139, 92, 246, .12) 0%, transparent 55%);
            pointer-events: none;
        }

        .hero-side::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, .055) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .13);
            border-radius: 50px;
            padding: 7px 18px 7px 8px;
            margin-bottom: 40px;
            width: fit-content;
            position: relative;
            z-index: 1;
        }

        .brand-icon {
            width: 32px;
            height: 32px;
            background: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 15px;
            color: #fff;
        }

        .hero-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: clamp(30px, 3.2vw, 46px);
            color: #fff;
            line-height: 1.18;
            margin-bottom: 18px;
            position: relative;
            z-index: 1;
        }

        .hero-title span {
            background: linear-gradient(90deg, #93c5fd, #a5b4fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            color: rgba(255, 255, 255, .65);
            font-size: 15px;
            line-height: 1.7;
            max-width: 440px;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .hero-sub {
            color: rgba(255, 255, 255, .35);
            font-size: 13px;
            margin-bottom: 44px;
            position: relative;
            z-index: 1;
        }

        .feature-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 11px;
            position: relative;
            z-index: 1;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255, 255, 255, .055);
            border: 1px solid rgba(255, 255, 255, .09);
            border-radius: 12px;
            padding: 13px 18px;
            color: rgba(255, 255, 255, .85);
            font-size: 14px;
            font-weight: 500;
            transition: background .2s;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, .09);
        }

        .ficon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .fi-b {
            background: rgba(59, 130, 246, .3);
            color: #93c5fd;
        }

        .fi-i {
            background: rgba(99, 102, 241, .3);
            color: #a5b4fc;
        }

        .fi-t {
            background: rgba(20, 184, 166, .3);
            color: #5eead4;
        }

        .fi-a {
            background: rgba(245, 158, 11, .25);
            color: #fcd34d;
        }

        /* ── FORM SIDE ── */
        .form-side {
            flex: 0 0 42%;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 52px 52px;
            box-shadow: -6px 0 48px rgba(0, 0, 0, .1);
        }

        .form-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 26px;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .form-sub {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 32px;
            line-height: 1.5;
        }

        .lbl {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .finput {
            display: block;
            width: 100%;
            height: 46px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            color: #0f172a;
            padding: 0 14px;
            background: #f8fafc;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        .finput:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3.5px rgba(26, 86, 219, .13);
            background: #fff;
        }

        .finput.err {
            border-color: #ef4444;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .finput {
            padding-right: 44px;
        }

        .eye-btn {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 44px;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color .2s;
        }

        .eye-btn:hover {
            color: var(--brand);
        }

        .row-mid {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 18px 0 24px;
        }

        .row-mid label {
            font-size: 13px;
            color: #475569;
            cursor: pointer;
        }

        .forgot {
            font-size: 13px;
            color: var(--brand);
            text-decoration: none;
            font-weight: 600;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, #1a56db, #1e429f);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: opacity .2s, transform .15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            opacity: .92;
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0;
            color: #94a3b8;
            font-size: 12px;
            font-weight: 500;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e9edf2;
        }

        .signup-row {
            text-align: center;
            font-size: 13.5px;
            color: #64748b;
        }

        .signup-row a {
            color: var(--brand);
            font-weight: 600;
            text-decoration: none;
        }

        .signup-row a:hover {
            text-decoration: underline;
        }

        .alert-err {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            color: #b91c1c;
            font-size: 13px;
            padding: 12px 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .mb14 {
            margin-bottom: 14px;
        }

        @media (max-width: 860px) {
            .page-wrap {
                flex-direction: column;
            }

            .hero-side {
                padding: 48px 28px;
            }

            .form-side {
                flex: 1;
                padding: 40px 28px;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrap">
        <!-- HERO -->
        <div class="hero-side">
            <div class="brand-badge">
                <div class="brand-icon"><img src="{{ asset('logo.png') }}" alt="" width="32" height="32">
                </div>
                <span class="brand-name">WebStudy CBT</span>
            </div>
            <h1 class="hero-title">
                Platform Ujian<br>
                <span>Berbasis Komputer</span><br>
                Terpercaya
            </h1>
            <p class="hero-desc">
                Sistem CBT modern untuk guru dan siswa. Kelola materi, soal, dan pantau
                perkembangan belajar secara real-time dalam satu platform terpadu.
            </p>
            <p class="hero-sub">Dipercaya oleh ribuan pengguna aktif</p>
            <ul class="feature-list">
                <li class="feature-item">
                    <div class="ficon fi-b"><i class="bi bi-lightning-charge-fill"></i></div>
                    Ujian Online Real-time dengan Timer Otomatis
                </li>
                <li class="feature-item">
                    <div class="ficon fi-i"><i class="bi bi-bar-chart-fill"></i></div>
                    Statistik & Laporan Nilai Lengkap
                </li>
                <li class="feature-item">
                    <div class="ficon fi-t"><i class="bi bi-journal-richtext"></i></div>
                    Kelola Materi dan Soal dengan Mudah
                </li>
                <li class="feature-item">
                    <div class="ficon fi-a"><i class="bi bi-shield-check"></i></div>
                    Keamanan Akun Berlapis untuk Semua Pengguna
                </li>
            </ul>
        </div>

        <!-- FORM -->
        <div class="form-side">
            <h2 class="form-title">Selamat Datang</h2>
            <p class="form-sub">Masuk ke akun Anda untuk melanjutkan</p>

            @if ($errors->any())
                <div class="alert-err">
                    <i class="bi bi-exclamation-circle-fill mt-1"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="mb14">
                    <label class="lbl">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="finput {{ $errors->has('email') ? 'err' : '' }}" placeholder="nama@email.com" required
                        autofocus>
                </div>
                <div class="mb14">
                    <label class="lbl">Password</label>
                    <div class="input-wrap">
                        <input type="password" name="password" id="pw"
                            class="finput {{ $errors->has('password') ? 'err' : '' }}" placeholder="Masukkan password"
                            required>
                        <button type="button" class="eye-btn" onclick="togglePw()">
                            <i class="bi bi-eye-slash" id="pw-ic"></i>
                        </button>
                    </div>
                </div>
                <div class="row-mid">
                    <div class="d-flex align-items-center gap-2">
                        <input class="form-check-input m-0" type="checkbox" name="remember" id="rem">
                        <label for="rem">Ingat saya</label>
                    </div>
                    <a href="#" class="forgot">Lupa password?</a>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk Sekarang
                </button>
            </form>

            <div class="divider">atau</div>
            <div class="signup-row">
                Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePw() {
            const f = document.getElementById('pw');
            const i = document.getElementById('pw-ic');
            f.type = f.type === 'password' ? 'text' : 'password';
            i.className = f.type === 'password' ? 'bi bi-eye-slash' : 'bi bi-eye';
        }
    </script>
</body>

</html>
