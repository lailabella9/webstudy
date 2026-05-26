@extends('layouts.guru')
@section('title', 'Statistik & Laporan Kelas')
@section('page-title', 'Statistik & Laporan')
@section('page-subtitle', 'Analisis tingkatan siswa dan evaluasi kesulitan materi')

@section('content')

    {{-- Filter Bar Kelas --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:14px 20px;margin-bottom:20px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
        <form method="GET" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;flex:1;">
            <label style="font-size:13px;font-weight:600;color:#475569;" for="kelas_id">Pilih Kelas / Jurusan:</label>
            <select name="kelas_id" id="kelas_id" onchange="this.form.submit()"
                style="height:36px;padding:0 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;color:#374151;outline:none;font-family:inherit;background:#fff;min-width:180px;cursor:pointer;">
                @if($kelasList->isEmpty())
                    <option value="">Tidak ada kelas</option>
                @else
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->Id_kelas }}" {{ $activeKelasId == $k->Id_kelas ? 'selected' : '' }}>
                            Kelas {{ $k->nama }}
                        </option>
                    @endforeach
                @endif
            </select>
        </form>
    </div>

    @if (empty($hierarchy))
        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:64px;text-align:center;color:#94a3b8;">
            <i class="bi bi-bar-chart" style="font-size:40px;display:block;margin-bottom:12px;"></i>
            <div style="font-size:14px;">Belum ada data mata pelajaran atau hasil latihan di kelas ini.</div>
        </div>
    @else
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:24px;">
            <div style="width:36px;height:36px;border-radius:8px;background:#0f172a;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-mortarboard-fill" style="color:#fff;font-size:16px;"></i>
            </div>
            <h2 style="font-size:18px;font-weight:800;color:#0f172a;">Data Kelas {{ $activeKelas->nama ?? '' }}</h2>
        </div>

        @foreach ($hierarchy as $data)
            @php 
                $mapel = $data['mapel'];
                $leaderboard = $data['leaderboard'];
                $babAnalytics = $data['babAnalytics'];
            @endphp

            <div style="background:#fff;border-radius:16px;border:1px solid #e9edf2;overflow:hidden;margin-bottom:32px;box-shadow:0 4px 6px -1px rgba(0,0,0,0.02);">
                
                {{-- Mapel Header --}}
                <div style="background:#f8fafc;padding:18px 24px;border-bottom:1px solid #e9edf2;display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:10px;background:#e0e7ff;color:#4f46e5;display:flex;align-items:center;justify-content:center;font-size:20px;">
                        <i class="bi bi-book-half"></i>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;margin-bottom:2px;">Mata Pelajaran</div>
                        <h3 style="font-size:16px;font-weight:800;color:#0f172a;margin:0;">{{ $mapel->nama }}</h3>
                    </div>
                </div>

                <div style="display:flex;flex-wrap:wrap;gap:0;">
                    {{-- KIRI: Peringkat Global --}}
                    <div style="flex:1;min-width:320px;border-right:1px solid #e9edf2;">
                        <div style="padding:20px 24px;border-bottom:1px solid #e9edf2;">
                            <h4 style="font-size:14px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;">
                                <i class="bi bi-trophy-fill" style="color:#f59e0b;"></i> Peringkat Siswa (Juara Kelas)
                            </h4>
                            <p style="font-size:11.5px;color:#64748b;margin-top:4px;">Berdasarkan rata-rata gabungan seluruh bab di mapel ini.</p>
                        </div>
                        
                        <div style="max-height:500px;overflow-y:auto;padding:12px 24px;">
                            @forelse($leaderboard as $idx => $row)
                                <div style="display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px dashed #e2e8f0;">
                                    <div style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;
                                        background:{{ $idx == 0 ? '#fef3c7' : ($idx == 1 ? '#f1f5f9' : ($idx == 2 ? '#ffedd5' : 'transparent')) }};
                                        color:{{ $idx == 0 ? '#d97706' : ($idx == 1 ? '#64748b' : ($idx == 2 ? '#c2410c' : '#94a3b8')) }};">
                                        {{ $idx + 1 }}
                                    </div>
                                    <div style="flex:1;">
                                        <div style="font-size:13px;font-weight:700;color:#0f172a;">{{ $row['siswa']->nama }}</div>
                                        <div style="font-size:11px;color:#94a3b8;margin-top:2px;">Mengerjakan {{ $row['bab_dikerjakan'] }} Bab</div>
                                    </div>
                                    <div style="text-align:right;">
                                        <div style="font-size:14px;font-weight:800;color:{{ $row['rata_rata_mapel'] >= 80 ? '#16a34a' : ($row['rata_rata_mapel'] >= 60 ? '#ca8a04' : '#dc2626') }};">
                                            {{ $row['rata_rata_mapel'] }}%
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align:center;padding:30px 0;color:#94a3b8;font-size:12.5px;">
                                    Belum ada siswa yang mengerjakan materi apapun.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- KANAN: Evaluasi Bab & Remedial (Accordion) --}}
                    <div style="flex:1;min-width:320px;background:#f8fafc;padding:24px;">
                        <h4 style="font-size:14px;font-weight:700;color:#0f172a;display:flex;align-items:center;gap:8px;margin-bottom:16px;">
                            <i class="bi bi-journal-text" style="color:#3b82f6;"></i> Evaluasi Kesulitan Tiap Bab
                        </h4>

                        @foreach($babAnalytics as $bIdx => $babStat)
                            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;margin-bottom:12px;overflow:hidden;" 
                                 x-data="{ open: false }">
                                
                                {{-- Header Bab --}}
                                <button @click="open = !open" style="width:100%;text-align:left;background:transparent;border:none;padding:14px 18px;display:flex;justify-content:space-between;align-items:center;cursor:pointer;outline:none;">
                                    <div style="flex:1;padding-right:12px;">
                                        <div style="font-size:13px;font-weight:700;color:#1e293b;">
                                            {{ \Illuminate\Support\Str::limit($babStat['materi']->judul, 40) }}
                                        </div>
                                        <div style="font-size:11px;color:#64748b;margin-top:4px;">
                                            Peserta: {{ $babStat['total_peserta'] }} &bull; Rata-rata: {{ $babStat['rata'] }}%
                                        </div>
                                    </div>
                                    <div style="width:28px;height:28px;border-radius:6px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;color:#64748b;transition:transform .2s;" :style="open ? 'transform:rotate(180deg);' : ''">
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </button>

                                {{-- Body Bab (Expanded) --}}
                                <div x-show="open" x-collapse style="display:none;border-top:1px solid #f1f5f9;padding:16px 18px;background:#fcfcfc;">
                                    {{-- Quick Stats --}}
                                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px;">
                                        <div style="background:#f0fdf4;border:1px solid #bbf7d0;padding:10px;border-radius:8px;text-align:center;">
                                            <div style="font-size:10px;font-weight:700;color:#166534;text-transform:uppercase;">Tertinggi</div>
                                            <div style="font-size:16px;font-weight:800;color:#15803d;">{{ $babStat['tertinggi'] }}%</div>
                                        </div>
                                        <div style="background:#fef2f2;border:1px solid #fecaca;padding:10px;border-radius:8px;text-align:center;">
                                            <div style="font-size:10px;font-weight:700;color:#991b1b;text-transform:uppercase;">Terendah</div>
                                            <div style="font-size:16px;font-weight:800;color:#b91c1c;">{{ $babStat['terendah'] }}%</div>
                                        </div>
                                    </div>

                                    {{-- Remedial List --}}
                                    <div>
                                        <div style="font-size:11px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;display:flex;align-items:center;justify-content:space-between;">
                                            <span>Siswa Remedial (< 60%)</span>
                                            <span style="background:#fee2e2;color:#b91c1c;padding:2px 6px;border-radius:12px;font-size:10px;">{{ count($babStat['remedials']) }} Siswa</span>
                                        </div>

                                        @if(count($babStat['remedials']) > 0)
                                            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
                                                @foreach($babStat['remedials'] as $rem)
                                                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 12px;border-bottom:1px solid #f1f5f9;font-size:12px;">
                                                        <span style="font-weight:600;color:#334155;">{{ $rem['siswa']->nama }}</span>
                                                        <span style="font-weight:800;color:#dc2626;">{{ $rem['nilai'] }}%</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div style="background:#f0fdf4;border:1px dashed #bbf7d0;padding:12px;border-radius:8px;text-align:center;font-size:12px;color:#166534;font-weight:500;">
                                                <i class="bi bi-check-circle-fill"></i> Luar biasa! Semua siswa tuntas di bab ini.
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        @endforeach
    @endif

@endsection
