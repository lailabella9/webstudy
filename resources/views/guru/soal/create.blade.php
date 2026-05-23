@extends('layouts.guru')
@section('title', 'Tambah Soal — ' . $materi->judul)
@section('page-title', 'Tambah Soal')
@section('page-subtitle'){{ $materi->judul }}@endsection

@section('topbar-actions')
    <a href="{{ route('guru.soal.index', $materi) }}" class="btn-icon-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
@endsection

@section('content')
    <div style="max-width:720px;">

        {{-- Info Materi --}}
        <div
            style="display:flex;align-items:center;gap:10px;padding:12px 16px;background:#eff6ff;
                    border:1.5px solid #bfdbfe;border-radius:10px;margin-bottom:20px;">
            <i class="bi bi-journal-richtext" style="color:#1a56db;font-size:16px;"></i>
            <div>
                <span style="font-size:12px;color:#3b82f6;font-weight:500;">Materi / Bab</span>
                <div style="font-size:13.5px;font-weight:700;color:#1e3a5f;">{{ $materi->judul }}</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:28px;">
            <form method="POST" action="{{ route('guru.soal.store', $materi) }}" id="form-soal"
                style="display:flex;flex-direction:column;gap:20px;">
                @csrf

                {{-- ── KATEGORI SOAL ── --}}
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#374151;margin-bottom:8px;">
                        Jenis Soal <span style="color:#ef4444;">*</span>
                    </label>
                    <div style="display:flex;gap:10px;flex-wrap:wrap;" id="kategori-pills">
                        @foreach ($kategoris as $k)
                            @php
                                $isSelected = old('kategori_id', request('kategori')) == $k->Id_kategori;
                            @endphp
                            <label style="cursor:pointer;flex:1;min-width:140px;">
                                <input type="radio" name="kategori_id" value="{{ $k->Id_kategori }}"
                                    {{ $isSelected ? 'checked' : '' }} style="opacity:0;position:absolute;" required
                                    onchange="updateKategoriStyle()">
                                <div class="kategori-pill" data-id="{{ $k->Id_kategori }}" data-warna="{{ $k->warna }}"
                                    style="padding:14px 16px;border-radius:10px;border:2px solid #e2e8f0;
                                            background:#f8fafc;transition:all .2s;text-align:center;
                                            {{ $isSelected ? 'border-color:' . $k->warna . ';background:' . $k->warna . '10;' : '' }}">
                                    <i class="bi {{ $k->ikon }}"
                                        style="font-size:20px;color:{{ $k->warna }};display:block;margin-bottom:6px;"></i>
                                    <div style="font-size:13px;font-weight:700;color:#0f172a;">{{ $k->nama }}</div>
                                    @if (str_contains(strtolower($k->nama), 'harian') || str_contains(strtolower($k->nama), 'latihan'))
                                        <div style="font-size:11px;color:#94a3b8;margin-top:2px;">Setelah pembahasan bab
                                        </div>
                                    @elseif(str_contains(strtolower($k->nama), 'uts') || str_contains(strtolower($k->nama), 'tengah'))
                                        <div style="font-size:11px;color:#94a3b8;margin-top:2px;">Ujian Tengah Semester
                                        </div>
                                    @elseif(str_contains(strtolower($k->nama), 'uas') || str_contains(strtolower($k->nama), 'akhir'))
                                        <div style="font-size:11px;color:#94a3b8;margin-top:2px;">Ujian Akhir Semester</div>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('kategori_id')
                        <div style="color:#ef4444;font-size:12px;margin-top:6px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ── PERTANYAAN ── --}}
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#374151;margin-bottom:5px;">
                        Pertanyaan <span style="color:#ef4444;">*</span>
                    </label>
                    <textarea name="pertanyaan" rows="3" required
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:9px;
                               padding:12px 14px;font-size:13.5px;background:#f8fafc;font-family:inherit;
                               outline:none;resize:vertical;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'"
                        placeholder="Tuliskan pertanyaan di sini...">{{ old('pertanyaan') }}</textarea>
                    @error('pertanyaan')
                        <div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ── TIPE SOAL & POIN ── --}}
                <div style="display:grid;grid-template-columns:1fr 120px;gap:14px;">
                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:#374151;margin-bottom:5px;">
                            Tipe Soal <span style="color:#ef4444;">*</span>
                        </label>
                        <select name="tipe_soal" id="tipe_soal" onchange="gantiTipe(this.value)"
                            style="width:100%;height:44px;border:1.5px solid #e2e8f0;border-radius:9px;
                                   padding:0 14px;font-size:13.5px;background:#f8fafc;outline:none;cursor:pointer;">
                            <option value="pilihan_ganda" {{ old('tipe_soal') == 'pilihan_ganda' ? 'selected' : '' }}>
                                Pilihan Ganda
                            </option>
                            <option value="benar_salah" {{ old('tipe_soal') == 'benar_salah' ? 'selected' : '' }}>
                                Benar / Salah
                            </option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:#374151;margin-bottom:5px;">
                            Poin <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="number" name="poin" value="{{ old('poin', 10) }}" min="1" required
                            style="width:100%;height:44px;border:1.5px solid #e2e8f0;border-radius:9px;
                                   padding:0 14px;font-size:13.5px;background:#f8fafc;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                </div>

                {{-- ── PILIHAN JAWABAN ── --}}
                <div>
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                        <label style="font-size:12px;font-weight:600;color:#374151;">
                            Pilihan Jawaban <span style="color:#ef4444;">*</span>
                        </label>
                        <button type="button" id="btn-tambah-pilihan" onclick="tambahPilihan()"
                            style="font-size:12px;background:#eff6ff;color:#1a56db;border:none;
                                   padding:6px 14px;border-radius:7px;cursor:pointer;font-weight:600;">
                            <i class="bi bi-plus"></i> Tambah Pilihan
                        </button>
                    </div>

                    <div id="pilihan-container" style="display:flex;flex-direction:column;gap:8px;">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="pilihan-row"
                                style="display:flex;align-items:center;gap:10px;padding:10px 14px;
                                        border:1.5px solid #e2e8f0;border-radius:9px;background:#f8fafc;">
                                <div
                                    style="width:26px;height:26px;border-radius:50%;background:#e2e8f0;
                                            display:flex;align-items:center;justify-content:center;
                                            font-size:11px;font-weight:700;color:#64748b;flex-shrink:0;">
                                    {{ chr(65 + $i) }}
                                </div>
                                <input type="radio" name="jawaban_benar" value="{{ $i }}" class="radio-benar"
                                    {{ old('jawaban_benar', 0) == $i ? 'checked' : '' }}
                                    style="accent-color:#16a34a;width:16px;height:16px;cursor:pointer;flex-shrink:0;"
                                    title="Tandai sebagai jawaban benar">
                                <input type="text" name="pilihan[]" value="{{ old('pilihan.' . $i) }}" required
                                    style="flex:1;border:none;background:transparent;font-size:13.5px;
                                           color:#0f172a;outline:none;"
                                    placeholder="Pilihan {{ chr(65 + $i) }}">
                                @if ($i >= 2)
                                    <button type="button" onclick="hapusPilihan(this)"
                                        style="color:#94a3b8;background:none;border:none;
                                               font-size:18px;cursor:pointer;line-height:1;padding:0;"
                                        title="Hapus pilihan">×</button>
                                @else
                                    <span style="width:18px;"></span>
                                @endif
                            </div>
                        @endfor
                    </div>
                    <div style="font-size:11.5px;color:#94a3b8;margin-top:8px;">
                        <i class="bi bi-info-circle"></i>
                        Klik radio button <span style="color:#16a34a;font-weight:600;">hijau</span> untuk menandai jawaban
                        yang benar
                    </div>
                </div>

                {{-- ── TOMBOL ── --}}
                <div style="display:flex;gap:10px;padding-top:4px;border-top:1px solid #f1f5f9;margin-top:4px;">
                    <button type="submit"
                        style="background:#1a56db;color:#fff;border:none;border-radius:9px;
                               padding:11px 28px;font-size:13px;font-weight:600;cursor:pointer;
                               display:flex;align-items:center;gap:7px;">
                        <i class="bi bi-check-lg"></i> Simpan Soal
                    </button>
                    <a href="{{ route('guru.soal.index', $materi) }}"
                        style="background:#f1f5f9;color:#374151;border-radius:9px;
                               padding:11px 22px;font-size:13px;font-weight:500;text-decoration:none;
                               display:flex;align-items:center;gap:7px;">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let pilihanCount = 4;

        // ── Styling kategori pill saat dipilih
        function updateKategoriStyle() {
            const radios = document.querySelectorAll('input[name="kategori_id"]');
            radios.forEach(radio => {
                const pill = radio.closest('label').querySelector('.kategori-pill');
                const warna = pill.dataset.warna;
                if (radio.checked) {
                    pill.style.borderColor = warna;
                    pill.style.background = warna + '12';
                    pill.style.boxShadow = '0 0 0 3px ' + warna + '20';
                } else {
                    pill.style.borderColor = '#e2e8f0';
                    pill.style.background = '#f8fafc';
                    pill.style.boxShadow = 'none';
                }
            });
        }

        // ── Inisialisasi style saat load
        updateKategoriStyle();

        // ── Tambah pilihan jawaban
        function tambahPilihan() {
            const container = document.getElementById('pilihan-container');
            const huruf = ['A', 'B', 'C', 'D', 'E', 'F'];
            const idx = pilihanCount++;
            const row = document.createElement('div');
            row.className = 'pilihan-row';
            row.style.cssText =
                'display:flex;align-items:center;gap:10px;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:9px;background:#f8fafc;';
            row.innerHTML = `
            <div style="width:26px;height:26px;border-radius:50%;background:#e2e8f0;
                        display:flex;align-items:center;justify-content:center;
                        font-size:11px;font-weight:700;color:#64748b;flex-shrink:0;">
                ${huruf[idx] || (idx+1)}
            </div>
            <input type="radio" name="jawaban_benar" value="${idx}" class="radio-benar"
                   style="accent-color:#16a34a;width:16px;height:16px;cursor:pointer;flex-shrink:0;"
                   title="Tandai sebagai jawaban benar">
            <input type="text" name="pilihan[]" required
                style="flex:1;border:none;background:transparent;font-size:13.5px;color:#0f172a;outline:none;"
                placeholder="Pilihan ${huruf[idx] || (idx+1)}">
            <button type="button" onclick="hapusPilihan(this)"
                style="color:#94a3b8;background:none;border:none;font-size:18px;cursor:pointer;line-height:1;padding:0;"
                title="Hapus pilihan">×</button>
        `;
            container.appendChild(row);
            renumberPilihan();
        }

        // ── Hapus pilihan jawaban
        function hapusPilihan(btn) {
            const rows = document.querySelectorAll('.pilihan-row');
            if (rows.length <= 2) {
                alert('Minimal 2 pilihan jawaban.');
                return;
            }
            btn.closest('.pilihan-row').remove();
            renumberPilihan();
        }

        // ── Renumber radio values
        function renumberPilihan() {
            const huruf = ['A', 'B', 'C', 'D', 'E', 'F'];
            document.querySelectorAll('.pilihan-row').forEach((row, i) => {
                const radio = row.querySelector('input[type=radio]');
                const label = row.querySelector('div');
                if (radio) radio.value = i;
                if (label) label.textContent = huruf[i] || (i + 1);
            });
        }

        // ── Ganti tipe soal (pilihan ganda / benar-salah)
        function gantiTipe(tipe) {
            const container = document.getElementById('pilihan-container');
            const btnTambah = document.getElementById('btn-tambah-pilihan');

            if (tipe === 'benar_salah') {
                container.innerHTML = `
                <div class="pilihan-row" style="display:flex;align-items:center;gap:10px;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:9px;background:#f8fafc;">
                    <div style="width:26px;height:26px;border-radius:50%;background:#dcfce7;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#16a34a;flex-shrink:0;">B</div>
                    <input type="radio" name="jawaban_benar" value="0" checked style="accent-color:#16a34a;width:16px;height:16px;cursor:pointer;flex-shrink:0;">
                    <input type="text" name="pilihan[]" value="Benar" required style="flex:1;border:none;background:transparent;font-size:13.5px;color:#0f172a;outline:none;">
                    <span style="width:18px;"></span>
                </div>
                <div class="pilihan-row" style="display:flex;align-items:center;gap:10px;padding:10px 14px;border:1.5px solid #e2e8f0;border-radius:9px;background:#f8fafc;">
                    <div style="width:26px;height:26px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#b91c1c;flex-shrink:0;">S</div>
                    <input type="radio" name="jawaban_benar" value="1" style="accent-color:#16a34a;width:16px;height:16px;cursor:pointer;flex-shrink:0;">
                    <input type="text" name="pilihan[]" value="Salah" required style="flex:1;border:none;background:transparent;font-size:13.5px;color:#0f172a;outline:none;">
                    <span style="width:18px;"></span>
                </div>
            `;
                btnTambah.style.opacity = '.4';
                btnTambah.style.pointerEvents = 'none';
            } else {
                btnTambah.style.opacity = '1';
                btnTambah.style.pointerEvents = 'auto';
            }
        }

        // ── Pre-select kategori dari URL param
        const urlParams = new URLSearchParams(window.location.search);
        const katParam = urlParams.get('kategori');
        if (katParam) {
            const radio = document.querySelector(`input[name="kategori_id"][value="${katParam}"]`);
            if (radio) {
                radio.checked = true;
                updateKategoriStyle();
            }
        }
    </script>
@endpush
