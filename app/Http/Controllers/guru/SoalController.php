<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\KategoriLatihan;
use App\Models\MataPelajaran;
use App\Models\Materi;
use App\Models\PilihanJawaban;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SoalController extends Controller
{
    public function indexAll(Request $request)
    {
        /** @var \App\Models\User $guru */
        $guru = Auth::user();

        $search    = $request->search;
        $kelas_id  = $request->kelas_id;
        $kelasList = \App\Models\Kelas::orderBy('nama')->get();
        $kategoris = KategoriLatihan::orderBy('urutan')->get();

        $mapels = MataPelajaran::where('Id_user', $guru->Id_user)
            ->when($kelas_id, function ($q) use ($kelas_id) {
                $q->where('kelas_id', $kelas_id);
            })
            ->with(['materis' => function ($q) use ($search) {
                $q->withCount(['soals as total_soal'])
                    ->orderBy('urutan');
                if ($search) {
                    $q->where('judul', 'like', '%' . $search . '%');
                }
            }])
            ->orderBy('urutan')
            ->get();

        // Hitung soal per kategori per materi secara efisien (single query)
        $soalPerMateriKategori = Soal::whereHas('materi', fn($q) => $q->where('Id_user', $guru->Id_user))
            ->select('materi_id', 'kategori_id', DB::raw('count(*) as jumlah'), DB::raw('sum(poin) as total_poin'))
            ->groupBy('materi_id', 'kategori_id')
            ->get()
            ->groupBy('materi_id');

        $totalSoal   = $mapels->sum(fn($m) => $m->materis->sum('total_soal'));
        $totalMateri = $mapels->sum(fn($m) => $m->materis->count());

        return view('guru.soal.all', compact(
            'mapels',
            'kategoris',
            'soalPerMateriKategori',
            'totalSoal',
            'totalMateri',
            'search',
            'kelasList',
            'kelas_id'
        ));
    }

    public function index(Materi $materi)
    {
        abort_unless($materi->Id_user === Auth::id(), 403);

        $kategoris = KategoriLatihan::orderBy('urutan')->get();

        // Group soal by kategori
        $soalsByKategori = $materi->soals()
            ->with(['pilihanJawabans', 'kategori'])
            ->get()
            ->groupBy('kategori_id');

        return view('guru.soal.index', compact('materi', 'kategoris', 'soalsByKategori'));
    }

    public function create(Materi $materi)
    {
        abort_unless($materi->Id_user === Auth::id(), 403);
        $kategoris = KategoriLatihan::orderBy('urutan')->get();
        return view('guru.soal.create', compact('materi', 'kategoris'));
    }

    public function store(Request $request, Materi $materi)
    {
        abort_unless($materi->Id_user === Auth::id(), 403);

        $request->validate([
            'pertanyaan'    => 'required|string',
            'tipe_soal'     => 'required|in:pilihan_ganda,benar_salah',
            'poin'          => 'required|integer|min:1',
            'kategori_id'   => 'required|exists:kategori_latihan,Id_kategori',
            'pilihan'       => 'required|array|min:2',
            'pilihan.*'     => 'required|string',
            'jawaban_benar' => 'required',
        ]);

        DB::transaction(function () use ($request, $materi) {
            $soal = Soal::create([
                'materi_id'   => $materi->Id_materi,
                'kategori_id' => $request->kategori_id,
                'pertanyaan'  => $request->pertanyaan,
                'tipe_soal'   => $request->tipe_soal,
                'poin'        => $request->poin,
            ]);

            foreach ($request->pilihan as $index => $teks) {
                PilihanJawaban::create([
                    'id_soal'      => $soal->Id_soal,
                    'teks_pilihan' => $teks,
                    'is_benar'     => ($index == $request->jawaban_benar),
                ]);
            }
        });

        return redirect()->route('guru.soal.index', $materi)->with('success', 'Soal berhasil ditambahkan.');
    }

    public function edit(Materi $materi, Soal $soal)
    {
        abort_unless($materi->Id_user === Auth::id(), 403);
        $soal->load('pilihanJawabans');
        $kategoris = KategoriLatihan::orderBy('urutan')->get();
        return view('guru.soal.edit', compact('materi', 'soal', 'kategoris'));
    }

    public function update(Request $request, Materi $materi, Soal $soal)
    {
        abort_unless($materi->Id_user === Auth::id(), 403);

        $request->validate([
            'pertanyaan'    => 'required|string',
            'tipe_soal'     => 'required|in:pilihan_ganda,benar_salah',
            'poin'          => 'required|integer|min:1',
            'kategori_id'   => 'required|exists:kategori_latihan,Id_kategori',
            'pilihan'       => 'required|array|min:2',
            'pilihan.*'     => 'required|string',
            'jawaban_benar' => 'required',
        ]);

        DB::transaction(function () use ($request, $soal) {
            $soal->update([
                'kategori_id' => $request->kategori_id,
                'pertanyaan'  => $request->pertanyaan,
                'tipe_soal'   => $request->tipe_soal,
                'poin'        => $request->poin,
            ]);

            $soal->pilihanJawabans()->delete();
            foreach ($request->pilihan as $index => $teks) {
                PilihanJawaban::create([
                    'id_soal'      => $soal->Id_soal,
                    'teks_pilihan' => $teks,
                    'is_benar'     => ($index == $request->jawaban_benar),
                ]);
            }
        });

        return redirect()->route('guru.soal.index', $materi)->with('success', 'Soal diperbarui.');
    }

    public function destroy(Materi $materi, Soal $soal)
    {
        abort_unless($materi->Id_user === Auth::id(), 403);
        $soal->delete();
        return back()->with('success', 'Soal dihapus.');
    }
}
