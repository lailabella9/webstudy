@extends('layouts.siswa')
@section('title', 'Latihan Coding')
@section('page-title', 'Latihan Coding')
@section('page-subtitle', 'Ketik dan jalankan kodemu langsung di browser')

@push('styles')
<style>
    .playground-container {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 160px); /* Adjust based on topbar and paddings */
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e9edf2;
        overflow: hidden;
    }
    .pg-topbar {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 16px; background: #1e293b; color: #fff; flex-shrink: 0;
    }
    .pg-topbar-title { font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px; }
    .pg-tabs { display: flex; gap: 4px; }
    .pg-tab {
        padding: 6px 16px; font-size: 12.5px; font-family: monospace;
        border-radius: 8px; cursor: pointer; border: 1px solid transparent;
        transition: all .15s; color: #94a3b8; background: transparent;
    }
    .pg-tab.active { background: #fff; color: #0f172a; border-color: #cbd5e1; font-weight: 700; }
    .pg-actions { display: flex; gap: 8px; }
    .pg-btn-reset {
        padding: 6px 14px; font-size: 12px; border: 1px solid #475569;
        border-radius: 8px; cursor: pointer; background: transparent; color: #94a3b8;
    }
    .pg-btn-reset:hover { color: #ef4444; border-color: #ef4444; }
    .pg-btn-run {
        display: inline-flex; align-items: center; gap: 6px; padding: 6px 18px;
        background: #4f46e5; color: #fff; border: none; border-radius: 8px;
        font-size: 13px; font-weight: 600; cursor: pointer;
    }
    .pg-btn-run:hover { opacity: .85; }
    .pg-main { display: flex; flex: 1; overflow: hidden; }
    .pg-editor-panel { width: 50%; display: flex; flex-direction: column; border-right: 1px solid #e2e8f0; }
    .pg-editor-label {
        padding: 5px 14px; font-size: 11px; color: #94a3b8;
        background: #f1f5f9; border-bottom: 1px solid #e2e8f0; font-family: monospace;
    }
    .pg-editor-wrap { position: relative; flex: 1; overflow: hidden; }
    .pg-editor-wrap textarea {
        position: absolute; inset: 0; width: 100%; height: 100%; resize: none;
        border: none; outline: none; padding: 14px; font-family: monospace;
        font-size: 13px; line-height: 1.7; tab-size: 2; background: #fff; color: #1e293b;
    }
    .pg-preview-panel { width: 50%; display: flex; flex-direction: column; background: #fff; }
    .pg-preview-label {
        padding: 5px 14px; font-size: 11px; color: #94a3b8;
        background: #f8fafc; border-bottom: 1px solid #e2e8f0;
    }
    .pg-preview-panel iframe { flex: 1; border: none; width: 100%; background: #fff; }
    .pg-statusbar {
        padding: 4px 14px; font-size: 11px; color: #94a3b8;
        background: #f8fafc; border-top: 1px solid #e2e8f0; font-family: monospace; flex-shrink: 0;
    }
    
    /* Layout Guide Cards */
    .guide-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
    }
    @media (min-width: 900px) {
        .guide-grid {
            grid-template-columns: 1fr 1fr;
        }
        .guide-html {
            grid-column: 1 / -1;
        }
    }
</style>
@endpush

@section('content')

{{-- Panduan Pengenalan --}}
<div style="background:#fff;border-radius:16px;border:1px solid #e9edf2;padding:24px 28px;margin-bottom:24px;box-shadow:0 4px 20px rgba(15,23,42,0.03);">
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:20px;">
        <div style="width:46px;height:46px;border-radius:12px;background:linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(79,70,229,0.3);">
            <i class="bi bi-lightbulb-fill" style="color:#fff;font-size:20px;"></i>
        </div>
        <div>
            <h3 style="margin:0;font-size:17px;font-weight:800;color:#0f172a;letter-spacing:-0.02em;">Panduan Dasar Pemrograman Web</h3>
            <p style="margin:2px 0 0;font-size:13px;color:#64748b;">Kenali 3 pilar utama pembangun website sebelum mulai menulis kode di bawah.</p>
        </div>
    </div>

    <div class="guide-grid">
        {{-- HTML Card --}}
        <div class="guide-html" style="padding:18px;border-radius:14px;background:linear-gradient(to bottom, #fff1f2, #fff);border:1px solid #ffe4e6;transition:transform 0.2s;cursor:default;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:32px;height:32px;border-radius:8px;background:#e11d48;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-filetype-html" style="color:#fff;font-size:16px;"></i>
                </div>
                <span style="font-weight:800;color:#9f1239;font-size:14.5px;">HTML (Struktur)</span>
            </div>
            <p style="font-size:12.5px;color:#be123c;margin:0 0 12px;line-height:1.6;">
                <strong>HyperText Markup Language</strong> (HTML) digunakan untuk menyusun kerangka dasar halaman web. Ibarat membangun rumah, HTML adalah tiang, lantai, dan dindingnya.
            </p>
            <div style="font-size:12px;color:#9f1239;margin-bottom:12px;">
                <strong>Tag Populer:</strong><br>
                <ul style="padding-left: 20px; margin: 4px 0;">
                    <li><code>&lt;h1&gt;</code> s/d <code>&lt;h6&gt;</code> : Membuat judul.</li>
                    <li><code>&lt;p&gt;</code> : Membuat paragraf teks biasa.</li>
                    <li><code>&lt;a href="..."&gt;</code> : Membuat tombol tautan (link).</li>
                    <li><code>&lt;img src="..."&gt;</code> : Menampilkan gambar.</li>
                </ul>
            </div>
            <div style="font-size:11.5px;color:#881337;font-family:monospace;background:rgba(225,29,72,0.08);padding:10px;border-radius:8px;border:1px dashed rgba(225,29,72,0.3);">
                &lt;h1&gt;Halo Dunia!&lt;/h1&gt;<br>
                &lt;p&gt;Saya sedang belajar.&lt;/p&gt;<br>
                &lt;button&gt;Klik Saya&lt;/button&gt;
            </div>
        </div>

        {{-- CSS Card --}}
        <div style="padding:18px;border-radius:14px;background:linear-gradient(to bottom, #eff6ff, #fff);border:1px solid #dbeafe;transition:transform 0.2s;cursor:default;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:32px;height:32px;border-radius:8px;background:#2563eb;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-filetype-css" style="color:#fff;font-size:16px;"></i>
                </div>
                <span style="font-weight:800;color:#1e40af;font-size:14.5px;">CSS (Tampilan)</span>
            </div>
            <p style="font-size:12.5px;color:#1d4ed8;margin:0 0 12px;line-height:1.6;">
                <strong>Cascading Style Sheets</strong> (CSS) berfungsi untuk mempercantik website. Jika HTML adalah kerangka rumah, CSS adalah cat warna dan dekorasi ruangannya.
            </p>
            <div style="font-size:12px;color:#1e40af;margin-bottom:12px;">
                <strong>Properti Populer:</strong><br>
                <ul style="padding-left: 20px; margin: 4px 0;">
                    <li><code>color</code> / <code>background</code> : Mengatur warna.</li>
                    <li><code>font-size</code> : Mengubah ukuran huruf.</li>
                    <li><code>margin</code> / <code>padding</code> : Mengatur jarak elemen.</li>
                    <li><code>border-radius</code> : Membuat sudut melengkung.</li>
                </ul>
            </div>
            <div style="font-size:11.5px;color:#1e3a8a;font-family:monospace;background:rgba(37,99,235,0.08);padding:10px;border-radius:8px;border:1px dashed rgba(37,99,235,0.3);">
                h1 { color: blue; }<br>
                button { <br>
                &nbsp;&nbsp;background: green;<br>
                &nbsp;&nbsp;color: white;<br>
                }
            </div>
        </div>

        {{-- JS Card --}}
        <div style="padding:18px;border-radius:14px;background:linear-gradient(to bottom, #fefce8, #fff);border:1px solid #fef08a;transition:transform 0.2s;cursor:default;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:32px;height:32px;border-radius:8px;background:#ca8a04;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-filetype-js" style="color:#fff;font-size:16px;"></i>
                </div>
                <span style="font-weight:800;color:#854d0e;font-size:14.5px;">JavaScript (Interaksi)</span>
            </div>
            <p style="font-size:12.5px;color:#a16207;margin:0 0 12px;line-height:1.6;">
                <strong>JavaScript</strong> (JS) memberikan interaksi pada website. Jika CSS adalah dekorasi, JS adalah saklar lampu otomatis yang membuatnya berfungsi.
            </p>
            <div style="font-size:12px;color:#854d0e;margin-bottom:12px;">
                <strong>Fungsi Dasar:</strong><br>
                <ul style="padding-left: 20px; margin: 4px 0;">
                    <li><code>alert("Pesan")</code> : Menampilkan popup layar.</li>
                    <li><code>prompt("Tanya")</code> : Meminta input pengguna.</li>
                    <li><code>document.getElementById()</code> : Memilih elemen.</li>
                    <li><code>console.log()</code> : Mencetak data di Console.</li>
                </ul>
            </div>
            <div style="font-size:11.5px;color:#713f12;font-family:monospace;background:rgba(202,138,4,0.12);padding:10px;border-radius:8px;border:1px dashed rgba(202,138,4,0.4);">
                let nama = prompt("Nama:");<br>
                if (nama) {<br>
                &nbsp;&nbsp;alert("Halo " + nama);<br>
                }
            </div>
        </div>
    </div>
</div>

<div class="playground-container">
    <div class="pg-topbar">
        <div class="pg-topbar-title">⚡ Code Playground</div>
        <div class="pg-tabs">
            <button class="pg-tab active" id="tab_html" onclick="switchTab('html')">HTML</button>
            <button class="pg-tab" id="tab_css"  onclick="switchTab('css')">CSS</button>
            <button class="pg-tab" id="tab_js"   onclick="switchTab('js')">JS</button>
        </div>
        <div class="pg-actions">
            <button class="pg-btn-reset" onclick="resetAll()">↺ Reset</button>
            <button class="pg-btn-run"   onclick="runCode()">▶ Jalankan</button>
        </div>
    </div>
    <div class="pg-main">
        <div class="pg-editor-panel">
            <div class="pg-editor-label" id="editor_label">HTML Editor</div>
            <div class="pg-editor-wrap">
                <textarea id="code_html" placeholder="Tulis HTML di sini..."></textarea>
                <textarea id="code_css"  placeholder="Tulis CSS di sini..."        style="display:none;"></textarea>
                <textarea id="code_js"   placeholder="Tulis JavaScript di sini..." style="display:none;"></textarea>
            </div>
        </div>
        <div class="pg-preview-panel">
            <div class="pg-preview-label">Preview</div>
            <iframe id="preview" sandbox="allow-scripts allow-modals allow-same-origin"></iframe>
        </div>
    </div>
    <div class="pg-statusbar" id="statusbar">Tekan Jalankan · Ctrl+Enter untuk shortcut</div>
</div>
@endsection

@push('scripts')
<script>
    const labels = { html: 'HTML Editor', css: 'CSS Editor', js: 'JavaScript Editor' };
    function switchTab(lang) {
        ['html','css','js'].forEach(l => {
            document.getElementById('code_' + l).style.display = l === lang ? 'block' : 'none';
            document.getElementById('tab_' + l).className = 'pg-tab' + (l === lang ? ' active' : '');
        });
        document.getElementById('editor_label').textContent = labels[lang];
    }
    function runCode() {
        const html = document.getElementById('code_html').value;
        const css  = document.getElementById('code_css').value;
        const js   = document.getElementById('code_js').value;
        const doc  = `<!DOCTYPE html><html><head><meta charset="UTF-8">
            <style>*{box-sizing:border-box;}body{font-family:sans-serif;padding:12px;margin:0;}${css}</style>
        </head><body>${html}<script>${js}<\/script></body></html>`;
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
</script>
@endpush
