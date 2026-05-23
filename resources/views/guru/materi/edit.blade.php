@extends('layouts.guru')
@section('title', 'Edit Bab — ' . $materi->judul)
@section('page-title', 'Edit Bab')
@section('page-subtitle'){{ $mapel->nama }}@endsection

@section('topbar-actions')
    <a href="{{ route('guru.mapel.kelola', $mapel) }}" class="btn-icon-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
@endsection

@section('content')
    <div style="max-width:680px;">

        {{-- Info mapel --}}
        <div
            style="display:flex;align-items:center;gap:10px;padding:12px 16px;background:#eff6ff;
                    border:1.5px solid #bfdbfe;border-radius:10px;margin-bottom:20px;">
            <i class="bi bi-collection" style="color:#1a56db;font-size:16px;"></i>
            <div>
                <span style="font-size:12px;color:#3b82f6;font-weight:500;">Mata Pelajaran</span>
                <div style="font-size:13.5px;font-weight:700;color:#1e3a5f;">{{ $mapel->nama }}</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:28px;">
            <form method="POST" id="form-tambah-bab" action="{{ route('guru.materi.update', [$mapel, $materi]) }}"
                enctype="multipart/form-data" style="display:flex;flex-direction:column;gap:18px;">
                @csrf @method('PUT')

                {{-- Judul --}}
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#374151;margin-bottom:5px;">
                        Judul Bab <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul', $materi->judul) }}" required
                        style="width:100%;height:44px;border:1.5px solid #e2e8f0;border-radius:9px;
                               padding:0 14px;font-size:13.5px;background:#f8fafc;outline:none;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'"
                        placeholder="Contoh: Bab 1 — Pengantar Aljabar">
                    @error('judul')
                        <div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#374151;margin-bottom:5px;">
                        Deskripsi Singkat
                    </label>
                    <textarea name="deskripsi" rows="2"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:9px;
                               padding:10px 14px;font-size:13.5px;background:#f8fafc;
                               outline:none;resize:vertical;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'"
                        placeholder="Deskripsi singkat tentang bab ini (opsional)">{{ old('deskripsi', $materi->deskripsi) }}</textarea>
                </div>

                {{-- Konten Materi (Quill) --}}
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#374151;margin-bottom:5px;">
                        Konten / Isi Materi <span style="color:#ef4444;">*</span>
                    </label>
                    <div style="font-size:11.5px;color:#94a3b8;margin-bottom:6px;">
                        Isi materi yang akan dibaca siswa sebelum mengerjakan latihan soal.
                    </div>

                    {{-- Hidden input yang dikirim ke server --}}
                    <input type="hidden" name="konten" id="konten-input">

                    {{-- Quill editor: isi dari DB dirender sebagai HTML --}}
                    <div class="quill-wrapper">
                        <div id="quill-editor">{!! old('konten', $materi->konten) !!}</div>
                    </div>

                    @error('konten')
                        <div style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- File Materi --}}
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#374151;margin-bottom:5px;">
                        File Pendukung
                        <span style="font-weight:400;color:#94a3b8;">(PDF, Word, PPT — maks 10MB)</span>
                    </label>

                    @if ($materi->file_materi)
                        <div
                            style="display:flex;align-items:center;gap:10px;padding:10px 14px;
                                    background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:9px;margin-bottom:10px;">
                            <i class="bi bi-file-earmark-check" style="color:#16a34a;font-size:18px;"></i>
                            <div style="flex:1;">
                                <div style="font-size:13px;font-weight:600;color:#15803d;">
                                    {{ basename($materi->file_materi) }}
                                </div>
                                <div style="font-size:11.5px;color:#4ade80;">File saat ini</div>
                            </div>
                            <label
                                style="display:flex;align-items:center;gap:6px;cursor:pointer;
                                          font-size:12px;color:#b91c1c;font-weight:500;">
                                <input type="checkbox" name="hapus_file" value="1" style="accent-color:#b91c1c;">
                                Hapus file
                            </label>
                        </div>
                    @endif

                    <div
                        style="border:1.5px dashed #e2e8f0;border-radius:9px;padding:16px;background:#f8fafc;
                                display:flex;align-items:center;gap:12px;">
                        <i class="bi bi-file-earmark-arrow-up" style="font-size:24px;color:#94a3b8;"></i>
                        <div style="flex:1;">
                            <input type="file" name="file_materi" accept=".pdf,.doc,.docx,.ppt,.pptx"
                                style="width:100%;font-size:13px;color:#374151;">
                            <div style="font-size:11.5px;color:#94a3b8;margin-top:4px;">
                                {{ $materi->file_materi ? 'Unggah file baru untuk mengganti yang lama' : 'Unggah modul atau slide presentasi' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Urutan --}}
                <div style="width:120px;">
                    <label style="display:block;font-size:12px;font-weight:600;color:#374151;margin-bottom:5px;">
                        Urutan <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="number" name="urutan" value="{{ old('urutan', $materi->urutan) }}" min="0"
                        required
                        style="width:100%;height:44px;border:1.5px solid #e2e8f0;border-radius:9px;
                               padding:0 14px;font-size:13.5px;background:#f8fafc;outline:none;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#e2e8f0'">
                    <div style="font-size:11px;color:#94a3b8;margin-top:4px;">Urutan tampil di siswa</div>
                </div>

                {{-- Tombol --}}
                <div style="display:flex;gap:10px;padding-top:4px;border-top:1px solid #f1f5f9;margin-top:4px;">
                    <button type="submit"
                        style="background:#1a56db;color:#fff;border:none;border-radius:9px;
                               padding:11px 28px;font-size:13px;font-weight:600;cursor:pointer;
                               display:flex;align-items:center;gap:7px;">
                        <i class="bi bi-check-lg"></i> Perbarui Bab
                    </button>
                    <a href="{{ route('guru.mapel.kelola', $mapel) }}"
                        style="background:#f1f5f9;color:#374151;border-radius:9px;
                               padding:11px 22px;font-size:13px;font-weight:500;text-decoration:none;
                               display:flex;align-items:center;gap:7px;">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <script>
            const quill = new Quill('#quill-editor', {
                theme: 'snow',
                placeholder: 'Tuliskan konten materi di sini...',
                modules: {
                    toolbar: [
                        [{
                            header: [1, 2, 3, false]
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{
                            list: 'ordered'
                        }, {
                            list: 'bullet'
                        }],
                        [{
                            indent: '-1'
                        }, {
                            indent: '+1'
                        }],
                        ['blockquote', 'code-block'],
                        ['link'],
                        [{
                            align: []
                        }],
                        ['clean'],
                    ],
                },
            });
            /**
             * Bersihkan HTML dari Quill sebelum disimpan:
             * - Hapus <p><br></p> dan <p></p> yang kosong di awal/akhir
             * - Trim whitespace
             */
            function cleanQuillHtml(html) {
                // Hapus paragraf kosong di awal dan akhir
                return html
                    .replace(/^(\s*<p>\s*(<br\s*\/?>\s*)?<\/p>\s*)+/gi, '')
                    .replace(/(\s*<p>\s*(<br\s*\/?>\s*)?<\/p>\s*)+$/gi, '')
                    .trim();
            }
            document.getElementById('form-tambah-bab').addEventListener('submit', function(e) {
                const rawHtml = quill.getSemanticHTML(); // HTML bersih dari Quill 2.x
                const cleaned = cleanQuillHtml(rawHtml);
                // Pastikan ada konten sebelum submit
                if (!cleaned || quill.getText().trim().length === 0) {
                    e.preventDefault();
                    alert('Konten / Isi Materi wajib diisi.');
                    quill.focus();
                    return;
                }
                document.getElementById('konten-input').value = cleaned;
            });
        </script>
    @endpush
@endsection
