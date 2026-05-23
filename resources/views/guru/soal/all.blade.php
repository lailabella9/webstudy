@extends('layouts.guru')
@section('title', 'Bank Soal')
@section('page-title', 'Bank Soal')
@section('page-subtitle', 'Semua soal dikelompokkan berdasarkan mata pelajaran dan materi')

@section('content')

    {{-- ── Stats ── --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:22px;">
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:16px 20px;display:flex;align-items:center;gap:14px;">
            <div
                style="width:44px;height:44px;border-radius:11px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-collection-fill" style="font-size:20px;color:#1a56db;"></i>
            </div>
            <div>
                <div style="font-size:22px;font-weight:800;color:#0f172a;">{{ $mapels->count() }}</div>
                <div style="font-size:11.5px;color:#64748b;">Mata Pelajaran</div>
            </div>
        </div>
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:16px 20px;display:flex;align-items:center;gap:14px;">
            <div
                style="width:44px;height:44px;border-radius:11px;background:#eef2ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-journal-richtext" style="font-size:20px;color:#4f46e5;"></i>
            </div>
            <div>
                <div style="font-size:22px;font-weight:800;color:#0f172a;">{{ $totalMateri }}</div>
                <div style="font-size:11.5px;color:#64748b;">Total Bab</div>
            </div>
        </div>
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:16px 20px;display:flex;align-items:center;gap:14px;">
            <div
                style="width:44px;height:44px;border-radius:11px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-patch-question-fill" style="font-size:20px;color:#16a34a;"></i>
            </div>
            <div>
                <div style="font-size:22px;font-weight:800;color:#0f172a;">{{ $totalSoal }}</div>
                <div style="font-size:11.5px;color:#64748b;">Total Soal</div>
            </div>
        </div>
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:16px 20px;display:flex;align-items:center;gap:14px;">
            <div
                style="width:44px;height:44px;border-radius:11px;background:#fefce8;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-tags-fill" style="font-size:20px;color:#ca8a04;"></i>
            </div>
            <div>
                <div style="font-size:22px;font-weight:800;color:#0f172a;">{{ $kategoris->count() }}</div>
                <div style="font-size:11.5px;color:#64748b;">Jenis Latihan</div>
            </div>
        </div>
    </div>

    {{-- ── Legenda kategori ── --}}
    @if ($kategoris->count())
        <div
            style="background:#fff;border-radius:12px;border:1px solid #e9edf2;padding:14px 18px;margin-bottom:18px;display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <span
                style="font-size:11.5px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;margin-right:4px;">Kategori:</span>
            @foreach ($kategoris as $k)
                <span
                    style="display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:20px;background:{{ $k->warna }}15;color:{{ $k->warna }};border:1px solid {{ $k->warna }}30;font-size:12px;font-weight:600;">
                    <i class="bi {{ $k->ikon }}" style="font-size:11px;"></i>
                    {{ $k->nama }}
                </span>
            @endforeach
        </div>
    @endif

    {{-- ── Search ── --}}
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
        <form method="GET" style="display:flex;gap:10px;flex:1;">
            <div style="position:relative;min-width:260px;">
                <i class="bi bi-search"
                    style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul materi..."
                    style="width:100%;height:38px;border:1.5px solid #e2e8f0;border-radius:9px;padding:0 12px 0 34px;font-size:13px;color:#0f172a;background:#fff;outline:none;"
                    onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
            </div>
            <button type="submit"
                style="height:38px;padding:0 18px;border:1.5px solid #e2e8f0;border-radius:9px;background:#fff;font-size:13px;font-weight:500;color:#374151;cursor:pointer;display:flex;align-items:center;gap:6px;">
                <i class="bi bi-funnel"></i> Cari
            </button>
            @if ($search)
                <a href="{{ route('guru.soal.all') }}"
                    style="height:38px;padding:0 14px;border:1.5px solid #e2e8f0;border-radius:9px;background:#fff;font-size:13px;color:#64748b;display:flex;align-items:center;text-decoration:none;">
                    ✕ Reset
                </a>
            @endif
        </form>
    </div>

    {{-- ── Per Mapel ── --}}
    @forelse($mapels as $mapel)
        @php
            $colors = ['#1a56db', '#4f46e5', '#0f766e', '#b45309', '#be185d', '#0369a1'];
            $idx = crc32($mapel->nama) % 6;
            $color = $colors[$idx];
            $materis = $mapel->materis;
        @endphp

        <div x-data="{ open: true }" style="margin-bottom:16px;">

            {{-- Mapel header --}}
            <div @click="open = !open"
                style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:16px 20px;display:flex;align-items:center;gap:14px;cursor:pointer;user-select:none;transition:box-shadow .15s;"
                onmouseover="this.style.boxShadow='0 2px 12px rgba(0,0,0,.06)'" onmouseout="this.style.boxShadow=''">

                <div
                    style="width:40px;height:40px;border-radius:10px;background:{{ $color }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-collection-fill" style="color:#fff;font-size:17px;"></i>
                </div>

                <div style="flex:1;">
                    <div style="font-size:14px;font-weight:700;color:#0f172a;">{{ $mapel->nama }}</div>
                    <div style="font-size:12px;color:#64748b;margin-top:2px;">
                        {{ $materis->count() }} bab
                        &middot;
                        {{ $materis->sum('total_soal') }} soal total
                    </div>
                </div>

                <i class="bi bi-chevron-down" style="color:#94a3b8;font-size:13px;transition:transform .2s;"
                    :style="open ? 'transform:rotate(180deg)' : ''"></i>
            </div>

            {{-- Materi cards --}}
            <div x-show="open" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                style="margin-top:4px;">

                @if ($materis->count())
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        @foreach ($materis as $materi)
                            @php
                                $soalByKat = $soalPerMateriKategori->get($materi->Id_materi, collect());
                            @endphp
                            <div style="background:#fff;border-radius:12px;border:1px solid #e9edf2;padding:14px 18px;display:flex;align-items:center;gap:16px;transition:background .15s;"
                                onmouseover="this.style.background='#fafbfc'" onmouseout="this.style.background=''">

                                {{-- Ikon materi --}}
                                <div
                                    style="width:38px;height:38px;border-radius:9px;background:linear-gradient(135deg,{{ $color }},{{ $color }}99);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="bi bi-journal-richtext" style="color:#fff;font-size:16px;"></i>
                                </div>

                                {{-- Info --}}
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:13.5px;font-weight:600;color:#0f172a;margin-bottom:6px;">
                                        {{ $materi->judul }}
                                    </div>

                                    {{-- Soal per kategori --}}
                                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                        @foreach ($kategoris as $k)
                                            @php $row = $soalByKat->firstWhere('kategori_id', $k->Id_kategori); @endphp
                                            <span
                                                style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;
                                            background:{{ $row && $row->jumlah > 0 ? $k->warna . '15' : '#f1f5f9' }};
                                            color:{{ $row && $row->jumlah > 0 ? $k->warna : '#94a3b8' }};
                                            border:1px solid {{ $row && $row->jumlah > 0 ? $k->warna . '30' : '#e2e8f0' }};
                                            font-size:11.5px;font-weight:600;">
                                                <i class="bi {{ $k->ikon }}" style="font-size:10.5px;"></i>
                                                {{ $k->nama }}: {{ $row->jumlah ?? 0 }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Total & Aksi --}}
                                <div style="display:flex;align-items:center;gap:12px;flex-shrink:0;">
                                    <div style="text-align:center;">
                                        <div style="font-size:20px;font-weight:800;color:#0f172a;">
                                            {{ $materi->total_soal }}</div>
                                        <div style="font-size:10.5px;color:#94a3b8;">total soal</div>
                                    </div>
                                    <a href="{{ route('guru.soal.index', $materi) }}"
                                        style="display:flex;align-items:center;gap:6px;padding:8px 16px;background:{{ $color }};color:#fff;border-radius:9px;font-size:12.5px;font-weight:600;text-decoration:none;transition:opacity .15s;"
                                        onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                                        <i class="bi bi-pencil-square"></i> Kelola Soal
                                    </a>
                                    <a href="{{ route('guru.soal.create', $materi) }}"
                                        style="width:34px;height:34px;border-radius:8px;background:#f1f5f9;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:15px;"
                                        title="Tambah Soal">
                                        <i class="bi bi-plus-lg"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        style="background:#fff;border-radius:12px;border:2px dashed #e2e8f0;padding:28px;text-align:center;color:#94a3b8;">
                        <i class="bi bi-journal-x"
                            style="font-size:26px;display:block;margin-bottom:8px;color:#cbd5e1;"></i>
                        <div style="font-size:13px;font-weight:500;">Belum ada bab di mata pelajaran ini</div>
                        <a href="{{ route('guru.materi.create', $mapel) }}"
                            style="font-size:12.5px;color:{{ $color }};font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:5px;margin-top:8px;">
                            <i class="bi bi-plus-circle"></i> Tambah bab
                        </a>
                    </div>
                @endif
            </div>
        </div>

    @empty
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:64px;text-align:center;color:#94a3b8;">
            <i class="bi bi-patch-question" style="font-size:40px;display:block;margin-bottom:14px;"></i>
            <div style="font-size:15px;font-weight:600;color:#374151;margin-bottom:6px;">Belum ada soal</div>
            <div style="font-size:13px;margin-bottom:16px;">Buat mata pelajaran dan materi terlebih dahulu, lalu tambahkan
                soal.</div>
            <a href="{{ route('guru.materi.all') }}"
                style="display:inline-flex;align-items:center;gap:7px;padding:9px 20px;background:#1a56db;color:#fff;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;">
                <i class="bi bi-journal-richtext"></i> Kelola Materi
            </a>
        </div>
    @endforelse

@endsection
