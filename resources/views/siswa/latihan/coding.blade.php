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
</style>
@endpush

@section('content')
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
