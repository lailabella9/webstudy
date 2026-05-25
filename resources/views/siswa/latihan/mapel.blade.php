@extends('layouts.siswa')
@section('title', $mapel->nama)
@section('page-title', $mapel->nama)
@section('page-subtitle')pilih bab dan jenis latihan yang ingin dikerjakan @endsection

@section('topbar-actions')
    <a href="{{ route('siswa.latihan.index') }}" class="btn-icon-sm" title="Kembali">
        <i class="bi bi-arrow-left"></i>
    </a>
@endsection

@section('content')

    {{-- Info KKM --}}
    <div
        style="background:#1a56db;border-radius:14px;padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;gap:14px;">
        <div
            style="width:44px;height:44px;border-radius:11px;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="bi bi-trophy-fill" style="color:#fbbf24;font-size:20px;"></i>
        </div>
        <div style="flex:1;">
            <div style="font-size:14px;font-weight:700;color:#fff;">KKM: {{ $kkm }}</div>
            <div style="font-size:12px;color:rgba(255,255,255,.7);margin-top:2px;">
                Capai nilai ≥ <strong style="color:#fbbf24;">{{ $kkm }}</strong> di setiap bab untuk membuka bab
                selanjutnya.
            </div>
        </div>
        <div style="font-size:28px;font-weight:900;color:#fbbf24;">{{ $kkm }}</div>
    </div>

    @php $nomor = 0; @endphp

    @forelse($materis as $item)
        @php
            $materi = $item['materi'];
            $babKategoris = $item['kategoris'];
            $locked = $item['locked'];
            $lulus = $item['lulus'];
            $selesai = $item['selesai'];
            $avgNilai = $item['avg_nilai'];
            $nomor++;

            // Warna status
            if ($locked) {
                $statusColor = '#94a3b8';
                $statusBg = '#f1f5f9';
                $statusLabel = 'Terkunci';
                $statusIcon = 'bi-lock-fill';
            } elseif ($lulus) {
                $statusColor = '#16a34a';
                $statusBg = '#f0fdf4';
                $statusLabel = 'Lulus';
                $statusIcon = 'bi-patch-check-fill';
            } elseif ($selesai) {
                $statusColor = '#dc2626';
                $statusBg = '#fef2f2';
                $statusLabel = 'Tidak Lulus';
                $statusIcon = 'bi-x-circle-fill';
            } else {
                $statusColor = '#1a56db';
                $statusBg = '#eff6ff';
                $statusLabel = 'Tersedia';
                $statusIcon = 'bi-play-circle-fill';
            }
        @endphp

        <div
            style="background:#fff;border-radius:14px;border:1.5px solid {{ $locked ? '#e2e8f0' : ($lulus ? '#bbf7d0' : '#e9edf2') }};margin-bottom:16px;overflow:hidden;{{ $locked ? 'opacity:.65;' : '' }}">

            {{-- Header bab --}}
            <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:14px;">
                {{-- Nomor bab --}}
                <div
                    style="width:42px;height:42px;border-radius:10px;
                        background:{{ $locked ? '#e2e8f0' : '#1a56db' }};
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    @if ($locked)
                        <i class="bi bi-lock-fill" style="color:#94a3b8;font-size:18px;"></i>
                    @else
                        <span style="color:#fff;font-size:15px;font-weight:800;">{{ $nomor }}</span>
                    @endif
                </div>

                <div style="flex:1;">
                    <div style="font-size:15px;font-weight:700;color:#0f172a;">{{ $materi->judul }}</div>
                    <div style="font-size:12px;color:#64748b;margin-top:2px;">
                        {{ count($babKategoris) }} latihan tersedia
                        @if ($selesai && !$locked)
                            · Nilai: <strong
                                style="color:{{ $avgNilai >= $kkm ? '#16a34a' : '#dc2626' }};">{{ $avgNilai }}%</strong>
                        @endif
                    </div>
                </div>

                {{-- Status badge --}}
                <div style="display:flex;align-items:center;gap:10px;">
                    <span
                        style="display:flex;align-items:center;gap:5px;padding:5px 12px;border-radius:20px;background:{{ $statusBg }};color:{{ $statusColor }};font-size:11.5px;font-weight:700;">
                        <i class="bi {{ $statusIcon }}" style="font-size:12px;"></i>
                        {{ $statusLabel }}
                        @if ($selesai && !$locked)
                            ({{ $avgNilai }}%)
                        @endif
                    </span>
                    @if ($materi->hasFile() && !$locked)
                        <a href="{{ route('siswa.latihan.download', $materi) }}"
                            style="display:flex;align-items:center;gap:6px;padding:7px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:12.5px;font-weight:600;color:#374151;text-decoration:none;">
                            <i class="bi bi-download"></i> Unduh
                        </a>
                    @endif
                </div>
            </div>

            {{-- Konten bab --}}
            @if ($materi->konten && !$locked)
                <div style="padding:14px 20px;border-bottom:1px solid #f8fafc;background:#fafbfc;">
                    <div style="font-size:12.5px;color:#475569;line-height:1.7;">
                        {{ \Illuminate\Support\Str::limit(strip_tags($materi->konten), 200) }}
                    </div>
                </div>
            @endif

            {{-- LOCKED: Pesan terkunci --}}
            @if ($locked)
                <div style="padding:24px 20px;display:flex;align-items:center;gap:14px;background:#f8fafc;">
                    <div
                        style="width:44px;height:44px;border-radius:11px;background:#fef2f2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-lock-fill" style="color:#ef4444;font-size:20px;"></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#0f172a;margin-bottom:3px;">Bab ini terkunci</div>
                        <div style="font-size:12.5px;color:#64748b;">
                            Selesaikan bab sebelumnya dengan nilai ≥ <strong
                                style="color:#1a56db;">{{ $kkm }}</strong> untuk membuka bab ini.
                        </div>
                    </div>
                </div>
            @else
                {{-- TIDAK LULUS: pesan belajar lagi --}}
                @if ($selesai && !$lulus)
                    <div
                        style="padding:12px 20px;background:#fef9c3;border-bottom:1px solid #fde68a;display:flex;align-items:center;gap:10px;">
                        <i class="bi bi-exclamation-triangle-fill" style="color:#d97706;font-size:16px;flex-shrink:0;"></i>
                        <div style="font-size:12.5px;color:#92400e;">
                            <strong>Nilai belum memenuhi KKM.</strong>
                            Kamu perlu mencapai minimal <strong>{{ $kkm }}%</strong> untuk membuka bab berikutnya.
                            Pelajari kembali materi dan ulangi latihan.
                        </div>
                    </div>
                @endif

                {{-- Daftar kategori --}}
                <div style="padding:14px 20px;display:flex;flex-direction:column;gap:10px;">
                    @foreach ($babKategoris as $kat)
                        @php
                            $k = $kat['kategori'];
                            $pct = $kat['pct'];
                            $nilai = $kat['nilai'];
                            $katLulus = $kat['lulus'];
                            $barColor = $nilai >= $kkm ? '#22c55e' : ($nilai >= 50 ? '#f59e0b' : '#94a3b8');
                        @endphp

                        <div
                            style="border:1.5px solid {{ $k->warna }}40;border-radius:12px;
                                padding:14px 16px;background:{{ $k->warna }}06;
                                display:flex;align-items:center;gap:14px;">

                            <div
                                style="width:40px;height:40px;border-radius:10px;background:{{ $k->warna }};
                                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi {{ $k->ikon }}" style="font-size:17px;color:#fff;"></i>
                            </div>

                            <div style="flex:1;min-width:0;">
                                <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                                    <span style="font-size:14px;font-weight:700;color:#0f172a;">{{ $k->nama }}</span>
                                    @if ($kat['selesai'])
                                        @if ($katLulus)
                                            <span
                                                style="font-size:10px;background:#f0fdf4;color:#16a34a;padding:2px 8px;border-radius:20px;font-weight:600;">
                                                ✓ Lulus
                                            </span>
                                        @else
                                            <span
                                                style="font-size:10px;background:#fef2f2;color:#dc2626;padding:2px 8px;border-radius:20px;font-weight:600;">
                                                ✗ Ulangi
                                            </span>
                                        @endif
                                    @elseif ($pct >= 100)
                                        <span
                                            style="font-size:10px;background:#f0fdf4;color:#16a34a;padding:2px 8px;border-radius:20px;font-weight:600;">
                                            ✓ Selesai
                                        </span>
                                    @endif
                                </div>
                                <div style="font-size:11.5px;color:#64748b;margin-bottom:6px;">
                                    {{ $kat['total'] }} soal · {{ $kat['dijawab'] }} sudah dijawab
                                </div>
                                @if ($pct > 0)
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        {{-- KKM marker --}}
                                        <div
                                            style="position:relative;flex:1;height:7px;background:#f1f5f9;border-radius:99px;overflow:visible;">
                                            <div
                                                style="height:100%;width:{{ $pct }}%;background:{{ $barColor }};border-radius:99px;transition:width .3s;">
                                            </div>
                                            {{-- KKM line --}}
                                            <div style="position:absolute;top:-3px;bottom:-3px;left:{{ $kkm }}%;width:2px;background:#dc2626;border-radius:1px;"
                                                title="KKM {{ $kkm }}%"></div>
                                        </div>
                                        <span
                                            style="font-size:11px;font-weight:700;color:{{ $barColor }};min-width:38px;text-align:right;">
                                            {{ $nilai > 0 ? $nilai . '%' : $pct . '%' }}
                                        </span>
                                        <span style="font-size:10px;color:#94a3b8;">/ KKM {{ $kkm }}%</span>
                                    </div>
                                @endif
                            </div>

                            <div style="flex-shrink:0;display:flex;gap:6px;align-items:center;">
                                @if ($canMulai)
                                    @if ($kat['dijawab'] > 0)
                                        <a href="{{ route('siswa.latihan.pembahasan', [$materi, $k]) }}"
                                            style="padding:8px 14px;border:1.5px solid {{ $k->warna }}40;border-radius:9px;font-size:12.5px;font-weight:600;color:{{ $k->warna }};text-decoration:none;display:flex;align-items:center;gap:5px;">
                                            <i class="bi bi-eye"></i> Pembahasan
                                        </a>
                                        {{-- Tombol Ulangi jika tidak lulus KKM --}}
                                        @if ($kat['selesai'] && !$katLulus)
                                            <a href="{{ route('siswa.latihan.ulangi', [$materi, $k]) }}"
                                                onclick="return confirm('Reset semua jawaban latihan ini dan mulai dari awal?')"
                                                style="padding:8px 14px;border:1.5px solid #fecaca;border-radius:9px;font-size:12.5px;font-weight:600;color:#dc2626;text-decoration:none;display:flex;align-items:center;gap:5px;background:#fef2f2;">
                                                <i class="bi bi-arrow-clockwise"></i> Ulangi
                                            </a>
                                        @endif
                                    @endif
                                    <a href="{{ route('siswa.latihan.mulai', [$materi, $k]) }}"
                                        style="padding:8px 18px;background:{{ $k->warna }};color:#fff;border-radius:9px;font-size:12.5px;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:5px;transition:opacity .15s;"
                                        onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                                        <i class="bi bi-play-circle"></i>
                                        {{ $kat['dijawab'] > 0 ? ($kat['selesai'] ? 'Lihat Hasil' : 'Lanjutkan') : 'Mulai' }}
                                    </a>
                                @else
                                    <span style="font-size:11.5px;color:#dc2626;font-weight:600;display:flex;align-items:center;gap:4px;" title="Anda tidak dapat mengerjakan latihan untuk kelas lain.">
                                        <i class="bi bi-lock-fill"></i> Anda tidak dapat mengerjakan latihan untuk kelas lain.
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Belajar Lagi banner jika selesai tapi tidak lulus --}}
                @if ($selesai && !$lulus)
                    <div style="padding:0 20px 16px;">
                        <div
                            style="background:#fef3c7;border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;border:1px solid #fde68a;">
                            <div
                                style="width:44px;height:44px;border-radius:11px;background:#f59e0b;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-book-fill" style="color:#fff;font-size:20px;"></i>
                            </div>
                            <div style="flex:1;">
                                <div style="font-size:14px;font-weight:700;color:#78350f;margin-bottom:3px;">📖 Belajar
                                    Lagi!</div>
                                <div style="font-size:12.5px;color:#92400e;">
                                    Nilai rata-rata bab ini <strong>{{ $avgNilai }}%</strong> belum mencapai KKM
                                    <strong>{{ $kkm }}%</strong>.
                                    Pelajari ulang materi, lalu ulangi latihan untuk membuka bab selanjutnya.
                                </div>
                            </div>
                            @if ($materi->hasFile())
                                <a href="{{ route('siswa.latihan.download', $materi) }}"
                                    style="padding:10px 16px;background:#f59e0b;color:#fff;border-radius:9px;font-size:12.5px;font-weight:700;text-decoration:none;white-space:nowrap;display:flex;align-items:center;gap:5px;">
                                    <i class="bi bi-download"></i> Unduh Materi
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        </div>

    @empty
        <div style="text-align:center;padding:64px;color:#94a3b8;">
            <i class="bi bi-journal-x" style="font-size:40px;display:block;margin-bottom:12px;"></i>
            <div style="font-size:15px;font-weight:500;">Belum ada latihan yang dibuka</div>
            <div style="font-size:13px;margin-top:6px;">Tunggu guru membuka akses latihan</div>
        </div>
    @endforelse

@endsection
