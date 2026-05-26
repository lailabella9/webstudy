<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Materi;
use App\Models\Soal;
use App\Models\HasilLatihan;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index()
    {
        $stats = [
            'total_guru'   => User::where('role', 'guru')->count(),
            'total_siswa'  => User::where('role', 'siswa')->count(),
            'total_kelas'  => Kelas::count(),
            'total_mapel'  => MataPelajaran::count(),
            'total_materi' => Materi::count(),
            'total_soal'   => Soal::count(),
            'total_evaluasi'=> HasilLatihan::count(),
        ];
        
        return view('admin.statistik.index', compact('stats'));
    }
}
