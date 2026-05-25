@extends('layouts.guru')
@section('title', 'Progres Siswa')
@section('page-title', 'Progres Siswa')
@section('page-subtitle')rekap nilai semua siswa per materi @endsection

@section('content')

    {{-- Filter Bar --}}
    <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:14px 20px;margin-bottom:20px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
        <form method="GET" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;flex:1;">
            <label style="font-size:13px;font-weight:600;color:#475569;" for="kelas_id">Pilih Kelas / Jurusan:</label>
            <select name="kelas_id" id="kelas_id" onchange="this.form.submit()"
                style="height:36px;padding:0 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;color:#374151;outline:none;font-family:inherit;background:#fff;min-width:180px;cursor:pointer;">
                <option value="">Semua Kelas & Jurusan</option>
                @foreach ($kelasList as $k)
                    <option value="{{ $k->Id_kelas }}" {{ $kelas_id == $k->Id_kelas ? 'selected' : '' }}>
                        {{ $k->nama }}
                    </option>
                @endforeach
            </select>
            @if ($kelas_id)
                <a href="{{ route('guru.progres') }}"
                    style="height:36px;padding:0 14px;border:1.5px solid #e2e8f0;border-radius:9px;background:#fff;font-size:13px;color:#64748b;display:inline-flex;align-items:center;text-decoration:none;">
                    ✕ Reset
                </a>
            @endif
        </form>
    </div>

    @if (empty($hierarchy))
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:64px;text-align:center;color:#94a3b8;">
            <i class="bi bi-people" style="font-size:40px;display:block;margin-bottom:12px;"></i>
            <div style="font-size:14px;font-weight:500;">Belum ada data progres siswa.</div>
        </div>
    @else
        @foreach ($hierarchy as $classItem)
            <div style="margin-bottom:32px;">
                {{-- Kelas header --}}
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <div
                        style="width:34px;height:34px;border-radius:8px;background:#0f172a;
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-mortarboard-fill" style="color:#fff;font-size:15px;"></i>
                    </div>
                    <span style="font-size:16px;font-weight:800;color:#0f172a;">{{ $classItem['kelas']->nama }}</span>
                </div>

                @foreach ($classItem['mapelData'] as $mapelItem)
                    <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:20px;margin-bottom:20px;">
                        {{-- Mapel header --}}
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
                            <i class="bi bi-book-half" style="color:#4f46e5;font-size:15px;"></i>
                            <span style="font-size:14px;font-weight:700;color:#1e293b;">{{ $mapelItem['mapel']->nama }}</span>
                        </div>

                        <div style="overflow-x:auto;">
                            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                                <thead>
                                    <tr style="background:#f8fafc;border-bottom:1.5px solid #e9edf2;">
                                        <th style="padding:12px 16px;text-align:left;font-size:11.5px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;min-width:160px;">
                                            Nama Siswa
                                        </th>
                                        @foreach ($mapelItem['babList'] as $bab)
                                            <th style="padding:12px 10px;text-align:center;font-size:10.5px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;min-width:110px;">
                                                {{ \Illuminate\Support\Str::limit($bab->judul, 20) }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mapelItem['grid'] as $row)
                                        <tr style="border-bottom:1px solid #f1f5f9;transition:background .15s;"
                                            onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                                            <td style="padding:11px 16px;font-weight:600;color:#0f172a;">{{ $row['siswa']->nama }}</td>
                                            @foreach ($mapelItem['babList'] as $bab)
                                                @php $pct = $row['scores'][$bab->Id_materi] ?? null; @endphp
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
                    </div>
                @endforeach
            </div>
        @endforeach

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
