<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CBT App') | {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="bg-gray-50 min-h-screen">

@auth
<nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-1">
                <span class="text-lg font-bold text-blue-600 mr-4">📚 CBT</span>
                @if(auth()->user()->isGuru())
                    <a href="{{ route('guru.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('guru.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}">Dashboard</a>
                    <a href="{{ route('guru.materi.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('guru.materi.*','guru.soal.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}">Materi</a>
                    <a href="{{ route('guru.siswa.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('guru.siswa.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}">Data Siswa</a>
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" class="px-3 py-2 rounded-md text-sm font-medium flex items-center gap-1 {{ request()->routeIs('guru.progres','guru.laporan','guru.evaluasi') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}">
                            Statistik <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-cloak class="absolute top-full left-0 mt-1 w-52 bg-white rounded-xl shadow-lg border border-gray-200 py-1 z-50">
                            <a href="{{ route('guru.progres') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">📊 Progres Siswa</a>
                            <a href="{{ route('guru.laporan') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">📈 Statistik & Laporan</a>
                            <a href="{{ route('guru.evaluasi') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">🔍 Evaluasi Jawaban</a>
                        </div>
                    </div>
                @else
                    <a href="{{ route('siswa.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('siswa.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}">Dashboard</a>
                    <a href="{{ route('siswa.latihan.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('siswa.latihan.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}">Latihan</a>
                    <a href="{{ route('siswa.riwayat') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('siswa.riwayat') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50' }}">Riwayat Nilai</a>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs px-2 py-1 rounded-full font-medium {{ auth()->user()->isGuru() ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" class="flex items-center gap-2 hover:opacity-80 transition">
                        @if(auth()->user()->foto_profil)
                        <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                        @else
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-sm font-bold">{{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}</div>
                        @endif
                        <span class="text-sm text-gray-700 hidden sm:inline">{{ auth()->user()->nama }}</span>
                    </button>
                    <div x-show="open" x-cloak class="absolute right-0 top-full mt-1 w-44 bg-white rounded-xl shadow-lg border border-gray-200 py-1 z-50">
                        <a href="{{ auth()->user()->isGuru() ? route('guru.profil.edit') : route('siswa.profil.edit') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">👤 Edit Profil</a>
                        <div class="border-t border-gray-100 mt-1 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">🚪 Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
@endauth

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 mb-4 text-sm">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-4 text-sm">❌ {{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-4 text-sm">
            <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif
</div>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    @yield('content')
</main>
@stack('scripts')
</body>
</html>
