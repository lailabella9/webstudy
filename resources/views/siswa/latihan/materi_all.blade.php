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
        $colors  = ['#1a56db', '#4f46e5', '#0f766e', '#b45309', '#be185d', '#0369a1'];
        $idx     = crc32($mapel->nama) % 6;
        $c1      = $colors[$idx];
        $c2      = $colors[($idx + 2) % 6];
    @endphp

    <div x-data="{ open: true }" style="margin-bottom:18px;">

        {{-- Mapel header --}}
        <div @click="open = !open"
            style="display:flex;align-items:center;gap:14px;padding:14px 20px;
                   background:linear-gradient(135deg,{{ $c1 }},{{ $c2 }});
                   border-radius:14px;cursor:pointer;user-select:none;color:#fff;">

            <div style="width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,.2);
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
             x-transition:leave-end="opacity-0 -translate-y-2">

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

                        <div style="width:38px;height:38px;border-radius:10px;
                                    background:linear-gradient(135deg,{{ $c1 }},{{ $c2 }});
                                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="bi bi-journal-richtext" style="color:#fff;font-size:16px;"></i>
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
                           :style="expand ? 'transform:rotate(180deg)' : ''"></i>
                    </div>

                    {{-- Detail konten --}}
                    <div x-show="expand"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         style="background:#fafbfc;border-top:1px solid #f1f5f9;padding:16px 20px 16px 72px;">

                        @if ($hasKonten)
                            {{-- Tombol buka konten di tab baru --}}
                            {{-- json_encode agar konten HTML aman di-pass ke JS --}}
                            <button type="button"
                                onclick="bukaKonten({{ json_encode($materi->judul) }}, {{ json_encode($materi->konten) }})"
                                style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;
                                       background:#fff;border:1px solid #e2e8f0;border-radius:10px;
                                       font-size:12.5px;font-weight:600;color:#1a56db;cursor:pointer;
                                       transition:all .15s;margin-bottom:8px;"
                                onmouseover="this.style.background='#eff6ff';this.style.borderColor='#93c5fd'"
                                onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0'">
                                <i class="bi bi-file-text" style="font-size:14px;"></i>
                                Baca Materi
                                <i class="bi bi-box-arrow-up-right" style="font-size:11px;color:#94a3b8;"></i>
                            </button>
                        @endif

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

                        {{-- ===== CODE PLAYGROUND ===== --}}
                        <button type="button" onclick="pgOpenNew({{ $materi->Id_materi }})"
                            style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;
                                   background:#fff;border:1px solid #e2e8f0;border-radius:10px;
                                   font-size:12.5px;font-weight:600;color:#4f46e5;cursor:pointer;
                                   transition:all .15s;margin-top:4px;"
                            onmouseover="this.style.background='#f5f3ff';this.style.borderColor='#c4b5fd'"
                            onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0'">
                            <i class="bi bi-code-slash" style="font-size:14px;"></i>
                            Coba Code
                            <i class="bi bi-box-arrow-up-right" style="font-size:11px;color:#94a3b8;"></i>
                        </button>
                        {{-- ===== END PLAYGROUND ===== --}}

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
    // judul & konten di-pass langsung via json_encode, aman dari quote conflict
    function bukaKonten(judul, konten) {
        const win = window.open('', '_blank');
        win.document.write(`<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${judul}</title>
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
    </div>
    <div class="container">
        <div class="card">
            <div class="card-label">Isi Materi</div>
            <div class="quill-content">${konten}</div>
        </div>
    </div>
</body>
</html>`);
        win.document.close();
    }

    // ── Code Playground di tab baru ──────────────────────────────────────
    function pgOpenNew(materiId) {
        const win = window.open('', '_blank');
        win.document.write(`<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Playground — Materi #${materiId}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; height: 100vh; display: flex; flex-direction: column; background: #f8fafc; }
        .topbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 10px 16px; background: #1e293b; color: #fff; flex-shrink: 0;
        }
        .topbar-title { font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px; }
        .topbar-title span { color: #94a3b8; font-weight: 400; font-size: 12px; }
        .tabs { display: flex; gap: 4px; }
        .tab {
            padding: 6px 16px; font-size: 12.5px; font-family: monospace;
            border-radius: 8px; cursor: pointer; border: 1px solid transparent;
            transition: all .15s; color: #94a3b8; background: transparent;
        }
        .tab.active { background: #fff; color: #0f172a; border-color: #cbd5e1; font-weight: 700; }
        .actions { display: flex; gap: 8px; }
        .btn-reset {
            padding: 6px 14px; font-size: 12px; border: 1px solid #475569;
            border-radius: 8px; cursor: pointer; background: transparent; color: #94a3b8;
        }
        .btn-reset:hover { color: #ef4444; border-color: #ef4444; }
        .btn-run {
            display: inline-flex; align-items: center; gap: 6px; padding: 6px 18px;
            background: #4f46e5; color: #fff; border: none; border-radius: 8px;
            font-size: 13px; font-weight: 600; cursor: pointer;
        }
        .btn-run:hover { opacity: .85; }
        .main { display: flex; flex: 1; overflow: hidden; }
        .editor-panel { width: 50%; display: flex; flex-direction: column; border-right: 1px solid #e2e8f0; }
        .editor-label {
            padding: 5px 14px; font-size: 11px; color: #94a3b8;
            background: #f1f5f9; border-bottom: 1px solid #e2e8f0; font-family: monospace;
        }
        .editor-wrap { position: relative; flex: 1; overflow: hidden; }
        textarea {
            position: absolute; inset: 0; width: 100%; height: 100%; resize: none;
            border: none; outline: none; padding: 14px; font-family: monospace;
            font-size: 13px; line-height: 1.7; tab-size: 2; background: #fff; color: #1e293b;
        }
        .preview-panel { width: 50%; display: flex; flex-direction: column; }
        .preview-label {
            padding: 5px 14px; font-size: 11px; color: #94a3b8;
            background: #f8fafc; border-bottom: 1px solid #e2e8f0;
        }
        iframe { flex: 1; border: none; width: 100%; background: #fff; }
        .statusbar {
            padding: 4px 14px; font-size: 11px; color: #94a3b8;
            background: #f8fafc; border-top: 1px solid #e2e8f0; font-family: monospace; flex-shrink: 0;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="topbar-title">⚡ Code Playground <span>Materi #${materiId}</span></div>
        <div class="tabs">
            <button class="tab active" id="tab_html" onclick="switchTab('html')">HTML</button>
            <button class="tab" id="tab_css"  onclick="switchTab('css')">CSS</button>
            <button class="tab" id="tab_js"   onclick="switchTab('js')">JS</button>
        </div>
        <div class="actions">
            <button class="btn-reset" onclick="resetAll()">↺ Reset</button>
            <button class="btn-run"   onclick="runCode()">▶ Jalankan</button>
        </div>
    </div>
    <div class="main">
        <div class="editor-panel">
            <div class="editor-label" id="editor_label">HTML Editor</div>
            <div class="editor-wrap">
                <textarea id="code_html" placeholder="Tulis HTML di sini..."></textarea>
                <textarea id="code_css"  placeholder="Tulis CSS di sini..."        style="display:none;"></textarea>
                <textarea id="code_js"   placeholder="Tulis JavaScript di sini..." style="display:none;"></textarea>
            </div>
        </div>
        <div class="preview-panel">
            <div class="preview-label">Preview</div>
            <iframe id="preview" sandbox="allow-scripts allow-modals allow-same-origin"></iframe>
        </div>
    </div>
    <div class="statusbar" id="statusbar">Tekan Jalankan · Ctrl+Enter untuk shortcut</div>
<script>
    const labels = { html: 'HTML Editor', css: 'CSS Editor', js: 'JavaScript Editor' };
    function switchTab(lang) {
        ['html','css','js'].forEach(l => {
            document.getElementById('code_' + l).style.display = l === lang ? 'block' : 'none';
            document.getElementById('tab_' + l).className = 'tab' + (l === lang ? ' active' : '');
        });
        document.getElementById('editor_label').textContent = labels[lang];
    }
    function runCode() {
        const html = document.getElementById('code_html').value;
        const css  = document.getElementById('code_css').value;
        const js   = document.getElementById('code_js').value;
        const doc  = \`<!DOCTYPE html><html><head><meta charset="UTF-8">
            <style>*{box-sizing:border-box;}body{font-family:sans-serif;padding:12px;margin:0;}\${css}</style>
        </head><body>\${html}<script>\${js}<\\/script></body></html>\`;
        const iframe = document.getElementById('preview');
        iframe.srcdoc = '';
        requestAnimationFrame(() => { iframe.srcdoc = doc; });
        document.getElementById('statusbar').textContent = '✓ Dijalankan · ' + new Date().toLocaleTimeString('id-ID');
    }
    function resetAll() {
        ['html','css','js'].forEach(l => document.getElementById('code_' + l).value = '');
        document.getElementById('preview').srcdoc = '';
        document.getElementById('statusbar').textContent = 'Kode direset';
        switchTab('html');
    }
    document.addEventListener('keydown', e => {
        if (e.key === 'Tab' && e.target.tagName === 'TEXTAREA') {
            e.preventDefault();
            const s = e.target.selectionStart;
            e.target.value = e.target.value.substring(0, s) + '  ' + e.target.value.substring(e.target.selectionEnd);
            e.target.selectionStart = e.target.selectionEnd = s + 2;
        }
        if (e.ctrlKey && e.key === 'Enter') runCode();
    });
<\/script>
</body></html>`);
        win.document.close();
    }
</script>
@endpush