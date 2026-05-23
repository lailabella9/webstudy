<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::withCount('siswa')->orderBy('nama');

        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $kelasList  = $query->paginate(15)->withQueryString();
        $totalKelas = Kelas::count();
        $totalSiswa = \App\Models\User::where('role', 'siswa')->count();

        return view('guru.kelas.index', compact('kelasList', 'totalKelas', 'totalSiswa'));
    }

    public function create()
    {
        return view('guru.kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:kelas,nama',
        ]);

        Kelas::create(['nama' => $request->nama]);

        return redirect()->route('guru.kelas.index')->with('success', 'Kelas "' . $request->nama . '" berhasil ditambahkan.');
    }

    public function edit(Kelas $kelas)
    {
        $kelas->loadCount('siswa');
        return view('guru.kelas.edit', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:kelas,nama,' . $kelas->Id_kelas . ',Id_kelas',
        ]);

        $kelas->update(['nama' => $request->nama]);

        return redirect()->route('guru.kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        $jumlahSiswa = $kelas->siswa()->count();
        if ($jumlahSiswa > 0) {
            return redirect()->route('guru.kelas.index')
                ->with('error', 'Kelas tidak bisa dihapus karena masih memiliki ' . $jumlahSiswa . ' siswa.');
        }

        $kelas->delete();
        return redirect()->route('guru.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
