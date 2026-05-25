@extends('layouts.guru')
@section('title', 'Manajemen Kelas')
@section('page-title', 'Manajemen Kelas')
@section('page-subtitle')kelola data kelas dan siswa @endsection

@section('topbar-actions')
    <a href="{{ route('guru.kelas.create') }}"
        style="display:flex;align-items:center;gap:7px;padding:9px 18px;background:#1a56db;color:#fff;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;">
        <i class="bi bi-plus-lg"></i> Tambah Kelas
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

    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-bottom:20px;">
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:20px;display:flex;align-items:center;gap:14px;">
            <div
                style="width:44px;height:44px;border-radius:11px;background:#1a56db;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-building" style="color:#fff;font-size:20px;"></i>
            </div>
            <div>
                <div style="font-size:24px;font-weight:900;color:#0f172a;">{{ $totalKelas }}</div>
                <div style="font-size:12px;color:#64748b;">Total Kelas</div>
            </div>
        </div>
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:20px;display:flex;align-items:center;gap:14px;">
            <div
                style="width:44px;height:44px;border-radius:11px;background:#0f766e;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-people-fill" style="color:#fff;font-size:20px;"></i>
            </div>
            <div>
                <div style="font-size:24px;font-weight:900;color:#0f172a;">{{ $totalSiswa }}</div>
                <div style="font-size:12px;color:#64748b;">Total Siswa</div>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('guru.kelas.index') }}"
        style="background:#fff;border-radius:12px;border:1px solid #e9edf2;padding:14px 18px;margin-bottom:16px;display:flex;gap:10px;">
        <div
            style="flex:1;display:flex;align-items:center;gap:9px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:9px;padding:8px 14px;">
            <i class="bi bi-search" style="color:#94a3b8;font-size:14px;"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kelas..."
                style="border:none;background:transparent;outline:none;font-size:13px;color:#0f172a;width:100%;">
        </div>
        <button type="submit"
            style="padding:8px 18px;background:#1a56db;color:#fff;border:none;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;">
            Cari
        </button>
        @if (request('search'))
            <a href="{{ route('guru.kelas.index') }}"
                style="padding:8px 14px;background:#f1f5f9;color:#374151;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;">
                Reset
            </a>
        @endif
    </form>

    {{-- Table --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;overflow:hidden;">
        <div
            style="padding:14px 20px;border-bottom:1px solid #f1f5f9;background:#f8fafc;display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:12px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:.06em;">
                Daftar Kelas
            </span>
            <span style="font-size:12px;color:#64748b;">{{ $kelasList->total() }} kelas ditemukan</span>
        </div>

        @forelse ($kelasList as $kelas)
            <div style="padding:14px 20px;border-bottom:1px solid #f8fafc;display:flex;align-items:center;gap:14px;"
                onmouseover="this.style.background='#fafbff'" onmouseout="this.style.background=''">

                {{-- Ikon --}}
                <div
                    style="width:40px;height:40px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-building" style="color:#1a56db;font-size:17px;"></i>
                </div>

                {{-- Info --}}
                <div style="flex:1;">
                    <div style="font-size:14px;font-weight:700;color:#0f172a;">{{ $kelas->nama }}</div>
                    <div style="font-size:12px;color:#64748b;margin-top:2px;">
                        <i class="bi bi-people" style="margin-right:3px;"></i>
                        {{ $kelas->siswa_count }} siswa terdaftar
                    </div>
                </div>

                {{-- Badge --}}
                <span
                    style="padding:4px 12px;background:#eff6ff;color:#1a56db;border-radius:20px;font-size:11.5px;font-weight:600;">
                    {{ $kelas->siswa_count }} siswa
                </span>

                {{-- Actions --}}
                <div style="display:flex;gap:6px;">
                    <a href="{{ route('guru.kelas.edit', $kelas) }}"
                        style="padding:7px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:12.5px;font-weight:600;color:#374151;text-decoration:none;display:flex;align-items:center;gap:5px;">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('guru.kelas.destroy', $kelas) }}"
                        onsubmit="return confirm('Hapus kelas {{ $kelas->nama }}? Kelas yang masih memiliki siswa tidak bisa dihapus.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            style="padding:7px 14px;border:1.5px solid #fecaca;border-radius:8px;font-size:12.5px;font-weight:600;color:#dc2626;background:#fef2f2;cursor:pointer;display:flex;align-items:center;gap:5px;">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div style="padding:48px;text-align:center;color:#94a3b8;">
                <i class="bi bi-building" style="font-size:36px;display:block;margin-bottom:10px;"></i>
                <div style="font-size:14px;font-weight:500;">Belum ada kelas</div>
                <div style="font-size:12.5px;margin-top:5px;">
                    <a href="{{ route('guru.kelas.create') }}" style="color:#1a56db;font-weight:600;">Buat kelas
                        pertama</a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($kelasList->hasPages())
        <div style="margin-top:16px;">{{ $kelasList->links() }}</div>
    @endif

@endsection
