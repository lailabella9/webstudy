<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — WebStudy CBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:opsz,wght@9..40,400;9..40,500&display=swap" rel="stylesheet">
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
            overflow-x: hidden;
            margin: 0;
            padding: 40px 20px;
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
        .register-box {
            background: #fff;
            width: 100%;
            max-width: 540px;
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
            margin-bottom: 24px;
        }

        /* Role tabs */
        .role-tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 24px;
        }

        .role-tab {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 14px;
            color: #64748b;
            cursor: pointer;
            transition: all .2s;
            background: #f8fafc;
            user-select: none;
        }

        .role-tab.active {
            border-color: var(--brand);
            background: #eff6ff;
            color: var(--brand);
        }

        .role-tab:hover:not(.active) {
            border-color: #93c5fd;
            background: #f0f9ff;
        }

        /* Form grid */
        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
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
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .12);
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

        .mb14 {
            margin-bottom: 16px;
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
            margin-top: 24px;
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

        .login-row {
            text-align: center;
            font-size: 13.5px;
            color: #64748b;
        }

        .login-row a {
            color: var(--brand);
            font-weight: 600;
            text-decoration: none;
        }

        .login-row a:hover {
            text-decoration: underline;
        }

        .alert-err {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            color: #b91c1c;
            font-size: 13px;
            padding: 12px 16px;
            margin-bottom: 18px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .err-list {
            list-style: none;
            margin-bottom: 0;
            padding-left: 0;
        }

        .err-list li {
            line-height: 1.6;
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

        @media (max-width: 600px) {
            .form-grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <a href="{{ url('/') }}" class="back-link"><i class="bi bi-arrow-left"></i> Kembali ke Beranda</a>

    <div class="register-box">
        <div class="brand-logo">
            <img src="{{ asset('logo.png') }}" alt="Logo" onerror="this.style.display='none'">
        </div>
        <h2 class="form-title">Buat Akun Baru</h2>
        <p class="form-sub">Isi formulir di bawah untuk mendaftar</p>

        @if ($errors->any())
            <div class="alert-err">
                <i class="bi bi-exclamation-circle-fill mt-1 flex-shrink-0"></i>
                <ul class="err-list">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            {{-- Role Selector --}}
            <div class="role-tabs" id="role-tabs">
                <div class="role-tab {{ old('role', 'siswa') === 'siswa' ? 'active' : '' }}" id="tab-siswa"
                    onclick="setRole('siswa')">
                    <i class="bi bi-mortarboard"></i> Siswa
                </div>
                <div class="role-tab {{ old('role') === 'guru' ? 'active' : '' }}" id="tab-guru"
                    onclick="setRole('guru')">
                    <i class="bi bi-person-badge"></i> Guru / Admin
                </div>
            </div>
            <input type="hidden" name="role" id="role-input" value="{{ old('role', 'siswa') }}">

            {{-- Nama + Email --}}
            <div class="form-grid-2 mb14">
                <div>
                    <label class="lbl">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        class="finput {{ $errors->has('nama') ? 'err' : '' }}" placeholder="Nama lengkap" required>
                </div>
                <div>
                    <label class="lbl">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="finput {{ $errors->has('email') ? 'err' : '' }}" placeholder="email@contoh.com"
                        required>
                </div>
            </div>

            <div class="mb14" id="kelas-wrapper"
                style="{{ old('role', 'siswa') === 'siswa' ? '' : 'display:none;' }}">
                <label class="lbl">
                    Kelas <span style="color:#ef4444;">*</span>
                </label>
                <select name="kelas_id" id="kelas_select" class="finput {{ $errors->has('kelas_id') ? 'err' : '' }}"
                    style="background:#f8fafc;" {{ old('role', 'siswa') === 'siswa' ? 'required' : '' }}>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->Id_kelas }}"
                            {{ old('kelas_id') == $k->Id_kelas ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <div style="font-size:11.5px;color:#ef4444;margin-top:4px;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-grid-2 mb14">
                <div>
                    <label class="lbl">Password</label>
                    <div class="input-wrap">
                        <input type="password" name="password" id="pw1"
                            class="finput {{ $errors->has('password') ? 'err' : '' }}"
                            placeholder="Minimal 6 karakter" required minlength="6">
                        <button type="button" class="eye-btn" onclick="togglePw('pw1','ic1')">
                            <i class="bi bi-eye-slash" id="ic1"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="lbl">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <input type="password" name="password_confirmation" id="pw2" class="finput"
                            placeholder="Ulangi password" required>
                        <button type="button" class="eye-btn" onclick="togglePw('pw2','ic2')">
                            <i class="bi bi-eye-slash" id="ic2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                Daftar Sekarang <i class="bi bi-person-plus-fill"></i>
            </button>
        </form>

        <div class="divider">atau</div>
        <div class="login-row">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function setRole(r) {
            document.getElementById('role-input').value = r;
            ['siswa', 'guru'].forEach(x => {
                document.getElementById('tab-' + x).classList.toggle('active', x === r);
            });
            const kelasWrapper = document.getElementById('kelas-wrapper');
            const kelasSelect = document.getElementById('kelas_select');
            if (r === 'siswa') {
                kelasWrapper.style.display = 'block';
                kelasSelect.required = true;
            } else {
                kelasWrapper.style.display = 'none';
                kelasSelect.required = false;
            }
        }

        function togglePw(id, icId) {
            const f = document.getElementById(id);
            const i = document.getElementById(icId);
            f.type = f.type === 'password' ? 'text' : 'password';
            i.className = f.type === 'password' ? 'bi bi-eye-slash' : 'bi bi-eye';
        }
    </script>
</body>
</html>
