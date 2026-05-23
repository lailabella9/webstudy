@extends('layouts.siswa')
@section('title', 'Profil Siswa')
@section('page-title', 'Profil Siswa')
@section('page-subtitle', 'Kelola informasi akun dan profil Anda')

@section('topbar-actions')
    <a href="{{ route('siswa.dashboard') }}" class="btn-icon-sm"><i class="bi bi-house"></i></a>
@endsection

@section('content')
    <div style="display:grid; grid-template-columns:320px 1fr; gap:20px; align-items:start;">

        {{-- ── KIRI: KARTU PROFIL ── --}}
        <div style="display:flex; flex-direction:column; gap:14px;">

            {{-- Foto & Info --}}
            <div style="background:#fff; border-radius:14px; border:1px solid #e9edf2; overflow:hidden;">
                {{-- Cover --}}
                <div style="height:90px; background:linear-gradient(135deg,#1a56db,#4f46e5);"></div>
                {{-- Avatar --}}
                <div style="padding:0 20px 20px; position:relative;">
                    <div style="position:relative; width:72px; margin-top:-36px; margin-bottom:12px;">
                        <div
                            style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#818cf8);border:3px solid #fff;display:flex;align-items:center;justify-content:center;font-size:26px;font-weight:800;color:#fff;overflow:hidden;">
                            @if ($user->foto_profil)
                                <img src="{{ asset('storage/' . $user->foto_profil) }}"
                                    style="width:100%;height:100%;object-fit:cover;" alt="">
                            @else
                                {{ strtoupper(substr($user->nama, 0, 1)) }}
                            @endif
                        </div>
                        <label for="foto-upload"
                            style="position:absolute;bottom:0;right:0;width:22px;height:22px;background:#1a56db;border:2px solid #fff;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;"
                            title="Edit foto">
                            <i class="bi bi-camera-fill" style="font-size:9px;color:#fff;"></i>
                        </label>
                    </div>
                    <div style="font-size:15px;font-weight:700;color:#0f172a;">{{ $user->nama }}</div>
                    <div style="font-size:12px;color:#64748b;margin-top:2px;">Siswa</div>
                    <div style="font-size:12px;color:#94a3b8;margin-top:1px;">{{ $user->email }}</div>
                </div>

                {{-- Info List --}}
                <div style="border-top:1px solid #f1f5f9; padding:14px 20px;">
                    @foreach ([['bi-envelope', 'Email', $user->email], ['bi-person-badge', 'Role', 'Siswa'], ['bi-mortarboard', 'Kelas', $user->kelas?->nama ?? '-'], ['bi-calendar3', 'Bergabung', $user->created_at->format('d M Y')]] as [$ic, $lbl, $val])
                        <div
                            style="display:flex;align-items:center;gap:10px;padding:6px 0;border-bottom:1px solid #f8fafc;">
                            <i class="bi {{ $ic }}"
                                style="font-size:13px;color:#94a3b8;width:16px;text-align:center;flex-shrink:0;"></i>
                            <span style="font-size:12px;color:#64748b;min-width:70px;">{{ $lbl }}</span>
                            <span style="font-size:12px;color:#0f172a;font-weight:500;">{{ $val }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── KANAN: FORM ── --}}
        <div style="display:flex; flex-direction:column; gap:16px;">

            {{-- Edit Profil --}}
            <div style="background:#fff; border-radius:14px; border:1px solid #e9edf2; padding:22px 24px;">
                <div
                    style="font-size:13px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:.06em;margin-bottom:18px;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-person-gear" style="color:#1a56db;"></i> Edit Profil Siswa
                </div>
                <form method="POST" action="{{ route('siswa.profil.update') }}" enctype="multipart/form-data"
                    id="form-profil">
                    @csrf
                    <input type="file" id="foto-upload" name="foto_profil" accept="image/*" style="display:none;"
                        onchange="previewFoto(this)">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
                        <div>
                            <label
                                style="display:block;font-size:11.5px;font-weight:600;color:#374151;margin-bottom:5px;">Nama
                                Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required
                                style="width:100%;height:40px;border:1.5px solid #e2e8f0;border-radius:8px;padding:0 12px;font-size:13px;color:#0f172a;background:#f8fafc;outline:none;transition:border-color .2s;"
                                onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                        <div>
                            <label
                                style="display:block;font-size:11.5px;font-weight:600;color:#374151;margin-bottom:5px;">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                style="width:100%;height:40px;border:1.5px solid #e2e8f0;border-radius:8px;padding:0 12px;font-size:13px;color:#0f172a;background:#f8fafc;outline:none;transition:border-color .2s;"
                                onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:11.5px;font-weight:600;color:#374151;margin-bottom:5px;">NIP /
                            No. Identitas</label>
                        <input type="text" placeholder="Opsional"
                            style="width:100%;height:40px;border:1.5px solid #e2e8f0;border-radius:8px;padding:0 12px;font-size:13px;color:#0f172a;background:#f8fafc;outline:none;"
                            onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px;">
                        <div>
                            <label
                                style="display:block;font-size:11.5px;font-weight:600;color:#374151;margin-bottom:5px;">No.
                                Telepon</label>
                            <input type="text" placeholder="Opsional"
                                style="width:100%;height:40px;border:1.5px solid #e2e8f0;border-radius:8px;padding:0 12px;font-size:13px;color:#0f172a;background:#f8fafc;outline:none;"
                                onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                        <div>
                            <label
                                style="display:block;font-size:11.5px;font-weight:600;color:#374151;margin-bottom:5px;">Jabatan
                                / Bidang Studi</label>
                            <input type="text" placeholder="Opsional"
                                style="width:100%;height:40px;border:1.5px solid #e2e8f0;border-radius:8px;padding:0 12px;font-size:13px;color:#0f172a;background:#f8fafc;outline:none;"
                                onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                    </div>
                    <button type="submit"
                        style="background:#1a56db;color:#fff;border:none;border-radius:9px;padding:10px 22px;font-size:13px;font-weight:600;cursor:pointer;transition:opacity .15s;"
                        onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- Ubah Password --}}
            <div style="background:#fff; border-radius:14px; border:1px solid #e9edf2; padding:22px 24px;">
                <div
                    style="font-size:13px;font-weight:700;color:#0f172a;text-transform:uppercase;letter-spacing:.06em;margin-bottom:18px;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-shield-lock" style="color:#4f46e5;"></i> Ubah Password
                </div>
                <form method="POST" action="{{ route('siswa.profil.update') }}">
                    @csrf
                    <input type="hidden" name="nama" value="{{ $user->nama }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <div style="margin-bottom:14px;">
                        <label
                            style="display:block;font-size:11.5px;font-weight:600;color:#374151;margin-bottom:5px;">Password
                            Lama</label>
                        <input type="password" name="password_lama" placeholder="Masukkan password lama"
                            style="width:100%;height:40px;border:1.5px solid #e2e8f0;border-radius:8px;padding:0 12px;font-size:13px;background:#f8fafc;outline:none;"
                            onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px;">
                        <div>
                            <label
                                style="display:block;font-size:11.5px;font-weight:600;color:#374151;margin-bottom:5px;">Password
                                Baru</label>
                            <input type="password" name="password" placeholder="Min. 6 karakter"
                                style="width:100%;height:40px;border:1.5px solid #e2e8f0;border-radius:8px;padding:0 12px;font-size:13px;background:#f8fafc;outline:none;"
                                onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                        <div>
                            <label
                                style="display:block;font-size:11.5px;font-weight:600;color:#374151;margin-bottom:5px;">Konfirmasi
                                Password Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                                style="width:100%;height:40px;border:1.5px solid #e2e8f0;border-radius:8px;padding:0 12px;font-size:13px;background:#f8fafc;outline:none;"
                                onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                    </div>
                    <button type="submit"
                        style="background:#4f46e5;color:#fff;border:none;border-radius:9px;padding:10px 22px;font-size:13px;font-weight:600;cursor:pointer;transition:opacity .15s;"
                        onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                        <i class="bi bi-key me-1"></i> Ubah Password
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewFoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    const av = document.querySelector('.avatar-img');
                    if (av) {
                        av.src = e.target.result;
                        av.style.display = 'block';
                    }
                };
                reader.readAsDataURL(input.files[0]);
                document.getElementById('form-profil').submit();
            }
        }
    </script>
@endpush
