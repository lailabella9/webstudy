<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KelolaGuruController extends Controller
{
    public function index()
    {
        $gurus = User::where('role', 'guru')->orderBy('nama')->get();
        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.guru.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'nama'      => $request->nama,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'guru',
            'is_active' => true,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Akun Guru berhasil ditambahkan.');
    }

    public function show(User $guru)
    {
        abort_unless($guru->isGuru(), 404);
        return view('admin.guru.show', compact('guru'));
    }

    public function edit(User $guru)
    {
        abort_unless($guru->isGuru(), 404);
        return view('admin.guru.form', compact('guru'));
    }

    public function update(Request $request, User $guru)
    {
        abort_unless($guru->isGuru(), 404);

        $rules = [
            'nama'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($guru->Id_user, 'Id_user')],
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:6|confirmed';
        }

        $request->validate($rules);

        $guru->nama  = $request->nama;
        $guru->email = $request->email;
        if ($request->filled('password')) {
            $guru->password = Hash::make($request->password);
        }
        $guru->save();

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil diperbarui.');
    }

    public function destroy(User $guru)
    {
        abort_unless($guru->isGuru(), 404);
        // Hapus file foto profil jika ada (opsional)
        if ($guru->foto_profil) {
            @unlink(storage_path('app/public/' . $guru->foto_profil));
        }
        $guru->delete();
        return redirect()->route('admin.guru.index')->with('success', 'Akun Guru berhasil dihapus.');
    }

    public function toggleStatus(User $guru)
    {
        abort_unless($guru->isGuru(), 404);
        $guru->is_active = !$guru->is_active;
        $guru->save();

        $status = $guru->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.guru.index')->with('success', "Akun Guru berhasil {$status}.");
    }
}
