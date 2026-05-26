<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Materi;
use App\Models\KategoriLatihan;
use App\Models\AksesLatihan;
use App\Models\Soal;
use App\Models\HasilLatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LatihanController extends Controller
{
    // ── KKM default (bisa dipindah ke config/app.php) ──
    const KKM = 75;

    // ── LIST MATA PELAJARAN — difilter by kelas siswa ──
    public function index()
    {
        $siswa  = Auth::user();

        $mapels = MataPelajaran::withCount('materis')
            ->when($siswa->kelas_id, function ($q) use ($siswa) {
                $siswaKelasNama = $siswa->kelas->nama ?? '';
                $q->whereHas('kelas', function ($subQ) use ($siswaKelasNama) {
                    $subQ->where(function($qq) use ($siswaKelasNama) {
                        $qq->where('nama', $siswaKelasNama)
                           ->orWhereRaw('? LIKE CONCAT(nama, " %")', [$siswaKelasNama]);
                    });
                });
            }, function ($q) {
                $q->whereNull('kelas_id');
            })
            ->orderBy('urutan')
            ->paginate(12);

        return view('siswa.latihan.index', compact('mapels'));
    }

    // ── MATERI STANDALONE — baca & download, difilter by kelas siswa ──
    public function materiAll()
    {
        $siswa  = Auth::user();
        $mapels = MataPelajaran::orderBy('urutan')
            ->when($siswa->kelas_id, function ($q) use ($siswa) {
                $siswaKelasNama = $siswa->kelas->nama ?? '';
                $q->whereHas('kelas', function ($subQ) use ($siswaKelasNama) {
                    $subQ->where(function($qq) use ($siswaKelasNama) {
                        $qq->where('nama', $siswaKelasNama)
                           ->orWhereRaw('? LIKE CONCAT(nama, " %")', [$siswaKelasNama]);
                    });
                });
            }, function ($q) {
                $q->whereNull('kelas_id');
            })
            ->get()
            ->map(fn($mapel) => [
                'mapel'   => $mapel,
                'materis' => $mapel->materis()->orderBy('urutan')->get()->map(fn($m) => ['materi' => $m]),
            ])
            ->filter(fn($item) => $item['materis']->isNotEmpty());

        return view('siswa.latihan.materi_all', compact('mapels'));
    }

    // ── LATIHAN CODING ──
    public function coding()
    {
        return view('siswa.latihan.coding');
    }

    // ── DETAIL MAPEL: daftar bab + kategori yang AKTIF — dengan lock KKM ──
    public function mapel(MataPelajaran $mapel)
    {
        abort_unless($this->checkKelasAksesMapel($mapel), 403, 'Anda tidak memiliki akses ke mata pelajaran ini.');

        $userId    = Auth::id();
        $kategoris = KategoriLatihan::orderBy('urutan')->get();
        $kkm       = self::KKM;

        $materisRaw = $mapel->materis()
            ->withCount('soals')
            ->orderBy('urutan')
            ->get()
            ->map(function ($m) use ($userId, $kategoris, $kkm) {
                $babData = [];
                foreach ($kategoris as $k) {
                    $akses = AksesLatihan::where('materi_id', $m->Id_materi)
                        ->where('kategori_id', $k->Id_kategori)->first();
                    if (!$akses?->isAktif()) continue;

                    $soalIds = $m->soals()->where('kategori_id', $k->Id_kategori)->pluck('Id_soal');
                    if ($soalIds->isEmpty()) continue;

                    $dijawab   = HasilLatihan::where('Id_user', $userId)
                        ->whereIn('Id_soal', $soalIds)->distinct('Id_soal')->count('Id_soal');
                    $totalPoin = Soal::whereIn('Id_soal', $soalIds)->sum('poin');
                    $diraih    = HasilLatihan::where('Id_user', $userId)->whereIn('Id_soal', $soalIds)->sum('nilai');
                    $total     = $soalIds->count();
                    $nilai     = $totalPoin > 0 ? round($diraih / $totalPoin * 100) : 0;

                    $babData[] = [
                        'kategori' => $k,
                        'total'    => $total,
                        'dijawab'  => $dijawab,
                        'pct'      => $total > 0 ? round($dijawab / $total * 100) : 0,
                        'nilai'    => $nilai,
                        'lulus'    => $dijawab === $total && $total > 0 && $nilai >= $kkm,
                        'selesai'  => $dijawab === $total && $total > 0,
                    ];
                }

                // Hitung rata-rata nilai bab ini (dari semua kategori yang diselesaikan)
                $nilaiList    = collect($babData)->where('selesai', true)->pluck('nilai');
                $avgNilai     = $nilaiList->isNotEmpty() ? round($nilaiList->avg()) : 0;
                $semuaSelesai = count($babData) > 0 && collect($babData)->every(fn($k) => $k['selesai']);
                $babLulus     = $semuaSelesai && $avgNilai >= $kkm;

                return [
                    'materi'    => $m,
                    'kategoris' => $babData,
                    'lulus'     => $babLulus,
                    'selesai'   => $semuaSelesai,
                    'avg_nilai' => $avgNilai,
                ];
            })
            ->filter(fn($item) => count($item['kategoris']) > 0)
            ->values();

        // Tandai bab yang terkunci (sequential: bab N hanya buka jika bab N-1 lulus)
        $prevLulus = true; // Bab pertama selalu terbuka
        $materis   = $materisRaw->map(function ($item) use (&$prevLulus) {
            $item['locked'] = !$prevLulus;
            $prevLulus      = $item['lulus'];
            return $item;
        });

        $canMulai = $this->checkKelasAksesMapel($mapel);

        return view('siswa.latihan.mapel', compact('mapel', 'materis', 'kategoris', 'kkm', 'canMulai'));
    }

    // ── MULAI LATIHAN ──
    public function mulai(Materi $materi, KategoriLatihan $kategori)
    {
        abort_unless($this->checkKelasAkses($materi), 403, 'Anda tidak dapat mengerjakan latihan untuk kelas lain.');

        $akses = AksesLatihan::where('materi_id', $materi->Id_materi)
            ->where('kategori_id', $kategori->Id_kategori)->first();
        abort_unless($akses?->isAktif(), 403, 'Latihan ini belum dibuka oleh guru.');

        // Cek apakah bab ini terkunci karena bab sebelumnya belum lulus KKM
        $this->abortIfBabLocked($materi);

        $soals        = $materi->soals()->where('kategori_id', $kategori->Id_kategori)
            ->with('pilihanJawabans')->get()->shuffle();
        $sudahDijawab = HasilLatihan::where('Id_user', Auth::id())
            ->whereIn('Id_soal', $soals->pluck('Id_soal'))->pluck('Id_soal')->toArray();
        $jawabanSiswa = HasilLatihan::where('Id_user', Auth::id())
            ->whereIn('Id_soal', $soals->pluck('Id_soal'))
            ->pluck('jawaban_siswa', 'Id_soal')
            ->toArray();

        return view('siswa.latihan.mulai', compact('materi', 'kategori', 'soals', 'sudahDijawab', 'jawabanSiswa'));
    }

    // ── JAWAB SOAL (AJAX) — simpan tanpa return feedback benar/salah ──
    public function jawab(Request $request, Soal $soal)
    {
        $request->validate(['pilihan_id' => 'required|exists:pilihan_jawaban,Id_pilihan']);
        if (HasilLatihan::where('Id_user', Auth::id())->where('Id_soal', $soal->Id_soal)->exists()) {
            return response()->json(['message' => 'Sudah dijawab.'], 422);
        }
        abort_unless($this->checkKelasAkses($soal->materi), 403, 'Anda tidak dapat mengerjakan latihan untuk kelas lain.');

        $pilihan = $soal->pilihanJawabans()->findOrFail($request->pilihan_id);
        $isBenar = $pilihan->is_benar;
        HasilLatihan::create([
            'Id_user'       => Auth::id(),
            'Id_soal'       => $soal->Id_soal,
            'jawaban_siswa' => $pilihan->teks_pilihan,
            'is_benar'      => $isBenar,
            'nilai'         => $isBenar ? $soal->poin : 0,
        ]);
        // Hanya kembalikan konfirmasi (tanpa reveal benar/salah)
        return response()->json(['saved' => true]);
    }

    // ── SELESAI ──
    public function selesai(Request $request, Materi $materi, KategoriLatihan $kategori)
    {
        abort_unless($this->checkKelasAkses($materi), 403, 'Anda tidak dapat mengerjakan latihan untuk kelas lain.');

        $soalIds = $materi->soals()->where('kategori_id', $kategori->Id_kategori)->pluck('Id_soal');
        if (!HasilLatihan::where('Id_user', Auth::id())->whereIn('Id_soal', $soalIds)->exists()) {
            return response()->json(['message' => 'Belum mengerjakan soal.'], 422);
        }
        return response()->json(['redirect' => route('siswa.latihan.hasil', [$materi, $kategori])]);
    }

    // ── HASIL + KKM STATUS ──
    public function hasil(Materi $materi, KategoriLatihan $kategori)
    {
        abort_unless($this->checkKelasAkses($materi), 403, 'Anda tidak dapat mengerjakan latihan untuk kelas lain.');

        $soalIds    = $materi->soals()->where('kategori_id', $kategori->Id_kategori)->pluck('Id_soal');
        $hasil      = HasilLatihan::where('Id_user', Auth::id())
            ->whereIn('Id_soal', $soalIds)->with('soal.pilihanJawabans')->get();
        $totalPoin  = Soal::whereIn('Id_soal', $soalIds)->sum('poin');
        $raihPoin   = $hasil->sum('nilai');
        $persentase = $totalPoin > 0 ? round($raihPoin / $totalPoin * 100) : 0;
        $kkm        = self::KKM;
        $lulus      = $persentase >= $kkm;

        // Cari bab berikutnya
        $nextMateri = $lulus
            ? $materi->mataPelajaran->materis()
            ->where('urutan', '>', $materi->urutan)
            ->orderBy('urutan')
            ->first()
            : null;

        return view('siswa.latihan.hasil', compact(
            'materi',
            'kategori',
            'hasil',
            'totalPoin',
            'raihPoin',
            'persentase',
            'kkm',
            'lulus',
            'nextMateri'
        ));
    }

    // ── ULANGI LATIHAN (reset jawaban untuk dikerjakan ulang) ──
    public function ulangi(Materi $materi, KategoriLatihan $kategori)
    {
        abort_unless($this->checkKelasAkses($materi), 403, 'Anda tidak dapat mengerjakan latihan untuk kelas lain.');

        $soalIds = $materi->soals()->where('kategori_id', $kategori->Id_kategori)->pluck('Id_soal');
        HasilLatihan::where('Id_user', Auth::id())->whereIn('Id_soal', $soalIds)->delete();

        return redirect()->route('siswa.latihan.mulai', [$materi, $kategori])
            ->with('info', 'Latihan direset. Silakan kerjakan kembali.');
    }

    // ── PEMBAHASAN ──
    public function pembahasan(Materi $materi, KategoriLatihan $kategori)
    {
        abort_unless($this->checkKelasAkses($materi), 403, 'Anda tidak dapat mengerjakan latihan untuk kelas lain.');

        $soalIds = $materi->soals()->where('kategori_id', $kategori->Id_kategori)->pluck('Id_soal');
        abort_unless(
            HasilLatihan::where('Id_user', Auth::id())->whereIn('Id_soal', $soalIds)->exists(),
            403,
            'Kerjakan latihan terlebih dahulu.'
        );
        $soals        = $materi->soals()->where('kategori_id', $kategori->Id_kategori)->with('pilihanJawabans')->get();
        $jawabanSiswa = HasilLatihan::where('Id_user', Auth::id())->whereIn('Id_soal', $soalIds)->pluck('jawaban_siswa', 'Id_soal');
        $isBenarMap   = HasilLatihan::where('Id_user', Auth::id())->whereIn('Id_soal', $soalIds)->pluck('is_benar', 'Id_soal');
        return view('siswa.latihan.pembahasan', compact('materi', 'kategori', 'soals', 'jawabanSiswa', 'isBenarMap'));
    }

    // ── RIWAYAT ──
    public function riwayat()
    {
        $userId  = Auth::id();
        $kkm     = self::KKM;
        $grouped = HasilLatihan::where('Id_user', $userId)
            ->with('soal.materi.mataPelajaran', 'soal.kategori')->get()
            ->groupBy(fn($h) => $h->soal->materi_id . '_' . ($h->soal->kategori_id ?? 0))
            ->map(function ($group) use ($kkm) {
                $materi    = $group->first()->soal->materi;
                $kategori  = $group->first()->soal->kategori;
                $totalPoin = $materi
                    ? $materi->soals()->when($kategori, fn($q) => $q->where('kategori_id', $kategori->Id_kategori))->sum('poin')
                    : 0;
                $diraih    = $group->sum('nilai');
                $pct       = $totalPoin > 0 ? round($diraih / $totalPoin * 100) : 0;
                return (object)[
                    'materi'      => $materi,
                    'kategori'    => $kategori,
                    'total_poin'  => $totalPoin,
                    'poin_diraih' => $diraih,
                    'persentase'  => $pct,
                    'lulus'       => $pct >= $kkm,
                    'dijawab'     => $group->pluck('Id_soal')->unique()->count(),
                    'selesai_at'  => $group->max('created_at'),
                ];
            })->sortByDesc('selesai_at')->values();

        $page    = request()->get('page', 1);
        $perPage = 10;
        $sesiList = new \Illuminate\Pagination\LengthAwarePaginator(
            $grouped->forPage($page, $perPage)->values(),
            $grouped->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        $rata      = $grouped->avg('persentase') ?? 0;
        $totalSesi = $grouped->count();
        $terbaik   = $grouped->max('persentase') ?? 0;
        return view('siswa.riwayat', compact('sesiList', 'rata', 'totalSesi', 'terbaik', 'kkm'));
    }

    // ── DOWNLOAD ──
    public function download(Materi $materi)
    {
        abort_unless($this->checkKelasAkses($materi), 403, 'Anda tidak memiliki akses untuk mengunduh materi ini.');
        abort_unless($materi->hasFile(), 404);

        // Path absolut file di storage/app/public
        $path = storage_path('app/public/' . $materi->file_materi);

        // Pastikan file benar-benar ada
        abort_unless(file_exists($path), 404);

        // Nama file saat diunduh
        $filename = $materi->judul . '_' . basename($materi->file_materi);

        return response()->download($path, $filename);
    }

    // ── HELPER: cek akses kelas siswa berdasarkan materi ──
    private function checkKelasAkses(Materi $materi): bool
    {
        return $this->checkKelasAksesMapel($materi->mataPelajaran);
    }

    // ── HELPER: cek akses kelas siswa berdasarkan mata pelajaran ──
    private function checkKelasAksesMapel(MataPelajaran $mapel): bool
    {
        $siswa = Auth::user();
        if (!$siswa || !$siswa->kelas_id || !$mapel->kelas_id) {
            return false;
        }

        if ($siswa->kelas_id === $mapel->kelas_id) {
            return true;
        }

        $siswaKelasNama = $siswa->kelas->nama ?? '';
        $mapelKelasNama = $mapel->kelas->nama ?? '';

        if ($siswaKelasNama && $mapelKelasNama) {
            // Cek pewarisan (prefix match) - misalnya Mapel kelas "X" atau "X RPL", Siswa "X RPL 1"
            if (strpos($siswaKelasNama, $mapelKelasNama . ' ') === 0) {
                return true;
            }
        }

        return false;
    }

    // ── HELPER: cek apakah bab terkunci ──
    private function abortIfBabLocked(Materi $materi): void
    {
        $userId     = Auth::id();
        $prevMateri = $materi->mataPelajaran->materis()
            ->where('urutan', '<', $materi->urutan)
            ->orderBy('urutan', 'desc')
            ->first();

        if (!$prevMateri) return; // Bab pertama, bebas

        // Hitung nilai bab sebelumnya
        $prevSoalIds = $prevMateri->soals()->pluck('Id_soal');
        if ($prevSoalIds->isEmpty()) return;

        $totalPoin = Soal::whereIn('Id_soal', $prevSoalIds)->sum('poin');
        $diraih    = HasilLatihan::where('Id_user', $userId)->whereIn('Id_soal', $prevSoalIds)->sum('nilai');
        $persentase = $totalPoin > 0 ? round($diraih / $totalPoin * 100) : 0;

        abort_if($persentase < self::KKM, 403, 'Selesaikan bab sebelumnya dengan nilai ≥ ' . self::KKM . ' terlebih dahulu.');
    }
}
