<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Guru\DashboardController    as GuruDashboard;
use App\Http\Controllers\Guru\MateriController       as GuruMateri;
use App\Http\Controllers\Guru\SoalController         as GuruSoal;
use App\Http\Controllers\Guru\MataPelajaranController;
use App\Http\Controllers\Guru\KelolaSiswaController;
use App\Http\Controllers\Guru\StatistikController;
use App\Http\Controllers\Guru\KelasController;        // ← tambah
use App\Http\Controllers\Admin\DashboardController   as AdminDashboard;
use App\Http\Controllers\Admin\KelolaGuruController  as AdminGuru;
use App\Http\Controllers\Admin\KelolaSiswaController as AdminSiswa;
use App\Http\Controllers\Admin\StatistikController   as AdminStatistik;
use App\Http\Controllers\Siswa\DashboardController   as SiswaDashboard;
use App\Http\Controllers\Siswa\LatihanController     as SiswaLatihan;

Route::get('/', function () {
    if (Auth::check()) {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        return $user->isGuru()
            ? redirect()->route('guru.dashboard')
            : redirect()->route('siswa.dashboard');
    }
    return view('landing');
})->name('home');

Route::get('/debug-db-check', function() {
    $user = \App\Models\User::where('nama', 'like', '%bagus%')->first();
    $mapel = \App\Models\MataPelajaran::find(4);
    $akses = \App\Models\AksesLatihan::all();
    $soals = \App\Models\Soal::all();
    $materis = \App\Models\Materi::all();
    
    $res = [];
    $res['user'] = $user ? [
        'nama' => $user->nama,
        'kelas_id' => $user->kelas_id,
        'kelas_nama' => $user->kelas?->nama
    ] : null;
    $res['mapel'] = $mapel ? [
        'nama' => $mapel->nama,
        'kelas_id' => $mapel->kelas_id,
        'kelas_nama' => $mapel->kelas?->nama
    ] : null;
    $res['materi'] = $materis->map(fn($m) => [
        'Id_materi' => $m->Id_materi,
        'judul' => $m->judul,
        'mapel_id' => $m->mapel_id,
        'soals_count' => $m->soals()->count(),
    ]);
    $res['soals'] = $soals->map(fn($s) => [
        'Id_soal' => $s->Id_soal,
        'materi_id' => $s->materi_id,
        'kategori_id' => $s->kategori_id,
    ]);
    $res['akses'] = $akses->map(fn($a) => [
        'materi_id' => $a->materi_id,
        'kategori_id' => $a->kategori_id,
        'is_buka' => $a->is_buka,
        'is_aktif' => $a->isAktif()
    ]);
    return response()->json($res);
});

// ── AUTH ──────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── ADMIN ─────────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // ── GURU ──
    Route::resource('guru', AdminGuru::class);
    Route::post('/guru/{guru}/toggle-status', [AdminGuru::class, 'toggleStatus'])->name('guru.toggle-status');

    // ── SISWA ──
    Route::resource('siswa', AdminSiswa::class)->except(['show']);

    // ── STATISTIK ──
    Route::get('/statistik', [AdminStatistik::class, 'index'])->name('statistik');
});

// ── GURU ──────────────────────────────────────────────────────────────────────
Route::prefix('guru')->name('guru.')->middleware(['auth', 'role:guru'])->group(function () {

    Route::get('/dashboard', [GuruDashboard::class, 'index'])->name('dashboard');

    // ── KELAS ──
    Route::prefix('kelas')->name('kelas.')->group(function () {
        Route::get('/',              [KelasController::class, 'index'])->name('index');
        Route::get('/tambah',        [KelasController::class, 'create'])->name('create');
        Route::post('/',             [KelasController::class, 'store'])->name('store');
        Route::get('/{kelas}/edit',  [KelasController::class, 'edit'])->name('edit');
        Route::put('/{kelas}',       [KelasController::class, 'update'])->name('update');
        Route::delete('/{kelas}',    [KelasController::class, 'destroy'])->name('destroy');
    });

    // ── MATA PELAJARAN ──
    Route::resource('mapel', MataPelajaranController::class)->except(['show']);
    Route::get('/mapel/{mapel}/kelola',        [MataPelajaranController::class, 'kelola'])->name('mapel.kelola');
    Route::post('/mapel/{mapel}/toggle-akses', [MataPelajaranController::class, 'toggleAkses'])->name('mapel.toggle-akses');

    // ── MATERI (semua) ──
    Route::get('/materi', [GuruMateri::class, 'indexAll'])->name('materi.all');

    // ── MATERI (per mapel) ──
    Route::prefix('materi/{mapel}')->name('materi.')->group(function () {
        Route::get('/',              [GuruMateri::class, 'index'])->name('index');
        Route::get('/tambah',        [GuruMateri::class, 'create'])->name('create');
        Route::post('/',             [GuruMateri::class, 'store'])->name('store');
        Route::get('/{materi}/edit', [GuruMateri::class, 'edit'])->name('edit');
        Route::put('/{materi}',      [GuruMateri::class, 'update'])->name('update');
        Route::delete('/{materi}',   [GuruMateri::class, 'destroy'])->name('destroy');
    });

    // ── SOAL (semua) ──
    Route::get('/soal', [GuruSoal::class, 'indexAll'])->name('soal.all');

    // ── SOAL (per materi) ──
    Route::prefix('materi/{materi}/soal')->name('soal.')->group(function () {
        Route::get('/',            [GuruSoal::class, 'index'])->name('index');
        Route::get('/tambah',      [GuruSoal::class, 'create'])->name('create');
        Route::post('/',           [GuruSoal::class, 'store'])->name('store');
        Route::get('/{soal}/edit', [GuruSoal::class, 'edit'])->name('edit');
        Route::put('/{soal}',      [GuruSoal::class, 'update'])->name('update');
        Route::delete('/{soal}',   [GuruSoal::class, 'destroy'])->name('destroy');
    });

    // ── SISWA ──
    Route::prefix('siswa')->name('siswa.')->group(function () {
                Route::get('/export/csv', [KelolaSiswaController::class, 'exportListCsv'])
            ->name('exportcsv');

        Route::get('/export/pdf', [KelolaSiswaController::class, 'exportListPdf'])
            ->name('exportpdf');
        Route::get('/',               [KelolaSiswaController::class, 'index'])->name('index');
        Route::get('/tambah',         [KelolaSiswaController::class, 'create'])->name('create');
        Route::post('/',              [KelolaSiswaController::class, 'store'])->name('store');
        Route::get('/{siswa}',        [KelolaSiswaController::class, 'show'])->name('show');
        Route::get('/{siswa}/edit',   [KelolaSiswaController::class, 'edit'])->name('edit');
        Route::put('/{siswa}',        [KelolaSiswaController::class, 'update'])->name('update');
        Route::delete('/{siswa}',     [KelolaSiswaController::class, 'destroy'])->name('destroy');
        Route::get('/{siswa}/print', [KelolaSiswaController::class, 'print'])->name('print');
        Route::get('/{siswa}/pdf',   [KelolaSiswaController::class, 'exportPdf'])->name('pdf');

    });

    Route::get('/progres',  [StatistikController::class, 'progres'])->name('progres');
    Route::get('/laporan',  [StatistikController::class, 'laporan'])->name('laporan');
    Route::get('/evaluasi', [StatistikController::class, 'evaluasi'])->name('evaluasi');

    Route::get('/profil',  [ProfilController::class, 'edit'])->name('profil.edit');
    Route::post('/profil', [ProfilController::class, 'update'])->name('profil.update');
});

// ── SISWA ──────────────────────────────────────────────────────────────────────
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {

    Route::get('/dashboard', [SiswaDashboard::class, 'index'])->name('dashboard');
    Route::get('/materi',    [SiswaLatihan::class, 'materiAll'])->name('materi.all');
    Route::get('/coding',    [SiswaLatihan::class, 'coding'])->name('coding');

    Route::get('/latihan',                                         [SiswaLatihan::class, 'index'])->name('latihan.index');
    Route::get('/latihan/mapel/{mapel}',                           [SiswaLatihan::class, 'mapel'])->name('latihan.mapel');
    Route::get('/latihan/{materi}/{kategori}/mulai',               [SiswaLatihan::class, 'mulai'])->name('latihan.mulai');
    Route::post('/latihan/soal/{soal}/jawab',                      [SiswaLatihan::class, 'jawab'])->name('latihan.jawab');
    Route::post('/latihan/{materi}/{kategori}/selesai',            [SiswaLatihan::class, 'selesai'])->name('latihan.selesai');
    Route::get('/latihan/{materi}/{kategori}/hasil',               [SiswaLatihan::class, 'hasil'])->name('latihan.hasil');
    Route::get('/latihan/{materi}/{kategori}/pembahasan',          [SiswaLatihan::class, 'pembahasan'])->name('latihan.pembahasan');
    Route::delete('/latihan/{materi}/{kategori}/ulangi',           [SiswaLatihan::class, 'ulangi'])->name('latihan.ulangi'); // ← tambah
    Route::get('/latihan/{materi}/download',                       [SiswaLatihan::class, 'download'])->name('latihan.download');

    Route::get('/riwayat', [SiswaLatihan::class, 'riwayat'])->name('riwayat');

    Route::get('/profil',  [ProfilController::class, 'edit'])->name('profil.edit');
    Route::post('/profil', [ProfilController::class, 'update'])->name('profil.update');
});
