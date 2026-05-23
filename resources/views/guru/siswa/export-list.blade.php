<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Siswa</title>

    <style>
        *{
            box-sizing:border-box;
        }

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
            color:#1f2937;
            margin:0;
            padding:24px;
        }

        .header{
            width:100%;
            margin-bottom:20px;
            border-bottom:2px solid #1e40af;
            padding-bottom:12px;
        }

        .header-table{
            width:100%;
        }

        .title{
            font-size:22px;
            font-weight:bold;
            color:#1e3a8a;
            margin-bottom:4px;
        }

        .subtitle{
            font-size:12px;
            color:#6b7280;
        }

        .info{
            margin-top:14px;
            width:100%;
        }

        .info td{
            padding:4px 0;
            font-size:12px;
        }

        .stats{
            margin-top:18px;
            margin-bottom:20px;
        }

        .stats-table{
            width:100%;
            border-collapse:separate;
            border-spacing:10px 0;
        }

        .stat-box{
            border:1px solid #dbeafe;
            background:#eff6ff;
            border-radius:8px;
            padding:12px;
            text-align:center;
        }

        .stat-label{
            font-size:11px;
            color:#6b7280;
            margin-bottom:6px;
        }

        .stat-value{
            font-size:20px;
            font-weight:bold;
            color:#1d4ed8;
        }

        table.data{
            width:100%;
            border-collapse:collapse;
            margin-top:10px;
        }

        table.data thead th{
            background:#1e3a8a;
            color:#fff;
            padding:10px 8px;
            font-size:11px;
            text-align:left;
        }

        table.data tbody td{
            border-bottom:1px solid #e5e7eb;
            padding:9px 8px;
            font-size:11px;
        }

        table.data tbody tr:nth-child(even){
            background:#f9fafb;
        }

        .badge{
            display:inline-block;
            padding:4px 8px;
            border-radius:12px;
            font-size:10px;
            font-weight:bold;
        }

        .badge-success{
            background:#dcfce7;
            color:#166534;
        }

        .badge-warning{
            background:#fef3c7;
            color:#92400e;
        }

        .footer{
            margin-top:30px;
            font-size:10px;
            color:#6b7280;
            text-align:right;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    <div class="title">
                        LAPORAN DATA SISWA
                    </div>

                    <div class="subtitle">
                        Sistem Latihan Pembelajaran
                    </div>
                </td>

                <td align="right">
                    <div style="font-size:11px;color:#6b7280;">
                        Dicetak:
                    </div>

                    <div style="font-size:12px;font-weight:bold;">
                        {{ now()->format('d M Y H:i') }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- INFO --}}
    <table class="info">
        <tr>
            <td width="120"><strong>Guru</strong></td>
            <td>: {{ $guru->nama }}</td>
        </tr>

        <tr>
            <td><strong>Total Data</strong></td>
            <td>: {{ $totalSiswa }} siswa</td>
        </tr>
    </table>

    {{-- STATISTIK --}}
    <div class="stats">
        <table class="stats-table">
            <tr>
                <td width="33.3%">
                    <div class="stat-box">
                        <div class="stat-label">
                            TOTAL SISWA
                        </div>

                        <div class="stat-value">
                            {{ $totalSiswa }}
                        </div>
                    </div>
                </td>

                <td width="33.3%">
                    <div class="stat-box">
                        <div class="stat-label">
                            SISWA AKTIF
                        </div>

                        <div class="stat-value">
                            {{ $siswaAktif }}
                        </div>
                    </div>
                </td>

                <td width="33.3%">
                    <div class="stat-box">
                        <div class="stat-label">
                            RATA-RATA NILAI
                        </div>

                        <div class="stat-value">
                            {{ number_format($rataRata,1) }}%
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- TABEL --}}
    <table class="data">
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th width="120">Kelas</th>
                <th width="90">Nilai</th>
                <th width="120">Status</th>
                <th width="100">Bergabung</th>
            </tr>
        </thead>

        <tbody>
            @forelse($siswaList as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>

                    <td>
                        <strong>{{ $s->nama }}</strong>
                    </td>

                    <td>{{ $s->email }}</td>

                    <td>
                        {{ $s->kelas?->nama ?? '-' }}
                    </td>

                    <td>
                        {{ number_format($s->nilai_rata,1) }}%
                    </td>

                    <td>
                        @if($s->jumlah_jawaban > 0)
                            <span class="badge badge-success">
                                Aktif
                            </span>
                        @else
                            <span class="badge badge-warning">
                                Belum Latihan
                            </span>
                        @endif
                    </td>

                    <td>
                        {{ $s->created_at->format('d/m/Y') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" align="center" style="padding:20px;">
                        Tidak ada data siswa
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        Laporan dibuat otomatis oleh sistem • {{ now()->format('Y') }}
    </div>

</body>
</html>