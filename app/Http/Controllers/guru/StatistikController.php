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
        $guru = Auth::user();

        // 1. Ambil semua kelas
        $kelas_id  = $request->kelas_id;
        $kelasList = \App\Models\Kelas::orderBy('nama')->get();

        // 2. Ambil semua mapel milik guru ini
        $mapels = \App\Models\MataPelajaran::where('Id_user', $guru->Id_user)
            ->with(['materis' => fn($q) => $q->orderBy('urutan')])
            ->orderBy('urutan')
            ->get();

        // 3. Ambil semua siswa
        $siswas = User::where('role', 'siswa')->orderBy('nama')->get();

        // 4. Ambil semua materi milik guru ini
        $materis = Materi::where('Id_user', $guru->Id_user)->get();

        // 5. Pre-compute total poin dan soal IDs per materi
        $materiInfo = [];
        $allSoalIds = [];
        foreach ($materis as $m) {
            $soalIds = $m->soals()->pluck('Id_soal')->toArray();
            $totalPoin = $m->soals()->sum('poin');
            $materiInfo[$m->Id_materi] = [
                'soalIds' => $soalIds,
                'totalPoin' => $totalPoin
            ];
            $allSoalIds = array_merge($allSoalIds, $soalIds);
        }

        // 6. Ambil hasil latihan
        $hasilMap = HasilLatihan::whereIn('Id_soal', $allSoalIds)
            ->selectRaw('Id_user, Id_soal, nilai')
            ->get()
            ->groupBy('Id_user');

        // 7. Bangun hirarki
        $hierarchy = [];
        $activeKelasList = $kelas_id 
            ? $kelasList->where('Id_kelas', $kelas_id) 
            : $kelasList;

        foreach ($activeKelasList as $kelas) {
            $kelasSiswa = $siswas->where('kelas_id', $kelas->Id_kelas);
            $kelasMapels = $mapels->where('kelas_id', $kelas->Id_kelas);

            if ($kelasSiswa->isEmpty() && $kelasMapels->isEmpty()) {
                continue;
            }

            $mapelData = [];
            foreach ($kelasMapels as $mapel) {
                $babList = $mapel->materis;
                if ($babList->isEmpty()) {
                    continue;
                }

                $grid = [];
                foreach ($kelasSiswa as $s) {
                    $hasilSiswa = $hasilMap->get($s->Id_user, collect());
                    $scores = [];
                    foreach ($babList as $m) {
                        $info = $materiInfo[$m->Id_materi] ?? ['soalIds' => [], 'totalPoin' => 0];
                        if (empty($info['soalIds']) || $info['totalPoin'] == 0) {
                            $scores[$m->Id_materi] = null;
                        } else {
                            $dijawab = $hasilSiswa->whereIn('Id_soal', $info['soalIds'])->count();
                            if ($dijawab == 0) {
                                $scores[$m->Id_materi] = null;
                            } else {
                                $diraih = $hasilSiswa->whereIn('Id_soal', $info['soalIds'])->sum('nilai');
                                $scores[$m->Id_materi] = $info['totalPoin'] > 0 ? round($diraih / $info['totalPoin'] * 100) : 0;
                            }
                        }
                    }
                    $grid[] = [
                        'siswa' => $s,
                        'scores' => $scores
                    ];
                }

                $mapelData[] = [
                    'mapel' => $mapel,
                    'babList' => $babList,
                    'grid' => $grid
                ];
            }

            if (!empty($mapelData)) {
                $hierarchy[] = [
                    'kelas' => $kelas,
                    'mapelData' => $mapelData
                ];
            }
        }

        return view('guru.statistik.progres', compact('hierarchy', 'kelasList', 'kelas_id'));
    }

    // ── LAPORAN: statistik per materi dari hasil_latihan ──
    public function laporan(Request $request)
    {
        /** @var \App\Models\User $guru */
        $guru     = Auth::user();
        $materis  = Materi::where('Id_user', $guru->Id_user)
            ->with(['mataPelajaran'])
            ->withCount('soals')
            ->orderBy('mapel_id')
            ->orderBy('urutan')
            ->get();
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
        $materiId = $request->materi_id;
        $kategoriId = $request->kategori_id;

        // Get all materials belonging to this teacher
        $materis = Materi::where('Id_user', $guru->Id_user)
            ->with(['mataPelajaran', 'mataPelajaran.kelas'])
            ->orderBy('mapel_id')
            ->orderBy('urutan')
            ->get();

        // Selected material
        $selected = $materiId
            ? Materi::find($materiId)
            : null;

        // Get all categories for filter buttons
        $kategoris = \App\Models\KategoriLatihan::orderBy('urutan')->get();

        $evaluasiData = [];
        if ($selected) {
            // Load questions of this material, optionally filtered by kategori_id
            $soalsQuery = $selected->soals();
            if ($kategoriId) {
                $soalsQuery->where('kategori_id', $kategoriId);
            }
            $soals = $soalsQuery->with('pilihanJawabans')->get();

            foreach ($soals as $soal) {
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

        return view('guru.statistik.evaluasi', compact('materis', 'selected', 'evaluasiData', 'kategoris', 'kategoriId'));
    }
}
