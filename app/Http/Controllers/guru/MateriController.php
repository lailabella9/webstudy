<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    /**
     * Daftar bab dalam satu mata pelajaran.
     */
    private function cleanKonten(?string $html): ?string
    {
        if (!$html) return $html;

        // Hapus paragraf kosong (<p></p> atau <p><br></p>) di awal & akhir
        $html = preg_replace('/^(\s*<p>\s*(<br\s*\/?>)?\s*<\/p>\s*)+/i', '', $html);
        $html = preg_replace('/(\s*<p>\s*(<br\s*\/?>)?\s*<\/p>\s*)+$/i', '', $html);

        return trim($html);
    }

    public function indexAll(Request $request)
    {
        $guru = Auth::user();

        $search   = $request->search;
        $kelas_id = $request->kelas_id;
        $kelasList = \App\Models\Kelas::orderBy('nama')->get();

        $mapels = MataPelajaran::where('Id_user', $guru->Id_user)
            ->when($kelas_id, function ($q) use ($kelas_id) {
                $q->where('kelas_id', $kelas_id);
            })
            ->with(['materis' => function ($q) use ($search) {
                $q->withCount('soals')
                    ->orderBy('urutan');
                if ($search) {
                    $q->where('judul', 'like', '%' . $search . '%');
                }
            }])
            ->orderBy('urutan')
            ->get();

        // Stats
        $totalMapel  = $mapels->count();
        $totalMateri = $mapels->sum(fn($m) => $m->materis->count());
        $totalSoal   = $mapels->sum(fn($m) => $m->materis->sum('soals_count'));

        return view('guru.materi.all', compact('mapels', 'totalMapel', 'totalMateri', 'totalSoal', 'search', 'kelasList', 'kelas_id'));
    }

    public function index(MataPelajaran $mapel)
    {
        abort_unless($mapel->Id_user === Auth::id(), 403);

        $materis = $mapel->materis()
            ->withCount('soals')
            ->orderBy('urutan')
            ->paginate(10);

        return view('guru.materi.index', compact('mapel', 'materis'));
    }

    /**
     * Form tambah bab baru di dalam mapel.
     */
    public function create(MataPelajaran $mapel)
    {
        abort_unless($mapel->Id_user === Auth::id(), 403);
        return view('guru.materi.create', compact('mapel'));
    }

    /**
     * Simpan bab baru ke database.
     */
    public function store(Request $request, MataPelajaran $mapel)
    {
        abort_unless($mapel->Id_user === Auth::id(), 403);

        $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'konten'      => 'required|string',
            'urutan'      => 'required|integer|min:0',
            'file_materi' => 'nullable|mimes:pdf,doc,docx,ppt,pptx|max:10240',
        ]);

        $data = [
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'konten'    => $this->cleanKonten($request->konten),
            'urutan'    => $request->urutan,
            'Id_user'   => Auth::id(),
            'mapel_id'  => $mapel->Id_mapel,
        ];

        if ($request->hasFile('file_materi')) {
            $data['file_materi'] = $request->file('file_materi')
                ->store('materi_files', 'public');
        }

        Materi::create($data);

        return redirect()
            ->route('guru.mapel.kelola', $mapel)
            ->with('success', 'Bab "' . $request->judul . '" berhasil ditambahkan.');
    }

    /**
     * Form edit bab.
     */
    public function edit(MataPelajaran $mapel, Materi $materi)
    {
        abort_unless($mapel->Id_user === Auth::id(), 403);
        return view('guru.materi.edit', compact('mapel', 'materi'));
    }

    /**
     * Perbarui data bab.
     */
    public function update(Request $request, MataPelajaran $mapel, Materi $materi)
    {
        abort_unless($mapel->Id_user === Auth::id(), 403);

        $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'konten'      => 'required|string',
            'urutan'      => 'required|integer|min:0',
            'file_materi' => 'nullable|mimes:pdf,doc,docx,ppt,pptx|max:10240',
        ]);

        $data = array_merge(
            $request->only('judul', 'deskripsi', 'urutan'),
            ['konten' => $this->cleanKonten($request->konten)] // ← bersihkan di server juga
        );

        if ($request->hasFile('file_materi')) {
            if ($materi->file_materi) {
                Storage::disk('public')->delete($materi->file_materi);
            }
            $data['file_materi'] = $request->file('file_materi')
                ->store('materi_files', 'public');
        }

        if ($request->boolean('hapus_file') && $materi->file_materi) {
            Storage::disk('public')->delete($materi->file_materi);
            $data['file_materi'] = null;
        }

        $materi->update($data);

        return redirect()
            ->route('guru.mapel.kelola', $mapel)
            ->with('success', 'Bab berhasil diperbarui.');
    }

    /**
     * Hapus bab.
     */
    public function destroy(MataPelajaran $mapel, Materi $materi)
    {
        abort_unless($mapel->Id_user === Auth::id(), 403);

        if ($materi->file_materi) {
            Storage::disk('public')->delete($materi->file_materi);
        }

        $materi->delete();

        return back()->with('success', 'Bab berhasil dihapus.');
    }
}
