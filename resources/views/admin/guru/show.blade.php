@extends('layouts.admin')

@section('title', 'Detail Data Guru')
@section('page-title', 'Detail Data Guru')
@section('page-subtitle', 'Informasi lengkap akun pengajar')

@section('topbar-actions')
    <a href="{{ route('admin.guru.index') }}" class="btn-icon-sm" title="Kembali" style="margin-right: 8px;">
        <i class="bi bi-arrow-left"></i>
    </a>
    <a href="{{ route('admin.guru.edit', $guru) }}" class="btn-primary-sm">
        <i class="bi bi-pencil-square"></i> Edit Data
    </a>
@endsection

@section('content')
<div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:32px;max-width:800px;display:flex;gap:32px;flex-wrap:wrap;">
    
    {{-- Foto Profil --}}
    <div style="flex-shrink:0;">
        <div style="width:140px;height:140px;border-radius:16px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;overflow:hidden;border:1px solid #e2e8f0;">
            @if ($guru->foto_profil)
                <img src="{{ asset('storage/' . $guru->foto_profil) }}" alt="{{ $guru->nama }}" style="width:100%;height:100%;object-fit:cover;">
            @else
                <span style="font-size:48px;font-weight:800;color:#94a3b8;">
                    {{ strtoupper(substr($guru->nama, 0, 1)) }}
                </span>
            @endif
        </div>
        <div style="text-align:center;margin-top:16px;">
            @if($guru->is_active)
                <span style="padding:6px 14px;border-radius:20px;font-size:12px;font-weight:700;background:#dcfce7;color:#166534;display:inline-block;">Aktif Mengajar</span>
            @else
                <span style="padding:6px 14px;border-radius:20px;font-size:12px;font-weight:700;background:#fee2e2;color:#991b1b;display:inline-block;">Dinonaktifkan</span>
            @endif
        </div>
    </div>

    {{-- Detail Informasi --}}
    <div style="flex:1;min-width:300px;">
        <div style="margin-bottom:24px;">
            <h2 style="font-size:22px;font-weight:800;color:#0f172a;margin-bottom:4px;">{{ $guru->nama }}</h2>
            <div style="font-size:14px;color:#64748b;">Pengajar / Guru</div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
            <div>
                <div style="font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px;">Alamat Email</div>
                <div style="font-size:14.5px;color:#0f172a;font-weight:600;">
                    <i class="bi bi-envelope-fill" style="color:#1a56db;margin-right:6px;"></i> {{ $guru->email }}
                </div>
            </div>

            <div>
                <div style="font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px;">Terdaftar Sejak</div>
                <div style="font-size:14.5px;color:#0f172a;font-weight:600;">
                    <i class="bi bi-calendar-check-fill" style="color:#1a56db;margin-right:6px;"></i> {{ $guru->created_at ? $guru->created_at->format('d M Y') : '-' }}
                </div>
            </div>

            <div>
                <div style="font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px;">Materi Dibuat</div>
                <div style="font-size:14.5px;color:#0f172a;font-weight:600;">
                    <i class="bi bi-journal-text" style="color:#1a56db;margin-right:6px;"></i> {{ $guru->materis()->count() }} Materi
                </div>
            </div>
            
            <div>
                <div style="font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px;">Sesi Terakhir</div>
                <div style="font-size:14.5px;color:#0f172a;font-weight:600;">
                    <i class="bi bi-clock-history" style="color:#1a56db;margin-right:6px;"></i> {{ $guru->updated_at ? $guru->updated_at->diffForHumans() : '-' }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
