@extends('layouts.guru')
@section('title', 'Kelola Data Siswa')
@section('page-title', 'Kelola Data Siswa')
@section('page-subtitle', 'Pantau dan kelola akun siswa')

@section('topbar-actions')
    {{-- <a href="{{ route('guru.kelas.index') }}" class="btn-icon-sm" title="Kelola Kelas">
        <i class="bi bi-grid-3x3-gap"></i>
    </a> --}}
    <a href="{{ route('guru.siswa.create') }}" class="btn-primary-sm">
        <i class="bi bi-person-plus"></i> Tambah Siswa
    </a>
@endsection

@section('content')

    {{-- Alert --}}
    @if (session('success'))
        <div
            style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;gap:10px;font-size:13px;color:#15803d;">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div
            style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;gap:10px;font-size:13px;color:#b91c1c;">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Stat Cards --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:20px;">
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:16px 20px;display:flex;align-items:center;gap:14px;">
            <div
                style="width:44px;height:44px;border-radius:11px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-people-fill" style="font-size:20px;color:#1a56db;"></i>
            </div>
            <div>
                <div style="font-size:22px;font-weight:800;color:#0f172a;">{{ $totalSiswa }}</div>
                <div style="font-size:11.5px;color:#64748b;">Total Siswa</div>
            </div>
        </div>
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:16px 20px;display:flex;align-items:center;gap:14px;">
            <div
                style="width:44px;height:44px;border-radius:11px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-check-circle-fill" style="font-size:20px;color:#16a34a;"></i>
            </div>
            <div>
                <div style="font-size:22px;font-weight:800;color:#0f172a;">{{ $siswaAktif }}</div>
                <div style="font-size:11.5px;color:#64748b;">Sudah Berlatih</div>
            </div>
        </div>
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:16px 20px;display:flex;align-items:center;gap:14px;">
            <div
                style="width:44px;height:44px;border-radius:11px;background:#fef9c3;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-clock-history" style="font-size:20px;color:#ca8a04;"></i>
            </div>
            <div>
                <div style="font-size:22px;font-weight:800;color:#0f172a;">{{ $siswaBelum }}</div>
                <div style="font-size:11.5px;color:#64748b;">Belum Berlatih</div>
            </div>
        </div>
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:16px 20px;display:flex;align-items:center;gap:14px;">
            <div
                style="width:44px;height:44px;border-radius:11px;background:#eef2ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-graph-up-arrow" style="font-size:20px;color:#4f46e5;"></i>
            </div>
            <div>
                <div style="font-size:22px;font-weight:800;color:#0f172a;">{{ number_format($rataRata, 0) }}%</div>
                <div style="font-size:11.5px;color:#64748b;">Rata-rata Nilai</div>
            </div>
        </div>
    </div>

    {{-- Filter bar --}}
    <div style="display:flex; align-items:center; gap:10px; margin-bottom:18px; flex-wrap:wrap;">
        <form method="GET" style="display:flex;gap:10px;flex:1;flex-wrap:wrap;align-items:center;">

            {{-- SEARCH --}}
            <div style="position:relative; min-width:220px;">
                <i class="bi bi-search"
                    style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..."
                    style="width:100%;height:38px;border:1.5px solid #e2e8f0;border-radius:9px;padding:0 12px 0 34px;font-size:13px;outline:none;font-family:inherit;"
                    onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
            </div>

            {{-- FILTER KELAS --}}
            <select name="kelas_id"
                style="height:38px;padding:0 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;color:#374151;outline:none;font-family:inherit;background:#fff;min-width:140px;">
                <option value="">Semua Kelas</option>
                @foreach ($kelasList as $k)
                    <option value="{{ $k->Id_kelas }}" {{ request('kelas_id') == $k->Id_kelas ? 'selected' : '' }}>
                        {{ $k->nama }}
                    </option>
                @endforeach
            </select>

            {{-- SORT --}}
            <select name="sort"
                style="height:38px;padding:0 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;color:#374151;outline:none;font-family:inherit;background:#fff;">
                <option value="">Urutkan</option>
                <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A–Z</option>
                <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z–A</option>
                <option value="nilai_tertinggi"{{ request('sort') == 'nilai_tertinggi' ? 'selected' : '' }}>Nilai Tertinggi
                </option>
                <option value="nilai_terendah" {{ request('sort') == 'nilai_terendah' ? 'selected' : '' }}>Nilai Terendah
                </option>
                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
            </select>

            <button type="submit"
                style="height:38px;padding:0 18px;border-radius:9px;background:#1a56db;color:#fff;border:none;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;">
                Terapkan
            </button>

            @if (request()->hasAny(['search', 'sort', 'kelas_id']))
                <a href="{{ route('guru.siswa.index') }}"
                    style="height:38px;padding:0 14px;border-radius:9px;background:#fff;border:1.5px solid #e2e8f0;display:flex;align-items:center;font-size:13px;color:#64748b;text-decoration:none;gap:5px;">
                    <i class="bi bi-x"></i> Reset
                </a>
            @endif
        </form>

        <div style="display:flex;gap:8px;">
            <a href="{{ route('guru.siswa.exportcsv', request()->query()) }}"
                style="height:38px;padding:0 16px;border:1.5px solid #e2e8f0;border-radius:9px;background:#fff;font-size:13px;font-weight:500;color:#374151;cursor:pointer;display:flex;align-items:center;gap:6px;text-decoration:none;white-space:nowrap;">
                <i class="bi bi-filetype-csv" style="color:#16a34a;"></i>
                Export CSV
            </a>

            <a href="{{ route('guru.siswa.exportpdf', request()->query()) }}"
                style="height:38px;padding:0 16px;border:1.5px solid #e2e8f0;border-radius:9px;background:#fff;font-size:13px;font-weight:500;color:#374151;cursor:pointer;display:flex;align-items:center;gap:6px;text-decoration:none;white-space:nowrap;">
                <i class="bi bi-file-earmark-pdf" style="color:#dc2626;"></i>
                Export PDF
            </a>
        </div>
    </div>

    {{-- Tabel --}}
    <div style="background:#fff; border-radius:14px; border:1px solid #e9edf2; overflow:hidden;">
        <table style="width:100%; border-collapse:collapse; font-size:13px;">
            <thead>
                <tr style="background:#f8fafc; border-bottom:1.5px solid #e9edf2;">
                    <th
                        style="padding:12px 14px; text-align:center; width:44px; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">
                        No</th>
                    <th style="padding:12px 14px; width:40px;"></th>
                    <th
                        style="padding:12px 14px; text-align:left; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.05em;">
                        Nama Siswa</th>
                    <th
                        style="padding:12px 14px; text-align:center; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.05em;">
                        Kelas</th>
                    <th
                        style="padding:12px 14px; text-align:left; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.05em;">
                        Email</th>
                    <th
                        style="padding:12px 14px; text-align:center; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.05em;">
                        Nilai Rata-rata</th>
                    <th
                        style="padding:12px 14px; text-align:center; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.05em;">
                        Status</th>
                    <th
                        style="padding:12px 14px; text-align:center; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.05em;">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa as $i => $s)
                    @php
                        $avatarColors = ['#1a56db', '#7c3aed', '#0f766e', '#b45309', '#be185d', '#0369a1'];
                        $avatarBg = $avatarColors[crc32($s->nama) % count($avatarColors)];
                        $initials = strtoupper(substr($s->nama, 0, 1));
                        $nilai = $s->nilai_rata ?? 0;
                        $aktif = $s->jumlah_jawaban > 0;
                    @endphp
                    <tr style="border-bottom:1px solid #f1f5f9; transition:background .15s;"
                        onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">

                        {{-- No --}}
                        <td style="padding:13px 14px; text-align:center; color:#94a3b8; font-weight:600; font-size:12px;">
                            {{ $siswa->firstItem() + $i }}
                        </td>

                        {{-- Avatar --}}
                        <td style="padding:13px 14px;">
                            <div
                                style="width:34px;height:34px;border-radius:50%;background:{{ $avatarBg }};display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;overflow:hidden;flex-shrink:0;">
                                @if ($s->foto_profil)
                                    <img src="{{ asset('storage/' . $s->foto_profil) }}"
                                        style="width:100%;height:100%;object-fit:cover;" alt="">
                                @else
                                    {{ $initials }}
                                @endif
                            </div>
                        </td>

                        {{-- Nama --}}
                        <td style="padding:13px 14px;">
                            <div style="font-weight:600;color:#0f172a;">{{ $s->nama }}</div>
                            <div style="font-size:11px;color:#94a3b8;margin-top:1px;">Bergabung
                                {{ $s->created_at->format('d M Y') }}</div>
                        </td>

                        {{-- Kelas --}}
                        <td style="padding:13px 14px; text-align:center;">
                            @if ($s->kelas)
                                <span
                                    style="display:inline-block;padding:3px 10px;border-radius:20px;background:#eff6ff;color:#1e3a8a;font-size:11px;font-weight:600;white-space:nowrap;">
                                    {{ $s->kelas->nama }}
                                </span>
                            @else
                                <span style="font-size:12px;color:#94a3b8;">—</span>
                            @endif
                        </td>

                        {{-- Email --}}
                        <td style="padding:13px 14px; color:#475569; font-size:12px;">{{ $s->email }}</td>

                        {{-- Nilai --}}
                        <td style="padding:13px 14px; text-align:center;">
                            @if ($aktif)
                                <div style="display:flex;align-items:center;gap:6px;justify-content:center;">
                                    <div
                                        style="flex:1;height:6px;background:#f1f5f9;border-radius:99px;overflow:hidden;max-width:60px;">
                                        <div
                                            style="height:100%;width:{{ min($nilai, 100) }}%;background:{{ $nilai >= 60 ? '#22c55e' : ($nilai >= 40 ? '#f59e0b' : '#ef4444') }};border-radius:99px;">
                                        </div>
                                    </div>
                                    <span
                                        style="font-size:12px;font-weight:700;color:{{ $nilai >= 60 ? '#16a34a' : ($nilai >= 40 ? '#ca8a04' : '#b91c1c') }};">{{ round($nilai) }}%</span>
                                </div>
                            @else
                                <span style="font-size:12px;color:#94a3b8;">—</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td style="padding:13px 14px; text-align:center;">
                            <span
                                style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;background:{{ $aktif ? '#f0fdf4' : '#f8fafc' }};color:{{ $aktif ? '#15803d' : '#64748b' }};">
                                {{ $aktif ? 'Aktif' : 'Belum' }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:13px 14px; text-align:center;">
                            <div style="display:flex; align-items:center; justify-content:center; gap:5px;">
                                <a href="{{ route('guru.siswa.show', $s) }}"
                                    style="width:30px;height:30px;border-radius:7px;background:#eff6ff;color:#1a56db;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:13px;"
                                    title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('guru.siswa.edit', $s) }}"
                                    style="width:30px;height:30px;border-radius:7px;background:#fffbeb;color:#b45309;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:13px;"
                                    title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('guru.siswa.destroy', $s) }}"
                                    onsubmit="return confirm('Hapus akun {{ addslashes($s->nama) }}?')">
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
                @empty
                    <tr>
                        <td colspan="8" style="padding:48px;text-align:center;color:#94a3b8;">
                            <i class="bi bi-people" style="font-size:36px;display:block;margin-bottom:10px;"></i>
                            <div style="font-size:14px;font-weight:500;">Belum ada siswa terdaftar</div>
                            <a href="{{ route('guru.siswa.create') }}"
                                style="font-size:13px;color:#1a56db;font-weight:600;margin-top:8px;display:inline-block;">+
                                Tambah siswa pertama</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($siswa->hasPages())
            <div style="padding:14px 16px; border-top:1px solid #f1f5f9; display:flex; justify-content:flex-end;">
                {{ $siswa->withQueryString()->links() }}
            </div>
        @endif
    </div>

@endsection
