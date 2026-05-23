@extends('layouts.guru')

@section('title', 'Dashboard Guru')
@section('page-title', 'Dashboard')
@section('page-subtitle')
    Selamat datang, {{ auth()->user()->nama }} — pantau semua aktivitas di sini
@endsection

@section('topbar-actions')
    <a href="{{ route('guru.profil.edit') }}" class="btn-icon-sm">
        <i class="bi bi-person"></i>
    </a>
@endsection

@section('content')

    {{-- ── STAT CARDS ── --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:20px;">

        <div style="background:#fff; border-radius:14px; border:1px solid #e9edf2; padding:18px 20px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                <div
                    style="width:40px;height:40px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;font-size:18px;">
                    <i class="bi bi-journal-richtext" style="color:#1a56db;"></i>
                </div>
                <span
                    style="font-size:11px;background:#eff6ff;color:#1a56db;padding:3px 9px;border-radius:20px;font-weight:600;">Materi</span>
            </div>
            <div style="font-size:30px;font-weight:800;color:#0f172a;line-height:1;">{{ $totalMateri }}</div>
            <div style="font-size:12px;color:#64748b;margin-top:4px;">Total Materi</div>
            {{-- Materi sekarang dikelola lewat halaman Mata Pelajaran --}}
            <a href="{{ route('guru.mapel.index') }}"
                style="font-size:11.5px;color:#1a56db;text-decoration:none;font-weight:600;margin-top:8px;display:inline-block;">
                Kelola →
            </a>
        </div>

        <div style="background:#fff; border-radius:14px; border:1px solid #e9edf2; padding:18px 20px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                <div
                    style="width:40px;height:40px;border-radius:10px;background:#eef2ff;display:flex;align-items:center;justify-content:center;font-size:18px;">
                    <i class="bi bi-patch-question-fill" style="color:#4f46e5;"></i>
                </div>
                <span
                    style="font-size:11px;background:#eef2ff;color:#4f46e5;padding:3px 9px;border-radius:20px;font-weight:600;">Soal</span>
            </div>
            <div style="font-size:30px;font-weight:800;color:#0f172a;line-height:1;">{{ $totalSoal }}</div>
            <div style="font-size:12px;color:#64748b;margin-top:4px;">Total Soal</div>
            {{-- Soal dikelola lewat Mata Pelajaran → Kelola Bab --}}
            <a href="{{ route('guru.mapel.index') }}"
                style="font-size:11.5px;color:#4f46e5;text-decoration:none;font-weight:600;margin-top:8px;display:inline-block;">
                Lihat →
            </a>
        </div>

        <div style="background:#fff; border-radius:14px; border:1px solid #e9edf2; padding:18px 20px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                <div
                    style="width:40px;height:40px;border-radius:10px;background:#f0fdfa;display:flex;align-items:center;justify-content:center;font-size:18px;">
                    <i class="bi bi-people-fill" style="color:#0f766e;"></i>
                </div>
                <span
                    style="font-size:11px;background:#f0fdfa;color:#0f766e;padding:3px 9px;border-radius:20px;font-weight:600;">Siswa</span>
            </div>
            <div style="font-size:30px;font-weight:800;color:#0f172a;line-height:1;">{{ $totalSiswa }}</div>
            <div style="font-size:12px;color:#64748b;margin-top:4px;">Total Siswa</div>
            <a href="{{ route('guru.siswa.index') }}"
                style="font-size:11.5px;color:#0f766e;text-decoration:none;font-weight:600;margin-top:8px;display:inline-block;">
                Kelola →
            </a>
        </div>

        <div style="background:#fff; border-radius:14px; border:1px solid #e9edf2; padding:18px 20px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                <div
                    style="width:40px;height:40px;border-radius:10px;background:#fffbeb;display:flex;align-items:center;justify-content:center;font-size:18px;">
                    <i class="bi bi-check2-all" style="color:#b45309;"></i>
                </div>
                <span
                    style="font-size:11px;background:#fffbeb;color:#b45309;padding:3px 9px;border-radius:20px;font-weight:600;">Jawaban</span>
            </div>
            <div style="font-size:30px;font-weight:800;color:#0f172a;line-height:1;">{{ $totalJawaban }}</div>
            <div style="font-size:12px;color:#64748b;margin-top:4px;">Total Jawaban Masuk</div>
            <a href="{{ route('guru.evaluasi') }}"
                style="font-size:11.5px;color:#b45309;text-decoration:none;font-weight:600;margin-top:8px;display:inline-block;">
                Evaluasi →
            </a>
        </div>

    </div>

    {{-- ── CHART ROW ── --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:20px;">

        {{-- Bar Chart: Rata-rata nilai per materi --}}
        <div style="background:#fff; border-radius:14px; border:1px solid #e9edf2; padding:20px;">
            <div
                style="font-size:12px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:.07em;margin-bottom:16px;">
                Grafik Nilai Per Materi
            </div>
            @if ($grafikData->count())
                <div style="position:relative; height:200px;">
                    <canvas id="barChart"></canvas>
                </div>
            @else
                <div
                    style="height:200px;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:13px;">
                    <div style="text-align:center;">
                        <i class="bi bi-bar-chart" style="font-size:32px;display:block;margin-bottom:8px;"></i>
                        Belum ada data nilai
                    </div>
                </div>
            @endif
        </div>

        {{-- Donut Chart: Distribusi nilai --}}
        <div style="background:#fff; border-radius:14px; border:1px solid #e9edf2; padding:20px;">
            <div
                style="font-size:12px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:.07em;margin-bottom:16px;">
                Distribusi Nilai Siswa
            </div>
            @php $totalDistribusi = array_sum($distribusi); @endphp
            @if ($totalDistribusi > 0)
                <div style="display:flex; align-items:center; gap:24px; height:200px;">
                    <div style="position:relative; width:150px; height:150px; flex-shrink:0;">
                        <canvas id="donutChart"></canvas>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:10px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="width:10px;height:10px;border-radius:50%;background:#22c55e;flex-shrink:0;"></span>
                            <span style="font-size:13px;color:#374151;">Lulus (≥60%)</span>
                            <span
                                style="font-size:13px;font-weight:700;color:#0f172a;margin-left:auto;">{{ $distribusi['lulus'] }}</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="width:10px;height:10px;border-radius:50%;background:#f59e0b;flex-shrink:0;"></span>
                            <span style="font-size:13px;color:#374151;">Hampir (40–59%)</span>
                            <span
                                style="font-size:13px;font-weight:700;color:#0f172a;margin-left:auto;">{{ $distribusi['hampir'] }}</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="width:10px;height:10px;border-radius:50%;background:#ef4444;flex-shrink:0;"></span>
                            <span style="font-size:13px;color:#374151;">Perlu Perhatian (&lt;40%)</span>
                            <span
                                style="font-size:13px;font-weight:700;color:#0f172a;margin-left:auto;">{{ $distribusi['perlu'] }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div
                    style="height:200px;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:13px;">
                    <div style="text-align:center;">
                        <i class="bi bi-pie-chart" style="font-size:32px;display:block;margin-bottom:8px;"></i>
                        Belum ada data distribusi
                    </div>
                </div>
            @endif
        </div>

    </div>

    {{-- ── PROGRES BELAJAR SISWA ── --}}
    <div style="background:#fff; border-radius:14px; border:1px solid #e9edf2; overflow:hidden;">

        <div
            style="padding:16px 22px; display:flex; align-items:center; justify-content:space-between; border-bottom:1px solid #f1f5f9;">
            <span style="font-size:12px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:.07em;">
                Progres Belajar Siswa
            </span>
            <a href="{{ route('guru.progres') }}"
                style="font-size:12px;color:#1a56db;text-decoration:none;font-weight:600;">
                Lihat semua →
            </a>
        </div>

        @if ($progres->count())
            @foreach ($progres as $s)
                @php
                    $pct = $s['pct'];
                    $color = $pct >= 60 ? '#22c55e' : ($pct >= 40 ? '#f59e0b' : '#ef4444');
                    $bg = $pct >= 60 ? '#f0fdf4' : ($pct >= 40 ? '#fffbeb' : '#fef2f2');
                    $initials = strtoupper(substr($s['nama'], 0, 1));
                    $avatarColors = ['#1a56db', '#7c3aed', '#0f766e', '#b45309', '#be185d'];
                    $avatarBg = $avatarColors[crc32($s['nama']) % count($avatarColors)];
                @endphp
                <div style="display:flex; align-items:center; gap:14px; padding:13px 22px;
                            border-bottom:1px solid #f8fafc; transition:background .15s;"
                    onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">

                    <div
                        style="width:36px;height:36px;border-radius:50%;background:{{ $avatarBg }};
                                display:flex;align-items:center;justify-content:center;
                                font-size:13px;font-weight:700;color:#fff;flex-shrink:0;overflow:hidden;">
                        @if ($s['foto'])
                            <img src="{{ asset('storage/' . $s['foto']) }}"
                                style="width:100%;height:100%;object-fit:cover;" alt="">
                        @else
                            {{ $initials }}
                        @endif
                    </div>

                    <div style="min-width:140px; max-width:160px;">
                        <div
                            style="font-size:13px;font-weight:600;color:#0f172a;
                                    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $s['nama'] }}
                        </div>
                        <div style="font-size:11px;color:#94a3b8;margin-top:1px;">
                            {{ $s['dijawab'] }}/{{ $s['total'] }} soal dijawab
                        </div>
                    </div>

                    <div style="flex:1;">
                        <div style="height:7px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                            <div
                                style="height:100%;width:{{ $pct }}%;background:{{ $color }};
                                        border-radius:99px;transition:width .4s;">
                            </div>
                        </div>
                    </div>

                    <div style="min-width:52px; text-align:right;">
                        <span
                            style="display:inline-block;padding:3px 10px;border-radius:20px;
                                     background:{{ $bg }};color:{{ $color }};font-size:12px;font-weight:700;">
                            {{ $pct }}%
                        </span>
                    </div>

                </div>
            @endforeach
        @else
            <div style="text-align:center; padding:48px 24px; color:#94a3b8;">
                <i class="bi bi-people" style="font-size:36px; display:block; margin-bottom:10px;"></i>
                <p style="font-size:14px;">Belum ada siswa yang mengerjakan latihan</p>
            </div>
        @endif

    </div>

@endsection

@push('scripts')
    <script type="module">
        @if ($grafikData->count())
            const barCtx = document.getElementById('barChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($grafikData->pluck('judul')) !!},
                    datasets: [{
                        label: 'Rata-rata Nilai (%)',
                        data: {!! json_encode($grafikData->pluck('rata')) !!},
                        backgroundColor: [
                            'rgba(26,86,219,.75)', 'rgba(79,70,229,.75)',
                            'rgba(15,118,110,.75)', 'rgba(180,83,9,.75)',
                            'rgba(190,24,93,.75)', 'rgba(5,150,105,.75)',
                        ],
                        borderRadius: 7,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` ${ctx.parsed.y}%`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: {
                                color: '#f1f5f9'
                            },
                            ticks: {
                                callback: v => v + '%',
                                font: {
                                    size: 11
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        @endif

        @if (array_sum($distribusi) > 0)
            const donutCtx = document.getElementById('donutChart').getContext('2d');
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Lulus', 'Hampir', 'Perlu Perhatian'],
                    datasets: [{
                        data: [{{ $distribusi['lulus'] }}, {{ $distribusi['hampir'] }},
                            {{ $distribusi['perlu'] }}
                        ],
                        backgroundColor: ['#22c55e', '#f59e0b', '#ef4444'],
                        borderWidth: 3,
                        borderColor: '#fff',
                        hoverOffset: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` ${ctx.label}: ${ctx.parsed} siswa`
                            }
                        }
                    }
                }
            });
        @endif
    </script>
@endpush
