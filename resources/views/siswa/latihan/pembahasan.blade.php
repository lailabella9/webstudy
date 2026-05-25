@extends('layouts.siswa')
@section('title', 'Pembahasan — ' . $kategori->nama)
@section('page-title', 'Pembahasan')
@section('page-subtitle'){{ $kategori->nama }} · {{ $materi->judul }}@endsection

@section('topbar-actions')
    <a href="{{ route('siswa.latihan.hasil', [$materi, $kategori]) }}" class="btn-icon-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
@endsection

@section('content')

    <div style="display:flex;flex-direction:column;gap:12px;">
        @foreach ($soals as $i => $soal)
            @php
                $jawabanku = $jawabanSiswa[$soal->Id_soal] ?? null;
                $benar = $isBenarMap[$soal->Id_soal] ?? false;
                $huruf = ['A', 'B', 'C', 'D', 'E'];
            @endphp
            <div
                style="background:#fff;border-radius:12px;border:1.5px solid {{ $benar ? '#bbf7d0' : '#fecaca' }};padding:18px 20px;">

                <div style="display:flex;gap:12px;align-items:flex-start;margin-bottom:14px;">
                    <div
                        style="width:28px;height:28px;border-radius:7px;background:{{ $benar ? '#f0fdf4' : '#fef2f2' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:14px;">
                        {{ $benar ? '✅' : '❌' }}
                    </div>
                    <p style="font-size:13.5px;font-weight:600;color:#0f172a;margin:0;line-height:1.6;">
                        {{ $i + 1 }}. {{ $soal->pertanyaan }}
                    </p>
                </div>

                <div style="display:flex;flex-direction:column;gap:7px;padding-left:40px;">
                    @foreach ($soal->pilihanJawabans as $pi => $pilihan)
                        @php
                            $isJawabanku = $pilihan->teks_pilihan === $jawabanku;
                            $isBenarPilihan = $pilihan->is_benar;
                            $borderColor = $isBenarPilihan
                                ? '#22c55e'
                                : ($isJawabanku && !$isBenarPilihan
                                    ? '#ef4444'
                                    : '#e2e8f0');
                            $bgColor = $isBenarPilihan
                                ? '#f0fdf4'
                                : ($isJawabanku && !$isBenarPilihan
                                    ? '#fef2f2'
                                    : '#f8fafc');
                            $textColor = $isBenarPilihan
                                ? '#15803d'
                                : ($isJawabanku && !$isBenarPilihan
                                    ? '#b91c1c'
                                    : '#64748b');
                        @endphp
                        <div
                            style="display:flex;align-items:center;gap:8px;padding:9px 12px;border-radius:8px;border:1.5px solid {{ $borderColor }};background:{{ $bgColor }};">
                            <span
                                style="width:22px;height:22px;border-radius:5px;background:{{ $borderColor }};display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:#fff;flex-shrink:0;">
                                {{ $huruf[$pi] }}
                            </span>
                            <span
                                style="font-size:13px;color:{{ $textColor }};font-weight:{{ $isBenarPilihan || $isJawabanku ? '600' : '400' }};flex:1;">
                                {{ $pilihan->teks_pilihan }}
                            </span>
                            @if ($isBenarPilihan)
                                <span style="font-size:10.5px;font-weight:700;color:#16a34a;">✓ Benar</span>
                            @elseif ($isJawabanku)
                                <span style="font-size:10.5px;font-weight:700;color:#dc2626;">✗ Jawaban Anda</span>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if (!$jawabanku)
                    <div
                        style="margin-top:10px;font-size:12px;color:#ca8a04;background:#fffbeb;border:1px solid #fcd34d;border-radius:7px;padding:8px 12px;margin-left:40px;">
                        ⚠️ Soal ini tidak dijawab
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Tombol Aksi --}}
    <div style="margin-top:16px;display:flex;gap:8px;flex-wrap:wrap;">

        {{-- Ulangi: pakai form DELETE agar jawaban direset --}}
        <form method="POST" action="{{ route('siswa.latihan.ulangi', [$materi, $kategori]) }}"
            onsubmit="return confirm('Reset semua jawaban dan kerjakan latihan ini dari awal?')">
            @csrf @method('DELETE')
            <button type="submit"
                style="padding:10px 20px;background:#d97706;color:#fff;border:none;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px;">
                <i class="bi bi-arrow-clockwise"></i> Kerjakan Ulang
            </button>
        </form>

        <a href="{{ route('siswa.latihan.hasil', [$materi, $kategori]) }}"
            style="padding:10px 20px;background:#eff6ff;color:#1a56db;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:6px;">
            <i class="bi bi-bar-chart"></i> Lihat Hasil
        </a>

        <a href="{{ route('siswa.latihan.mapel', $materi->mataPelajaran) }}"
            style="padding:10px 20px;background:#f1f5f9;color:#374151;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:6px;">
            <i class="bi bi-arrow-left"></i> Kembali ke Bab
        </a>
    </div>

@endsection
