@extends('layouts.siswa')
@section('title', 'Semua Materi')
@section('page-title', 'Semua Materi')
@section('page-subtitle')baca dan unduh materi pembelajaran dari seluruh mata pelajaran @endsection

@push('styles')
<style>
    .quill-content p { margin: 0 0 8px 0; }
    .quill-content p:last-child { margin-bottom: 0; }
    .quill-content strong { font-weight: 700; }
    .quill-content em { font-style: italic; }
    .quill-content u { text-decoration: underline; }
    .quill-content ul, .quill-content ol { padding-left: 20px; margin: 6px 0; }
    .quill-content li { margin-bottom: 4px; }
    .quill-content h1 { font-size: 1.6em; font-weight: 700; margin: 10px 0 6px; }
    .quill-content h2 { font-size: 1.3em; font-weight: 700; margin: 10px 0 6px; }
    .quill-content blockquote {
        border-left: 3px solid #cbd5e1; padding-left: 12px;
        color: #64748b; margin: 8px 0;
    }
    .quill-content pre {
        background: #f8fafc; padding: 10px 14px; border-radius: 8px;
        font-family: monospace; font-size: 13px; overflow-x: auto;
    }
</style>
@endpush

@section('content')

@forelse($mapels as $item)
    @php
        $mapel   = $item['mapel'];
        $materis = $item['materis'];
    @endphp

    <div x-data="{ open: false }" style="margin-bottom:18px;">

        {{-- Mapel header --}}
        <div @click="open = !open"
            style="display:flex;align-items:center;gap:14px;padding:14px 20px;
                   background:#1a56db;
                   cursor:pointer;user-select:none;color:#fff;transition:border-radius .2s ease;"
            :style="{ borderRadius: open ? '14px 14px 0 0' : '14px' }">

            <div style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,.2);
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <span style="font-size:15px;font-weight:900;color:#fff;font-style:italic;">
                    {{ strtoupper(substr($mapel->nama, 0, 2)) }}
                </span>
            </div>

            <div style="flex:1;">
                <div style="font-size:15px;font-weight:800;color:#fff;">{{ $mapel->nama }}</div>
                <div style="font-size:12px;color:rgba(255,255,255,.7);margin-top:1px;">
                    {{ $materis->count() }} bab tersedia
                </div>
            </div>

            <i class="bi bi-chevron-down"
               style="color:rgba(255,255,255,.8);font-size:14px;transition:transform .25s ease;"
               :class="{ 'rotate-180': open }"></i>
        </div>

        {{-- Bab list --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             style="background:#fff;border:1px solid #e2e8f0;border-top:none;border-radius:0 0 14px 14px;box-shadow:0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);overflow:hidden;">

            @foreach ($materis as $babItem)
                @php
                    $materi    = $babItem['materi'];
                    $hasFile   = !empty($materi->file_materi);
                    $hasKonten = !empty($materi->konten);
                    $ext       = $hasFile ? strtolower(pathinfo($materi->file_materi, PATHINFO_EXTENSION)) : '';
                    $iconMap   = [
                        'pdf'  => ['bi-file-earmark-pdf-fill', '#ef4444'],
                        'doc'  => ['bi-file-earmark-word-fill', '#2563eb'],
                        'docx' => ['bi-file-earmark-word-fill', '#2563eb'],
                        'ppt'  => ['bi-file-earmark-ppt-fill', '#ea580c'],
                        'pptx' => ['bi-file-earmark-ppt-fill', '#ea580c'],
                    ];
                    [$fileIcon, $fileColor] = $iconMap[$ext] ?? ['bi-file-earmark-fill', '#64748b'];
                @endphp

                <div x-data="{ expand: false }"
                     style="border-bottom:{{ $loop->last ? 'none' : '1px solid #f1f5f9' }};">

                    {{-- Bab row --}}
                    <div @click="expand = !expand"
                         style="display:flex;align-items:center;gap:14px;padding:14px 20px;cursor:pointer;transition:background .15s;"
                         onmouseover="this.style.background='#fafbff'"
                         onmouseout="this.style.background=''">

                        <div style="width:38px;height:38px;border-radius:50%;
                                    background:#1a56db;
                                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span style="color:#fff;font-size:14px;font-weight:800;font-family:'Plus Jakarta Sans',sans-serif;">{{ $loop->iteration }}</span>
                        </div>

                        <div style="flex:1;min-width:0;">
                            <div style="font-size:13.5px;font-weight:600;color:#0f172a;">
                                {{ $materi->judul }}
                            </div>
                            @if ($materi->deskripsi)
                                <div style="font-size:11.5px;color:#94a3b8;margin-top:2px;
                                            white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:420px;">
                                    {{ $materi->deskripsi }}
                                </div>
                            @endif
                        </div>

                        {{-- Badges --}}
                        <div style="display:flex;align-items:center;gap:6px;flex-shrink:0;">
                            @if ($hasKonten)
                                <span style="font-size:11px;background:#eff6ff;color:#1a56db;padding:3px 10px;
                                             border-radius:20px;font-weight:600;display:flex;align-items:center;gap:4px;">
                                    <i class="bi bi-file-text" style="font-size:10px;"></i> Konten
                                </span>
                            @endif
                            @if ($hasFile)
                                <span style="font-size:11px;background:#f0fdf4;color:#16a34a;padding:3px 10px;
                                             border-radius:20px;font-weight:600;display:flex;align-items:center;gap:4px;">
                                    <i class="bi bi-paperclip" style="font-size:10px;"></i> {{ strtoupper($ext) }}
                                </span>
                            @endif
                            @if (!$hasKonten && !$hasFile)
                                <span style="font-size:11px;background:#f8fafc;color:#94a3b8;padding:3px 10px;
                                             border-radius:20px;font-weight:600;">
                                    Belum ada isi
                                </span>
                            @endif
                        </div>

                        <i class="bi bi-chevron-down"
                           style="color:#94a3b8;font-size:12px;transition:transform .2s;flex-shrink:0;"
                           :style="{ transform: expand ? 'rotate(180deg)' : 'none' }"></i>
                    </div>

                    {{-- Detail konten --}}
                    <div x-show="expand"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         style="background:#fafbfc;border-top:1px solid #f1f5f9;padding:16px 20px 16px 72px;">

                        @if ($hasFile)
                            {{-- Download card --}}
                            <div style="display:flex;align-items:center;gap:14px;padding:13px 16px;
                                        background:#fff;border-radius:12px;border:1px solid #e9edf2;margin-bottom:12px;">
                                <div style="width:42px;height:42px;border-radius:10px;background:{{ $fileColor }}15;
                                            display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="bi {{ $fileIcon }}" style="font-size:20px;color:{{ $fileColor }};"></i>
                                </div>
                                <div style="flex:1;">
                                    <div style="font-size:13px;font-weight:600;color:#0f172a;">
                                        File Materi — {{ $materi->judul }}
                                    </div>
                                    <div style="font-size:11.5px;color:#94a3b8;margin-top:2px;">
                                        Format {{ strtoupper($ext) }} · klik unduh untuk membuka
                                    </div>
                                </div>
                                <a href="{{ route('siswa.latihan.download', $materi) }}"
                                   style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;
                                          background:{{ $fileColor }};color:#fff;border-radius:9px;
                                          font-size:13px;font-weight:600;text-decoration:none;
                                          box-shadow:0 2px 8px {{ $fileColor }}40;transition:opacity .15s;"
                                   onmouseover="this.style.opacity='.88'"
                                   onmouseout="this.style.opacity='1'">
                                    <i class="bi bi-download"></i> Unduh
                                </a>
                            </div>
                        @endif

                        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-top:4px;">
                            @if ($hasKonten)
                                {{-- Tombol buka konten di tab baru --}}
                                <button type="button"
                                    onclick="bukaKonten({{ json_encode($materi->judul) }}, {{ json_encode($materi->konten) }}, '{{ route('siswa.latihan.mapel', $materi->mataPelajaran) }}')"
                                    style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;
                                           background:#fff;border:1px solid #e2e8f0;border-radius:10px;
                                           font-size:12.5px;font-weight:600;color:#1a56db;cursor:pointer;
                                           transition:all .15s;"
                                    onmouseover="this.style.background='#eff6ff';this.style.borderColor='#93c5fd'"
                                    onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0'">
                                    <i class="bi bi-file-text" style="font-size:14px;"></i>
                                    Baca Materi
                                    <i class="bi bi-box-arrow-up-right" style="font-size:11px;color:#94a3b8;"></i>
                                </button>
                            @endif


                        </div>

                        @if (!$hasKonten && !$hasFile)
                            <div style="text-align:center;padding:20px;color:#94a3b8;">
                                <i class="bi bi-inbox" style="font-size:26px;display:block;margin-bottom:8px;color:#cbd5e1;"></i>
                                <div style="font-size:13px;">Belum ada konten untuk bab ini.</div>
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    </div>

@empty
    <div style="text-align:center;padding:64px;color:#94a3b8;">
        <i class="bi bi-collection" style="font-size:40px;display:block;margin-bottom:12px;"></i>
        <div style="font-size:15px;font-weight:500;">Belum ada materi tersedia</div>
    </div>
@endforelse

@endsection

{{-- Satu @push('scripts') saja --}}
@push('scripts')
<script>
    // ── Buka Konten di tab baru ──────────────────────────────────────────
    // Fungsi untuk mengubah teks URL mentah menjadi link (tanpa merusak HTML)
    function autoLink(html) {
        const temp = document.createElement('div');
        temp.innerHTML = html;
        const walk = document.createTreeWalker(temp, NodeFilter.SHOW_TEXT, null, false);
        const nodesToReplace = [];
        let node;
        while (node = walk.nextNode()) {
            if (/(https?:\/\/[^\s]+)/g.test(node.nodeValue)) {
                nodesToReplace.push(node);
            }
        }
        nodesToReplace.forEach(n => {
            const span = document.createElement('span');
            span.innerHTML = n.nodeValue.replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank">$1</a>');
            n.parentNode.replaceChild(span, n);
        });
        return temp.innerHTML;
    }

    // judul, konten, & url latihan di-pass langsung
    function bukaKonten(judul, konten, latihanUrl) {
        konten = autoLink(konten); // Ubah teks URL menjadi link
        const win = window.open('', '_blank');
        win.document.write(`<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${judul}</title>
    <base href="{{ url('/') }}/" target="_blank">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f8fafc; color: #1e293b; }
        .topbar {
            position: sticky; top: 0; z-index: 10;
            display: flex; align-items: center; gap: 14px;
            padding: 12px 32px; background: #1e293b; border-bottom: 1px solid #334155;
        }
        .topbar-icon {
            width: 36px; height: 36px; border-radius: 9px; background: #1a56db;
            display: flex; align-items: center; justify-content: center; font-size: 16px;
        }
        .topbar-title { font-size: 15px; font-weight: 700; color: #fff; }
        .topbar-sub   { font-size: 12px; color: #94a3b8; margin-top: 2px; }
        .container    { max-width: 780px; margin: 40px auto; padding: 0 24px 60px; }
        .card {
            background: #fff; border-radius: 16px; border: 1px solid #e2e8f0;
            padding: 32px 36px; box-shadow: 0 1px 6px rgba(0,0,0,.06);
        }
        .card-label {
            font-size: 11px; font-weight: 700; color: #94a3b8;
            text-transform: uppercase; letter-spacing: .07em;
            margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
        }
        .card-label::before {
            content: ''; width: 3px; height: 14px;
            background: #1a56db; border-radius: 2px;
        }
        .quill-content { font-size: 14.5px; color: #374151; line-height: 1.85; }
        .quill-content p { margin: 0 0 10px 0; }
        .quill-content p:last-child { margin-bottom: 0; }
        .quill-content strong { font-weight: 700; }
        .quill-content em { font-style: italic; }
        .quill-content u { text-decoration: underline; }
        .quill-content ul, .quill-content ol { padding-left: 22px; margin: 8px 0; }
        .quill-content li { margin-bottom: 5px; }
        .quill-content h1 { font-size: 1.6em; font-weight: 700; margin: 16px 0 8px; color: #0f172a; }
        .quill-content h2 { font-size: 1.3em; font-weight: 700; margin: 14px 0 6px; color: #0f172a; }
        .quill-content h3 { font-size: 1.1em; font-weight: 700; margin: 12px 0 6px; color: #0f172a; }
        .quill-content blockquote {
            border-left: 3px solid #1a56db; padding: 8px 16px;
            color: #64748b; margin: 12px 0; background: #f8fafc; border-radius: 0 8px 8px 0;
        }
        .quill-content pre {
            background: #1e293b; color: #e2e8f0; padding: 14px 18px;
            border-radius: 10px; font-family: monospace; font-size: 13px;
            overflow-x: auto; margin: 10px 0;
        }
        .quill-content img { max-width: 100%; border-radius: 8px; margin: 8px 0; }
        .quill-content a   { color: #1a56db; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="topbar-icon">📄</div>
        <div>
            <div class="topbar-title">${judul}</div>
            <div class="topbar-sub">Isi Materi</div>
        </div>
        <div style="margin-left: auto;">
            <button onclick="window.close()" style="background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>
                Kembali ke Semua Materi
            </button>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-label">Isi Materi</div>
            <div class="quill-content">${konten}</div>
            
            <div style="margin-top: 36px; padding-top: 24px; border-top: 2px dashed #e2e8f0; text-align: center;">
                <div style="font-size: 14px; color: #64748b; margin-bottom: 12px;">Sudah selesai membaca materi ini?</div>
                <a href="${latihanUrl}" style="display: inline-flex; align-items: center; gap: 8px; background: #1a56db; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-weight: 700; font-size: 14.5px; box-shadow: 0 4px 12px rgba(26,86,219,0.25);">
                    Lanjut Mengerjakan Latihan 
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>
                </a>
            </div>
        </div>
    </div>
</body>
</html>`);
        win.document.close();
    }


</script>
@endpush