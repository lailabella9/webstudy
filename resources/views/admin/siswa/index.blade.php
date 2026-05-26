@extends('layouts.admin')

@section('title', 'Kelola Data Siswa')
@section('page-title', 'Kelola Data Siswa')
@section('page-subtitle', 'Manajemen akun siswa di platform')

@section('topbar-actions')
    <a href="{{ route('admin.siswa.create') }}" class="btn-primary-sm">
        <i class="bi bi-plus-lg"></i> Tambah Siswa
    </a>
@endsection

@section('content')

{{-- Tabs Kelas --}}
<div style="display:flex;gap:8px;margin-bottom:20px;overflow-x:auto;padding-bottom:5px;">
    <a href="{{ route('admin.siswa.index') }}" 
       style="padding:8px 16px;border-radius:20px;font-size:13px;font-weight:600;text-decoration:none;white-space:nowrap;
              {{ request('kelas') == '' && empty($activeKelasId) ? 'background:#1a56db;color:#fff;' : 'background:#fff;color:#64748b;border:1px solid #e2e8f0;' }}">
        Semua Siswa
    </a>
    @foreach($kelasList as $kelas)
        <a href="{{ route('admin.siswa.index', ['kelas' => $kelas->Id_kelas]) }}" 
           style="padding:8px 16px;border-radius:20px;font-size:13px;font-weight:600;text-decoration:none;white-space:nowrap;
                  {{ $activeKelasId == $kelas->Id_kelas ? 'background:#1a56db;color:#fff;' : 'background:#fff;color:#64748b;border:1px solid #e2e8f0;' }}">
            Kelas {{ $kelas->nama }}
        </a>
    @endforeach
</div>

<div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;overflow:hidden;">
    <div style="padding:16px 20px;border-bottom:1px solid #e9edf2;background:#f8fafc;display:flex;justify-content:space-between;align-items:center;">
        <div style="font-size:14px;font-weight:700;color:#0f172a;">Daftar Akun Siswa</div>
    </div>
    
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;text-align:left;font-size:13.5px;">
            <thead>
                <tr style="background:#f1f5f9;border-bottom:2px solid #e2e8f0;color:#475569;">
                    <th style="padding:12px 20px;font-weight:600;">No</th>
                    <th style="padding:12px 20px;font-weight:600;">Nama Lengkap</th>
                    <th style="padding:12px 20px;font-weight:600;">Email</th>
                    <th style="padding:12px 20px;font-weight:600;">Kelas</th>
                    <th style="padding:12px 20px;font-weight:600;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $siswa)
                    <tr style="border-bottom:1px solid #e9edf2;">
                        <td style="padding:14px 20px;color:#64748b;">{{ $loop->iteration }}</td>
                        <td style="padding:14px 20px;font-weight:600;color:#0f172a;">{{ $siswa->nama }}</td>
                        <td style="padding:14px 20px;color:#475569;">{{ $siswa->email }}</td>
                        <td style="padding:14px 20px;font-weight:600;color:#1a56db;">{{ $siswa->kelas->nama ?? '-' }}</td>
                        <td style="padding:14px 20px;text-align:center;">
                            <div style="display:inline-flex;gap:6px;flex-wrap:wrap;">
                                <a href="{{ route('admin.siswa.edit', $siswa) }}" style="display:inline-flex;align-items:center;gap:4px;padding:6px 12px;border-radius:6px;background:#dbeafe;border:1px solid #bfdbfe;color:#1d4ed8;font-size:12px;font-weight:600;text-decoration:none;"
                                   onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'" title="Edit">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:#fee2e2;border:1px solid #fecaca;cursor:pointer;padding:6px 12px;border-radius:6px;color:#b91c1c;font-size:12px;font-weight:600;display:flex;align-items:center;gap:4px;"
                                            onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'" title="Hapus">
                                        <i class="bi bi-trash-fill"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding:40px;text-align:center;color:#94a3b8;">
                            <i class="bi bi-inbox" style="font-size:32px;display:block;margin-bottom:8px;color:#cbd5e1;"></i>
                            Belum ada data siswa di kelas ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
