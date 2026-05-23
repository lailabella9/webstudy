@extends('layouts.siswa')
@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard')
@section('page-subtitle')Selamat datang, <strong>{{ $siswa->nama }}</strong>! — Kelas
    {{ $siswa->kelas?->nama ?? '—' }}@endsection

@section('topbar-actions')
    <a href="{{ route('siswa.latihan.index') }}" class="btn-primary-sm">
        <i class="bi bi-play-circle"></i> Mulai Latihan
    </a>
    <a href="{{ route('siswa.profil.edit') }}" class="btn-icon-sm"><i class="bi bi-person"></i></a>
@endsection

@section('content')

    {{-- ── STAT CARDS ── --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
        @php
            $cards = [
                [
                    'icon' => 'bi-collection-fill',
                    'bg' => '#eff6ff',
                    'ic' => '#1a56db',
                    'val' => $totalMapel,
                    'lbl' => 'Mata Pelajaran',
                    'sub' => 'Kelas ' . ($siswa->kelas?->nama ?? '—'),
                    'route' => route('siswa.latihan.index'),
                    'rtxt' => 'Lihat semua',
                ],
                [
                    'icon' => 'bi-patch-question-fill',
                    'bg' => '#eef2ff',
                    'ic' => '#4f46e5',
                    'val' => $totalSoalDijawab,
                    'lbl' => 'Soal Dijawab',
                    'sub' => 'Dari mapel kelasmu',
                    'route' => route('siswa.latihan.index'),
                    'rtxt' => 'Kerjakan lagi',
                ],
                [
                    'icon' => 'bi-trophy-fill',
                    'bg' => '#fffbeb',
                    'ic' => '#b45309',
                    'val' => number_format($nilaiRata, 1) . '%',
                    'lbl' => 'Rata-rata Nilai',
                    'sub' => 'KKM ' . $kkm . '%',
                    'route' => route('siswa.riwayat'),
                    'rtxt' => 'Lihat riwayat',
                ],
                [
                    'icon' => 'bi-check2-circle',
                    'bg' => '#f0fdf4',
                    'ic' => '#15803d',
                    'val' => $totalSesi,
                    'lbl' => 'Materi Dikerjakan',
                    'sub' => 'Sesi latihan',
                    'route' => route('siswa.riwayat'),
                    'rtxt' => 'Detail',
                ],
            ];
        @endphp
        @foreach ($cards as $card)
            <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:18px 20px;">
                <div style="margin-bottom:10px;">
                    <div
                        style="width:40px;height:40px;border-radius:10px;background:{{ $card['bg'] }};display:flex;align-items:center;justify-content:center;">
                        <i class="bi {{ $card['icon'] }}" style="font-size:18px;color:{{ $card['ic'] }};"></i>
                    </div>
                </div>
                <div style="font-size:26px;font-weight:800;color:#0f172a;line-height:1;">{{ $card['val'] }}</div>
                <div style="font-size:12px;color:#64748b;margin-top:3px;">{{ $card['lbl'] }}</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:1px;">{{ $card['sub'] }}</div>
                <a href="{{ $card['route'] }}"
                    style="font-size:11.5px;color:{{ $card['ic'] }};text-decoration:none;font-weight:600;margin-top:8px;display:inline-block;">
                    {{ $card['rtxt'] }} →
                </a>
            </div>
        @endforeach
    </div>

    {{-- ── PROGRES + AKTIVITAS ── --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px;">

        {{-- Progres Belajar --}}
        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;overflow:hidden;">
            <div
                style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                <span
                    style="font-size:12px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:.07em;">Progres
                    Belajar</span>
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:11px;color:#94a3b8;background:#f1f5f9;padding:3px 9px;border-radius:20px;">
                        KKM <strong style="color:#1a56db;">{{ $kkm }}%</strong>
                    </span>
                    <a href="{{ route('siswa.riwayat') }}"
                        style="font-size:12px;color:#1a56db;text-decoration:none;font-weight:600;">Semua →</a>
                </div>
            </div>

            <div style="padding:14px 20px;max-height:420px;overflow-y:auto;">
                @forelse ($progresMapel as $mapel)
                    @php
                        $colors = ['#1a56db', '#4f46e5', '#0f766e', '#b45309', '#be185d', '#0369a1'];
                        $mc = $colors[crc32($mapel['nama']) % 6];
                    @endphp

                    {{-- Header Mapel --}}
                    <div style="display:flex;align-items:center;gap:8px;margin:{{ $loop->first ? '0' : '14px' }} 0 8px;">
                        <div style="width:6px;height:6px;border-radius:50%;background:{{ $mc }};flex-shrink:0;">
                        </div>
                        <span style="font-size:12px;font-weight:700;color:#0f172a;">{{ $mapel['nama'] }}</span>
                        @if ($mapel['avg'] > 0)
                            <span
                                style="font-size:11px;font-weight:700;margin-left:auto;padding:2px 8px;border-radius:20px;
                                background:{{ $mapel['avg'] >= $kkm ? '#f0fdf4' : '#fffbeb' }};
                                color:{{ $mapel['avg'] >= $kkm ? '#16a34a' : '#ca8a04' }};">
                                rata {{ $mapel['avg'] }}%
                            </span>
                        @endif
                    </div>

                    @foreach ($mapel['materis'] as $p)
                        @php
                            $barColor = $p['nilai'] >= $kkm ? '#22c55e' : ($p['nilai'] >= 50 ? '#f59e0b' : '#94a3b8');
                        @endphp
                        <div style="margin-bottom:9px;padding-left:14px;border-left:2px solid {{ $mc }}30;">
                            <div
                                style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;gap:8px;">
                                <span
                                    style="font-size:12.5px;color:#374151;flex:1;min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $p['judul'] }}
                                </span>
                                <div style="display:flex;align-items:center;gap:5px;flex-shrink:0;">
                                    @if ($p['selesai'])
                                        @if ($p['lulus'])
                                            <span
                                                style="font-size:10px;background:#f0fdf4;color:#16a34a;padding:1px 7px;border-radius:20px;font-weight:700;">✓
                                                Lulus</span>
                                        @else
                                            <span
                                                style="font-size:10px;background:#fef2f2;color:#dc2626;padding:1px 7px;border-radius:20px;font-weight:700;">✗
                                                Ulangi</span>
                                        @endif
                                    @elseif ($p['dijawab'] > 0)
                                        <span
                                            style="font-size:10px;background:#eff6ff;color:#1a56db;padding:1px 7px;border-radius:20px;font-weight:700;">
                                            {{ $p['dijawab'] }}/{{ $p['total'] }}
                                        </span>
                                    @endif
                                    <span
                                        style="font-size:11px;font-weight:700;color:{{ $barColor }};min-width:30px;text-align:right;">
                                        {{ $p['nilai'] > 0 ? $p['nilai'] . '%' : ($p['pct'] > 0 ? $p['pct'] . '%' : '—') }}
                                    </span>
                                </div>
                            </div>
                            {{-- Bar + KKM line --}}
                            <div
                                style="position:relative;height:6px;background:#f1f5f9;border-radius:99px;overflow:visible;">
                                <div
                                    style="height:100%;width:{{ $p['pct'] }}%;background:{{ $barColor }};border-radius:99px;">
                                </div>
                                <div style="position:absolute;top:-2px;bottom:-2px;left:{{ $kkm }}%;width:2px;background:#ef4444;border-radius:1px;opacity:.5;"
                                    title="KKM"></div>
                            </div>
                        </div>
                    @endforeach
                @empty
                    <div style="text-align:center;padding:32px;color:#94a3b8;font-size:13px;">
                        <i class="bi bi-journal-x" style="font-size:28px;display:block;margin-bottom:8px;"></i>
                        Belum ada progres belajar
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;overflow:hidden;">
            <div
                style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                <span
                    style="font-size:12px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:.07em;">Aktivitas
                    Terbaru</span>
                <span style="font-size:11px;color:#94a3b8;">Kelas {{ $siswa->kelas?->nama ?? '—' }}</span>
            </div>
            <div style="padding:8px 0;">
                @forelse($aktivitas as $a)
                    @php
                        $color = $a->is_benar ? '#16a34a' : '#dc2626';
                        $bg = $a->is_benar ? '#f0fdf4' : '#fef2f2';
                        $ic = $a->is_benar ? 'bi-check-circle-fill' : 'bi-x-circle-fill';
                    @endphp
                    <div
                        style="display:flex;align-items:flex-start;gap:12px;padding:10px 20px;border-bottom:1px solid #f8fafc;">
                        <div
                            style="width:30px;height:30px;border-radius:8px;background:{{ $bg }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="bi {{ $ic }}" style="font-size:14px;color:{{ $color }};"></i>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div
                                style="font-size:12.5px;font-weight:600;color:#0f172a;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ \Illuminate\Support\Str::limit($a->soal->pertanyaan ?? '-', 52) }}
                            </div>
                            <div style="font-size:11px;color:#94a3b8;margin-top:2px;display:flex;gap:8px;">
                                <span>{{ $a->soal->materi->judul ?? '-' }}</span>
                                <span>·</span>
                                <span>{{ $a->created_at?->diffForHumans() ?? '-' }}</span>
                            </div>
                        </div>
                        <span style="font-size:11px;font-weight:700;color:{{ $color }};flex-shrink:0;">
                            {{ $a->is_benar ? '+' . $a->nilai : '0' }}
                        </span>
                    </div>
                @empty
                    <div style="text-align:center;padding:32px;color:#94a3b8;font-size:13px;">
                        <i class="bi bi-clock-history" style="font-size:28px;display:block;margin-bottom:8px;"></i>
                        Belum ada aktivitas
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ── LANJUTKAN BELAJAR ── --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;overflow:hidden;">
        <div
            style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
            <span
                style="font-size:12px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:.07em;">Lanjutkan
                Belajar</span>
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="font-size:12px;color:#64748b;">
                    <i class="bi bi-building" style="margin-right:3px;"></i>{{ $siswa->kelas?->nama ?? '—' }}
                </span>
                <a href="{{ route('siswa.latihan.index') }}"
                    style="font-size:12px;color:#1a56db;text-decoration:none;font-weight:600;">Lihat semua →</a>
            </div>
        </div>

        @if ($lanjutkan->isEmpty())
            <div style="padding:40px;text-align:center;color:#94a3b8;font-size:13px;">
                <i class="bi bi-collection" style="font-size:28px;display:block;margin-bottom:8px;"></i>
                Belum ada mata pelajaran untuk kelas {{ $siswa->kelas?->nama ?? 'ini' }}
            </div>
        @else
            <div style="padding:16px 20px;display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
                @foreach ($lanjutkan as $mapel)
                    @php
                        $colors = ['#1a56db', '#4f46e5', '#0f766e', '#b45309', '#be185d', '#0369a1'];
                        $idx = crc32($mapel->nama) % 6;
                        $c1 = $colors[$idx];
                        $c2 = $colors[($idx + 2) % 6];
                    @endphp
                    <div style="border:1px solid #e9edf2;border-radius:12px;overflow:hidden;transition:box-shadow .15s;"
                        onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.08)'"
                        onmouseout="this.style.boxShadow=''">
                        <div
                            style="height:80px;background:linear-gradient(135deg,{{ $c1 }},{{ $c2 }});display:flex;align-items:center;padding:0 16px;gap:10px;">
                            <div
                                style="font-size:22px;font-weight:900;color:rgba(255,255,255,.2);font-style:italic;flex-shrink:0;">
                                {{ strtoupper(substr($mapel->nama, 0, 2)) }}
                            </div>
                            <div style="font-size:13px;font-weight:800;color:#fff;line-height:1.25;">
                                {{ \Illuminate\Support\Str::limit($mapel->nama, 20) }}
                            </div>
                        </div>
                        <div style="padding:12px 14px;">
                            <div style="font-size:11.5px;color:#64748b;margin-bottom:10px;">
                                <i class="bi bi-journal-richtext" style="margin-right:3px;"></i>{{ $mapel->materis_count }}
                                bab tersedia
                            </div>
                            <a href="{{ route('siswa.latihan.mapel', $mapel) }}"
                                style="display:block;text-align:center;background:{{ $c1 }};color:#fff;border-radius:8px;padding:7px;font-size:12px;font-weight:600;text-decoration:none;"
                                onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                                <i class="bi bi-play-circle" style="margin-right:4px;"></i>Buka Materi
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection
