<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KelolaSiswaController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::orderBy('nama')->get();
        
        // Ambil ID kelas aktif dari tab (jika ada), default ke kelas pertama
        $activeKelasId = $request->get('kelas', $kelasList->first()->Id_kelas ?? null);

        $siswas = User::where('role', 'siswa')
            ->when($activeKelasId, function ($query) use ($activeKelasId) {
                return $query->where('kelas_id', $activeKelasId);
            })
            ->orderBy('nama')
            ->get();

        return view('admin.siswa.index', compact('kelasList', 'activeKelasId', 'siswas'));
    }

    public function create()
    {
        $kelasList = Kelas::orderBy('nama')->get();
        return view('admin.siswa.form', compact('kelasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'kelas_id' => 'required|exists:kelas,Id_kelas',
        ]);

        User::create([
            'nama'      => $request->nama,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'siswa',
            'kelas_id'  => $request->kelas_id,
        ]);

        return redirect()->route('admin.siswa.index', ['kelas' => $request->kelas_id])
            ->with('success', 'Akun Siswa berhasil ditambahkan.');
    }

    public function edit(User $siswa)
    {
        abort_unless($siswa->isSiswa(), 404);
        $kelasList = Kelas::orderBy('nama')->get();
        return view('admin.siswa.form', compact('siswa', 'kelasList'));
    }

    public function update(Request $request, User $siswa)
    {
        abort_unless($siswa->isSiswa(), 404);

        $rules = [
            'nama'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($siswa->Id_user, 'Id_user')],
            'kelas_id' => 'required|exists:kelas,Id_kelas',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:6|confirmed';
        }

        $request->validate($rules);

        $siswa->nama     = $request->nama;
        $siswa->email    = $request->email;
        $siswa->kelas_id = $request->kelas_id;
        
        if ($request->filled('password')) {
            $siswa->password = Hash::make($request->password);
        }
        $siswa->save();

        return redirect()->route('admin.siswa.index', ['kelas' => $request->kelas_id])
            ->with('success', 'Data Siswa berhasil diperbarui.');
    }

    public function destroy(User $siswa)
    {
        abort_unless($siswa->isSiswa(), 404);
        $kelasId = $siswa->kelas_id;
        
        if ($siswa->foto_profil) {
            @unlink(storage_path('app/public/' . $siswa->foto_profil));
        }
        $siswa->delete();
        
        return redirect()->route('admin.siswa.index', ['kelas' => $kelasId])
            ->with('success', 'Akun Siswa berhasil dihapus.');
    }
}
