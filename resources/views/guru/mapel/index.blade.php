@extends('layouts.guru')
@section('title', 'Mata Pelajaran')
@section('page-title', 'Mata Pelajaran')
@section('page-subtitle')kelola semua mata pelajaran Anda @endsection

@section('topbar-actions')
    <a href="{{ route('guru.mapel.create') }}" class="btn-primary-sm">
        <i class="bi bi-plus-lg"></i> Tambah Mata Pelajaran
    </a>
@endsection

@section('content')

    {{-- Group mapels by kelas --}}
    @php
        $byKelas = $mapels->getCollection()->groupBy(fn($m) => $m->kelas?->nama ?? 'KELAS X');
    @endphp

    @forelse($byKelas as $kelasNama => $items)
        <div style="margin-bottom:28px;">

            {{-- Kelas header --}}
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                <div
                    style="width:32px;height:32px;border-radius:8px;background:#0f172a;
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-mortarboard-fill" style="color:#fff;font-size:14px;"></i>
                </div>
                <span style="font-weight:bold;">{{ $kelasNama }}</span>
                    
            </div>

            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
                @foreach ($items as $mapel)
                    @php
                        $colors = ['#1a56db', '#4f46e5', '#0f766e', '#b45309', '#be185d', '#0369a1'];
                        $c = $colors[crc32($mapel->nama) % 6];
                        $c2 = $colors[(crc32($mapel->nama) + 2) % 6];
                    @endphp
                    <div
                        style="background:#fff;border-radius:14px;border:1px solid #e9edf2;
                            overflow:hidden;display:flex;flex-direction:column;">

                        {{-- Header --}}
                        <div
                            style="height:90px;background:linear-gradient(135deg,{{ $c }},{{ $c2 }});
                                display:flex;align-items:center;padding:0 20px;position:relative;">
                            <div style="font-size:28px;font-weight:800;color:rgba(255,255,255,.2);font-style:italic;">
                                {{ strtoupper(substr($mapel->nama, 0, 2)) }}
                            </div>
                            <div style="margin-left:12px;flex:1;min-width:0;">
                                <div
                                    style="font-size:14px;font-weight:800;color:#fff;line-height:1.2;
                                        overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                    {{ $mapel->nama }}
                                </div>
                                <div style="font-size:11px;color:rgba(255,255,255,.7);margin-top:3px;">
                                    {{ $mapel->materis_count }} bab
                                </div>
                            </div>
                            {{-- Kelas badge di sudut --}}
                            <div
                                style="position:absolute;top:10px;right:12px;
                                    background:rgba(255,255,255,.2);backdrop-filter:blur(4px);
                                    padding:3px 9px;border-radius:20px;font-size:10.5px;
                                    font-weight:700;color:#fff;border:1px solid rgba(255,255,255,.3);">
                                {{ $mapel->kelas?->nama ?? '—' }}
                            </div>
                        </div>

                        {{-- Body --}}
                        <div style="padding:14px 16px;flex:1;">
                            @if ($mapel->deskripsi)
                                <div style="font-size:12.5px;color:#64748b;line-height:1.6;margin-bottom:12px;">
                                    {{ \Illuminate\Support\Str::limit($mapel->deskripsi, 80) }}
                                </div>
                            @else
                                <div style="margin-bottom:12px;"></div>
                            @endif
                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                <a href="{{ route('guru.mapel.kelola', $mapel) }}"
                                    style="flex:1;text-align:center;background:{{ $c }};color:#fff;
                                       border-radius:8px;padding:8px;font-size:12.5px;font-weight:600;text-decoration:none;">
                                    <i class="bi bi-grid-3x3-gap me-1"></i> Kelola Bab & Akses
                                </a>
                                <a href="{{ route('guru.mapel.edit', $mapel) }}"
                                    style="width:34px;height:34px;border:1.5px solid #e2e8f0;border-radius:8px;
                                       display:flex;align-items:center;justify-content:center;
                                       color:#64748b;text-decoration:none;font-size:14px;">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('guru.mapel.destroy', $mapel) }}"
                                    onsubmit="return confirm('Hapus mata pelajaran ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        style="width:34px;height:34px;border:1.5px solid #fecaca;border-radius:8px;
                                           background:#fef2f2;color:#b91c1c;cursor:pointer;font-size:14px;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div
            style="text-align:center;padding:64px;color:#94a3b8;background:#fff;
                border-radius:14px;border:1px solid #e9edf2;">
            <i class="bi bi-collection" style="font-size:40px;display:block;margin-bottom:12px;"></i>
            <div style="font-size:15px;font-weight:500;">Belum ada mata pelajaran</div>
            <a href="{{ route('guru.mapel.create') }}"
                style="font-size:13px;color:#1a56db;font-weight:600;margin-top:10px;display:inline-block;">
                + Buat sekarang
            </a>
        </div>
    @endforelse

    @if ($mapels->hasPages())
        <div style="margin-top:20px;">{{ $mapels->links() }}</div>
    @endif

@endsection
