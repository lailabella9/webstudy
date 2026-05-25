@extends('layouts.guru')
@section('title', 'Detail Siswa — ' . $siswa->nama)
@section('page-title', 'Detail Siswa')
@section('page-subtitle', $siswa->nama . ' — riwayat latihan')

@section('topbar-actions')
    <a href="{{ route('guru.siswa.print', $siswa) }}" target="_blank" class="btn-icon-sm" title="Print"
        style="display:inline-flex;align-items:center;gap:5px;padding:7px 14px;border-radius:8px;border:1px solid #e2e8f0;font-size:13px;font-weight:500;color:#374151;text-decoration:none;">
        <i class="bi bi-printer"></i> Print
    </a>
    <a href="{{ route('guru.siswa.pdf', $siswa) }}" class="btn-icon-sm" title="Export PDF"
        style="display:inline-flex;align-items:center;gap:5px;padding:7px 14px;border-radius:8px;border:none;background:#1a56db;font-size:13px;font-weight:500;color:#fff;text-decoration:none;">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
    </a>
    <a href="{{ route('guru.siswa.index') }}" class="btn-icon-sm" title="Kembali" style="padding:7px 10px;">
        <i class="bi bi-arrow-left"></i>
    </a>
@endsection

@section('content')

    {{-- Header profil siswa --}}
    <div
        style="background:#fff; border-radius:14px; border:1px solid #e9edf2; padding:22px 24px; margin-bottom:16px; display:flex; align-items:center; gap:18px;">
        @php
            $avatarColors = ['#1a56db', '#7c3aed', '#0f766e', '#b45309', '#be185d'];
            $avatarBg = $avatarColors[crc32($siswa->nama) % count($avatarColors)];
        @endphp
        <div
            style="width:56px;height:56px;border-radius:50%;background:{{ $avatarBg }};display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:800;color:#fff;flex-shrink:0;overflow:hidden;">
            @if ($siswa->foto_profil)
                <img src="{{ asset('storage/' . $siswa->foto_profil) }}" style="width:100%;height:100%;object-fit:cover;">
            @else
                {{ strtoupper(substr($siswa->nama, 0, 1)) }}
            @endif
        </div>
        <div class="flex-1">
            <div style="font-size:17px;font-weight:700;color:#0f172a;">{{ $siswa->nama }}</div>
            <div style="font-size:13px;color:#64748b;margin-top:2px;">{{ $siswa->email }}</div>
            <div style="font-size:12px;color:#94a3b8;margin-top:1px;">
                Bergabung {{ $siswa->created_at->format('d M Y') }}
            </div>
        </div>
        <a href="{{ route('guru.siswa.index') }}"
            style="padding:8px 18px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;font-weight:500;color:#374151;text-decoration:none;display:flex;align-items:center;gap:6px;">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Stat Cards --}}
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:16px;">
        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:18px 22px;text-align:center;">
            <div style="font-size:28px;font-weight:800;color:#1a56db;">{{ $totalSesi }}</div>
            <div style="font-size:12px;color:#64748b;margin-top:4px;">Total Sesi Latihan</div>
        </div>
        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:18px 22px;text-align:center;">
            <div
                style="font-size:28px;font-weight:800;color:{{ $rata >= 60 ? '#16a34a' : ($rata >= 40 ? '#ca8a04' : '#dc2626') }};">
                {{ number_format($rata, 1) }}%
            </div>
            <div style="font-size:12px;color:#64748b;margin-top:4px;">Rata-rata Nilai</div>
        </div>
        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:18px 22px;text-align:center;">
            <div style="font-size:28px;font-weight:800;color:#0f172a;">{{ $siswa->created_at->format('d M') }}</div>
            <div style="font-size:12px;color:#64748b;margin-top:4px;">Tanggal Bergabung</div>
        </div>
    </div>

    {{-- Riwayat Sesi --}}
    <div style="background:#fff; border-radius:14px; border:1px solid #e9edf2; overflow:hidden;">
        <div style="padding:14px 22px; border-bottom:1px solid #f1f5f9; background:#f8fafc;">
            <span style="font-size:12px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:.06em;">
                Riwayat Sesi Latihan
            </span>
        </div>

        @forelse($sesiList as $sesi)
            @php
                $pct = $sesi->persentase;
                $color = $pct >= 60 ? '#16a34a' : ($pct >= 40 ? '#ca8a04' : '#dc2626');
                $bg = $pct >= 60 ? '#f0fdf4' : ($pct >= 40 ? '#fffbeb' : '#fef2f2');
            @endphp
            <div style="display:flex; align-items:center; gap:16px; padding:14px 22px; border-bottom:1px solid #f8fafc; transition:background .15s;"
                onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">

                {{-- Ikon materi --}}
                <div
                    style="width:38px;height:38px;border-radius:9px;background:#1a56db;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-journal-richtext" style="color:#fff;font-size:16px;"></i>
                </div>

                {{-- Info --}}
                <div style="flex:1;min-width:0;">
                    <div style="font-size:13px;font-weight:600;color:#0f172a;">
                        {{ $sesi->materi->judul ?? '-' }}
                    </div>
                    <div style="font-size:11px;color:#94a3b8;margin-top:2px;display:flex;gap:12px;">
                        <span>
                            <i class="bi bi-calendar3" style="margin-right:3px;"></i>
                            {{ $sesi->selesai_at ? $sesi->selesai_at->format('d M Y, H:i') : 'Belum selesai' }}
                        </span>
                        @if ($sesi->durasi)
                            <span>
                                <i class="bi bi-clock" style="margin-right:3px;"></i>
                                {{ gmdate('i:s', $sesi->durasi) }} menit
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Poin --}}
                <div style="text-align:center;min-width:80px;">
                    <div style="font-size:12px;color:#94a3b8;">Poin</div>
                    <div style="font-size:13px;font-weight:700;color:#0f172a;">
                        {{ $sesi->poin_diraih }}/{{ $sesi->total_poin }}
                    </div>
                </div>

                {{-- Progress bar --}}
                <div style="min-width:100px;">
                    <div style="height:6px;background:#f1f5f9;border-radius:99px;overflow:hidden;margin-bottom:4px;">
                        <div
                            style="height:100%;width:{{ $pct }}%;background:{{ $color }};border-radius:99px;">
                        </div>
                    </div>
                </div>

                {{-- Badge % --}}
                <div style="min-width:52px;text-align:right;">
                    <span
                        style="display:inline-block;padding:4px 10px;border-radius:20px;background:{{ $bg }};color:{{ $color }};font-size:12px;font-weight:700;">
                        {{ $pct }}%
                    </span>
                </div>
            </div>
        @empty
            <div style="text-align:center;padding:48px 24px;color:#94a3b8;">
                <i class="bi bi-journal-x" style="font-size:36px;display:block;margin-bottom:10px;"></i>
                <div style="font-size:14px;font-weight:500;">Belum ada sesi latihan</div>
                <div style="font-size:12px;margin-top:4px;">Siswa belum pernah menyelesaikan latihan</div>
            </div>
        @endforelse
    </div>

    @if ($sesiList->hasPages())
        <div style="margin-top:14px; display:flex; justify-content:flex-end;">
            {{ $sesiList->links() }}
        </div>
    @endif

@endsection
