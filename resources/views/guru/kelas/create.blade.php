@extends('layouts.guru')
@section('title', 'Tambah Kelas')
@section('page-title', 'Tambah Kelas')
@section('page-subtitle')buat kelas baru @endsection

@section('topbar-actions')
    <a href="{{ route('guru.kelas.index') }}" class="btn-icon-sm" title="Kembali">
        <i class="bi bi-arrow-left"></i>
    </a>
@endsection

@section('content')

    <div style="max-width:480px;margin:0 auto;">
        <div style="background:#fff;border-radius:16px;border:1px solid #e9edf2;overflow:hidden;">

            {{-- Header form --}}
            <div
                style="padding:20px 24px;border-bottom:1px solid #f1f5f9;background:#1a56db;display:flex;align-items:center;gap:14px;">
                <div
                    style="width:44px;height:44px;border-radius:11px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-building-add" style="color:#fff;font-size:20px;"></i>
                </div>
                <div>
                    <div style="font-size:16px;font-weight:800;color:#fff;">Tambah Kelas Baru</div>
                    <div style="font-size:12px;color:rgba(255,255,255,.7);margin-top:1px;">Isi nama kelas yang akan dibuat
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('guru.kelas.store') }}" style="padding:24px;">
                @csrf

                {{-- Nama Kelas --}}
                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:13px;font-weight:700;color:#374151;margin-bottom:7px;">
                        Nama Kelas <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        placeholder="Contoh: 10 RPL, 11 TKJ, 12 MM"
                        style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('nama') ? '#ef4444' : '#e2e8f0' }};border-radius:10px;font-size:13.5px;color:#0f172a;outline:none;font-family:inherit;transition:border .15s;"
                        onfocus="this.style.borderColor='#1a56db'"
                        onblur="this.style.borderColor='{{ $errors->has('nama') ? '#ef4444' : '#e2e8f0' }}'">
                    @error('nama')
                        <div style="font-size:12px;color:#dc2626;margin-top:5px;display:flex;align-items:center;gap:4px;">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    <div style="font-size:11.5px;color:#94a3b8;margin-top:5px;">
                        <i class="bi bi-info-circle" style="margin-right:3px;"></i>
                        Nama kelas harus unik. Contoh format: "10 RPL 1", "XI TKJ", "12 MM A"
                    </div>
                </div>

                {{-- Preview --}}
                <div
                    style="background:#f8fafc;border-radius:10px;border:1px dashed #cbd5e1;padding:14px;margin-bottom:20px;">
                    <div
                        style="font-size:11.5px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">
                        Preview</div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div
                            style="width:36px;height:36px;border-radius:9px;background:#1a56db;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-building" style="color:#fff;font-size:15px;"></i>
                        </div>
                        <div>
                            <div id="preview-nama" style="font-size:14px;font-weight:700;color:#0f172a;">—</div>
                            <div style="font-size:11.5px;color:#94a3b8;">0 siswa terdaftar</div>
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div style="display:flex;gap:8px;">
                    <a href="{{ route('guru.kelas.index') }}"
                        style="flex:1;text-align:center;padding:11px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;font-weight:600;color:#374151;text-decoration:none;">
                        Batal
                    </a>
                    <button type="submit"
                        style="flex:2;padding:11px;background:#1a56db;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;">
                        <i class="bi bi-plus-lg"></i> Simpan Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelector('[name="nama"]').addEventListener('input', function() {
            document.getElementById('preview-nama').textContent = this.value || '—';
        });
    </script>

@endsection
