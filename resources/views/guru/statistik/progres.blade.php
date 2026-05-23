@extends('layouts.guru')
@section('title', 'Progres Siswa')
@section('page-title', 'Progres Siswa')
@section('page-subtitle')rekap nilai semua siswa per materi @endsection

@section('content')

    @if ($materis->isEmpty() || $siswa->isEmpty())
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:64px;text-align:center;color:#94a3b8;">
            <i class="bi bi-people" style="font-size:40px;display:block;margin-bottom:12px;"></i>
            <div style="font-size:14px;font-weight:500;">Belum ada data materi atau siswa.</div>
        </div>
    @else
        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;overflow:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="background:#f8fafc;border-bottom:1.5px solid #e9edf2;">
                        <th
                            style="padding:12px 16px;text-align:left;font-size:11.5px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;min-width:160px;">
                            Nama Siswa</th>
                        @foreach ($materis as $m)
                            <th
                                style="padding:12px 10px;text-align:center;font-size:10.5px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;min-width:110px;">
                                {{ \Illuminate\Support\Str::limit($m->judul, 16) }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grid as $row)
                        <tr style="border-bottom:1px solid #f1f5f9;transition:background .15s;"
                            onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                            <td style="padding:11px 16px;font-weight:600;color:#0f172a;">{{ $row['siswa']->nama }}</td>
                            @foreach ($materis as $m)
                                @php $pct = $row['materi'][$m->Id_materi] ?? null; @endphp
                                <td style="padding:11px 10px;text-align:center;">
                                    @if ($pct !== null)
                                        <span
                                            style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:11.5px;font-weight:700;
                        background:{{ $pct >= 80 ? '#f0fdf4' : ($pct >= 60 ? '#fffbeb' : '#fef2f2') }};
                        color:{{ $pct >= 80 ? '#16a34a' : ($pct >= 60 ? '#ca8a04' : '#dc2626') }};">
                                            {{ $pct }}%
                                        </span>
                                    @else
                                        <span style="color:#d1d5db;font-size:12px;">—</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="font-size:11.5px;color:#94a3b8;margin-top:10px;">
            — = belum mengerjakan &nbsp;
            <span style="background:#f0fdf4;color:#16a34a;padding:2px 8px;border-radius:20px;font-weight:600;">≥80%</span>
            &nbsp;
            <span style="background:#fffbeb;color:#ca8a04;padding:2px 8px;border-radius:20px;font-weight:600;">60–79%</span>
            &nbsp;
            <span
                style="background:#fef2f2;color:#dc2626;padding:2px 8px;border-radius:20px;font-weight:600;">&lt;60%</span>
        </div>
    @endif
@endsection
