@extends('layouts.guru')
@section('title', 'Semua Materi')
@section('page-title', 'Materi / Bab')
@section('page-subtitle', 'Kelola semua bab materi dari seluruh mata pelajaran')

@section('content')

    {{-- ── Stats ── --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:22px;">
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:16px 20px;display:flex;align-items:center;gap:14px;">
            <div
                style="width:44px;height:44px;border-radius:11px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-collection-fill" style="font-size:20px;color:#1a56db;"></i>
            </div>
            <div>
                <div style="font-size:24px;font-weight:800;color:#0f172a;">{{ $totalMapel }}</div>
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
                <div style="font-size:24px;font-weight:800;color:#0f172a;">{{ $totalMateri }}</div>
                <div style="font-size:11.5px;color:#64748b;">Total Bab / Materi</div>
            </div>
        </div>
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:16px 20px;display:flex;align-items:center;gap:14px;">
            <div
                style="width:44px;height:44px;border-radius:11px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-patch-question-fill" style="font-size:20px;color:#16a34a;"></i>
            </div>
            <div>
                <div style="font-size:24px;font-weight:800;color:#0f172a;">{{ $totalSoal }}</div>
                <div style="font-size:11.5px;color:#64748b;">Total Soal</div>
            </div>
        </div>
    </div>

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
                <a href="{{ route('guru.materi.all') }}"
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
                        {{ $materis->count() }} bab &middot;
                        {{ $materis->sum('soals_count') }} soal total
                    </div>
                </div>

                <div style="display:flex;align-items:center;gap:10px;">
                    {{-- Tambah bab di mapel ini --}}
                    <a href="{{ route('guru.materi.create', $mapel) }}" @click.stop
                        style="display:flex;align-items:center;gap:6px;padding:7px 14px;background:{{ $color }}12;border:1.5px solid {{ $color }}30;border-radius:9px;font-size:12.5px;font-weight:600;color:{{ $color }};text-decoration:none;">
                        <i class="bi bi-plus-circle"></i> Tambah Bab
                    </a>
                    <i class="bi bi-chevron-down" style="color:#94a3b8;font-size:13px;transition:transform .2s;"
                        :style="open ? 'transform:rotate(180deg)' : ''"></i>
                </div>
            </div>

            {{-- Materi table --}}
            <div x-show="open" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                style="margin-top:4px;">

                @if ($materis->count())
                    <div style="background:#fff;border-radius:12px;border:1px solid #e9edf2;overflow:hidden;">
                        <table style="width:100%;border-collapse:collapse;font-size:13px;">
                            <thead>
                                <tr style="background:#f8fafc;border-bottom:1.5px solid #e9edf2;">
                                    <th
                                        style="padding:10px 16px;text-align:center;width:40px;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;">
                                        #</th>
                                    <th
                                        style="padding:10px 16px;text-align:left;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;">
                                        Judul Bab</th>
                                    <th
                                        style="padding:10px 16px;text-align:center;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;">
                                        Urutan</th>
                                    <th
                                        style="padding:10px 16px;text-align:center;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;">
                                        Soal</th>
                                    <th
                                        style="padding:10px 16px;text-align:center;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;">
                                        Status</th>
                                    <th
                                        style="padding:10px 16px;text-align:center;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materis as $i => $materi)
                                    <tr style="border-bottom:{{ $loop->last ? 'none' : '1px solid #f1f5f9' }};transition:background .15s;"
                                        onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">

                                        <td
                                            style="padding:13px 16px;text-align:center;color:#94a3b8;font-weight:600;font-size:12px;">
                                            {{ $i + 1 }}
                                        </td>

                                        <td style="padding:13px 16px;">
                                            <div style="display:flex;align-items:center;gap:11px;">
                                                <div
                                                    style="width:36px;height:36px;border-radius:9px;background:linear-gradient(135deg,{{ $color }},{{ $color }}aa);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                    <i class="bi bi-journal-richtext"
                                                        style="color:#fff;font-size:15px;"></i>
                                                </div>
                                                <div>
                                                    <div style="font-weight:600;color:#0f172a;">{{ $materi->judul }}</div>
                                                    @if ($materi->deskripsi)
                                                        <div
                                                            style="font-size:11.5px;color:#94a3b8;margin-top:1px;max-width:320px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                                            {{ $materi->deskripsi }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td style="padding:13px 16px;text-align:center;">
                                            <span
                                                style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;background:#eff6ff;color:#1a56db;border-radius:7px;font-size:12px;font-weight:700;">
                                                {{ $materi->urutan }}
                                            </span>
                                        </td>

                                        <td style="padding:13px 16px;text-align:center;">
                                            <span
                                                style="background:#f1f5f9;color:#475569;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;">
                                                {{ $materi->soals_count }} soal
                                            </span>
                                        </td>

                                        <td style="padding:13px 16px;text-align:center;">
                                            <span
                                                style="padding:4px 12px;border-radius:20px;font-size:11.5px;font-weight:600;
                                            background:{{ $materi->soals_count > 0 ? '#f0fdf4' : '#fef9c3' }};
                                            color:{{ $materi->soals_count > 0 ? '#15803d' : '#a16207' }};">
                                                {{ $materi->soals_count > 0 ? 'Aktif' : 'Kosong' }}
                                            </span>
                                        </td>

                                        <td style="padding:13px 16px;text-align:center;">
                                            <div style="display:flex;align-items:center;justify-content:center;gap:5px;">
                                                {{-- Kelola Soal --}}
                                                <a href="{{ route('guru.soal.index', $materi) }}"
                                                    style="width:30px;height:30px;border-radius:7px;background:#eef2ff;color:#4f46e5;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:13px;"
                                                    title="Kelola Soal">
                                                    <i class="bi bi-patch-question"></i>
                                                </a>
                                                {{-- Edit --}}
                                                <a href="{{ route('guru.materi.edit', [$mapel, $materi]) }}"
                                                    style="width:30px;height:30px;border-radius:7px;background:#fffbeb;color:#b45309;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:13px;"
                                                    title="Edit Bab">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                {{-- Hapus --}}
                                                <form method="POST"
                                                    action="{{ route('guru.materi.destroy', [$mapel, $materi]) }}"
                                                    onsubmit="return confirm('Hapus bab {{ addslashes($materi->judul) }}? Semua soal di dalamnya akan ikut terhapus.')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        style="width:30px;height:30px;border-radius:7px;background:#fef2f2;color:#b91c1c;border:none;cursor:pointer;font-size:13px;display:flex;align-items:center;justify-content:center;"
                                                        title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div
                        style="background:#fff;border-radius:12px;border:2px dashed #e2e8f0;padding:32px;text-align:center;color:#94a3b8;">
                        <i class="bi bi-journal-x"
                            style="font-size:28px;display:block;margin-bottom:8px;color:#cbd5e1;"></i>
                        <div style="font-size:13px;font-weight:500;margin-bottom:8px;">Belum ada bab untuk mapel ini</div>
                        <a href="{{ route('guru.materi.create', $mapel) }}"
                            style="font-size:12.5px;color:{{ $color }};font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
                            <i class="bi bi-plus-circle"></i> Tambah bab pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>

    @empty
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:64px;text-align:center;color:#94a3b8;">
            <i class="bi bi-collection" style="font-size:40px;display:block;margin-bottom:14px;"></i>
            <div style="font-size:15px;font-weight:600;color:#374151;margin-bottom:6px;">Belum ada mata pelajaran</div>
            <div style="font-size:13px;margin-bottom:16px;">Buat mata pelajaran terlebih dahulu sebelum menambahkan materi.
            </div>
            <a href="{{ route('guru.mapel.create') }}"
                style="display:inline-flex;align-items:center;gap:7px;padding:9px 20px;background:#1a56db;color:#fff;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;">
                <i class="bi bi-plus-circle"></i> Buat Mata Pelajaran
            </a>
        </div>
    @endforelse

@endsection
