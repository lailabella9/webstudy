@extends('layouts.siswa')
@section('title', 'Hasil — ' . $materi->judul)
@section('page-title', 'Hasil Latihan')
@section('page-subtitle'){{ $kategori->nama }} · {{ $materi->judul }}@endsection

@section('topbar-actions')
    <a href="{{ route('siswa.latihan.mapel', $materi->mataPelajaran) }}" class="btn-icon-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
@endsection

@section('content')

    {{-- ── SCORE CARD ── --}}
    <div style="max-width:460px;margin:0 auto 24px;">

        {{-- Nilai Utama --}}
        <div
            style="background:#fff;border-radius:16px;border:1px solid #e9edf2;padding:28px;text-align:center;margin-bottom:14px;">

            {{-- Lingkaran nilai --}}
            <div style="position:relative;width:110px;height:110px;margin:0 auto 18px;">
                <svg viewBox="0 0 110 110" style="transform:rotate(-90deg);width:110px;height:110px;">
                    <circle cx="55" cy="55" r="48" fill="none" stroke="#f1f5f9" stroke-width="9" />
                    <circle cx="55" cy="55" r="48" fill="none"
                        stroke="{{ $lulus ? '#22c55e' : ($persentase >= 50 ? '#f59e0b' : '#ef4444') }}" stroke-width="9"
                        stroke-linecap="round" stroke-dasharray="{{ round(2 * 3.14159 * 48) }}"
                        stroke-dashoffset="{{ round(2 * 3.14159 * 48 * (1 - $persentase / 100)) }}"
                        style="transition:stroke-dashoffset 1s ease;" />
                </svg>
                <div
                    style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;">
                    <span
                        style="font-size:26px;font-weight:900;color:{{ $lulus ? '#16a34a' : ($persentase >= 50 ? '#ca8a04' : '#dc2626') }};">{{ $persentase }}</span>
                    <span style="font-size:10px;color:#94a3b8;font-weight:600;">dari 100</span>
                </div>
            </div>

            {{-- KKM indicator --}}
            <div style="display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:14px;">
                <div style="height:2px;flex:1;max-width:80px;background:#f1f5f9;border-radius:1px;"></div>
                <span style="font-size:12px;color:#64748b;">KKM {{ $kkm }}</span>
                <div style="height:2px;flex:1;max-width:80px;background:#f1f5f9;border-radius:1px;"></div>
            </div>

            {{-- Status Lulus / Tidak Lulus --}}
            @if ($lulus)
                <div
                    style="display:inline-flex;align-items:center;gap:8px;padding:8px 22px;border-radius:24px;background:#dcfce7;border:1.5px solid #86efac;margin-bottom:14px;">
                    <i class="bi bi-patch-check-fill" style="color:#16a34a;font-size:18px;"></i>
                    <span style="font-size:15px;font-weight:800;color:#15803d;">LULUS ✓</span>
                </div>
            @else
                <div
                    style="display:inline-flex;align-items:center;gap:8px;padding:8px 22px;border-radius:24px;background:#fee2e2;border:1.5px solid #fca5a5;margin-bottom:14px;">
                    <i class="bi bi-x-circle-fill" style="color:#dc2626;font-size:18px;"></i>
                    <span style="font-size:15px;font-weight:800;color:#b91c1c;">TIDAK LULUS ✗</span>
                </div>
            @endif

            {{-- Stats --}}
            <div style="display:flex;justify-content:center;gap:24px;margin-bottom:18px;">
                <div style="text-align:center;">
                    <div style="font-size:20px;font-weight:800;color:#0f172a;">{{ $raihPoin }}/{{ $totalPoin }}
                    </div>
                    <div style="font-size:11px;color:#64748b;">Poin</div>
                </div>
                <div style="width:1px;background:#e9edf2;"></div>
                <div style="text-align:center;">
                    <div style="font-size:20px;font-weight:800;color:#16a34a;">
                        {{ $hasil->where('is_benar', true)->count() }}</div>
                    <div style="font-size:11px;color:#64748b;">Benar</div>
                </div>
                <div style="width:1px;background:#e9edf2;"></div>
                <div style="text-align:center;">
                    <div style="font-size:20px;font-weight:800;color:#dc2626;">
                        {{ $hasil->where('is_benar', false)->count() }}</div>
                    <div style="font-size:11px;color:#64748b;">Salah</div>
                </div>
            </div>

            {{-- Progress bar dengan KKM marker --}}
            <div
                style="position:relative;height:10px;background:#f1f5f9;border-radius:99px;overflow:visible;margin-bottom:6px;">
                <div
                    style="height:100%;width:{{ $persentase }}%;background:{{ $lulus ? '#22c55e' : ($persentase >= 50 ? '#f59e0b' : '#ef4444') }};border-radius:99px;transition:width 1s ease;">
                </div>
                <div style="position:absolute;top:-4px;bottom:-4px;left:{{ $kkm }}%;width:2.5px;background:#1a56db;border-radius:1px;"
                    title="KKM"></div>
            </div>
            <div style="display:flex;justify-content:flex-end;font-size:10.5px;color:#64748b;">
                <span style="color:#1a56db;font-weight:600;">▲ KKM {{ $kkm }}%</span>
            </div>

            {{-- Action buttons --}}
            <div style="display:flex;gap:8px;margin-top:18px;">
                <a href="{{ route('siswa.latihan.pembahasan', [$materi, $kategori]) }}"
                    style="flex:1;text-align:center;padding:10px;border:1.5px solid {{ $kategori->warna }}40;border-radius:10px;font-size:13px;font-weight:600;color:{{ $kategori->warna }};text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;">
                    <i class="bi bi-eye"></i> Pembahasan
                </a>
                @if ($lulus && $nextMateri)
                    <a href="{{ route('siswa.latihan.mapel', $materi->mataPelajaran) }}"
                        style="flex:1;text-align:center;padding:10px;background:#16a34a;color:#fff;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;">
                        <i class="bi bi-arrow-right-circle-fill"></i> Bab Berikutnya
                    </a>
                @elseif ($lulus)
                    <a href="{{ route('siswa.latihan.mapel', $materi->mataPelajaran) }}"
                        style="flex:1;text-align:center;padding:10px;background:{{ $kategori->warna }};color:#fff;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;">
                        <i class="bi bi-grid-3x3-gap"></i> Kembali ke Bab
                    </a>
                @else
                    <a href="{{ route('siswa.latihan.ulangi', [$materi, $kategori]) }}"
                        onclick="return confirm('Reset semua jawaban dan mulai ulang latihan ini?')"
                        style="flex:1;text-align:center;padding:10px;background:#d97706;color:#fff;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;">
                        <i class="bi bi-arrow-clockwise"></i> Belajar Lagi
                    </a>
                @endif
            </div>
        </div>

        {{-- Pesan KKM --}}
        @if (!$lulus)
            <div
                style="background:#fef3c7;border-radius:14px;border:1.5px solid #fcd34d;padding:18px 20px;margin-bottom:14px;">
                <div style="display:flex;align-items:flex-start;gap:12px;">
                    <div
                        style="width:42px;height:42px;border-radius:10px;background:#f59e0b;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-book-fill" style="color:#fff;font-size:18px;"></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:800;color:#78350f;margin-bottom:5px;">📖 Belajar Lagi!</div>
                        <div style="font-size:12.5px;color:#92400e;line-height:1.7;">
                            Nilaimu <strong>{{ $persentase }}%</strong> belum mencapai KKM
                            <strong>{{ $kkm }}%</strong>.
                            Bab selanjutnya masih <strong>terkunci</strong> 🔒.<br>
                            Pelajari kembali materi, lalu klik <strong>"Belajar Lagi"</strong> untuk mengerjakan ulang.
                        </div>
                        <div style="margin-top:10px;display:flex;gap:8px;flex-wrap:wrap;">
                            <a href="{{ route('siswa.latihan.mapel', $materi->mataPelajaran) }}"
                                style="padding:7px 14px;background:#f59e0b;color:#fff;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:5px;">
                                <i class="bi bi-journal-richtext"></i> Baca Materi
                            </a>
                            @if ($materi->hasFile())
                                <a href="{{ route('siswa.latihan.download', $materi) }}"
                                    style="padding:7px 14px;background:#fff;border:1.5px solid #fcd34d;color:#92400e;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:5px;">
                                    <i class="bi bi-download"></i> Unduh Materi
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Selamat Lulus --}}
            <div
                style="background:#dcfce7;border-radius:14px;border:1.5px solid #86efac;padding:18px 20px;margin-bottom:14px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div
                        style="width:42px;height:42px;border-radius:10px;background:#16a34a;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-trophy-fill" style="color:#fff;font-size:18px;"></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:800;color:#14532d;margin-bottom:3px;">🎉 Selamat, kamu lulus!
                        </div>
                        <div style="font-size:12.5px;color:#166534;">
                            Nilaimu <strong>{{ $persentase }}%</strong> telah mencapai KKM.
                            @if ($nextMateri)
                                Bab <strong>{{ $nextMateri->judul }}</strong> sekarang terbuka! 🔓
                            @else
                                Kamu telah menyelesaikan semua bab! 🏆
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- ── RINCIAN JAWABAN ── --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;overflow:hidden;">
        <div
            style="padding:14px 20px;border-bottom:1px solid #f1f5f9;background:#f8fafc;display:flex;align-items:center;justify-content:space-between;">
            <span
                style="font-size:12px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:.06em;">Rincian
                Jawaban</span>
            <span style="font-size:12px;color:#64748b;">{{ $hasil->where('is_benar', true)->count() }} benar dari
                {{ $hasil->count() }} soal</span>
        </div>
        @foreach ($hasil as $i => $h)
            <div style="padding:14px 20px;border-bottom:1px solid #f8fafc;display:flex;gap:12px;align-items:flex-start;">
                <div
                    style="width:28px;height:28px;border-radius:7px;background:{{ $h->is_benar ? '#f0fdf4' : '#fef2f2' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:14px;">
                    {{ $h->is_benar ? '✅' : '❌' }}
                </div>
                <div style="flex:1;">
                    <div style="font-size:13px;font-weight:500;color:#0f172a;margin-bottom:3px;">
                        {{ $i + 1 }}. {{ \Illuminate\Support\Str::limit($h->soal->pertanyaan ?? '-', 80) }}
                    </div>
                    <div style="font-size:12px;color:{{ $h->is_benar ? '#16a34a' : '#dc2626' }};">
                        Jawabanmu: {{ $h->jawaban_siswa ?? '-' }}
                    </div>
                    @if (!$h->is_benar)
                        <div style="font-size:12px;color:#16a34a;margin-top:1px;">
                            ✓ Benar: {{ $h->soal->jawabanBenar()?->teks_pilihan ?? 'N/A' }}
                        </div>
                    @endif
                </div>
                <span
                    style="font-size:12px;font-weight:700;color:{{ $h->is_benar ? '#16a34a' : '#94a3b8' }};flex-shrink:0;">
                    +{{ $h->nilai }}
                </span>
            </div>
        @endforeach
    </div>

@endsection
