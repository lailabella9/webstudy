<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebStudy CBT - Platform Ujian Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;1,9..40,400&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}">
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background: #0f172a;
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }

        /* Top Navigation */
        .navbar-custom {
            padding: 20px 5%;
            background: transparent;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            background: #ffffff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 18px;
            color: #fff;
            letter-spacing: 0.5px;
        }

        .btn-top {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 24px;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-login {
            background: #1a56db;
            color: #fff;
        }

        .btn-login:hover {
            background: #1e429f;
            color: #fff;
        }

        .btn-register {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-left: 10px;
        }

        .btn-register:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        /* Hero Section */
        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 60px 20px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-size: 32px 32px;
            pointer-events: none;
            opacity: 0.5;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
        }

        .hero-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: clamp(36px, 5vw, 56px);
            line-height: 1.2;
            margin-bottom: 24px;
        }

        .hero-title span {
            color: #93c5fd;
        }

        .hero-desc {
            font-size: 18px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-start {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #1a56db;
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 16px;
            padding: 14px 36px;
            border-radius: 12px;
            text-decoration: none;
            transition: transform 0.2s, background 0.2s;
        }

        .btn-start:hover {
            background: #1e429f;
            color: #fff;
            transform: translateY(-2px);
        }

        .feature-cards {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 60px;
            flex-wrap: wrap;
        }

        .card-feature {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 24px;
            width: calc(33.333% - 20px);
            min-width: 250px;
            text-align: left;
            transition: background 0.2s;
        }

        .card-feature:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .ficon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 16px;
        }

        .fi-b { background: rgba(59, 130, 246, 0.2); color: #93c5fd; }
        .fi-i { background: rgba(99, 102, 241, 0.2); color: #a5b4fc; }
        .fi-t { background: rgba(20, 184, 166, 0.2); color: #5eead4; }

        .card-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .card-desc {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.6;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar-custom">
        <a href="{{ url('/') }}" class="brand-badge">
            <div class="brand-icon">
                <img src="{{ asset('logo.png') }}" alt="Logo" width="24" height="24" onerror="this.style.display='none'">
            </div>
            <span class="brand-name">WebStudy CBT</span>
        </a>
        <div class="nav-actions">
            @auth
                <a href="{{ url('/home') }}" class="btn-top btn-login">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-top btn-login">Log In</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-top btn-register">Register</a>
                @endif
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-content">
            <h1 class="hero-title">
                Platform Ujian<br>
                <span>Berbasis Komputer</span><br>
                Terpercaya
            </h1>
            <p class="hero-desc">
                Sistem CBT modern untuk guru dan siswa. Kelola materi, soal, dan pantau perkembangan belajar secara real-time dalam satu platform terpadu.
            </p>
            
            @guest
                <a href="{{ route('login') }}" class="btn-start">
                    Mulai Sekarang <i class="bi bi-arrow-right"></i>
                </a>
            @else
                <a href="{{ url('/home') }}" class="btn-start">
                    Masuk ke Dashboard <i class="bi bi-arrow-right"></i>
                </a>
            @endguest

            <!-- Features -->
            <div class="feature-cards">
                <div class="card-feature">
                    <div class="ficon fi-b"><i class="bi bi-lightning-charge-fill"></i></div>
                    <div class="card-title">Real-time Ujian</div>
                    <div class="card-desc">Sistem ujian online terintegrasi dengan timer otomatis dan anti-kecurangan.</div>
                </div>
                <div class="card-feature">
                    <div class="ficon fi-i"><i class="bi bi-bar-chart-fill"></i></div>
                    <div class="card-title">Analisis Lengkap</div>
                    <div class="card-desc">Statistik komprehensif dan laporan nilai detail untuk pemantauan belajar.</div>
                </div>
                <div class="card-feature">
                    <div class="ficon fi-t"><i class="bi bi-journal-richtext"></i></div>
                    <div class="card-title">Kelola Materi</div>
                    <div class="card-desc">Kemudahan dalam mengunggah materi pelajaran dan bank soal interaktif.</div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
