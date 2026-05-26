@extends('layouts.admin')

@section('title', isset($siswa) ? 'Edit Data Siswa' : 'Tambah Data Siswa')
@section('page-title', isset($siswa) ? 'Edit Data Siswa' : 'Tambah Data Siswa')
@section('page-subtitle', isset($siswa) ? 'Perbarui informasi akun siswa' : 'Daftarkan akun siswa baru ke dalam sistem')

@section('topbar-actions')
    <a href="{{ route('admin.siswa.index') }}" class="btn-icon-sm" title="Kembali">
        <i class="bi bi-arrow-left"></i>
    </a>
@endsection

@section('content')
<div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:24px 30px;max-width:600px;">
    <form action="{{ isset($siswa) ? route('admin.siswa.update', $siswa) : route('admin.siswa.store') }}" method="POST">
        @csrf
        @if(isset($siswa))
            @method('PUT')
        @endif

        <div style="margin-bottom:18px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#475569;margin-bottom:8px;">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama', $siswa->nama ?? '') }}" required
                   style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;outline:none;transition:border-color .15s;"
                   onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#475569;margin-bottom:8px;">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email', $siswa->email ?? '') }}" required
                   style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;outline:none;transition:border-color .15s;"
                   onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#475569;margin-bottom:8px;">Kelas</label>
            <select name="kelas_id" required
                    style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;outline:none;transition:border-color .15s;background:#fff;cursor:pointer;"
                    onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
                <option value="">Pilih Kelas</option>
                @foreach($kelasList as $kelas)
                    <option value="{{ $kelas->Id_kelas }}" {{ old('kelas_id', $siswa->kelas_id ?? '') == $kelas->Id_kelas ? 'selected' : '' }}>
                        Kelas {{ $kelas->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#475569;margin-bottom:8px;">
                Password {{ isset($siswa) ? '(Kosongkan jika tidak ingin mengubah)' : '' }}
            </label>
            <input type="password" name="password" {{ isset($siswa) ? '' : 'required' }}
                   style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;outline:none;transition:border-color .15s;"
                   onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
        </div>

        <div style="margin-bottom:24px;">
            <label style="display:block;font-size:12px;font-weight:700;color:#475569;margin-bottom:8px;">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" {{ isset($siswa) ? '' : 'required' }}
                   style="width:100%;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;outline:none;transition:border-color .15s;"
                   onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
        </div>

        <button type="submit" class="btn-primary-sm" style="width:100%;justify-content:center;padding:12px;font-size:14px;">
            <i class="bi bi-save"></i> Simpan Data Siswa
        </button>
    </form>
</div>
@endsection
