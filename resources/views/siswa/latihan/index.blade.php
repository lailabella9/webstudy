@extends('layouts.siswa')
@section('title', 'Materi Pembelajaran')
@section('page-title', 'Materi Pembelajaran')
@section('page-subtitle')pilih mata pelajaran dan mulai belajar @endsection

@section('content')

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
        @forelse($mapels as $mapel)
            @php
                $colors = ['#1a56db', '#4f46e5', '#0f766e', '#b45309', '#be185d', '#0369a1'];
                $idx = crc32($mapel->nama) % 6;
                $c1 = $colors[$idx];
                $c2 = $colors[($idx + 2) % 6];
            @endphp
            <a href="{{ route('siswa.latihan.mapel', $mapel) }}"
                style="background:#fff;border-radius:14px;border:1px solid #e9edf2;overflow:hidden;display:flex;flex-direction:column;text-decoration:none;transition:box-shadow .2s;"
                onmouseover="this.style.boxShadow='0 6px 24px rgba(0,0,0,.10)'" onmouseout="this.style.boxShadow=''">

                {{-- Thumbnail --}}
                <div
                    style="height:110px;background:linear-gradient(135deg,{{ $c1 }},{{ $c2 }});display:flex;align-items:center;justify-content:center;position:relative;">
                    <div
                        style="font-size:48px;font-weight:900;color:rgba(255,255,255,.18);font-style:italic;letter-spacing:-2px;">
                        {{ strtoupper(substr($mapel->nama, 0, 3)) }}
                    </div>
                    <div style="position:absolute;bottom:12px;left:16px;right:16px;">
                        <div style="font-size:15px;font-weight:800;color:#fff;line-height:1.2;">{{ $mapel->nama }}</div>
                        @if ($mapel->kelas)
                            <div style="font-size:11px;color:rgba(255,255,255,.7);margin-top:2px;">
                                <i class="bi bi-building" style="margin-right:2px;"></i>{{ $mapel->kelas->nama }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Info --}}
                <div style="padding:14px 16px;flex:1;display:flex;flex-direction:column;">
                    @if ($mapel->deskripsi)
                        <div style="font-size:12px;color:#64748b;line-height:1.6;margin-bottom:10px;flex:1;">
                            {{ \Illuminate\Support\Str::limit($mapel->deskripsi, 70) }}
                        </div>
                    @else
                        <div style="flex:1;"></div>
                    @endif

                    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:8px;">
                        <span style="font-size:12px;color:#94a3b8;">
                            <i class="bi bi-journal-richtext me-1"></i>{{ $mapel->materis_count }} bab
                        </span>
                        <span
                            style="font-size:12px;font-weight:600;color:{{ $c1 }};display:flex;align-items:center;gap:4px;">
                            Buka <i class="bi bi-arrow-right-circle"></i>
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <div style="grid-column:1/-1;text-align:center;padding:64px;color:#94a3b8;">
                <i class="bi bi-collection" style="font-size:40px;display:block;margin-bottom:12px;"></i>
                <div style="font-size:15px;font-weight:500;">Belum ada mata pelajaran tersedia</div>
                <div style="font-size:13px;margin-top:5px;color:#b0bec5;">Hubungi guru untuk ditambahkan ke kelas</div>
            </div>
        @endforelse
    </div>

    @if ($mapels->hasPages())
        <div style="margin-top:20px;">{{ $mapels->links() }}</div>
    @endif

@endsection
