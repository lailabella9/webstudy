<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $kategori->nama }} — {{ $materi->judul }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
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

        :root {
            --sidebar-w: 210px;
            --brand: {{ $kategori->warna }};
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
        }

        .sb-logo {
            padding: 20px 16px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .sb-li {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: #1a56db;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .sb-lt {
            font-size: 14px;
            font-weight: 800;
            color: #fff;
        }

        .sb-ls {
            font-size: 10px;
            color: rgba(255, 255, 255, .35);
        }

        .sb-nav {
            padding: 12px 10px;
            flex: 1;
            overflow-y: auto;
        }

        .sb-lbl {
            font-size: 9.5px;
            font-weight: 700;
            color: rgba(255, 255, 255, .28);
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 10px 10px 5px;
        }

        .sb-a {
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
            transition: background .15s;
        }

        .sb-a i {
            font-size: 15px;
            width: 18px;
            text-align: center;
        }

        .sb-a:hover {
            background: rgba(255, 255, 255, .07);
            color: #fff;
        }

        .sb-a.act {
            background: var(--brand);
            color: #fff;
        }

        .sb-hr {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, .07);
            margin: 8px 10px;
        }

        .sb-foot {
            padding: 12px 10px;
            border-top: 1px solid rgba(255, 255, 255, .08);
        }

        .sb-usr {
            display: flex;
            align-items: center;
            gap: 9px;
            background: rgba(255, 255, 255, .06);
            border-radius: 10px;
            padding: 10px 11px;
        }

        .sb-av {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #1a56db;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            overflow: hidden;
        }

        .sb-av img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sb-un {
            font-size: 12px;
            font-weight: 600;
            color: #fff;
        }

        .sb-ur {
            font-size: 10px;
            color: rgba(255, 255, 255, .4);
            margin-top: 1px;
        }

        .main {
            margin-left: var(--sidebar-w);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .cbt-topbar {
            background: #fff;
            border-bottom: 1px solid #e9edf2;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .cbt-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
        }

        .cbt-sub {
            font-size: 12px;
            color: #64748b;
            margin-top: 1px;
        }

        .btn-akhiri {
            background: #fef2f2;
            color: #b91c1c;
            border: 1.5px solid #fecaca;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
        }

        .btn-akhiri:hover {
            background: #fee2e2;
        }

        .cbt-infobar {
            background: #fff;
            border-bottom: 1px solid #e9edf2;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .kat-badge {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .kat-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: var(--brand);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }

        .timer-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #0f172a;
            color: #fff;
            padding: 8px 16px;
            border-radius: 10px;
        }

        .timer-val {
            font-size: 18px;
            font-weight: 800;
            font-variant-numeric: tabular-nums;
            letter-spacing: .04em;
        }

        .timer-lbl {
            font-size: 10px;
            color: rgba(255, 255, 255, .5);
        }

        .cbt-progress {
            height: 4px;
            background: #f1f5f9;
        }

        .cbt-progress-fill {
            height: 100%;
            background: var(--brand);
            transition: width .3s;
        }

        .cbt-body {
            display: flex;
            flex: 1;
            padding: 20px 24px;
            gap: 20px;
        }

        .soal-area {
            flex: 1;
            min-width: 0;
        }

        .soal-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e9edf2;
            overflow: hidden;
        }

        .soal-header {
            padding: 14px 20px;
            background: #f8fafc;
            border-bottom: 1px solid #e9edf2;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .soal-num {
            width: 28px;
            height: 28px;
            background: var(--brand);
            color: #fff;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .soal-meta {
            font-size: 12px;
            color: #64748b;
        }

        .soal-body {
            padding: 20px;
        }

        .soal-text {
            font-size: 14px;
            color: #0f172a;
            line-height: 1.7;
            margin-bottom: 20px;
            font-weight: 500;
        }

        /* Pilihan: hanya 3 state — default, dipilih, disabled-sudah */
        .pilihan-btn {
            width: 100%;
            text-align: left;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 9px;
            font-size: 13.5px;
            color: #374151;
            background: #fff;
            cursor: pointer;
            transition: all .15s;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .pilihan-btn:hover:not(:disabled) {
            border-color: var(--brand);
            background: color-mix(in srgb, var(--brand) 8%, white);
        }

        .pilihan-btn:disabled {
            cursor: not-allowed;
            opacity: .75;
        }

        .pilihan-btn.dipilih {
            border-color: var(--brand);
            background: color-mix(in srgb, var(--brand) 12%, white);
            color: #0f172a;
        }

        /* Custom Colors for Choice Buttons */
        .pilihan-btn.pilihan-0:hover:not(:disabled),
        .pilihan-btn.pilihan-0.dipilih {
            border-color: #1a56db;
            background-color: #eff6ff;
            color: #1a56db;
        }
        .pilihan-btn.pilihan-1:hover:not(:disabled),
        .pilihan-btn.pilihan-1.dipilih {
            border-color: #4f46e5;
            background-color: #f5f3ff;
            color: #4f46e5;
        }
        .pilihan-btn.pilihan-2:hover:not(:disabled),
        .pilihan-btn.pilihan-2.dipilih {
            border-color: #0f766e;
            background-color: #f0fdfa;
            color: #0f766e;
        }
        .pilihan-btn.pilihan-3:hover:not(:disabled),
        .pilihan-btn.pilihan-3.dipilih {
            border-color: #b45309;
            background-color: #fffbeb;
            color: #b45309;
        }
        .pilihan-btn.pilihan-4:hover:not(:disabled),
        .pilihan-btn.pilihan-4.dipilih {
            border-color: #be185d;
            background-color: #fdf2f8;
            color: #be185d;
        }

        /* Saat semua soal selesai, tampilkan hasil jawaban */
        .pilihan-btn.reveal-benar {
            border-color: #16a34a;
            background: #f0fdf4;
            color: #15803d;
        }

        .pilihan-btn.reveal-salah {
            border-color: #dc2626;
            background: #fef2f2;
            color: #b91c1c;
        }

        .pilihan-badge {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 11px;
            font-weight: 700;
        }

        /* Feedback netral (sudah dijawab) */
        .feedback {
            border-radius: 10px;
            padding: 12px 16px;
            margin-top: 12px;
            font-size: 13px;
            font-weight: 500;
            display: none;
            align-items: flex-start;
            gap: 8px;
        }

        .feedback.show {
            display: flex;
        }

        .feedback-saved {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            color: #0369a1;
        }

        .soal-footer {
            padding: 14px 20px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-nav {
            padding: 9px 20px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid #e2e8f0;
            background: #fff;
            color: #374151;
            transition: all .15s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-nav:hover {
            background: #f1f5f9;
        }

        .btn-nav.primary {
            background: var(--brand);
            color: #fff;
            border-color: var(--brand);
        }

        .btn-nav.primary:hover {
            opacity: .88;
        }

        .btn-tandai {
            background: #fffbeb;
            color: #b45309;
            border-color: #fcd34d;
        }

        .btn-tandai.ditandai {
            background: #f59e0b;
            color: #fff;
            border-color: #f59e0b;
        }

        .nav-soal {
            width: 220px;
            flex-shrink: 0;
        }

        .nav-soal-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e9edf2;
            padding: 16px;
            position: sticky;
            top: 80px;
        }

        .nav-title {
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-bottom: 12px;
        }

        .nav-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 6px;
            margin-bottom: 14px;
        }

        .nav-btn {
            height: 34px;
            border-radius: 7px;
            border: none;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .nav-btn.default {
            background: #f1f5f9;
            color: #64748b;
        }

        .nav-btn.aktif {
            background: var(--brand);
            color: #fff;
        }

        .nav-btn.dijawab {
            background: #22c55e;
            color: #fff;
        }

        .nav-btn.ditandai {
            background: #f59e0b;
            color: #fff;
        }

        .nav-legend {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 14px;
        }

        .leg {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 11.5px;
            color: #374151;
        }

        .leg-dot {
            width: 12px;
            height: 12px;
            border-radius: 3px;
            flex-shrink: 0;
        }

        .btn-submit {
            width: 100%;
            padding: 11px;
            background: var(--brand);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity .15s;
        }

        .btn-submit:hover {
            opacity: .88;
        }

        /* Info banner: hasil disembunyikan */
        .info-banner {
            background: #fffbeb;
            border: 1px solid #fcd34d;
            border-radius: 10px;
            padding: 10px 16px;
            margin-bottom: 16px;
            font-size: 12.5px;
            color: #92400e;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="sb-logo">
            <div class="sb-li">📚</div>
            <div>
                <div class="sb-lt">WebStudy</div>
                <div class="sb-ls">CBT Platform</div>
            </div>
        </div>
        <nav class="sb-nav">
            <div class="sb-lbl">Menu</div>
            <a href="{{ route('siswa.dashboard') }}" class="sb-a"><i class="bi bi-grid-fill"></i> Dashboard</a>
            <a href="{{ route('siswa.latihan.index') }}" class="sb-a"><i class="bi bi-journal-richtext"></i>
                Materi</a>
            <a href="{{ route('siswa.latihan.index') }}" class="sb-a act"><i class="bi bi-patch-question-fill"></i>
                Latihan Soal</a>
            <a href="{{ route('siswa.riwayat') }}" class="sb-a"><i class="bi bi-bar-chart-fill"></i> Riwayat</a>
            <hr class="sb-hr">
            <a href="{{ route('siswa.profil.edit') }}" class="sb-a"><i class="bi bi-person-circle"></i> Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sb-a w-100 border-0 bg-transparent text-start" style="cursor:pointer;">
                    <i class="bi bi-box-arrow-left"></i> Keluar
                </button>
            </form>
        </nav>
        <div class="sb-foot">
            <div class="sb-usr">
                <div class="sb-av">
                    @if (auth()->user()->foto_profil)
                        <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="">
                    @else
                        {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="sb-un">{{ auth()->user()->nama }}</div>
                    <div class="sb-ur">Siswa</div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main">
        <div class="cbt-topbar">
            <div>
                <div class="cbt-title">{{ $kategori->nama }}</div>
                <div class="cbt-sub">{{ $materi->judul }}</div>
            </div>
            <button class="btn-akhiri" onclick="akhiriLatihan()">
                <i class="bi bi-stop-circle me-1"></i> Akhiri
            </button>
        </div>

        <div class="cbt-infobar">
            <div class="kat-badge">
                <div class="kat-icon"><i class="bi {{ $kategori->ikon }}" style="color:#fff;font-size:15px;"></i></div>
                <div>
                    <div style="font-size:13px;font-weight:600;color:#0f172a;">{{ $kategori->nama }} ·
                        {{ $materi->judul }}</div>
                    <div style="font-size:11px;color:#64748b;">{{ $soals->count() }} soal</div>
                </div>
            </div>
            <div class="timer-box">
                <div>
                    <div class="timer-val" id="timer">00:00</div>
                    <div class="timer-lbl">Waktu berjalan</div>
                </div>
            </div>
        </div>

        <div class="cbt-progress">
            <div class="cbt-progress-fill" id="progress-fill"
                style="width:{{ $soals->count() > 0 ? (count($sudahDijawab) / $soals->count()) * 100 : 0 }}%"></div>
        </div>

        <div class="cbt-body">
            <div class="soal-area" id="soal-area">

                {{-- Banner informasi —hasil disembunyikan hingga selesai --}}
                <div class="info-banner">
                    <i class="bi bi-eye-slash-fill"></i>
                    <span>Hasil jawaban <strong>disembunyikan</strong> selama pengerjaan. Hasil lengkap akan ditampilkan
                        setelah kamu menekan <strong>Submit Jawaban</strong>.</span>
                </div>

                @foreach ($soals as $i => $soal)
                    @php
                        $sudah = in_array($soal->Id_soal, $sudahDijawab);
                        $huruf = ['A', 'B', 'C', 'D', 'E'];
                        $bgColors = ['#1a56db', '#4f46e5', '#0f766e', '#b45309', '#be185d'];
                    @endphp
                    <div class="soal-card" id="soal-card-{{ $i }}"
                        style="{{ $i > 0 ? 'display:none;' : '' }}">
                        <div class="soal-header">
                            <div class="soal-num">{{ $i + 1 }}</div>
                            <div>
                                <div style="font-size:13px;font-weight:600;color:#0f172a;">Soal {{ $i + 1 }}
                                    dari {{ $soals->count() }}</div>
                                <div class="soal-meta">{{ $soal->poin }} poin</div>
                            </div>
                        </div>
                        <div class="soal-body">
                            <div class="soal-text">{{ $soal->pertanyaan }}</div>
                            <div id="pilihan-wrap-{{ $soal->Id_soal }}">
                                @foreach ($soal->pilihanJawabans as $pi => $pilihan)
                                    @php
                                        $isDipilih = isset($jawabanSiswa[$soal->Id_soal]) && $jawabanSiswa[$soal->Id_soal] === $pilihan->teks_pilihan;
                                    @endphp
                                    <button type="button" class="pilihan-btn pilihan-{{ $pi }} {{ $isDipilih ? 'dipilih' : '' }}"
                                        id="btn-{{ $soal->Id_soal }}-{{ $pilihan->Id_pilihan }}"
                                        data-soal="{{ $soal->Id_soal }}" data-pilihan="{{ $pilihan->Id_pilihan }}"
                                        data-idx="{{ $i }}"
                                        data-is-benar="{{ $pilihan->is_benar ? '1' : '0' }}" onclick="jawabSoal(this)"
                                        {{ $sudah ? 'disabled' : '' }}>
                                        <div class="pilihan-badge"
                                            style="background:{{ $bgColors[$pi] ?? '#64748b' }};color:#fff;">
                                            {{ $huruf[$pi] }}
                                        </div>
                                        {{ $pilihan->teks_pilihan }}
                                    </button>
                                @endforeach
                            </div>
                            {{-- Feedback netral: hanya tampil jika sudah dijawab --}}
                            @if ($sudah)
                                <div class="feedback feedback-saved show">
                                    <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                                    Sudah dijawab — hasil akan ditampilkan setelah selesai.
                                </div>
                            @else
                                <div class="feedback feedback-saved" id="feedback-{{ $soal->Id_soal }}"></div>
                            @endif
                        </div>
                        <div class="soal-footer">
                            <button class="btn-nav" onclick="prevSoal({{ $i }})"
                                {{ $i === 0 ? 'disabled' : '' }}>
                                <i class="bi bi-arrow-left"></i> Sebelumnya
                            </button>
                            @if ($i < $soals->count() - 1)
                                <button class="btn-nav primary" onclick="nextSoal({{ $i }})">
                                    Selanjutnya <i class="bi bi-arrow-right"></i>
                                </button>
                            @else
                                <button class="btn-nav primary" onclick="akhiriLatihan()">
                                    Selesai <i class="bi bi-check-lg"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="nav-soal">
                <div class="nav-soal-card">
                    <div class="nav-title">Navigasi Soal</div>
                    <div class="nav-grid">
                        @foreach ($soals as $i => $soal)
                            <button
                                class="nav-btn {{ in_array($soal->Id_soal, $sudahDijawab) ? 'dijawab' : ($i === 0 ? 'aktif' : 'default') }}"
                                id="nav-{{ $i }}"
                                onclick="gotoSoal({{ $i }})">{{ $i + 1 }}</button>
                        @endforeach
                    </div>
                    <div class="nav-legend">
                        <div class="leg">
                            <div class="leg-dot" style="background:#22c55e;"></div>Dijawab
                        </div>
                        <div class="leg">
                            <div class="leg-dot" style="background:var(--brand);"></div>Aktif
                        </div>
                    </div>
                    <button class="btn-submit" onclick="akhiriLatihan()">Submit Jawaban</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let detik = 0,
            soalAktif = 0;
        const totalSoal = {{ $soals->count() }};
        let dijawab = new Set({{ json_encode($sudahDijawab) }});
        let ditandai = new Set();

        setInterval(() => {
            detik++;
            document.getElementById('timer').textContent =
                String(Math.floor(detik / 60)).padStart(2, '0') + ':' + String(detik % 60).padStart(2, '0');
        }, 1000);

        function gotoSoal(idx) {
            document.getElementById('soal-card-' + soalAktif).style.display = 'none';
            const prevNav = document.getElementById('nav-' + soalAktif);
            if (!dijawab.has(soalAktif)) {
                prevNav.className = 'nav-btn ' + (ditandai.has(soalAktif) ? 'ditandai' : 'default');
            }
            soalAktif = idx;
            document.getElementById('soal-card-' + idx).style.display = '';
            document.getElementById('nav-' + idx).className = 'nav-btn aktif';
        }

        function nextSoal(idx) {
            if (idx < totalSoal - 1) gotoSoal(idx + 1);
        }

        function prevSoal(idx) {
            if (idx > 0) gotoSoal(idx - 1);
        }

        function tandaiSoal(idx, soalId) {
            const btn = document.getElementById('tandai-' + idx);
            const nav = document.getElementById('nav-' + idx);
            if (ditandai.has(idx)) {
                ditandai.delete(idx);
                btn.classList.remove('ditandai');
                btn.innerHTML = '<i class="bi bi-flag"></i> Tandai';
                if (!dijawab.has(soalId)) nav.className = 'nav-btn default';
            } else {
                ditandai.add(idx);
                btn.classList.add('ditandai');
                btn.innerHTML = '<i class="bi bi-flag-fill"></i> Ditandai';
                nav.className = 'nav-btn ditandai';
            }
        }

        function jawabSoal(btn) {
            const soalId = parseInt(btn.dataset.soal);
            const pilihanId = parseInt(btn.dataset.pilihan);
            const idx = parseInt(btn.dataset.idx);

            // Nonaktifkan semua pilihan soal ini segera
            document.querySelectorAll(`[data-soal="${soalId}"]`).forEach(b => b.disabled = true);

            // Tandai pilihan yang diklik sebagai "dipilih" (neutral, tanpa benar/salah)
            btn.classList.add('dipilih');

            fetch(`/siswa/latihan/soal/${soalId}/jawab`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        pilihan_id: pilihanId,
                        waktu: detik
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.saved) {
                        // Tampilkan feedback netral (tanpa reveal benar/salah)
                        const fb = document.getElementById('feedback-' + soalId);
                        if (fb) {
                            fb.className = 'feedback feedback-saved show';
                            fb.innerHTML =
                                '<i class="bi bi-check-circle-fill flex-shrink-0"></i>&nbsp; Dijawab — hasil akan ditampilkan setelah selesai.';
                        }
                        dijawab.add(soalId);
                        document.getElementById('nav-' + idx).className = 'nav-btn dijawab';
                        document.getElementById('progress-fill').style.width = (dijawab.size / totalSoal * 100) + '%';

                        // Auto-submit jika semua soal sudah dijawab
                        if (dijawab.size >= totalSoal) {
                            setTimeout(() => akhiriLatihan(), 800);
                        } else {
                            // Auto-lanjut ke soal berikutnya
                            setTimeout(() => nextSoal(idx), 400);
                        }
                    }
                })
                .catch(() => {
                    // Re-enable jika gagal
                    document.querySelectorAll(`[data-soal="${soalId}"]`).forEach(b => b.disabled = false);
                    btn.classList.remove('dipilih');
                });
        }

        function akhiriLatihan() {
            const belumDijawab = totalSoal - dijawab.size;
            let confirmMsg = 'Semua soal sudah dijawab. Submit sekarang?';
            if (belumDijawab > 0) {
                confirmMsg = `Masih ada ${belumDijawab} soal belum dijawab. Yakin ingin mengakhiri?`;
            }

            Swal.fire({
                title: 'Akhiri Latihan',
                text: confirmMsg,
                icon: belumDijawab > 0 ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonColor: '#1a56db',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Selesai',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal2-premium-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    submitLatihan();
                }
            });
        }

        function submitLatihan() {
            fetch('/siswa/latihan/{{ $materi->Id_materi }}/{{ $kategori->Id_kategori }}/selesai', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        durasi: detik
                    })
                })
                .then(r => r.json().then(d => ({
                    ok: r.ok,
                    data: d
                })))
                .then(({
                    ok,
                    data
                }) => {
                    if (ok && data.redirect) window.location.href = data.redirect;
                    else window.location.href = '{{ route('siswa.latihan.hasil', [$materi, $kategori]) }}';
                })
                .catch(() => {
                    window.location.href = '{{ route('siswa.latihan.hasil', [$materi, $kategori]) }}';
                });
        }
    </script>
</body>

</html>
