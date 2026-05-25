@extends('layouts.guru')
@section('title', 'Edit Siswa — ' . $siswa->nama)
@section('page-title', 'Edit Data Siswa')
@section('page-subtitle', 'Perbarui informasi akun ' . $siswa->nama)

@section('topbar-actions')
    <a href="{{ route('guru.siswa.show', $siswa) }}" class="btn-icon-sm" title="Kembali ke Detail">
        <i class="bi bi-arrow-left"></i>
    </a>
@endsection

@push('styles')
    <style>
        .form-card { background:#fff; border-radius:16px; border:1px solid #e9edf2; overflow:hidden; }
        .form-card-header {
            padding:18px 24px; border-bottom:1px solid #f1f5f9; background:#f8fafc;
            display:flex; align-items:center; gap:10px;
        }
        .form-card-header-icon {
            width:34px; height:34px; border-radius:9px;
            background:#1a56db;
            display:flex; align-items:center; justify-content:center;
            color:#fff; font-size:15px; flex-shrink:0;
        }
        .form-card-header-title { font-size:13px; font-weight:700; color:#0f172a; text-transform:uppercase; letter-spacing:.06em; }
        .form-card-body { padding:28px 24px; }
        .form-group { margin-bottom:22px; }
        .form-label { display:block; font-size:12.5px; font-weight:600; color:#374151; margin-bottom:7px; }
        .form-label span.required { color:#ef4444; margin-left:3px; }
        .form-label .hint { font-weight:400; color:#94a3b8; margin-left:6px; font-size:11.5px; }
        .form-input {
            width:100%; height:42px; border:1.5px solid #e2e8f0; border-radius:10px;
            padding:0 14px; font-size:13.5px; font-family:'Plus Jakarta Sans',sans-serif;
            color:#0f172a; background:#fff; outline:none;
            transition:border-color .15s, box-shadow .15s; box-sizing:border-box;
        }
        .form-input:focus { border-color:#1a56db; box-shadow:0 0 0 3px rgba(26,86,219,.1); }
        .form-input.is-invalid { border-color:#ef4444; box-shadow:0 0 0 3px rgba(239,68,68,.08); }
        .form-input:disabled { background:#f8fafc; color:#94a3b8; cursor:not-allowed; }
        .form-input-wrap { position:relative; }
        .form-input-wrap .input-icon {
            position:absolute; left:13px; top:50%; transform:translateY(-50%);
            color:#94a3b8; font-size:15px; pointer-events:none;
        }
        .form-input-wrap .form-input { padding-left:40px; }
        .form-input-wrap .toggle-pass {
            position:absolute; right:13px; top:50%; transform:translateY(-50%);
            color:#94a3b8; font-size:15px; cursor:pointer; border:none; background:none; padding:0; transition:color .15s;
        }
        .form-input-wrap .toggle-pass:hover { color:#1a56db; }
        .invalid-feedback { font-size:11.5px; color:#ef4444; margin-top:5px; display:flex; align-items:center; gap:4px; }
        .form-hint { font-size:11.5px; color:#94a3b8; margin-top:5px; display:flex; align-items:center; gap:4px; }
        .form-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
        .strength-bar { display:flex; gap:4px; margin-top:8px; }
        .strength-bar-segment { flex:1; height:4px; border-radius:99px; background:#e2e8f0; transition:background .2s; }
        .strength-label { font-size:11px; margin-top:5px; color:#94a3b8; transition:color .2s; }

        /* Avatar */
        .avatar-edit-wrap {
            display:flex; align-items:center; gap:16px; padding:16px;
            background:#f8fafc; border-radius:12px; border:1.5px dashed #e2e8f0;
            margin-bottom:22px; transition:border-color .15s;
        }
        .avatar-edit-wrap:hover { border-color:#1a56db; }
        .avatar-preview {
            width:56px; height:56px; border-radius:50%;
            background:#1a56db;
            display:flex; align-items:center; justify-content:center;
            font-size:22px; font-weight:800; color:#fff; flex-shrink:0; overflow:hidden; position:relative;
        }
        .avatar-preview img { width:100%; height:100%; object-fit:cover; }
        .avatar-upload-btn {
            display:inline-flex; align-items:center; gap:7px; padding:8px 16px;
            border:1.5px solid #e2e8f0; border-radius:9px; background:#fff;
            font-size:13px; font-weight:500; color:#374151; cursor:pointer; transition:border-color .15s, color .15s;
        }
        .avatar-upload-btn:hover { border-color:#1a56db; color:#1a56db; }

        /* Password section */
        .password-toggle-section {
            background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:12px;
            overflow:hidden; transition:border-color .15s;
        }
        .password-toggle-header {
            display:flex; align-items:center; justify-content:space-between;
            padding:14px 18px; cursor:pointer; user-select:none;
        }
        .password-toggle-header:hover { background:#f1f5f9; }
        .password-toggle-header .left { display:flex; align-items:center; gap:10px; }
        .password-toggle-header .icon-wrap {
            width:32px; height:32px; border-radius:8px; background:#eff6ff;
            display:flex; align-items:center; justify-content:center; color:#1a56db; font-size:14px;
        }
        .password-toggle-header .title { font-size:13px; font-weight:600; color:#0f172a; }
        .password-toggle-header .subtitle { font-size:11.5px; color:#94a3b8; margin-top:1px; }
        .password-fields { padding:0 18px 18px; display:none; }
        .password-fields.open { display:block; }

        /* Divider */
        .divider-label { display:flex; align-items:center; gap:10px; margin:24px 0 18px; }
        .divider-label::before, .divider-label::after { content:''; flex:1; height:1px; background:#f1f5f9; }
        .divider-label span { font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.08em; white-space:nowrap; }

        /* Footer */
        .form-footer {
            padding:18px 24px; border-top:1px solid #f1f5f9; background:#f8fafc;
            display:flex; align-items:center; justify-content:space-between; gap:10px;
        }
        .btn-cancel {
            display:inline-flex; align-items:center; gap:7px; padding:9px 20px;
            border:1.5px solid #e2e8f0; border-radius:9px; background:#fff;
            font-size:13px; font-weight:500; color:#374151; text-decoration:none;
            transition:border-color .15s, background .15s; font-family:'Plus Jakarta Sans',sans-serif;
        }
        .btn-cancel:hover { background:#f1f5f9; border-color:#cbd5e1; color:#374151; }
        .btn-submit {
            display:inline-flex; align-items:center; gap:8px; padding:9px 24px;
            background:#1a56db; color:#fff; border:none;
            border-radius:9px; font-size:13px; font-weight:600; cursor:pointer;
            font-family:'Plus Jakarta Sans',sans-serif; transition:opacity .15s, transform .1s;
            box-shadow:0 2px 8px rgba(26,86,219,.25);
        }
        .btn-submit:hover { opacity:.9; transform:translateY(-1px); box-shadow:0 4px 14px rgba(26,86,219,.35); }
        .btn-submit:active { transform:translateY(0); }
        .btn-danger {
            display:inline-flex; align-items:center; gap:7px; padding:9px 18px;
            border:1.5px solid #fecaca; border-radius:9px; background:#fef2f2;
            font-size:13px; font-weight:500; color:#b91c1c; cursor:pointer;
            font-family:'Plus Jakarta Sans',sans-serif; transition:background .15s;
        }
        .btn-danger:hover { background:#fee2e2; }
        .siswa-meta-badge {
            display:inline-flex; align-items:center; gap:6px; padding:5px 12px;
            background:#eff6ff; border:1px solid #bfdbfe; border-radius:20px;
            font-size:11.5px; font-weight:600; color:#1e3a8a;
        }
        .kelas-shortcut {
            display:inline-flex; align-items:center; gap:5px;
            font-size:11.5px; color:#1a56db; font-weight:500; text-decoration:none; margin-top:6px;
        }
        .kelas-shortcut:hover { text-decoration:underline; }
    </style>
@endpush

@section('content')

    <div style="max-width:700px;">

        {{-- Identity header --}}
        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:16px 22px;margin-bottom:18px;display:flex;align-items:center;gap:14px;">
            @php
                $avatarColors = ['#1a56db','#7c3aed','#0f766e','#b45309','#be185d'];
                $avatarBg = $avatarColors[crc32($siswa->nama) % count($avatarColors)];
            @endphp
            <div style="width:46px;height:46px;border-radius:50%;background:{{ $avatarBg }};display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:800;color:#fff;flex-shrink:0;overflow:hidden;">
                @if ($siswa->foto_profil)
                    <img src="{{ asset('storage/' . $siswa->foto_profil) }}" style="width:100%;height:100%;object-fit:cover;" alt="">
                @else
                    {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                @endif
            </div>
            <div style="flex:1;">
                <div style="font-size:14px;font-weight:700;color:#0f172a;">{{ $siswa->nama }}</div>
                <div style="font-size:12px;color:#64748b;margin-top:2px;display:flex;align-items:center;gap:8px;">
                    <span>{{ $siswa->email }}</span>
                    @if ($siswa->kelas)
                        <span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;background:#eff6ff;border-radius:20px;font-size:11px;color:#1e3a8a;font-weight:600;">
                            <i class="bi bi-grid-3x3-gap" style="font-size:10px;"></i>{{ $siswa->kelas->nama }}
                        </span>
                    @endif
                </div>
            </div>
            <span class="siswa-meta-badge">
                <i class="bi bi-person-badge"></i> ID #{{ $siswa->Id_user }}
            </span>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-header-icon"><i class="bi bi-pencil-fill"></i></div>
                <div class="form-card-header-title">Edit Data Siswa</div>
            </div>

            <form method="POST" action="{{ route('guru.siswa.update', $siswa) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-card-body">

                    {{-- Avatar --}}
                    <div class="avatar-edit-wrap">
                        <div class="avatar-preview" id="avatarPreview" style="background:{{ $avatarBg }};">
                            @if ($siswa->foto_profil)
                                <img src="{{ asset('storage/' . $siswa->foto_profil) }}" alt="" id="avatarImg">
                            @else
                                <span id="avatarInitials">{{ strtoupper(substr($siswa->nama, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:600;color:#0f172a;margin-bottom:4px;">Foto Profil</div>
                            <div style="font-size:12px;color:#64748b;margin-bottom:8px;">JPG, PNG maks. 2MB — opsional</div>
                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                <label class="avatar-upload-btn" for="foto_input">
                                    <i class="bi bi-upload"></i> Ganti Foto
                                </label>
                                @if ($siswa->foto_profil)
                                    <label style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border:1.5px solid #fecaca;border-radius:9px;background:#fef2f2;font-size:12px;font-weight:500;color:#b91c1c;cursor:pointer;">
                                        <input type="hidden" name="hapus_foto" value="0">
                                        <input type="checkbox" name="hapus_foto" value="1" style="display:none;" onchange="removeFoto(this)">
                                        <i class="bi bi-trash"></i> Hapus Foto
                                    </label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <input type="file" id="foto_input" name="foto_profil" accept="image/*" class="d-none" onchange="previewAvatar(this)">

                    {{-- ── Bagian 1: Info Dasar ── --}}
                    <div class="divider-label" style="margin-top:0;"><span>Informasi Dasar</span></div>

                    <div class="form-group">
                        <label class="form-label" for="nama">
                            Nama Lengkap <span class="required">*</span>
                        </label>
                        <div class="form-input-wrap">
                            <i class="bi bi-person input-icon"></i>
                            <input type="text" id="nama" name="nama"
                                class="form-input {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                                value="{{ old('nama', $siswa->nama) }}" placeholder="Nama lengkap siswa">
                        </div>
                        @error('nama')
                            <div class="invalid-feedback"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">
                            Alamat Email <span class="required">*</span>
                            <span class="hint">Digunakan untuk login</span>
                        </label>
                        <div class="form-input-wrap">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" id="email" name="email"
                                class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                value="{{ old('email', $siswa->email) }}" placeholder="email@example.com">
                        </div>
                        @error('email')
                            <div class="invalid-feedback"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ── Bagian 2: Kelas ── --}}
                    <div class="divider-label"><span>Penempatan Kelas</span></div>

                    <div class="form-group">
                        <label class="form-label" for="kelas_id">
                            Kelas <span class="required">*</span>
                        </label>
                        <div class="form-input-wrap">
                            <i class="bi bi-grid-3x3-gap input-icon"></i>
                            <select id="kelas_id" name="kelas_id"
                                class="form-input {{ $errors->has('kelas_id') ? 'is-invalid' : '' }}"
                                style="padding-left:40px;appearance:none;-webkit-appearance:none;cursor:pointer;">
                                <option value="">— Pilih Kelas —</option>
                                @foreach ($kelasList as $k)
                                    <option value="{{ $k->Id_kelas }}"
                                        {{ old('kelas_id', $siswa->kelas_id) == $k->Id_kelas ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="bi bi-chevron-down"
                                style="position:absolute;right:13px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:12px;pointer-events:none;"></i>
                        </div>
                        @error('kelas_id')
                            <div class="invalid-feedback"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                        <a href="{{ route('guru.kelas.index') }}" class="kelas-shortcut" target="_blank">
                            <i class="bi bi-grid-3x3-gap"></i> Kelola kelas
                        </a>
                    </div>

                    {{-- ── Bagian 3: Password ── --}}
                    <div class="divider-label"><span>Keamanan Akun</span></div>

                    <div class="password-toggle-section" id="passwordSection">
                        <div class="password-toggle-header" onclick="togglePasswordSection()">
                            <div class="left">
                                <div class="icon-wrap"><i class="bi bi-shield-lock-fill"></i></div>
                                <div>
                                    <div class="title">Ganti Password</div>
                                    <div class="subtitle">Kosongkan jika tidak ingin mengubah password</div>
                                </div>
                            </div>
                            <i class="bi bi-chevron-down" id="chevronIcon" style="color:#94a3b8;font-size:13px;transition:transform .2s;"></i>
                        </div>

                        <div class="password-fields {{ $errors->has('password') ? 'open' : '' }}" id="passwordFields">
                            <div class="form-grid-2" style="margin-bottom:0;">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label class="form-label" for="password">Password Baru</label>
                                    <div class="form-input-wrap">
                                        <i class="bi bi-lock input-icon"></i>
                                        <input type="password" id="password" name="password"
                                            class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                            placeholder="Min. 6 karakter" oninput="checkStrength(this.value)">
                                        <button type="button" class="toggle-pass" onclick="togglePass('password', this)">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                                    @enderror
                                    <div class="strength-bar" id="strengthBar">
                                        <div class="strength-bar-segment" id="s1"></div>
                                        <div class="strength-bar-segment" id="s2"></div>
                                        <div class="strength-bar-segment" id="s3"></div>
                                        <div class="strength-bar-segment" id="s4"></div>
                                    </div>
                                    <div class="strength-label" id="strengthLabel">Masukkan password baru</div>
                                </div>

                                <div class="form-group" style="margin-bottom:0;">
                                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                                    <div class="form-input-wrap">
                                        <i class="bi bi-lock-fill input-icon"></i>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-input" placeholder="Ulangi password baru" oninput="checkMatch()">
                                        <button type="button" class="toggle-pass" onclick="togglePass('password_confirmation', this)">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-hint" id="matchHint">
                                        <i class="bi bi-arrow-return-right"></i> Harus sama dengan password di atas
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-footer">
                    <button type="button" class="btn-danger" onclick="submitDeleteForm()">
                        <i class="bi bi-trash"></i> Hapus Akun
                    </button>
                    <div style="display:flex;gap:10px;">
                        <a href="{{ route('guru.siswa.show', $siswa) }}" class="btn-cancel">
                            <i class="bi bi-x"></i> Batal
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-check-lg"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>

            <form id="deleteForm" method="POST" action="{{ route('guru.siswa.destroy', $siswa) }}">
                @csrf @method('DELETE')
            </form>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        function submitDeleteForm() {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Yakin hapus akun ini? Semua data akan terhapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal2-premium-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        }
        function previewAvatar(input) {
            const preview = document.getElementById('avatarPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.innerHTML = `<img src="${e.target.result}" alt="" style="width:100%;height:100%;object-fit:cover;">`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function removeFoto(checkbox) {
            const preview = document.getElementById('avatarPreview');
            if (checkbox.checked) {
                preview.innerHTML = `<i class="bi bi-person" style="font-size:22px;"></i>`;
            } else {
                @if ($siswa->foto_profil)
                    preview.innerHTML = `<img src="{{ asset('storage/' . $siswa->foto_profil) }}" alt="" style="width:100%;height:100%;object-fit:cover;">`;
                @endif
            }
        }
        let passOpen = {{ $errors->has('password') ? 'true' : 'false' }};
        function togglePasswordSection() {
            passOpen = !passOpen;
            const fields   = document.getElementById('passwordFields');
            const chevron  = document.getElementById('chevronIcon');
            const section  = document.getElementById('passwordSection');
            fields.classList.toggle('open', passOpen);
            chevron.style.transform = passOpen ? 'rotate(180deg)' : '';
            section.style.borderColor = passOpen ? '#1a56db' : '#e2e8f0';
        }
        if (passOpen) {
            document.getElementById('chevronIcon').style.transform = 'rotate(180deg)';
            document.getElementById('passwordSection').style.borderColor = '#1a56db';
        }
        function togglePass(id, btn) {
            const input = document.getElementById(id);
            const icon  = btn.querySelector('i');
            if (input.type === 'password') { input.type = 'text'; icon.className = 'bi bi-eye-slash'; }
            else                           { input.type = 'password'; icon.className = 'bi bi-eye'; }
        }
        function checkStrength(val) {
            const segs  = ['s1','s2','s3','s4'].map(id => document.getElementById(id));
            const label = document.getElementById('strengthLabel');
            let score = 0;
            if (val.length >= 6) score++;
            if (val.length >= 10) score++;
            if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
            if (/[0-9!@#$%^&*]/.test(val)) score++;
            const colors = ['','#ef4444','#f59e0b','#22c55e','#16a34a'];
            const labels = ['Masukkan password baru','Lemah','Sedang','Kuat','Sangat Kuat'];
            segs.forEach((s,i) => s.style.background = i < score ? colors[score] : '#e2e8f0');
            label.textContent = val.length === 0 ? labels[0] : labels[score];
            label.style.color = val.length === 0 ? '#94a3b8' : colors[score];
        }
        function checkMatch() {
            const pass    = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            const hint    = document.getElementById('matchHint');
            const input   = document.getElementById('password_confirmation');
            if (confirm.length === 0) {
                hint.innerHTML = '<i class="bi bi-arrow-return-right"></i> Harus sama dengan password di atas';
                hint.style.color = '#94a3b8'; input.style.borderColor = '#e2e8f0'; input.style.boxShadow = 'none'; return;
            }
            if (pass === confirm) {
                hint.innerHTML = '<i class="bi bi-check-circle-fill"></i> Password cocok';
                hint.style.color = '#16a34a'; input.style.borderColor = '#22c55e';
                input.style.boxShadow = '0 0 0 3px rgba(34,197,94,.1)';
            } else {
                hint.innerHTML = '<i class="bi bi-x-circle-fill"></i> Password tidak cocok';
                hint.style.color = '#ef4444'; input.style.borderColor = '#ef4444';
                input.style.boxShadow = '0 0 0 3px rgba(239,68,68,.08)';
            }
        }
    </script>
@endpush