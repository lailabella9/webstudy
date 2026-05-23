@extends('layouts.guru')
@section('title', 'Soal — ' . $materi->judul)
@section('page-title', 'Kelola Soal')
@section('page-subtitle'){{ $materi->judul }}@endsection

@section('topbar-actions')
    {{-- Kembali ke halaman kelola mapel --}}
    @if ($materi->mapel_id)
        <a href="{{ route('guru.mapel.kelola', $materi->mapel_id) }}" class="btn-icon-sm" title="Kembali ke Kelola Bab">
            <i class="bi bi-arrow-left"></i>
        </a>
    @endif
    <a href="{{ route('guru.soal.create', $materi) }}" class="btn-primary-sm">
        <i class="bi bi-plus-lg"></i> Tambah Soal
    </a>
@endsection

@section('content')

    {{-- ── Ringkasan per kategori ── --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:12px;margin-bottom:24px;">
        @foreach ($kategoris as $k)
            @php $count = $soalsByKategori->get($k->Id_kategori)?->count() ?? 0; @endphp
            <div
                style="background:#fff;border-radius:12px;border:1.5px solid #e9edf2;
                        padding:16px 18px;display:flex;align-items:center;gap:12px;">
                <div
                    style="width:42px;height:42px;border-radius:10px;background:{{ $k->warna }}15;
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi {{ $k->ikon }}" style="font-size:18px;color:{{ $k->warna }};"></i>
                </div>
                <div>
                    <div style="font-size:11.5px;font-weight:600;color:#64748b;">{{ $k->nama }}</div>
                    <div style="font-size:22px;font-weight:800;color:#0f172a;line-height:1.1;">{{ $count }}</div>
                    <div style="font-size:11px;color:#94a3b8;">soal</div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ── Tab filter kategori ── --}}
    <div style="display:flex;gap:0;margin-bottom:20px;border-bottom:2px solid #e9edf2;overflow-x:auto;">
        <button onclick="filterKategori('semua')" id="tab-semua"
            style="padding:10px 20px;border:none;background:none;font-size:13px;font-weight:600;
                   color:#1a56db;border-bottom:2px solid #1a56db;margin-bottom:-2px;
                   cursor:pointer;white-space:nowrap;display:flex;align-items:center;gap:6px;">
            <i class="bi bi-grid"></i> Semua
        </button>
        @foreach ($kategoris as $k)
            @php $count = $soalsByKategori->get($k->Id_kategori)?->count() ?? 0; @endphp
            <button onclick="filterKategori('{{ $k->Id_kategori }}')" id="tab-{{ $k->Id_kategori }}"
                style="padding:10px 20px;border:none;background:none;font-size:13px;font-weight:600;
                       color:#64748b;border-bottom:2px solid transparent;margin-bottom:-2px;
                       cursor:pointer;white-space:nowrap;display:flex;align-items:center;gap:7px;">
                <i class="bi {{ $k->ikon }}" style="color:{{ $k->warna }};font-size:13px;"></i>
                {{ $k->nama }}
                <span
                    style="background:{{ $k->warna }}18;color:{{ $k->warna }};
                             font-size:10.5px;padding:1px 8px;border-radius:20px;font-weight:700;">
                    {{ $count }}
                </span>
            </button>
        @endforeach
    </div>

    {{-- ── Soal per kategori ── --}}
    @foreach ($kategoris as $k)
        @php $soals = $soalsByKategori->get($k->Id_kategori, collect()); @endphp

        <div class="kategori-section" id="section-{{ $k->Id_kategori }}" style="margin-bottom:28px;">

            {{-- Header seksi kategori --}}
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                <div
                    style="width:34px;height:34px;border-radius:9px;background:{{ $k->warna }};
                            display:flex;align-items:center;justify-content:center;">
                    <i class="bi {{ $k->ikon }}" style="color:#fff;font-size:15px;"></i>
                </div>
                <div>
                    <span style="font-size:14px;font-weight:800;color:#0f172a;">{{ $k->nama }}</span>
                    <span style="font-size:12px;color:#94a3b8;margin-left:8px;">{{ $soals->count() }} soal</span>
                    @if (str_contains(strtolower($k->nama), 'harian') || str_contains(strtolower($k->nama), 'latihan'))
                        <span
                            style="font-size:11px;background:#f0fdf4;color:#16a34a;padding:2px 8px;
                                     border-radius:5px;margin-left:6px;font-weight:600;">
                            Setelah pembahasan bab
                        </span>
                    @elseif(str_contains(strtolower($k->nama), 'uts'))
                        <span
                            style="font-size:11px;background:#fff7ed;color:#ea580c;padding:2px 8px;
                                     border-radius:5px;margin-left:6px;font-weight:600;">
                            Ujian Tengah Semester
                        </span>
                    @elseif(str_contains(strtolower($k->nama), 'uas'))
                        <span
                            style="font-size:11px;background:#faf5ff;color:#7c3aed;padding:2px 8px;
                                     border-radius:5px;margin-left:6px;font-weight:600;">
                            Ujian Akhir Semester
                        </span>
                    @endif
                </div>
                <a href="{{ route('guru.soal.create', $materi) }}?kategori={{ $k->Id_kategori }}"
                    style="margin-left:auto;font-size:12px;color:{{ $k->warna }};font-weight:700;
                          text-decoration:none;display:flex;align-items:center;gap:5px;
                          padding:6px 12px;border:1.5px solid {{ $k->warna }}30;border-radius:8px;
                          background:{{ $k->warna }}08;">
                    <i class="bi bi-plus-circle"></i> Tambah Soal {{ $k->nama }}
                </a>
            </div>

            @if ($soals->count())
                <div style="background:#fff;border-radius:12px;border:1px solid #e9edf2;overflow:hidden;">
                    @foreach ($soals as $i => $soal)
                        @php
                            $huruf = ['A', 'B', 'C', 'D', 'E', 'F'];
                            $idxBenar = $soal->pilihanJawabans->search(fn($p) => $p->is_benar);
                            $kunci = $idxBenar !== false && isset($huruf[$idxBenar]) ? $huruf[$idxBenar] : '?';
                        @endphp
                        <div style="padding:16px 18px;border-bottom:{{ $i < $soals->count() - 1 ? '1px solid #f1f5f9' : 'none' }};
                                    display:flex;align-items:flex-start;gap:14px;transition:background .15s;"
                            onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">

                            {{-- Nomor --}}
                            <span
                                style="min-width:30px;height:30px;background:#f1f5f9;color:#64748b;border-radius:8px;
                                         display:flex;align-items:center;justify-content:center;
                                         font-size:12px;font-weight:700;flex-shrink:0;margin-top:1px;">
                                {{ $i + 1 }}
                            </span>

                            {{-- Konten soal --}}
                            <div style="flex:1;min-width:0;">
                                <div
                                    style="font-size:13.5px;color:#0f172a;font-weight:500;
                                            line-height:1.5;margin-bottom:8px;">
                                    {{ \Illuminate\Support\Str::limit($soal->pertanyaan, 120) }}
                                </div>
                                <div style="display:flex;gap:5px;flex-wrap:wrap;">
                                    @foreach ($soal->pilihanJawabans->take(5) as $pi => $p)
                                        <span
                                            style="font-size:11.5px;padding:3px 10px;border-radius:6px;
                                                     background:{{ $p->is_benar ? '#f0fdf4' : '#f8fafc' }};
                                                     color:{{ $p->is_benar ? '#15803d' : '#64748b' }};
                                                     border:1px solid {{ $p->is_benar ? '#bbf7d0' : '#e9edf2' }};
                                                     font-weight:{{ $p->is_benar ? '700' : '400' }};">
                                            {{ $huruf[$pi] ?? $pi + 1 }}.
                                            {{ \Illuminate\Support\Str::limit($p->teks_pilihan, 24) }}
                                        </span>
                                    @endforeach
                                </div>
                                <div style="margin-top:8px;display:flex;align-items:center;gap:8px;">
                                    <span style="font-size:11px;color:#94a3b8;">Poin: {{ $soal->poin }}</span>
                                    <span style="font-size:11px;color:#94a3b8;">·</span>
                                    <span style="font-size:11px;color:#94a3b8;text-transform:capitalize;">
                                        {{ str_replace('_', ' ', $soal->tipe_soal) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Kunci & Aksi --}}
                            <div style="display:flex;align-items:center;gap:6px;flex-shrink:0;">
                                <div style="width:28px;height:28px;border-radius:7px;
                                            background:{{ $k->warna }}18;color:{{ $k->warna }};
                                            border:1.5px solid {{ $k->warna }}30;
                                            display:flex;align-items:center;justify-content:center;
                                            font-size:12px;font-weight:800;"
                                    title="Kunci jawaban: {{ $kunci }}">
                                    {{ $kunci }}
                                </div>
                                <a href="{{ route('guru.soal.edit', [$materi, $soal]) }}"
                                    style="width:32px;height:32px;border-radius:8px;background:#fffbeb;
                                           color:#b45309;display:flex;align-items:center;justify-content:center;
                                           text-decoration:none;font-size:14px;"
                                    title="Edit Soal">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('guru.soal.destroy', [$materi, $soal]) }}"
                                    onsubmit="return confirm('Hapus soal ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        style="width:32px;height:32px;border-radius:8px;background:#fef2f2;
                                               color:#b91c1c;border:none;cursor:pointer;font-size:14px;
                                               display:flex;align-items:center;justify-content:center;"
                                        title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div
                    style="border:2px dashed #e2e8f0;border-radius:12px;padding:32px;
                            text-align:center;color:#94a3b8;">
                    <i class="bi {{ $k->ikon }}"
                        style="font-size:32px;display:block;margin-bottom:10px;color:{{ $k->warna }}40;"></i>
                    <div style="font-size:13px;font-weight:500;margin-bottom:8px;">
                        Belum ada soal {{ $k->nama }}
                    </div>
                    <a href="{{ route('guru.soal.create', $materi) }}?kategori={{ $k->Id_kategori }}"
                        style="font-size:12.5px;color:{{ $k->warna }};font-weight:700;
                               text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
                        <i class="bi bi-plus-circle"></i> Tambah soal pertama
                    </a>
                </div>
            @endif
        </div>
    @endforeach

@endsection

@push('scripts')
    <script>
        function filterKategori(id) {
            const sections = document.querySelectorAll('.kategori-section');
            const tabs = document.querySelectorAll('[id^="tab-"]');

            // Reset semua tab
            tabs.forEach(t => {
                t.style.color = '#64748b';
                t.style.borderBottomColor = 'transparent';
            });

            if (id === 'semua') {
                sections.forEach(s => s.style.display = '');
                const tab = document.getElementById('tab-semua');
                tab.style.color = '#1a56db';
                tab.style.borderBottomColor = '#1a56db';
            } else {
                sections.forEach(s => s.style.display = s.id === 'section-' + id ? '' : 'none');
                const tab = document.getElementById('tab-' + id);
                if (tab) {
                    tab.style.color = '#0f172a';
                    tab.style.borderBottomColor = '#0f172a';
                }
            }
        }

        // Pre-select dari query param
        const urlParams = new URLSearchParams(window.location.search);
        const kat = urlParams.get('kategori');
        if (kat) filterKategori(kat);
    </script>
@endpush
