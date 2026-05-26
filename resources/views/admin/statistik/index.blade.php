@extends('layouts.admin')

@section('title', 'Statistik Platform')
@section('page-title', 'Statistik Platform')
@section('page-subtitle', 'Ringkasan seluruh data pada sistem CBT')

@section('content')
<div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:20px;margin-bottom:24px;">
    
    <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:22px 24px;position:relative;overflow:hidden;">
        <div style="width:48px;height:48px;border-radius:12px;background:#eff6ff;color:#1a56db;display:flex;align-items:center;justify-content:center;font-size:20px;position:absolute;top:22px;right:24px;">
            <i class="bi bi-person-badge-fill"></i>
        </div>
        <div style="font-size:32px;font-weight:800;color:#0f172a;line-height:1;">{{ $stats['total_guru'] }}</div>
        <div style="font-size:13px;color:#64748b;margin-top:6px;font-weight:600;">Total Guru</div>
    </div>

    <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:22px 24px;position:relative;overflow:hidden;">
        <div style="width:48px;height:48px;border-radius:12px;background:#fef2f2;color:#dc2626;display:flex;align-items:center;justify-content:center;font-size:20px;position:absolute;top:22px;right:24px;">
            <i class="bi bi-people-fill"></i>
        </div>
        <div style="font-size:32px;font-weight:800;color:#0f172a;line-height:1;">{{ $stats['total_siswa'] }}</div>
        <div style="font-size:13px;color:#64748b;margin-top:6px;font-weight:600;">Total Siswa</div>
    </div>

    <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:22px 24px;position:relative;overflow:hidden;">
        <div style="width:48px;height:48px;border-radius:12px;background:#fdf4ff;color:#c026d3;display:flex;align-items:center;justify-content:center;font-size:20px;position:absolute;top:22px;right:24px;">
            <i class="bi bi-building"></i>
        </div>
        <div style="font-size:32px;font-weight:800;color:#0f172a;line-height:1;">{{ $stats['total_kelas'] }}</div>
        <div style="font-size:13px;color:#64748b;margin-top:6px;font-weight:600;">Total Kelas</div>
    </div>

    <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:22px 24px;position:relative;overflow:hidden;">
        <div style="width:48px;height:48px;border-radius:12px;background:#fffbeb;color:#d97706;display:flex;align-items:center;justify-content:center;font-size:20px;position:absolute;top:22px;right:24px;">
            <i class="bi bi-book-fill"></i>
        </div>
        <div style="font-size:32px;font-weight:800;color:#0f172a;line-height:1;">{{ $stats['total_mapel'] }}</div>
        <div style="font-size:13px;color:#64748b;margin-top:6px;font-weight:600;">Mata Pelajaran</div>
    </div>

    <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:22px 24px;position:relative;overflow:hidden;">
        <div style="width:48px;height:48px;border-radius:12px;background:#f0fdf4;color:#16a34a;display:flex;align-items:center;justify-content:center;font-size:20px;position:absolute;top:22px;right:24px;">
            <i class="bi bi-journal-text"></i>
        </div>
        <div style="font-size:32px;font-weight:800;color:#0f172a;line-height:1;">{{ $stats['total_materi'] }}</div>
        <div style="font-size:13px;color:#64748b;margin-top:6px;font-weight:600;">Total Materi</div>
    </div>

    <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:22px 24px;position:relative;overflow:hidden;">
        <div style="width:48px;height:48px;border-radius:12px;background:#f5f3ff;color:#6d28d9;display:flex;align-items:center;justify-content:center;font-size:20px;position:absolute;top:22px;right:24px;">
            <i class="bi bi-ui-checks"></i>
        </div>
        <div style="font-size:32px;font-weight:800;color:#0f172a;line-height:1;">{{ $stats['total_soal'] }}</div>
        <div style="font-size:13px;color:#64748b;margin-top:6px;font-weight:600;">Total Bank Soal</div>
    </div>

    <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:22px 24px;position:relative;overflow:hidden;">
        <div style="width:48px;height:48px;border-radius:12px;background:#f0fdfa;color:#0d9488;display:flex;align-items:center;justify-content:center;font-size:20px;position:absolute;top:22px;right:24px;">
            <i class="bi bi-file-earmark-check-fill"></i>
        </div>
        <div style="font-size:32px;font-weight:800;color:#0f172a;line-height:1;">{{ $stats['total_evaluasi'] }}</div>
        <div style="font-size:13px;color:#64748b;margin-top:6px;font-weight:600;">Total Evaluasi Masuk</div>
    </div>

</div>

@endsection
