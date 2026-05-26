<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — WebStudy CBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;1,9..40,400&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}">
    <style>
        :root {
            --brand: #1a56db;
            --brand-dark: #1e429f;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            margin: 0;
            padding: 20px;
        }

        body::after {
            content: '';
            position: absolute;
            inset: 0;
            background-size: 32px 32px;
            pointer-events: none;
            opacity: 0.3;
        }

        /* ── MODAL BOX ── */
        .login-box {
            background: #fff;
            width: 100%;
            max-width: 440px;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            position: relative;
            z-index: 10;
            animation: slideUp 0.4s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 24px;
        }
        .brand-logo img {
            width: 56px;
            height: 56px;
            background: #f1f5f9;
            border-radius: 14px;
            padding: 8px;
        }

        .form-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 24px;
            color: #0f172a;
            text-align: center;
            margin-bottom: 8px;
        }

        .form-sub {
            font-size: 14px;
            color: #64748b;
            text-align: center;
            margin-bottom: 32px;
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
            background: var(--brand);
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
            background: var(--brand-dark);
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
        
        .back-link {
            position: absolute;
            top: 24px;
            left: 24px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 10;
            transition: color 0.2s;
        }
        
        .back-link:hover {
            color: #fff;
        }
    </style>
</head>

<body>
    <a href="{{ url('/') }}" class="back-link"><i class="bi bi-arrow-left"></i> Kembali ke Beranda</a>

    <div class="login-box">
        <div class="brand-logo">
            <img src="{{ asset('logo.png') }}" alt="Logo" onerror="this.style.display='none'">
        </div>
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
                Masuk Sekarang <i class="bi bi-box-arrow-in-right"></i>
            </button>
        </form>

        @if (Route::has('register'))
        <div class="divider">atau</div>
        <div class="signup-row">
            Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
        </div>
        @endif
    </div>

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
