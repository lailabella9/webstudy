@extends('layouts.admin')

@section('title', 'Kelola Data Guru')
@section('page-title', 'Kelola Data Guru')
@section('page-subtitle', 'Manajemen akun pengajar di platform')

@section('topbar-actions')
    <a href="{{ route('admin.guru.create') }}" class="btn-primary-sm">
        <i class="bi bi-plus-lg"></i> Tambah Guru
    </a>
@endsection

@section('content')
<div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;overflow:hidden;">
    <div style="padding:16px 20px;border-bottom:1px solid #e9edf2;background:#f8fafc;display:flex;justify-content:space-between;align-items:center;">
        <div style="font-size:14px;font-weight:700;color:#0f172a;">Daftar Akun Guru</div>
    </div>
    
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;text-align:left;font-size:13.5px;">
            <thead>
                <tr style="background:#f1f5f9;border-bottom:2px solid #e2e8f0;color:#475569;">
                    <th style="padding:12px 20px;font-weight:600;">No</th>
                    <th style="padding:12px 20px;font-weight:600;">Nama Lengkap</th>
                    <th style="padding:12px 20px;font-weight:600;">Email</th>
                    <th style="padding:12px 20px;font-weight:600;">Status</th>
                    <th style="padding:12px 20px;font-weight:600;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gurus as $guru)
                    <tr style="border-bottom:1px solid #e9edf2;">
                        <td style="padding:14px 20px;color:#64748b;">{{ $loop->iteration }}</td>
                        <td style="padding:14px 20px;font-weight:600;color:#0f172a;">{{ $guru->nama }}</td>
                        <td style="padding:14px 20px;color:#475569;">{{ $guru->email }}</td>
                        <td style="padding:14px 20px;">
                            @if($guru->is_active)
                                <span style="padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#dcfce7;color:#166534;">Aktif</span>
                            @else
                                <span style="padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#fee2e2;color:#991b1b;">Non-Aktif</span>
                            @endif
                        </td>
                        <td style="padding:14px 20px;text-align:center;">
                            <div style="display:inline-flex;gap:6px;flex-wrap:wrap;">
                                <form action="{{ route('admin.guru.toggle-status', $guru) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background:{{ $guru->is_active ? '#fef3c7' : '#d1fae5' }};border:1px solid {{ $guru->is_active ? '#fde68a' : '#a7f3d0' }};cursor:pointer;padding:6px 12px;border-radius:6px;color:{{ $guru->is_active ? '#d97706' : '#059669' }};font-size:12px;font-weight:600;display:flex;align-items:center;gap:4px;"
                                        onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'"
                                        title="{{ $guru->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="bi bi-{{ $guru->is_active ? 'pause-circle-fill' : 'play-circle-fill' }}"></i>
                                        {{ $guru->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>

                                <a href="{{ route('admin.guru.show', $guru) }}" style="display:inline-flex;align-items:center;gap:4px;padding:6px 12px;border-radius:6px;background:#e0e7ff;border:1px solid #c7d2fe;color:#4338ca;font-size:12px;font-weight:600;text-decoration:none;"
                                   onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'" title="Detail">
                                    <i class="bi bi-eye-fill"></i> Detail
                                </a>

                                <a href="{{ route('admin.guru.edit', $guru) }}" style="display:inline-flex;align-items:center;gap:4px;padding:6px 12px;border-radius:6px;background:#dbeafe;border:1px solid #bfdbfe;color:#1d4ed8;font-size:12px;font-weight:600;text-decoration:none;"
                                   onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'" title="Edit">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus guru ini?')">
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
                            Belum ada data guru.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
