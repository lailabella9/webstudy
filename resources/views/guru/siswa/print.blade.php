<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Siswa — {{ $siswa->nama }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            color: #1e293b;
            background: #fff;
            padding: 32px 40px;
        }

        /* ── Header ── */
        .header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            border-bottom: 2px solid #1a56db;
            padding-bottom: 14px;
            margin-bottom: 20px;
        }
        .header-title { font-size: 18px; font-weight: 700; color: #0f172a; }
        .header-sub   { font-size: 11px; color: #64748b; margin-top: 3px; }
        .header-meta  { text-align: right; font-size: 11px; color: #64748b; line-height: 1.7; }

        /* ── Profil siswa ── */
        .profil {
            display: flex;
            gap: 20px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 20px;
        }
        .avatar {
            width: 54px; height: 54px; border-radius: 50%;
            background: #1a56db;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: 800; color: #fff;
            flex-shrink: 0; overflow: hidden;
        }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }
        .profil-info { flex: 1; }
        .profil-nama  { font-size: 15px; font-weight: 700; color: #0f172a; }
        .profil-email { font-size: 11px; color: #64748b; margin-top: 2px; }
        .badge-kelas {
            display: inline-block; margin-top: 6px;
            padding: 2px 10px; border-radius: 20px;
            background: #eff6ff; color: #1d4ed8;
            font-size: 11px; font-weight: 600;
        }

        /* ── Stat cards ── */
        .stats {
            display: flex; gap: 14px;
            margin-bottom: 20px;
        }
        .stat-card {
            flex: 1; border: 1px solid #e2e8f0; border-radius: 10px;
            padding: 12px 16px; text-align: center;
        }
        .stat-val  { font-size: 22px; font-weight: 800; }
        .stat-lbl  { font-size: 11px; color: #64748b; margin-top: 3px; }
        .c-blue    { color: #1a56db; }
        .c-green   { color: #16a34a; }
        .c-yellow  { color: #ca8a04; }
        .c-red     { color: #dc2626; }

        /* ── Tabel ── */
        .section-title {
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .06em; color: #0f172a;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 6px; margin-bottom: 10px;
        }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #f1f5f9; }
        th {
            text-align: left; padding: 8px 10px;
            font-size: 11px; font-weight: 700;
            color: #475569; border-bottom: 1px solid #e2e8f0;
        }
        td {
            padding: 8px 10px; border-bottom: 1px solid #f1f5f9;
            font-size: 12px; vertical-align: middle;
        }
        tr:last-child td { border-bottom: none; }

        .badge {
            display: inline-block; padding: 2px 8px;
            border-radius: 20px; font-size: 11px; font-weight: 700;
        }
        .badge-green  { background: #f0fdf4; color: #16a34a; }
        .badge-yellow { background: #fffbeb; color: #ca8a04; }
        .badge-red    { background: #fef2f2; color: #dc2626; }

        /* progress bar */
        .bar-wrap { height: 5px; background: #f1f5f9; border-radius: 99px; overflow: hidden; width: 80px; }
        .bar-fill  { height: 100%; border-radius: 99px; }

        /* ── Footer ── */
        .footer {
            margin-top: 28px; border-top: 1px solid #e2e8f0;
            padding-top: 10px; font-size: 10px; color: #94a3b8;
            display: flex; justify-content: space-between;
        }

        /* ── Print-only ── */
        .no-print { display: block; }
        @media print {
            body { padding: 20px 28px; }
            .no-print { display: none !important; }
            @page { margin: 1cm; size: A4 portrait; }
        }
    </style>
</head>
<body>

    {{-- Tombol aksi (hilang saat print/PDF) --}}
    <div class="no-print" style="margin-bottom:20px;display:flex;gap:10px;">
        <button onclick="window.print()"
            style="padding:8px 18px;background:#1a56db;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px;">
            🖨️ Print
        </button>
        <a href="{{ route('guru.siswa.show', $siswa) }}"
            style="padding:8px 18px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;color:#374151;text-decoration:none;display:flex;align-items:center;gap:6px;">
            ← Kembali
        </a>
    </div>

    {{-- Header dokumen --}}
    <div class="header">
        <div>
            <div class="header-title">Laporan Riwayat Latihan Siswa</div>
            <div class="header-sub">Data diambil dari sistem pembelajaran</div>
        </div>
        <div class="header-meta">
            <div>Dicetak: {{ now()->format('d M Y, H:i') }}</div>
            <div>Kelas: {{ $siswa->kelas->nama ?? '-' }}</div>
        </div>
    </div>

    {{-- Profil --}}
    <div class="profil">
        @php
            $avatarColors = ['#1a56db','#7c3aed','#0f766e','#b45309','#be185d'];
            $avatarBg     = $avatarColors[crc32($siswa->nama) % count($avatarColors)];
        @endphp
        <div class="avatar" style="background:{{ $avatarBg }};">
            @if($siswa->foto_profil)
                <img src="{{ public_path('storage/' . $siswa->foto_profil) }}">
            @else
                {{ strtoupper(substr($siswa->nama, 0, 1)) }}
            @endif
        </div>
        <div class="profil-info">
            <div class="profil-nama">{{ $siswa->nama }}</div>
            <div class="profil-email">{{ $siswa->email }}</div>
            <span class="badge-kelas">{{ $siswa->kelas->nama ?? 'Belum ada kelas' }}</span>
            <span style="font-size:11px;color:#94a3b8;margin-left:8px;">
                Bergabung {{ $siswa->created_at->format('d M Y') }}
            </span>
        </div>
    </div>

    {{-- Stat cards --}}
    @php
        $rataColor = $rata >= 60 ? 'c-green' : ($rata >= 40 ? 'c-yellow' : 'c-red');
    @endphp
    <div class="stats">
        <div class="stat-card">
            <div class="stat-val c-blue">{{ $sesiList->count() }}</div>
            <div class="stat-lbl">Total Sesi Latihan</div>
        </div>
        <div class="stat-card">
            <div class="stat-val {{ $rataColor }}">{{ number_format($rata, 1) }}%</div>
            <div class="stat-lbl">Rata-rata Nilai</div>
        </div>
        <div class="stat-card">
            <div class="stat-val" style="color:#0f172a;">{{ $siswa->kelas->nama ?? '-' }}</div>
            <div class="stat-lbl">Kelas</div>
        </div>
    </div>

    {{-- Tabel sesi --}}
    <div class="section-title">Riwayat Sesi Latihan</div>

    @if($sesiList->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width:30px;">#</th>
                <th>Materi</th>
                <th>Kategori</th>
                <th>Terakhir Dikerjakan</th>
                <th style="width:70px;">Poin</th>
                <th style="width:90px;">Progress</th>
                <th style="width:55px;">Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sesiList as $i => $sesi)
            @php
                $pct   = $sesi->persentase;
                $bCls  = $pct >= 60 ? 'badge-green' : ($pct >= 40 ? 'badge-yellow' : 'badge-red');
                $bColor= $pct >= 60 ? '#16a34a'     : ($pct >= 40 ? '#ca8a04'      : '#dc2626');
            @endphp
            <tr>
                <td style="color:#94a3b8;">{{ $i + 1 }}</td>
                <td style="font-weight:600;">{{ $sesi->materi->judul ?? '-' }}</td>
                <td style="color:#64748b;">{{ $sesi->kategori->nama ?? '-' }}</td>
                <td style="color:#64748b;">
                    {{ $sesi->selesai_at ? $sesi->selesai_at->format('d M Y, H:i') : '-' }}
                </td>
                <td style="font-weight:600;">{{ $sesi->poin_diraih }}/{{ $sesi->total_poin }}</td>
                <td>
                    <div class="bar-wrap">
                        <div class="bar-fill" style="width:{{ $pct }}%;background:{{ $bColor }};"></div>
                    </div>
                </td>
                <td>
                    <span class="badge {{ $bCls }}">{{ $pct }}%</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div style="text-align:center;padding:32px;color:#94a3b8;font-size:13px;">
            Belum ada sesi latihan yang tercatat.
        </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        <span>Sistem Pembelajaran — Laporan otomatis</span>
        <span>{{ now()->format('d/m/Y H:i') }}</span>
    </div>

</body>
</html>