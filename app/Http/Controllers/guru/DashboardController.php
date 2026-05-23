<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\HasilLatihan;
use App\Models\User;
use App\Models\Soal;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $guru */
        $guru = Auth::user();

        // ── STAT CARDS ──
        $totalMapel   = MataPelajaran::where('Id_user', $guru->Id_user)->count();
        $totalMateri  = Materi::where('Id_user', $guru->Id_user)->count();
        $totalSoal    = Soal::whereHas('materi', fn($q) => $q->where('Id_user', $guru->Id_user))->count();
        $totalSiswa   = User::where('role', 'siswa')->count();
        $totalJawaban = HasilLatihan::whereHas('soal.materi', fn($q) => $q->where('Id_user', $guru->Id_user))->count();

        // ── Ambil soal IDs guru sekali ──
        $soalIds = Soal::whereHas('materi', fn($q) => $q->where('Id_user', $guru->Id_user))
            ->pluck('Id_soal');

        // ── GRAFIK NILAI PER MATERI ──
        // Hitung rata-rata nilai per materi dari hasil_latihan langsung
        $materis = Materi::where('Id_user', $guru->Id_user)
            ->withCount('soals')
            ->orderBy('urutan')
            ->get();

        $grafikData = $materis->map(function ($materi) {
            $soalIdsMateri  = $materi->soals()->pluck('Id_soal');
            $totalPoinMaks  = $materi->soals()->sum('poin');
            $jumlahSiswa    = HasilLatihan::whereIn('Id_soal', $soalIdsMateri)
                ->distinct('Id_user')->count('Id_user');

            if ($totalPoinMaks === 0 || $jumlahSiswa === 0) {
                return ['judul' => \Illuminate\Support\Str::limit($materi->judul, 20), 'rata' => 0, 'siswa' => 0];
            }

            $totalDiraih = HasilLatihan::whereIn('Id_soal', $soalIdsMateri)->sum('nilai');
            $rata        = round($totalDiraih / ($totalPoinMaks * $jumlahSiswa) * 100);

            return [
                'judul' => \Illuminate\Support\Str::limit($materi->judul, 20),
                'rata'  => $rata,
                'siswa' => $jumlahSiswa,
            ];
        });

        // ── DISTRIBUSI NILAI SISWA ──
        // Hitung persentase terbaik per siswa dari hasil_latihan
        $distribusi = ['lulus' => 0, 'hampir' => 0, 'perlu' => 0];

        if ($soalIds->isNotEmpty()) {
            $totalPoinGuru = Soal::whereIn('Id_soal', $soalIds)->sum('poin');

            if ($totalPoinGuru > 0) {
                $nilaiPerSiswa = HasilLatihan::whereIn('Id_soal', $soalIds)
                    ->selectRaw('Id_user, SUM(nilai) as total_nilai')
                    ->groupBy('Id_user')
                    ->get();

                foreach ($nilaiPerSiswa as $row) {
                    $pct = round($row->total_nilai / $totalPoinGuru * 100);
                    if ($pct >= 60)      $distribusi['lulus']++;
                    elseif ($pct >= 40)  $distribusi['hampir']++;
                    else                 $distribusi['perlu']++;
                }
            }
        }

        // ── PROGRES SISWA (top 8) ──
        $progres = collect();

        if ($soalIds->isNotEmpty()) {
            $totalPoinGuru  = Soal::whereIn('Id_soal', $soalIds)->sum('poin');
            $jawabanPerSiswa = HasilLatihan::whereIn('Id_soal', $soalIds)
                ->selectRaw('Id_user, SUM(nilai) as total_nilai, COUNT(DISTINCT Id_soal) as dijawab')
                ->groupBy('Id_user')
                ->with('user')
                ->get();

            $progres = $jawabanPerSiswa->map(function ($row) use ($soalIds, $totalPoinGuru) {
                $pct = $totalPoinGuru > 0 ? round($row->total_nilai / $totalPoinGuru * 100) : 0;
                return [
                    'nama'    => $row->user->nama ?? '-',
                    'foto'    => $row->user->foto_profil ?? null,
                    'pct'     => $pct,
                    'dijawab' => $row->dijawab,
                    'total'   => $soalIds->count(),
                    'id'      => $row->Id_user,
                ];
            })
                ->sortByDesc('pct')
                ->take(8)
                ->values();
        }

        return view('guru.dashboard', compact(
            'totalMapel',
            'totalMateri',
            'totalSoal',
            'totalSiswa',
            'totalJawaban',
            'grafikData',
            'distribusi',
            'progres'
        ));
    }
}
