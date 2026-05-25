@extends('layouts.guru')
@section('title', 'Statistik & Laporan Kelas')
@section('page-title', 'Statistik & Laporan')
@section('page-subtitle')analisis hasil latihan per materi @endsection

@section('content')

    {{-- Pilih materi --}}
    <form method="GET" style="margin-bottom:20px;">
        <div style="display:flex;gap:10px;align-items:center;">
            <select name="materi_id" onchange="this.form.submit()"
                style="min-width:280px;height:40px;border:1.5px solid #e2e8f0;border-radius:9px;padding:0 14px;font-size:13px;background:#fff;outline:none;color:#0f172a;">
                <option value="">— Pilih Materi —</option>
                @foreach ($materis->groupBy(fn($m) => $m->mataPelajaran->nama ?? 'Umum') as $mapelNama => $babList)
                    <optgroup label="{{ $mapelNama }}">
                        @foreach ($babList as $m)
                            <option value="{{ $m->Id_materi }}"
                                {{ optional($selected)->Id_materi == $m->Id_materi ? 'selected' : '' }}>
                                {{ $m->judul }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
    </form>

    @if ($selected && $stats)

        {{-- Stat Cards --}}
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:18px;">
            @foreach ([['val' => $stats['total'], 'lbl' => 'Total Peserta', 'color' => '#1a56db'], ['val' => number_format($stats['rata'], 1) . '%', 'lbl' => 'Rata-rata', 'color' => '#0f172a'], ['val' => $stats['tertinggi'] . '%', 'lbl' => 'Nilai Tertinggi', 'color' => '#16a34a'], ['val' => $stats['terendah'] . '%', 'lbl' => 'Nilai Terendah', 'color' => '#dc2626']] as $c)
                <div
                    style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:18px 22px;text-align:center;">
                    <div style="font-size:28px;font-weight:800;color:{{ $c['color'] }};">{{ $c['val'] }}</div>
                    <div style="font-size:12px;color:#64748b;margin-top:4px;">{{ $c['lbl'] }}</div>
                </div>
            @endforeach
        </div>

        {{-- Kelulusan --}}
        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:20px;margin-bottom:18px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                <span style="font-size:13px;font-weight:700;color:#0f172a;">Kelulusan (KKM 60%)</span>
                <span style="font-size:12px;color:#64748b;">
                    {{ $stats['lulus'] }} lulus dari {{ $stats['total'] }} peserta
                </span>
            </div>
            @if ($stats['total'] > 0)
                @php $pctLulus = round($stats['lulus'] / $stats['total'] * 100); @endphp
                <div style="height:14px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                    <div
                        style="height:100%;width:{{ $pctLulus }}%;background:#22c55e;border-radius:99px;display:flex;align-items:center;justify-content:flex-end;padding-right:8px;transition:width .4s;">
                        @if ($pctLulus > 12)
                            <span style="font-size:10px;font-weight:700;color:#fff;">{{ $pctLulus }}%</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- Peringkat --}}
        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;overflow:hidden;">
            <div style="padding:14px 20px;border-bottom:1px solid #f1f5f9;background:#f8fafc;">
                <span style="font-size:12px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:.06em;">
                    Peringkat — {{ $selected->judul }}
                </span>
            </div>
            @forelse($stats['sesi'] as $i => $row)
                <div style="display:flex;align-items:center;gap:14px;padding:12px 20px;border-bottom:1px solid #f8fafc;transition:background .15s;"
                    onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                    <span
                        style="font-size:13px;font-weight:800;width:24px;text-align:center;color:{{ $i < 3 ? '#f59e0b' : '#94a3b8' }};">
                        {{ $i + 1 }}
                    </span>
                    <div style="flex:1;">
                        <div style="font-size:13px;font-weight:600;color:#0f172a;">{{ $row->user->nama ?? '-' }}</div>
                        <div style="font-size:11px;color:#94a3b8;margin-top:1px;">
                            {{ $row->selesai_at ? \Carbon\Carbon::parse($row->selesai_at)->format('d M Y') : '-' }}
                        </div>
                    </div>
                    {{-- Progress bar --}}
                    <div style="min-width:120px;">
                        <div style="height:6px;background:#f1f5f9;border-radius:99px;overflow:hidden;margin-bottom:3px;">
                            <div
                                style="height:100%;width:{{ $row->persentase }}%;background:{{ $row->persentase >= 60 ? '#22c55e' : '#ef4444' }};border-radius:99px;">
                            </div>
                        </div>
                        <div style="font-size:10.5px;color:#94a3b8;text-align:right;">
                            {{ $row->poin_diraih }}/{{ $row->total_poin }}</div>
                    </div>
                    <span
                        style="font-size:14px;font-weight:800;min-width:44px;text-align:right;color:{{ $row->persentase >= 60 ? '#16a34a' : '#dc2626' }};">
                        {{ $row->persentase }}%
                    </span>
                </div>
            @empty
                <div style="text-align:center;padding:48px;color:#94a3b8;font-size:13px;">
                    Belum ada siswa yang mengerjakan materi ini.
                </div>
            @endforelse
        </div>
    @elseif($materis->isNotEmpty())
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:64px;text-align:center;color:#94a3b8;">
            <i class="bi bi-bar-chart" style="font-size:40px;display:block;margin-bottom:12px;"></i>
            <div style="font-size:14px;">Pilih materi di atas untuk melihat laporan.</div>
        </div>
    @endif
@endsection
