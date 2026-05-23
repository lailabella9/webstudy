<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — WebStudy CBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:opsz,wght@9..40,400;9..40,500&display=swap"
        rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}">
    <style>
        :root {
            --brand: #1a56db;
            --brand-dark: #1e429f;
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

        .page-wrap {
            display: flex;
            min-height: calc(100vh - 40px);
        }

        /* ── HERO ── */
        .hero-side {
            flex: 1 1 40%;
            background: linear-gradient(145deg, #0f172a 0%, #1e3a8a 65%, #1d4ed8 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 56px;
            overflow: hidden;
        }

        .hero-side::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 70% 60% at 85% 15%, rgba(147, 197, 253, .14) 0%, transparent 60%),
                radial-gradient(ellipse 55% 50% at 10% 85%, rgba(139, 92, 246, .12) 0%, transparent 55%);
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
            margin-bottom: 36px;
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
            font-size: clamp(28px, 2.8vw, 42px);
            color: #fff;
            line-height: 1.2;
            margin-bottom: 16px;
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
            color: rgba(255, 255, 255, .62);
            font-size: 14.5px;
            line-height: 1.7;
            max-width: 400px;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .hero-sub {
            color: rgba(255, 255, 255, .32);
            font-size: 12.5px;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .kl-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
            position: relative;
            z-index: 1;
        }

        .kl-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, .055);
            border: 1px solid rgba(255, 255, 255, .09);
            border-radius: 12px;
            padding: 12px 16px;
            color: rgba(255, 255, 255, .82);
            font-size: 13.5px;
            font-weight: 500;
            transition: background .2s;
        }

        .kl-item:hover {
            background: rgba(255, 255, 255, .09);
        }

        .kl-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .ki-b {
            background: rgba(59, 130, 246, .3);
            color: #93c5fd;
        }

        .ki-i {
            background: rgba(99, 102, 241, .3);
            color: #a5b4fc;
        }

        .ki-t {
            background: rgba(20, 184, 166, .3);
            color: #5eead4;
        }

        /* ── FORM SIDE ── */
        .form-side {
            flex: 0 0 60%;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 44px 60px;
            box-shadow: -6px 0 48px rgba(0, 0, 0, .1);
            overflow-y: auto;
        }

        .form-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 24px;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .form-sub {
            font-size: 13.5px;
            color: #64748b;
            margin-bottom: 22px;
            line-height: 1.5;
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
            padding: 13px 20px;
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
            font-size: 12.5px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
        }

        .finput {
            display: block;
            width: 100%;
            height: 44px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 13.5px;
            color: #0f172a;
            padding: 0 13px;
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
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color .2s;
        }

        .eye-btn:hover {
            color: var(--brand);
        }

        .mb14 {
            margin-bottom: 14px;
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
            margin-top: 8px;
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
            margin: 18px 0;
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
        }

        .err-list li {
            line-height: 1.6;
        }

        @media (max-width: 900px) {
            .page-wrap {
                flex-direction: column;
            }

            .hero-side {
                padding: 44px 28px;
                flex: none;
            }

            .form-side {
                flex: 1;
                padding: 36px 24px;
                box-shadow: none;
            }

            .form-grid-2 {
                grid-template-columns: 1fr;
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
                Bergabung &<br>
                <span>Mulai Belajar</span><br>
                Sekarang
            </h1>
            <p class="hero-desc">
                Buat akun gratis dan akses semua fitur platform
                CBT WebStudy. Tersedia untuk siswa dan guru.
            </p>
            <p class="hero-sub">Proses pendaftaran cepat, kurang dari 1 menit</p>
            <ul class="kl-list">
                <li class="kl-item">
                    <div class="kl-icon ki-b"><i class="bi bi-person-check-fill"></i></div>
                    Daftar gratis, tanpa biaya apapun
                </li>
                <li class="kl-item">
                    <div class="kl-icon ki-i"><i class="bi bi-mortarboard-fill"></i></div>
                    Akses semua materi & soal latihan
                </li>
                <li class="kl-item">
                    <div class="kl-icon ki-t"><i class="bi bi-graph-up-arrow"></i></div>
                    Pantau perkembangan nilai secara real-time
                </li>
            </ul>
        </div>

        <!-- FORM -->
        <div class="form-side">
            <h2 class="form-title">Buat Akun Baru</h2>
            <p class="form-sub">Isi formulir di bawah untuk mendaftar</p>

            @if ($errors->any())
                <div class="alert-err">
                    <i class="bi bi-exclamation-circle-fill mt-1 flex-shrink-0"></i>
                    <ul class="err-list mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf

                {{-- Role Selector --}}
                <div class="role-tabs mb-3" id="role-tabs">
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
                    <select name="kelas_id" class="finput {{ $errors->has('kelas_id') ? 'err' : '' }}"
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

                {{-- Konfirmasi + (kosong placeholder kolom kanan) --}}
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
                    <i class="bi bi-person-plus-fill"></i> Daftar Sekarang
                </button>
            </form>

            <div class="divider">atau</div>
            <div class="login-row">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function setRole(r) {
            document.getElementById('role-input').value = r;
            ['siswa', 'guru'].forEach(x => {
                document.getElementById('tab-' + x).classList.toggle('active', x === r);
            });
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
