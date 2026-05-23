<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\User;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->load('kelas');

        if ($user->isGuru()) {
            // Mata pelajaran milik guru + hitung bab dan soal per mapel
            $mapels = MataPelajaran::where('Id_user', $user->Id_user)
                ->withCount('materis')
                ->orderBy('urutan')
                ->get()
                ->map(function ($m) use ($user) {
                    $m->total_soal = Soal::whereHas(
                        'materi',
                        fn($q) =>
                        $q->where('mapel_id', $m->Id_mapel)
                            ->where('Id_user', $user->Id_user)
                    )->count();

                    return $m;
                });

            $totalMapel = $mapels->count();
            $totalSoal  = Soal::whereHas(
                'materi',
                fn($q) => $q->where('Id_user', $user->Id_user)
            )->count();

            $totalSiswa = User::where('role', 'siswa')->count();

            return view('guru.profil', compact(
                'user',
                'mapels',
                'totalMapel',
                'totalSoal',
                'totalSiswa'
            ));
        }

        return view('siswa.profil', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'nama'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->Id_user . ',Id_user',
            'password'    => 'nullable|min:6|confirmed',
            'foto_profil' => 'nullable|image|max:2048',
        ]);

        $data = ['nama' => $request->nama, 'email' => $request->email];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('foto_profil', 'public');
        }

        $user->update($data);

        $route = $user->isGuru() ? 'guru.profil.edit' : 'siswa.profil.edit';
        return redirect()->route($route)->with('success', 'Profil berhasil diperbarui.');
    }
}
