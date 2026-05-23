@extends('layouts.guru')
@section('title', 'Edit Mata Pelajaran')
@section('page-title', 'Edit Mata Pelajaran')

@section('content')
    <div style="max-width:560px;">
        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:24px;">
            <form method="POST" action="{{ route('guru.mapel.update', $mapel) }}" enctype="multipart/form-data"
                style="display:flex;flex-direction:column;gap:16px;">
                @csrf @method('PUT')

                {{-- Kelas --}}
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#374151;margin-bottom:5px;">
                        Kelas <span style="color:#ef4444;">*</span>
                    </label>
                    <select name="kelas_id" required
                        style="width:100%;height:42px;border:1.5px solid #e2e8f0;border-radius:9px;padding:0 14px;
                           font-size:13.5px;background:#f8fafc;outline:none;color:#0f172a;"
                        onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelasList as $k)
                            <option value="{{ $k->Id_kelas }}"
                                {{ old('kelas_id', $mapel->kelas_id) == $k->Id_kelas ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <div style="font-size:11.5px;color:#ef4444;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama --}}
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#374151;margin-bottom:5px;">
                        Nama Mata Pelajaran <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama', $mapel->nama) }}" required
                        style="width:100%;height:42px;border:1.5px solid #e2e8f0;border-radius:9px;padding:0 14px;font-size:13.5px;background:#f8fafc;outline:none;"
                        onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'"
                        placeholder="contoh: Pemrograman Web Dasar">
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label
                        style="display:block;font-size:12px;font-weight:600;color:#374151;margin-bottom:5px;">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:9px;padding:10px 14px;font-size:13.5px;background:#f8fafc;outline:none;resize:vertical;"
                        onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'"
                        placeholder="Deskripsi singkat">{{ old('deskripsi', $mapel->deskripsi) }}</textarea>
                </div>

                {{-- Urutan --}}
                <div style="width:100px;">
                    <label style="display:block;font-size:12px;font-weight:600;color:#374151;margin-bottom:5px;">
                        Urutan <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="number" name="urutan" value="{{ old('urutan', $mapel->urutan) }}" min="0" required
                        style="width:100%;height:42px;border:1.5px solid #e2e8f0;border-radius:9px;padding:0 14px;font-size:13.5px;background:#f8fafc;outline:none;"
                        onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
                </div>

                <div style="display:flex;gap:10px;padding-top:4px;">
                    <button type="submit"
                        style="background:#1a56db;color:#fff;border:none;border-radius:9px;padding:10px 24px;font-size:13px;font-weight:600;cursor:pointer;">
                        Simpan
                    </button>
                    <a href="{{ route('guru.mapel.index') }}"
                        style="background:#f1f5f9;color:#374151;border-radius:9px;padding:10px 20px;font-size:13px;font-weight:500;text-decoration:none;">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
