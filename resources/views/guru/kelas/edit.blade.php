@extends('layouts.guru')
@section('title', 'Edit Kelas — ' . $kelas->nama)
@section('page-title', 'Edit Kelas')
@section('page-subtitle')ubah nama kelas @endsection

@section('topbar-actions')
    <a href="{{ route('guru.kelas.index') }}" class="btn-icon-sm" title="Kembali">
        <i class="bi bi-arrow-left"></i>
    </a>
@endsection

@section('content')

    <div style="max-width:480px;margin:0 auto;">

        {{-- Info siswa di kelas ini --}}
        <div
            style="background:#eff6ff;border-radius:14px;border:1px solid #bae6fd;padding:16px 20px;margin-bottom:16px;display:flex;align-items:center;gap:14px;">
            <div
                style="width:44px;height:44px;border-radius:11px;background:#0ea5e9;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-people-fill" style="color:#fff;font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:14px;font-weight:700;color:#0c4a6e;">Kelas ini memiliki {{ $kelas->siswa_count }} siswa
                </div>
                <div style="font-size:12.5px;color:#0369a1;margin-top:1px;">
                    Mengubah nama kelas tidak mempengaruhi data siswa.
                </div>
            </div>
        </div>

        <div style="background:#fff;border-radius:16px;border:1px solid #e9edf2;overflow:hidden;">

            {{-- Header --}}
            <div
                style="padding:20px 24px;border-bottom:1px solid #f1f5f9;background:#1a56db;display:flex;align-items:center;gap:14px;">
                <div
                    style="width:44px;height:44px;border-radius:11px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-pencil-fill" style="color:#fff;font-size:18px;"></i>
                </div>
                <div>
                    <div style="font-size:16px;font-weight:800;color:#fff;">Edit Kelas</div>
                    <div style="font-size:12px;color:rgba(255,255,255,.7);margin-top:1px;">{{ $kelas->nama }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('guru.kelas.update', $kelas) }}" style="padding:24px;">
                @csrf @method('PUT')

                {{-- Nama Kelas --}}
                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:13px;font-weight:700;color:#374151;margin-bottom:7px;">
                        Nama Kelas <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama', $kelas->nama) }}"
                        placeholder="Contoh: 10 RPL, 11 TKJ, 12 MM"
                        style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('nama') ? '#ef4444' : '#e2e8f0' }};border-radius:10px;font-size:13.5px;color:#0f172a;outline:none;font-family:inherit;transition:border .15s;"
                        onfocus="this.style.borderColor='#1a56db'"
                        onblur="this.style.borderColor='{{ $errors->has('nama') ? '#ef4444' : '#e2e8f0' }}'">
                    @error('nama')
                        <div style="font-size:12px;color:#dc2626;margin-top:5px;display:flex;align-items:center;gap:4px;">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
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
                            <div id="preview-nama" style="font-size:14px;font-weight:700;color:#0f172a;">{{ $kelas->nama }}
                            </div>
                            <div style="font-size:11.5px;color:#94a3b8;">{{ $kelas->siswa_count }} siswa terdaftar</div>
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
                        <i class="bi bi-check-lg"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Danger Zone: Hapus kelas --}}
        @if ($kelas->siswa_count === 0)
            <div style="background:#fff;border-radius:14px;border:1.5px solid #fecaca;margin-top:16px;overflow:hidden;">
                <div style="padding:14px 20px;border-bottom:1px solid #fecaca;background:#fef2f2;">
                    <span style="font-size:12.5px;font-weight:700;color:#dc2626;display:flex;align-items:center;gap:5px;">
                        <i class="bi bi-exclamation-triangle-fill"></i> Zona Berbahaya
                    </span>
                </div>
                <div style="padding:16px 20px;display:flex;align-items:center;justify-content:space-between;gap:14px;">
                    <div>
                        <div style="font-size:13px;font-weight:600;color:#0f172a;">Hapus Kelas</div>
                        <div style="font-size:12px;color:#64748b;margin-top:2px;">Tindakan ini tidak dapat dibatalkan.</div>
                    </div>
                    <form method="POST" action="{{ route('guru.kelas.destroy', $kelas) }}"
                        onsubmit="return confirm('Yakin ingin menghapus kelas {{ $kelas->nama }}?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            style="padding:8px 16px;background:#fef2f2;color:#dc2626;border:1.5px solid #fecaca;border-radius:9px;font-size:12.5px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:5px;">
                            <i class="bi bi-trash"></i> Hapus Kelas
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.querySelector('[name="nama"]').addEventListener('input', function() {
            document.getElementById('preview-nama').textContent = this.value || '—';
        });
    </script>

@endsection
