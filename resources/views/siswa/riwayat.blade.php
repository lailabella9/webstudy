@extends('layouts.siswa')
@section('title', 'Riwayat Nilai')
@section('page-title', 'Riwayat Nilai')
@section('page-subtitle')rekap semua sesi latihan Anda @endsection

@section('content')

    {{-- ── STAT CARDS ── --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">

        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:18px 22px;text-align:center;">
            <div style="font-size:28px;font-weight:800;color:#1a56db;">{{ $totalSesi }}</div>
            <div style="font-size:12px;color:#64748b;margin-top:4px;">Total Sesi</div>
        </div>

        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:18px 22px;text-align:center;">
            <div style="font-size:28px;font-weight:800;color:{{ $rata >= $kkm ? '#16a34a' : '#ca8a04' }};">
                {{ number_format($rata, 1) }}%
            </div>
            <div style="font-size:12px;color:#64748b;margin-top:4px;">Rata-rata Nilai</div>
            <div style="font-size:11px;color:#94a3b8;margin-top:2px;">KKM {{ $kkm }}%</div>
        </div>

        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:18px 22px;text-align:center;">
            <div style="font-size:28px;font-weight:800;color:#16a34a;">{{ $terbaik }}%</div>
            <div style="font-size:12px;color:#64748b;margin-top:4px;">Nilai Terbaik</div>
        </div>

        {{-- Stat: jumlah lulus --}}
        @php
            $jumlahLulus = collect($sesiList->items())->where('lulus', true)->count();
        @endphp
        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:18px 22px;text-align:center;">
            <div style="font-size:28px;font-weight:800;color:#16a34a;">{{ $jumlahLulus }}</div>
            <div style="font-size:12px;color:#64748b;margin-top:4px;">Sesi Lulus KKM</div>
            <div style="font-size:11px;color:#94a3b8;margin-top:2px;">dari {{ $sesiList->count() }} di halaman ini</div>
        </div>
    </div>

    {{-- ── TABEL RIWAYAT ── --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;overflow:hidden;">
        <div
            style="padding:14px 20px;border-bottom:1px solid #f1f5f9;background:#f8fafc;display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:12px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:.06em;">
                Riwayat Latihan
            </span>
            <span style="font-size:11px;color:#94a3b8;background:#f1f5f9;padding:3px 10px;border-radius:20px;">
                KKM <strong style="color:#1a56db;">{{ $kkm }}%</strong>
            </span>
        </div>

        @forelse($sesiList as $sesi)
            @php
                $pct = $sesi->persentase;
                $lulus = $sesi->lulus;
                $color = $lulus ? '#16a34a' : ($pct >= 50 ? '#ca8a04' : '#dc2626');
                $bg = $lulus ? '#f0fdf4' : ($pct >= 50 ? '#fffbeb' : '#fef2f2');
                $kat = $sesi->kategori;
            @endphp
            <div style="display:flex;align-items:center;gap:14px;padding:14px 20px;border-bottom:1px solid #f8fafc;transition:background .15s;"
                onmouseover="this.style.background='#fafbff'" onmouseout="this.style.background=''">

                {{-- Ikon kategori --}}
                <div
                    style="width:40px;height:40px;border-radius:10px;background:{{ $kat?->warna ?? '#64748b' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi {{ $kat?->ikon ?? 'bi-pencil' }}" style="color:#fff;font-size:17px;"></i>
                </div>

                {{-- Info --}}
                <div style="flex:1;min-width:0;">
                    <div
                        style="font-size:13px;font-weight:700;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $sesi->materi?->judul ?? '-' }}
                    </div>
                    <div style="font-size:11.5px;color:#64748b;margin-top:2px;display:flex;gap:10px;flex-wrap:wrap;">
                        @if ($kat)
                            <span style="color:{{ $kat->warna }};font-weight:600;">{{ $kat->nama }}</span>
                            <span>·</span>
                        @endif
                        <span>{{ $sesi->materi?->mataPelajaran?->nama ?? '' }}</span>
                        <span>·</span>
                        <span>{{ $sesi->selesai_at?->format('d M Y, H:i') ?? '-' }}</span>
                    </div>
                </div>

                {{-- Progress bar --}}
                <div style="min-width:110px;">
                    <div
                        style="position:relative;height:6px;background:#f1f5f9;border-radius:99px;overflow:visible;margin-bottom:4px;">
                        <div
                            style="height:100%;width:{{ $pct }}%;background:{{ $color }};border-radius:99px;">
                        </div>
                        {{-- KKM marker --}}
                        <div style="position:absolute;top:-3px;bottom:-3px;left:{{ $kkm }}%;width:2px;background:#1a56db;border-radius:1px;opacity:.5;"
                            title="KKM {{ $kkm }}%"></div>
                    </div>
                    <div style="font-size:10.5px;color:#94a3b8;text-align:right;">
                        {{ $sesi->poin_diraih }}/{{ $sesi->total_poin }} poin
                    </div>
                </div>

                {{-- Badge nilai + KKM status --}}
                <div style="min-width:80px;text-align:center;flex-shrink:0;">
                    <span
                        style="display:block;padding:4px 10px;border-radius:20px;background:{{ $bg }};color:{{ $color }};font-size:13px;font-weight:800;margin-bottom:3px;">
                        {{ $pct }}%
                    </span>
                    @if ($lulus)
                        <span style="font-size:10px;color:#16a34a;font-weight:700;">✓ Lulus KKM</span>
                    @else
                        <span style="font-size:10px;color:#dc2626;font-weight:700;">✗ Belum KKM</span>
                    @endif
                </div>

                {{-- Aksi --}}
                @if ($sesi->materi && $sesi->kategori)
                    <div style="display:flex;flex-direction:column;gap:5px;flex-shrink:0;">
                        <a href="{{ route('siswa.latihan.hasil', [$sesi->materi, $sesi->kategori]) }}"
                            style="display:flex;align-items:center;gap:5px;padding:5px 11px;border-radius:7px;background:#eff6ff;color:#1a56db;text-decoration:none;font-size:11.5px;font-weight:600;"
                            title="Lihat hasil">
                            <i class="bi bi-eye"></i> Hasil
                        </a>
                        <a href="{{ route('siswa.latihan.pembahasan', [$sesi->materi, $sesi->kategori]) }}"
                            style="display:flex;align-items:center;gap:5px;padding:5px 11px;border-radius:7px;background:#eef2ff;color:#4f46e5;text-decoration:none;font-size:11.5px;font-weight:600;"
                            title="Pembahasan">
                            <i class="bi bi-lightbulb"></i> Bahas
                        </a>
                        @if (!$lulus)
                            <form method="POST"
                                action="{{ route('siswa.latihan.ulangi', [$sesi->materi, $sesi->kategori]) }}"
                                onsubmit="return confirm('Reset jawaban dan ulangi latihan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    style="display:flex;align-items:center;gap:5px;padding:5px 11px;border-radius:7px;background:#fef2f2;color:#dc2626;border:none;cursor:pointer;font-size:11.5px;font-weight:600;width:100%;">
                                    <i class="bi bi-arrow-clockwise"></i> Ulangi
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div style="text-align:center;padding:48px;color:#94a3b8;">
                <i class="bi bi-clipboard-x" style="font-size:36px;display:block;margin-bottom:10px;"></i>
                <div style="font-size:14px;font-weight:500;">Belum ada riwayat latihan</div>
                <a href="{{ route('siswa.latihan.index') }}"
                    style="font-size:13px;color:#1a56db;font-weight:600;margin-top:8px;display:inline-block;">
                    Mulai latihan →
                </a>
            </div>
        @endforelse
    </div>

    @if ($sesiList->hasPages())
        <div style="margin-top:14px;">{{ $sesiList->links() }}</div>
    @endif

@endsection
