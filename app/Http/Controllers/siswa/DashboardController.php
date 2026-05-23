<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\HasilLatihan;
use App\Models\Soal;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa  = Auth::user();
        $userId = $siswa->Id_user;
        $kkm    = \App\Http\Controllers\Siswa\LatihanController::KKM;

        // ── Mapel milik kelas siswa ──────────────────────────────────────
        $mapelBase = MataPelajaran::when(
            $siswa->kelas_id,
            fn($q) => $q->where('kelas_id', $siswa->kelas_id)
        );

        $mapelIds = (clone $mapelBase)->pluck('Id_mapel');

        // Soal yang berasal dari mapel kelas siswa
        $kelassoalIds = Soal::whereHas(
            'materi',
            fn($q) => $q->whereIn('mapel_id', $mapelIds)
        )->pluck('Id_soal');

        // ── STAT CARDS ──────────────────────────────────────────────────
        $totalMapel = (clone $mapelBase)->count();

        $totalSoalDijawab = HasilLatihan::where('Id_user', $userId)
            ->whereIn('Id_soal', $kelassoalIds)
            ->distinct('Id_soal')
            ->count('Id_soal');

        $totalPoinMaks = Soal::whereIn('Id_soal', $kelassoalIds)->sum('poin');
        $totalDiraih   = HasilLatihan::where('Id_user', $userId)
            ->whereIn('Id_soal', $kelassoalIds)
            ->sum('nilai');
        $nilaiRata = $totalPoinMaks > 0
            ? round($totalDiraih / $totalPoinMaks * 100, 1)
            : 0;

        // FIX: prefix tabel agar tidak ambigu setelah JOIN
        $totalSesi = HasilLatihan::where('hasil_latihan.Id_user', $userId)
            ->whereIn('hasil_latihan.Id_soal', $kelassoalIds)
            ->join('soal', 'hasil_latihan.Id_soal', '=', 'soal.Id_soal')
            ->distinct('soal.materi_id')
            ->count('soal.materi_id');

        // ── PROGRES PER MATERI ───────────────────────────────────────────
        $hasilLatihan = HasilLatihan::where('Id_user', $userId)
            ->whereIn('Id_soal', $kelassoalIds)
            ->selectRaw('Id_soal, nilai, is_benar')
            ->get()
            ->keyBy('Id_soal');

        $mapels = (clone $mapelBase)
            ->with(['materis' => fn($q) => $q->orderBy('urutan'), 'materis.soals'])
            ->orderBy('urutan')
            ->get();

        $progresMapel = $mapels->map(function ($mapel) use ($hasilLatihan, $kkm) {
            $materis = $mapel->materis->map(function ($m) use ($hasilLatihan, $kkm) {
                $soalIds   = $m->soals->pluck('Id_soal');
                $totalSoal = $soalIds->count();
                $totalPoin = $m->soals->sum('poin');

                $dijawab = $soalIds->filter(fn($id) => $hasilLatihan->has($id))->count();
                $diraih  = $soalIds->sum(fn($id) => $hasilLatihan->get($id)?->nilai ?? 0);
                $nilai   = $totalPoin > 0 ? round($diraih / $totalPoin * 100) : 0;
                $selesai = $totalSoal > 0 && $dijawab === $totalSoal;

                return [
                    'judul'   => $m->judul,
                    'pct'     => $totalSoal > 0 ? round($dijawab / $totalSoal * 100) : 0,
                    'nilai'   => $nilai,
                    'dijawab' => $dijawab,
                    'total'   => $totalSoal,
                    'selesai' => $selesai,
                    'lulus'   => $selesai && $nilai >= $kkm,
                ];
            });

            $selesaiList = $materis->where('selesai', true);
            $avgMapel    = $selesaiList->count() > 0
                ? round($selesaiList->avg('nilai'))
                : 0;

            return [
                'nama'     => $mapel->nama,
                'materis'  => $materis,
                'avg'      => $avgMapel,
                'mapel_id' => $mapel->Id_mapel,
            ];
        })->filter(fn($m) => $m['materis']->isNotEmpty());

        // ── AKTIVITAS TERBARU ────────────────────────────────────────────
        $aktivitas = HasilLatihan::where('Id_user', $userId)
            ->whereIn('Id_soal', $kelassoalIds)
            ->with('soal.materi')
            ->latest('created_at')
            ->take(6)
            ->get();

        // ── LANJUTKAN BELAJAR ────────────────────────────────────────────
        $lanjutkan = (clone $mapelBase)
            ->withCount('materis')
            ->orderBy('urutan')
            ->take(3)
            ->get();

        return view('siswa.dashboard', compact(
            'siswa',
            'totalMapel',
            'totalSoalDijawab',
            'nilaiRata',
            'totalSesi',
            'progresMapel',
            'aktivitas',
            'lanjutkan',
            'kkm'
        ));
    }
}
