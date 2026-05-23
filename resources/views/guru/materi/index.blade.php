@extends('layouts.guru')
@section('title', 'Manajemen Materi')
@section('page-title', 'Manajemen Materi')
@section('page-subtitle')kelola bab dan konten pembelajaran @endsection

@section('topbar-actions')
    <a href="{{ route('guru.materi.create') }}"
        style="display:flex;align-items:center;gap:7px;padding:9px 18px;background:linear-gradient(135deg,#1a56db,#4f46e5);color:#fff;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;">
        <i class="bi bi-plus-lg"></i> Tambah Materi
    </a>
@endsection

@section('content')

    @if (session('success'))
        <div
            style="background:#f0fdf4;border:1px solid #86efac;border-radius:10px;padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;gap:10px;font-size:13px;color:#15803d;">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div
            style="background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;gap:10px;font-size:13px;color:#b91c1c;">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Filter --}}
    <form method="GET" action="{{ route('guru.materi.index') }}"
        style="background:#fff;border-radius:12px;border:1px solid #e9edf2;padding:14px 18px;margin-bottom:16px;display:flex;gap:10px;flex-wrap:wrap;">

        {{-- Search --}}
        <div
            style="flex:1;min-width:200px;display:flex;align-items:center;gap:9px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:9px;padding:8px 14px;">
            <i class="bi bi-search" style="color:#94a3b8;font-size:14px;"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul materi..."
                style="border:none;background:transparent;outline:none;font-size:13px;color:#0f172a;width:100%;">
        </div>

        {{-- Filter Kelas --}}
        <select name="kelas_id"
            style="padding:8px 14px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;color:#374151;background:#f8fafc;outline:none;font-family:inherit;cursor:pointer;">
            <option value="">Semua Kelas</option>
            @foreach ($kelasList as $kelas)
                <option value="{{ $kelas->Id_kelas }}" {{ request('kelas_id') == $kelas->Id_kelas ? 'selected' : '' }}>
                    {{ $kelas->nama }}
                </option>
            @endforeach
        </select>

        {{-- Filter Mapel --}}
        <select name="mapel_id"
            style="padding:8px 14px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;color:#374151;background:#f8fafc;outline:none;font-family:inherit;cursor:pointer;">
            <option value="">Semua Mata Pelajaran</option>
            @foreach ($mapelList as $mp)
                <option value="{{ $mp->Id_mapel }}" {{ request('mapel_id') == $mp->Id_mapel ? 'selected' : '' }}>
                    {{ $mp->nama }} ({{ $mp->kelas->nama ?? '-' }})
                </option>
            @endforeach
        </select>

        <button type="submit"
            style="padding:8px 18px;background:#1a56db;color:#fff;border:none;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;">
            Filter
        </button>
        @if (request()->hasAny(['search', 'kelas_id', 'mapel_id']))
            <a href="{{ route('guru.materi.index') }}"
                style="padding:8px 14px;background:#f1f5f9;color:#374151;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;">
                Reset
            </a>
        @endif
    </form>

    {{-- Tabel Materi --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;overflow:hidden;">
        <div
            style="padding:14px 20px;border-bottom:1px solid #f1f5f9;background:#f8fafc;display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:12px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:.06em;">Daftar
                Materi</span>
            <span style="font-size:12px;color:#64748b;">{{ $materis->total() }} materi</span>
        </div>

        @forelse ($materis as $materi)
            @php
                $colors = ['#1a56db', '#4f46e5', '#0f766e', '#b45309', '#be185d', '#0369a1'];
                $idx = crc32($materi->mataPelajaran->nama ?? '') % 6;
                $c = $colors[$idx];
            @endphp
            <div style="padding:14px 20px;border-bottom:1px solid #f8fafc;display:flex;align-items:center;gap:14px;"
                onmouseover="this.style.background='#fafbff'" onmouseout="this.style.background=''">

                {{-- Ikon --}}
                <div
                    style="width:42px;height:42px;border-radius:10px;background:{{ $c }}15;border:1px solid {{ $c }}30;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-journal-richtext" style="color:{{ $c }};font-size:17px;"></i>
                </div>

                {{-- Info --}}
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                        <span style="font-size:14px;font-weight:700;color:#0f172a;">{{ $materi->judul }}</span>
                        <span
                            style="font-size:11px;background:{{ $c }}15;color:{{ $c }};padding:2px 9px;border-radius:20px;font-weight:600;">
                            Urutan {{ $materi->urutan }}
                        </span>
                        @if ($materi->file_materi)
                            <span
                                style="font-size:11px;background:#f0fdf4;color:#16a34a;padding:2px 9px;border-radius:20px;font-weight:600;">
                                <i class="bi bi-paperclip"></i> Ada File
                            </span>
                        @endif
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;margin-top:4px;flex-wrap:wrap;">
                        <span style="font-size:12px;color:#64748b;">
                            <i class="bi bi-book" style="margin-right:2px;"></i>
                            {{ $materi->mataPelajaran->nama ?? '—' }}
                        </span>
                        <span style="font-size:12px;color:#94a3b8;">·</span>
                        <span style="font-size:12px;color:#64748b;">
                            <i class="bi bi-building" style="margin-right:2px;"></i>
                            {{ $materi->mataPelajaran->kelas->nama ?? '—' }}
                        </span>
                        <span style="font-size:12px;color:#94a3b8;">·</span>
                        <span style="font-size:12px;color:#64748b;">
                            <i class="bi bi-patch-question" style="margin-right:2px;"></i>
                            {{ $materi->soals_count ?? $materi->soals()->count() }} soal
                        </span>
                    </div>
                    @if ($materi->deskripsi)
                        <div
                            style="font-size:12px;color:#94a3b8;margin-top:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:500px;">
                            {{ $materi->deskripsi }}
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div style="display:flex;gap:6px;flex-shrink:0;">
                    <a href="{{ route('guru.materi.show', $materi) }}"
                        style="padding:7px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:12px;font-weight:600;color:#64748b;text-decoration:none;display:flex;align-items:center;gap:4px;">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('guru.materi.edit', $materi) }}"
                        style="padding:7px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:12.5px;font-weight:600;color:#374151;text-decoration:none;display:flex;align-items:center;gap:5px;">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('guru.materi.destroy', $materi) }}"
                        onsubmit="return confirm('Hapus materi {{ $materi->judul }}? Semua soal terkait juga akan dihapus.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            style="padding:7px 14px;border:1.5px solid #fecaca;border-radius:8px;font-size:12.5px;font-weight:600;color:#dc2626;background:#fef2f2;cursor:pointer;display:flex;align-items:center;gap:5px;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div style="padding:48px;text-align:center;color:#94a3b8;">
                <i class="bi bi-journal-x" style="font-size:36px;display:block;margin-bottom:10px;"></i>
                <div style="font-size:14px;font-weight:500;">Belum ada materi</div>
                <div style="font-size:12.5px;margin-top:5px;">
                    <a href="{{ route('guru.materi.create') }}" style="color:#1a56db;font-weight:600;">Buat materi
                        pertama</a>
                </div>
            </div>
        @endforelse
    </div>

    @if ($materis->hasPages())
        <div style="margin-top:16px;">{{ $materis->links() }}</div>
    @endif

@endsection
