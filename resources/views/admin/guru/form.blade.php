@extends('layouts.admin')

@section('title', isset($guru) ? 'Edit Data Guru' : 'Tambah Data Guru')
@section('page-title', isset($guru) ? 'Edit Data Guru' : 'Tambah Data Guru')
@section('page-subtitle', isset($guru) ? 'Perbarui informasi akun pengajar' : 'Daftarkan akun pengajar baru ke dalam sistem')

@section('topbar-actions')
    <a href="{{ route('admin.guru.index') }}" class="btn-icon-sm" title="Kembali">
        <i class="bi bi-arrow-left"></i>
    </a>
@endsection

@section('content')
<div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:24px 30px;max-width:600px;">
    <form action="{{ isset($guru) ? route('admin.guru.update', $guru) : route('admin.guru.store') }}" method="POST">
        @csrf
        @if(isset($guru))
            @method('PUT')
        @endif

        <div style="margin-bottom:18px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#475569;margin-bottom:8px;">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama', $guru->nama ?? '') }}" required
                   style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;outline:none;transition:border-color .15s;"
                   onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#475569;margin-bottom:8px;">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email', $guru->email ?? '') }}" required
                   style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;outline:none;transition:border-color .15s;"
                   onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#475569;margin-bottom:8px;">
                Password {{ isset($guru) ? '(Kosongkan jika tidak ingin mengubah)' : '' }}
            </label>
            <input type="password" name="password" {{ isset($guru) ? '' : 'required' }}
                   style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;outline:none;transition:border-color .15s;"
                   onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
        </div>

        <div style="margin-bottom:24px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#475569;margin-bottom:8px;">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" {{ isset($guru) ? '' : 'required' }}
                   style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;outline:none;transition:border-color .15s;"
                   onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
        </div>

        <button type="submit" class="btn-primary-sm" style="width:100%;justify-content:center;padding:12px;font-size:14px;">
            <i class="bi bi-save"></i> Simpan Data Guru
        </button>
    </form>
</div>
@endsection
