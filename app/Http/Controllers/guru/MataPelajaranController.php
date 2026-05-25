<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\KategoriLatihan;
use App\Models\AksesLatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $guru      = Auth::user();
        $kelas_id  = $request->kelas_id;

        $kelasList = Kelas::orderBy('nama')->get();

        $mapelsQuery = MataPelajaran::where('Id_user', $guru->Id_user)
            ->with(['kelas','kelas.walikelas'])
            ->withCount('materis');

        if ($kelas_id) {
            $mapelsQuery->where('kelas_id', $kelas_id);
        }

        $mapels = $mapelsQuery->orderBy('kelas_id')
            ->orderBy('urutan')
            ->get();

        return view('guru.mapel.index', compact('mapels', 'kelasList', 'kelas_id'));
    }

    public function create()
    {
        $kelasList = Kelas::orderBy('nama')->get();
        return view('guru.mapel.create', compact('kelasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'kelas_id'  => 'required|exists:kelas,Id_kelas',
            'deskripsi' => 'nullable|string',
            'urutan'    => 'required|integer|min:0',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $guru = Auth::user();
        $data = $request->only('nama', 'kelas_id', 'deskripsi', 'urutan');
        $data['Id_user'] = $guru->Id_user;

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        MataPelajaran::create($data);
        return redirect()->route('guru.mapel.index')->with('success', 'Mata pelajaran berhasil dibuat.');
    }

    public function edit(MataPelajaran $mapel)
    {
        abort_unless($mapel->Id_user === Auth::id(), 403);
        $kelasList = Kelas::orderBy('nama')->get();
        return view('guru.mapel.edit', compact('mapel', 'kelasList'));
    }

    public function update(Request $request, MataPelajaran $mapel)
    {
        abort_unless($mapel->Id_user === Auth::id(), 403);
        $request->validate([
            'nama'      => 'required|string|max:255',
            'kelas_id'  => 'required|exists:kelas,Id_kelas',
            'deskripsi' => 'nullable|string',
            'urutan'    => 'required|integer|min:0',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('nama', 'kelas_id', 'deskripsi', 'urutan');

        if ($request->hasFile('thumbnail')) {
            if ($mapel->thumbnail) Storage::disk('public')->delete($mapel->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $mapel->update($data);
        return redirect()->route('guru.mapel.index')->with('success', 'Mata pelajaran diperbarui.');
    }

    public function destroy(MataPelajaran $mapel)
    {
        abort_unless($mapel->Id_user === Auth::id(), 403);
        if ($mapel->thumbnail) Storage::disk('public')->delete($mapel->thumbnail);
        $mapel->delete();
        return back()->with('success', 'Mata pelajaran dihapus.');
    }

    public function kelola(MataPelajaran $mapel)
    {
        abort_unless($mapel->Id_user === Auth::id(), 403);

        $materis   = $mapel->materis()->withCount('soals')->get();
        $kategoris = KategoriLatihan::orderBy('urutan')->get();
        $aksesMap  = AksesLatihan::whereIn('materi_id', $materis->pluck('Id_materi'))
            ->get()->groupBy('materi_id');

        return view('guru.mapel.kelola', compact('mapel', 'materis', 'kategoris', 'aksesMap'));
    }

    public function toggleAkses(Request $request, MataPelajaran $mapel)
    {
        abort_unless($mapel->Id_user === Auth::id(), 403);
        $request->validate([
            'materi_id'   => 'required|exists:materi,Id_materi',
            'kategori_id' => 'required|exists:kategori_latihan,Id_kategori',
        ]);

        $akses = AksesLatihan::firstOrNew([
            'materi_id'   => $request->materi_id,
            'kategori_id' => $request->kategori_id,
        ]);
        $akses->is_buka    = !$akses->is_buka;
        $akses->dibuka_at  = $akses->is_buka ? now() : null;
        $akses->ditutup_at = null;
        $akses->save();

        return response()->json([
            'is_buka' => $akses->is_buka,
            'message' => $akses->is_buka ? 'Soal dibuka untuk siswa.' : 'Soal ditutup.',
        ]);
    }
}
