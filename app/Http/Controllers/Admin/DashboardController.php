<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMateri = \App\Models\Materi::count();
        $totalSoal = \App\Models\Soal::count();
        $totalSiswa = \App\Models\User::where('role', 'siswa')->count();
        $totalJawaban = \App\Models\HasilLatihan::count();
        
        $grafikData = collect([]);
        $distribusi = ['lulus' => 0, 'hampir' => 0, 'perlu' => 0];
        $progres = collect([]);

        return view('admin.dashboard', compact(
            'totalMateri', 'totalSoal', 'totalSiswa', 'totalJawaban',
            'grafikData', 'distribusi', 'progres'
        ));
    }
}
