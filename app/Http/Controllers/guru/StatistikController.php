<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\User;
use App\Models\HasilLatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatistikController extends Controller
{
    // ── PROGRES: tabel siswa × materi, nilai dari hasil_latihan ──
    public function progres(Request $request)
    {
        /** @var \App\Models\User $guru */
        $guru    = Auth::user();
        $materis = Materi::where('Id_user', $guru->Id_user)->withCount('soals')->orderBy('urutan')->get();
        $siswa   = User::where('role', 'siswa')->orderBy('nama')->get();

        // Pre-load semua hasil latihan yang relevan — 1 query
        $semuaSoalIds = $materis->flatMap(fn($m) => $m->soals()->pluck('Id_soal'));

        $hasilMap = HasilLatihan::whereIn('Id_soal', $semuaSoalIds)
            ->selectRaw('Id_user, Id_soal, nilai')
            ->get()
            ->groupBy('Id_user'); // key: Id_user → collection hasil

        // Total poin per materi (pre-compute)
        $poinPerMateri = $materis->mapWithKeys(function ($m) {
            return [$m->Id_materi => [
                'soalIds'    => $m->soals()->pluck('Id_soal'),
                'totalPoin'  => $m->soals()->sum('poin'),
            ]];
        });

        // Bangun grid: siswa × materi → persentase
        $grid = [];
        foreach ($siswa as $s) {
            $hasilSiswa = $hasilMap->get($s->Id_user, collect());
            $row        = ['siswa' => $s, 'materi' => []];

            foreach ($materis as $m) {
                $info      = $poinPerMateri[$m->Id_materi];
                $diraih    = $hasilSiswa->whereIn('Id_soal', $info['soalIds']->toArray())->sum('nilai');
                $totalPoin = $info['totalPoin'];

                $row['materi'][$m->Id_materi] = ($totalPoin > 0 && $diraih > 0)
                    ? round($diraih / $totalPoin * 100)
                    : null;
            }
            $grid[] = $row;
        }

        return view('guru.statistik.progres', compact('materis', 'siswa', 'grid'));
    }

    // ── LAPORAN: statistik per materi dari hasil_latihan ──
    public function laporan(Request $request)
    {
        /** @var \App\Models\User $guru */
        $guru     = Auth::user();
        $materis  = Materi::where('Id_user', $guru->Id_user)->withCount('soals')->orderBy('urutan')->get();
        $selected = $request->materi_id ? Materi::find($request->materi_id) : $materis->first();

        $stats = null;
        if ($selected) {
            $soalIds   = $selected->soals()->pluck('Id_soal');
            $totalPoin = $selected->soals()->sum('poin');

            if ($soalIds->isEmpty() || $totalPoin == 0) {
                $stats = ['sesi' => collect(), 'rata' => 0, 'tertinggi' => 0, 'terendah' => 0, 'lulus' => 0, 'total' => 0];
            } else {
                // Hitung persentase per siswa dari hasil_latihan
                $nilaiPerSiswa = HasilLatihan::whereIn('Id_soal', $soalIds)
                    ->selectRaw('Id_user, SUM(nilai) as total_nilai, COUNT(DISTINCT Id_soal) as dijawab, MAX(created_at) as selesai_at')
                    ->groupBy('Id_user')
                    ->with('user')
                    ->get()
                    ->map(function ($row) use ($totalPoin) {
                        $row->persentase = round($row->total_nilai / $totalPoin * 100);
                        $row->poin_diraih = $row->total_nilai;
                        $row->total_poin  = $totalPoin;
                        return $row;
                    })
                    ->sortByDesc('persentase')
                    ->values();

                $stats = [
                    'sesi'      => $nilaiPerSiswa,
                    'rata'      => $nilaiPerSiswa->avg('persentase') ?? 0,
                    'tertinggi' => $nilaiPerSiswa->max('persentase') ?? 0,
                    'terendah'  => $nilaiPerSiswa->min('persentase') ?? 0,
                    'lulus'     => $nilaiPerSiswa->where('persentase', '>=', 60)->count(),
                    'total'     => $nilaiPerSiswa->count(),
                ];
            }
        }

        return view('guru.statistik.laporan', compact('materis', 'selected', 'stats'));
    }

    // ── EVALUASI: analisis per soal ──
    public function evaluasi(Request $request)
    {
        /** @var \App\Models\User $guru */
        $guru     = Auth::user();
        $materis  = Materi::where('Id_user', $guru->Id_user)->get();
        $selected = $request->materi_id
            ? Materi::with('soals.pilihanJawabans')->find($request->materi_id)
            : null;

        $evaluasiData = [];
        if ($selected) {
            foreach ($selected->soals as $soal) {
                $jawaban = HasilLatihan::where('Id_soal', $soal->Id_soal)->with('user')->get();
                $benar   = $jawaban->where('is_benar', true)->count();
                $total   = $jawaban->count();

                $evaluasiData[] = [
                    'soal'       => $soal,
                    'total'      => $total,
                    'benar'      => $benar,
                    'salah'      => $total - $benar,
                    'persentase' => $total > 0 ? round($benar / $total * 100) : 0,
                    'jawaban'    => $jawaban,
                ];
            }
        }

        return view('guru.statistik.evaluasi', compact('materis', 'selected', 'evaluasiData'));
    }
}
