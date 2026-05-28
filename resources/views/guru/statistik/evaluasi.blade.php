@extends('layouts.guru')
@section('title', 'Evaluasi Jawaban & Nilai Siswa')
@section('page-title', 'Evaluasi Jawaban')
@section('page-subtitle')analisis tingkat kesulitan soal berdasarkan jawaban siswa @endsection

@section('content')

    {{-- Filter Materi & Kategori --}}
    <div style="background:#fff;border-radius:16px;border:1px solid #e9edf2;padding:20px;margin-bottom:20px;box-shadow:0 4px 20px -2px rgba(15,23,42,0.04);">
        <form id="filterForm" method="GET" style="display:flex;flex-direction:column;gap:16px;">
            <input type="hidden" name="kategori_id" id="filterKategoriId" value="{{ $kategoriId }}">

            {{-- Row 0: Select Kelas --}}
            <div style="display:flex;align-items:center;gap:16px;flex-wrap:nowrap;">
                <div style="display:flex;align-items:center;gap:8px;min-width:110px;color:#475569;font-weight:700;font-size:12px;text-transform:uppercase;letter-spacing:.05em;">
                    <i class="bi bi-building" style="font-size:16px;color:#f59e0b;"></i>
                    <span>Kelas</span>
                </div>
                <select name="kelas_id" onchange="document.querySelector('select[name=\'materi_id\']').value=''; this.form.submit()"
                    style="min-width:280px;height:40px;border:1.5px solid #e2e8f0;border-radius:10px;padding:0 14px;font-size:13px;background:#fff;outline:none;color:#0f172a;cursor:pointer;">
                    <option value="">— Semua Kelas —</option>
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->Id_kelas }}" {{ $kelas_id == $k->Id_kelas ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Divider --}}
            <div style="height:1px;background:#f1f5f9;width:100%;"></div>

            {{-- Row 1: Select Materi --}}
            <div style="display:flex;align-items:center;gap:16px;flex-wrap:nowrap;">
                <div style="display:flex;align-items:center;gap:8px;min-width:110px;color:#475569;font-weight:700;font-size:12px;text-transform:uppercase;letter-spacing:.05em;">
                    <i class="bi bi-journal-check" style="font-size:16px;color:#10b981;"></i>
                    <span>Materi</span>
                </div>
                <select name="materi_id" onchange="this.form.submit()"
                    style="min-width:280px;height:40px;border:1.5px solid #e2e8f0;border-radius:10px;padding:0 14px;font-size:13px;background:#fff;outline:none;color:#0f172a;cursor:pointer;">
                    <option value="">— Pilih Materi —</option>
                    @foreach ($materis->groupBy(fn($m) => ($m->mataPelajaran->nama ?? 'Umum') . ($m->mataPelajaran && $m->mataPelajaran->kelas ? ' (' . $m->mataPelajaran->kelas->nama . ')' : '')) as $mapelNama => $materiMapel)
                        <optgroup label="{{ $mapelNama }}">
                            @foreach ($materiMapel as $m)
                                <option value="{{ $m->Id_materi }}" {{ optional($selected)->Id_materi == $m->Id_materi ? 'selected' : '' }}>
                                    {{ $m->judul }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            {{-- Divider --}}
            <div style="height:1px;background:#f1f5f9;width:100%;"></div>

            {{-- Row 2: Kategori Latihan --}}
            <div style="display:flex;align-items:center;gap:16px;flex-wrap:nowrap;">
                <div style="display:flex;align-items:center;gap:8px;min-width:110px;color:#475569;font-weight:700;font-size:12px;text-transform:uppercase;letter-spacing:.05em;">
                    <i class="bi bi-tags-fill" style="font-size:16px;color:#1a56db;"></i>
                    <span>Kategori</span>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;flex:1;">
                    <button type="button" onclick="setFilter('')" class="filter-pill {{ !$kategoriId ? 'active-all' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i> Semua Kategori
                    </button>
                    @foreach ($kategoris as $k)
                        <button type="button" onclick="setFilter('{{ $k->Id_kategori }}')" 
                            class="filter-pill {{ $kategoriId == $k->Id_kategori ? 'active-cat' : '' }}"
                            style="--cat-color: {{ $k->warna }};">
                            <i class="bi {{ $k->ikon }}"></i> {{ $k->nama }}
                        </button>
                    @endforeach
                </div>
            </div>
        </form>
    </div>

    <style>
        .filter-pill {
            padding: 8px 18px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            color: #475569;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .filter-pill i {
            font-size: 14px;
            opacity: 0.8;
            transition: transform 0.2s ease;
        }
        .filter-pill:hover {
            border-color: #cbd5e1;
            background: #eff1f5;
            color: #0f172a;
            transform: translateY(-1px);
        }
        .filter-pill:hover i {
            transform: scale(1.1);
        }
        .filter-pill.active-all {
            background: #1a56db;
            border-color: transparent;
            color: #fff;
            box-shadow: 0 4px 12px rgba(26, 86, 219, 0.25);
            transform: translateY(-1px) scale(1.02);
        }
        .filter-pill.active-cat {
            background: var(--cat-color);
            border-color: transparent;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px) scale(1.02);
        }
        .filter-pill.active-all i, .filter-pill.active-cat i {
            opacity: 1;
        }
    </style>

    <script>
        function setFilter(value) {
            document.getElementById('filterKategoriId').value = value;
            document.getElementById('filterForm').submit();
        }
    </script>

    @if ($selected && count($evaluasiData))
        <div style="display:flex;flex-direction:column;gap:14px;">
            @foreach ($evaluasiData as $i => $item)
                <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:20px;">
                    {{-- Header soal --}}
                    <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:16px;">
                        <span
                            style="flex-shrink:0;font-size:11px;font-weight:700;background:#eef2ff;color:#4f46e5;padding:4px 10px;border-radius:7px;">
                            {{ $i + 1 }}
                        </span>
                        <p style="font-size:13.5px;font-weight:600;color:#0f172a;line-height:1.6;margin:0;">
                            {{ $item['soal']->pertanyaan }}
                        </p>
                    </div>

                    {{-- Statistik jawaban --}}
                    <div style="display:flex;align-items:center;gap:20px;margin-bottom:12px;font-size:13px;">
                        <div style="display:flex;align-items:center;gap:6px;">
                            <span
                                style="width:10px;height:10px;border-radius:50%;background:#22c55e;display:inline-block;"></span>
                            <span style="color:#374151;">Benar: <strong
                                    style="color:#16a34a;">{{ $item['benar'] }}</strong></span>
                        </div>
                        <div style="display:flex;align-items:center;gap:6px;">
                            <span
                                style="width:10px;height:10px;border-radius:50%;background:#ef4444;display:inline-block;"></span>
                            <span style="color:#374151;">Salah: <strong
                                    style="color:#dc2626;">{{ $item['salah'] }}</strong></span>
                        </div>
                        <span style="color:#64748b;">Total: {{ $item['total'] }} siswa</span>
                        <span
                            style="margin-left:auto;font-size:11.5px;font-weight:700;padding:4px 12px;border-radius:20px;
                background:{{ $item['persentase'] >= 70 ? '#f0fdf4' : ($item['persentase'] >= 40 ? '#fffbeb' : '#fef2f2') }};
                color:{{ $item['persentase'] >= 70 ? '#16a34a' : ($item['persentase'] >= 40 ? '#ca8a04' : '#dc2626') }};">
                            {{ $item['persentase'] >= 70 ? '😊 Mudah' : ($item['persentase'] >= 40 ? '😐 Sedang' : '😓 Sulit') }}
                        </span>
                    </div>

                    {{-- Progress bar --}}
                    @if ($item['total'] > 0)
                        <div style="height:8px;background:#f1f5f9;border-radius:99px;overflow:hidden;margin-bottom:12px;">
                            <div
                                style="height:100%;width:{{ $item['persentase'] }}%;background:#22c55e;border-radius:99px;">
                            </div>
                        </div>
                    @endif

                    {{-- Jawaban benar --}}
                    <div
                        style="font-size:12px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:9px;padding:10px 14px;margin-bottom:10px;color:#15803d;">
                        ✅ Jawaban benar: <strong>{{ $item['soal']->jawabanBenar()?->teks_pilihan ?? 'N/A' }}</strong>
                    </div>

                    {{-- Detail collapsible --}}
                    @if ($item['total'] > 0)
                        <details style="margin-top:4px;">
                            <summary
                                style="font-size:12px;color:#1a56db;cursor:pointer;font-weight:600;list-style:none;display:flex;align-items:center;gap:4px;">
                                <i class="bi bi-chevron-right" style="font-size:10px;"></i>
                                Lihat detail jawaban siswa ({{ $item['total'] }})
                            </summary>
                            <div style="margin-top:10px;border:1px solid #e9edf2;border-radius:10px;overflow:hidden;">
                                <table style="width:100%;border-collapse:collapse;font-size:12px;">
                                    <thead style="background:#f8fafc;">
                                        <tr>
                                            <th style="padding:9px 14px;text-align:left;font-weight:600;color:#64748b;">Nama
                                                Siswa</th>
                                            <th style="padding:9px 14px;text-align:left;font-weight:600;color:#64748b;">
                                                Jawaban</th>
                                            <th style="padding:9px 14px;text-align:left;font-weight:600;color:#64748b;">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($item['jawaban'] as $j)
                                            <tr style="border-top:1px solid #f1f5f9;">
                                                <td style="padding:9px 14px;color:#374151;">
                                                    {{ $j->user->nama ?? '-' }}
                                                    @if(isset($j->user->kelas))
                                                        <span style="font-size:10px;font-weight:600;background:#f1f5f9;color:#64748b;padding:2px 6px;border-radius:4px;margin-left:4px;">
                                                            {{ $j->user->kelas->nama }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td style="padding:9px 14px;color:#64748b;">{{ $j->jawaban_siswa ?? '-' }}
                                                </td>
                                                <td style="padding:9px 14px;">
                                                    <span
                                                        style="font-size:11.5px;font-weight:600;color:{{ $j->is_benar ? '#16a34a' : '#dc2626' }};">
                                                        {{ $j->is_benar ? '✅ Benar' : '❌ Salah' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                    @endif
                </div>
            @endforeach
        </div>
    @elseif($selected)
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:64px;text-align:center;color:#94a3b8;">
            <i class="bi bi-journal-x" style="font-size:40px;display:block;margin-bottom:12px;"></i>
            <div style="font-size:14px;">Belum ada soal atau belum ada siswa yang mengerjakan materi ini.</div>
        </div>
    @else
        <div
            style="background:#fff;border-radius:14px;border:1px solid #e9edf2;padding:64px;text-align:center;color:#94a3b8;">
            <i class="bi bi-search" style="font-size:40px;display:block;margin-bottom:12px;"></i>
            <div style="font-size:14px;">Pilih materi di atas untuk melihat evaluasi.</div>
        </div>
    @endif
@endsection
