@extends('layouts.guru')
@section('title', 'Kelola — ' . $mapel->nama)
@section('page-title', $mapel->nama)
@section('page-subtitle')kelola bab dan buka/tutup akses latihan untuk siswa @endsection

@section('topbar-actions')
    <a href="{{ route('guru.mapel.index') }}" class="btn-icon-sm"><i class="bi bi-arrow-left"></i></a>
    {{-- Tambah Bab menggunakan nested route (materi di dalam mapel) --}}
    <a href="{{ route('guru.materi.create', $mapel) }}" class="btn-primary-sm">
        <i class="bi bi-plus-lg"></i> Tambah Bab
    </a>
@endsection

@section('content')

    {{-- Legenda kategori --}}
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px;align-items:center;">
        @foreach ($kategoris as $k)
            <span
                style="display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:20px;
                       background:{{ $k->warna }}18;color:{{ $k->warna }};font-size:12px;font-weight:600;
                       border:1px solid {{ $k->warna }}30;">
                       
                <i class="bi {{ $k->ikon }}" style="font-size:12px;"></i> {{ $k->nama }}
            </span>
        @endforeach
        <span style="font-size:12px;color:#94a3b8;margin-left:4px;">— Toggle untuk buka/tutup akses siswa</span>
    </div>

    {{-- Daftar Bab --}}
    @forelse($materis as $materi)
        <div style="background:#fff;border-radius:14px;border:1px solid #e9edf2;margin-bottom:14px;overflow:hidden;">

            {{-- Header bab --}}
            <div
                style="padding:14px 20px;background:#f8fafc;border-bottom:1px solid #e9edf2;
                        display:flex;align-items:center;gap:12px;">
                <div
                    style="width:36px;height:36px;border-radius:9px;
                            background:#1a56db;
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-journal-richtext" style="color:#fff;font-size:15px;"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-size:14px;font-weight:700;color:#0f172a;">{{ $materi->judul }}</div>
                    <div style="font-size:11.5px;color:#64748b;margin-top:1px;">
                        Urutan ke-{{ $materi->urutan }} &middot; {{ $materi->soals_count }} soal total
                    </div>
                </div>
                <div style="display:flex;gap:6px;">
                    {{-- Kelola Soal --}}
                    <a href="{{ route('guru.soal.index', $materi) }}"
                        style="padding:6px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:12px;
                               font-weight:600;color:#374151;text-decoration:none;display:flex;align-items:center;gap:5px;">
                        <i class="bi bi-patch-question"></i> Kelola Soal
                    </a>
                    {{-- Edit Bab — nested route dengan $mapel dan $materi --}}
                    <a href="{{ route('guru.materi.edit', [$mapel, $materi]) }}"
                        style="width:32px;height:32px;border:1.5px solid #e2e8f0;border-radius:8px;
                               display:flex;align-items:center;justify-content:center;
                               color:#64748b;text-decoration:none;font-size:13px;"
                        title="Edit Bab">
                        <i class="bi bi-pencil"></i>
                    </a>
                    {{-- Hapus Bab --}}
                    <form method="POST" action="{{ route('guru.materi.destroy', [$mapel, $materi]) }}"
                        onsubmit="return confirm('Hapus bab \'{{ $materi->judul }}\'? Semua soal di dalamnya juga akan terhapus.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            style="width:32px;height:32px;border:1.5px solid #fecaca;border-radius:8px;
                                   background:#fef2f2;color:#b91c1c;cursor:pointer;font-size:13px;
                                   display:flex;align-items:center;justify-content:center;"
                            title="Hapus Bab">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Ringkasan soal per kategori --}}
            <div
                style="padding:10px 20px;background:#f8fafc;border-bottom:1px solid #e9edf2;
                        display:flex;gap:10px;flex-wrap:wrap;">
                @foreach ($kategoris as $k)
                    @php
                        $jumlahSoal = $materi->soals->where('kategori_id', $k->Id_kategori)->count();
                    @endphp
                    <a href="{{ route('guru.soal.index', $materi) }}?kategori={{ $k->Id_kategori }}"
                        style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:6px;
                              background:{{ $k->warna }}10;color:{{ $k->warna }};font-size:11.5px;
                              font-weight:600;text-decoration:none;border:1px solid {{ $k->warna }}25;">
                        <i class="bi {{ $k->ikon }}" style="font-size:11px;"></i>
                        {{ $k->nama }}: {{ $jumlahSoal }} soal
                    </a>
                @endforeach
            </div>

            {{-- Toggle akses per kategori --}}
            <div style="padding:14px 20px;display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
                @foreach ($kategoris as $k)
                    @php
                        $akses = $aksesMap->get($materi->Id_materi)?->firstWhere('kategori_id', $k->Id_kategori);
                        $isBuka = $akses?->isAktif() ?? false;
                        $jumlahSoal = $materi->soals->where('kategori_id', $k->Id_kategori)->count();
                    @endphp
                    <div
                        style="display:flex;align-items:center;gap:10px;padding:10px 14px;border-radius:10px;
                                border:1.5px solid {{ $isBuka ? $k->warna . '50' : '#e2e8f0' }};
                                background:{{ $isBuka ? $k->warna . '08' : '#f8fafc' }};min-width:160px;">
                        <div style="flex:1;">
                            <div style="display:flex;align-items:center;gap:6px;margin-bottom:2px;">
                                <i class="bi {{ $k->ikon }}" style="font-size:13px;color:{{ $k->warna }};"></i>
                                <span style="font-size:12.5px;font-weight:700;color:#0f172a;">{{ $k->nama }}</span>
                            </div>
                            <div style="font-size:11px;color:#94a3b8;">
                                {{ $jumlahSoal }} soal
                                @if ($jumlahSoal === 0)
                                    <span style="color:#f59e0b;">— belum ada soal</span>
                                @endif
                            </div>
                        </div>
                        {{-- Toggle switch --}}
                        <label style="position:relative;width:42px;height:24px;cursor:pointer;flex-shrink:0;"
                            title="{{ $isBuka ? 'Tutup akses' : 'Buka akses' }}">
                            <input type="checkbox" class="toggle-akses" data-mapel="{{ $mapel->Id_mapel }}"
                                data-materi="{{ $materi->Id_materi }}" data-kategori="{{ $k->Id_kategori }}"
                                {{ $isBuka ? 'checked' : '' }} {{ $jumlahSoal === 0 ? 'disabled' : '' }}
                                style="opacity:0;width:0;height:0;position:absolute;">
                            <span
                                style="position:absolute;top:0;left:0;right:0;bottom:0;border-radius:24px;
                                         background:{{ $isBuka ? $k->warna : '#e2e8f0' }};transition:background .2s;
                                         opacity:{{ $jumlahSoal === 0 ? '.5' : '1' }};">
                                <span
                                    style="position:absolute;top:3px;left:{{ $isBuka ? '21px' : '3px' }};
                                             width:18px;height:18px;border-radius:50%;background:#fff;
                                             transition:left .2s;box-shadow:0 1px 3px rgba(0,0,0,.15);"></span>
                            </span>
                        </label>
                    </div>
                @endforeach
            </div>

        </div>
    @empty
        <div
            style="text-align:center;padding:64px;color:#94a3b8;background:#fff;border-radius:14px;border:1px solid #e9edf2;">
            <i class="bi bi-journal-x" style="font-size:40px;display:block;margin-bottom:12px;"></i>
            <div style="font-size:15px;font-weight:500;">Belum ada bab di mata pelajaran ini</div>
            <a href="{{ route('guru.materi.create', $mapel) }}"
                style="font-size:13px;color:#1a56db;font-weight:600;margin-top:10px;display:inline-block;">
                + Tambah bab pertama
            </a>
        </div>
    @endforelse

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.toggle-akses').forEach(input => {
            input.addEventListener('change', function() {
                const mapelId = this.dataset.mapel;
                const materiId = this.dataset.materi;
                const kategoriId = this.dataset.kategori;
                const label = this.closest('label');
                const track = label.querySelector('span');
                const thumb = track.querySelector('span');
                const isBuka = this.checked;

                // Animasi optimistik
                track.style.background = isBuka ? '#1a56db' : '#e2e8f0';
                thumb.style.left = isBuka ? '21px' : '3px';

                fetch(`/guru/mapel/${mapelId}/toggle-akses`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            materi_id: materiId,
                            kategori_id: kategoriId
                        }),
                    })
                    .then(r => r.json())
                    .then(data => {
                        const notif = document.createElement('div');
                        notif.style.cssText =
                            'position:fixed;top:80px;right:20px;background:#0f172a;color:#fff;' +
                            'padding:10px 18px;border-radius:10px;font-size:13px;font-weight:500;' +
                            'z-index:9999;transition:opacity .3s;';
                        notif.textContent = data.message;
                        document.body.appendChild(notif);
                        setTimeout(() => {
                            notif.style.opacity = '0';
                            setTimeout(() => notif.remove(), 300);
                        }, 2000);
                    })
                    .catch(() => {
                        // Rollback jika gagal
                        this.checked = !isBuka;
                        track.style.background = !isBuka ? '#1a56db' : '#e2e8f0';
                        thumb.style.left = !isBuka ? '21px' : '3px';
                    });
            });
        });
    </script>
@endpush
