<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\HasilLatihan;
use App\Models\Kelas;
use App\Models\Soal;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KelolaSiswaController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $guru */
        $guru = Auth::user();

        $soalIds       = Soal::whereHas('materi', fn($q) => $q->where('Id_user', $guru->Id_user))->pluck('Id_soal');
        $totalPoinMaks = Soal::whereIn('Id_soal', $soalIds)->sum('poin');

        $query = User::where('role', 'siswa')->with('kelas');
        if ($request->search) {
            $query->where(fn($q) => $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%'));
        }
        if ($request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswaRaw = $query->orderBy('kelas_id')->orderBy('nama')->get()
            ->map(function ($s) use ($soalIds, $totalPoinMaks) {
                $diraih  = HasilLatihan::where('Id_user', $s->Id_user)->whereIn('Id_soal', $soalIds)->sum('nilai');
                $dijawab = HasilLatihan::where('Id_user', $s->Id_user)->whereIn('Id_soal', $soalIds)->count();
                $s->nilai_rata     = $totalPoinMaks > 0 ? round($diraih / $totalPoinMaks * 100, 1) : 0;
                $s->jumlah_jawaban = $dijawab;
                return $s;
            });

        $page    = $request->get('page', 1);
        $perPage = 10;
        $siswa   = new \Illuminate\Pagination\LengthAwarePaginator(
            $siswaRaw->forPage($page, $perPage)->values(),
            $siswaRaw->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $totalSiswa = $siswaRaw->count();
        $siswaAktif = $siswaRaw->where('jumlah_jawaban', '>', 0)->count();
        $siswaBelum = $totalSiswa - $siswaAktif;
        $rataRata   = $siswaRaw->where('jumlah_jawaban', '>', 0)->avg('nilai_rata') ?? 0;
        $kelasList  = Kelas::orderBy('nama')->get();

        return view('guru.siswa.index', compact('siswa', 'totalSiswa', 'siswaAktif', 'siswaBelum', 'rataRata', 'kelasList'));
    }

    // ── Export Daftar Siswa → CSV ────────────────────────────────────
    public function exportListCsv(Request $request)
    {
        /** @var \App\Models\User $guru */
        $guru = Auth::user();

        $soalIds       = Soal::whereHas('materi', fn($q) => $q->where('Id_user', $guru->Id_user))->pluck('Id_soal');
        $totalPoinMaks = Soal::whereIn('Id_soal', $soalIds)->sum('poin');

        $query = User::where('role', 'siswa')->with('kelas');
        if ($request->search) {
            $query->where(fn($q) => $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%'));
        }
        if ($request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswaList = $query->orderBy('kelas_id')->orderBy('nama')->get()
            ->map(function ($s) use ($soalIds, $totalPoinMaks) {
                $diraih  = HasilLatihan::where('Id_user', $s->Id_user)->whereIn('Id_soal', $soalIds)->sum('nilai');
                $dijawab = HasilLatihan::where('Id_user', $s->Id_user)->whereIn('Id_soal', $soalIds)->count();
                $s->nilai_rata     = $totalPoinMaks > 0 ? round($diraih / $totalPoinMaks * 100, 1) : 0;
                $s->jumlah_jawaban = $dijawab;
                return $s;
            });

        $filename = 'data-siswa-' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($siswaList) {
            $handle = fopen('php://output', 'w');

            // BOM agar Excel bisa baca UTF-8 dengan benar
            fputs($handle, "\xEF\xBB\xBF");

            // Header kolom
            fputcsv($handle, ['No', 'Nama', 'Email', 'Kelas', 'Nilai Rata-rata (%)', 'Status', 'Bergabung']);

            foreach ($siswaList as $i => $s) {
                fputcsv($handle, [
                    $i + 1,
                    $s->nama,
                    $s->email,
                    $s->kelas?->nama ?? '-',
                    $s->nilai_rata,
                    $s->jumlah_jawaban > 0 ? 'Aktif' : 'Belum Berlatih',
                    $s->created_at->format('d/m/Y'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ── Export Daftar Siswa → PDF ────────────────────────────────────
    public function exportListPdf(Request $request)
    {
        /** @var \App\Models\User $guru */
        $guru = Auth::user();

        $soalIds       = Soal::whereHas('materi', fn($q) => $q->where('Id_user', $guru->Id_user))->pluck('Id_soal');
        $totalPoinMaks = Soal::whereIn('Id_soal', $soalIds)->sum('poin');

        $query = User::where('role', 'siswa')->with('kelas');
        if ($request->search) {
            $query->where(fn($q) => $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%'));
        }
        if ($request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswaList = $query->orderBy('kelas_id')->orderBy('nama')->get()
            ->map(function ($s) use ($soalIds, $totalPoinMaks) {
                $diraih  = HasilLatihan::where('Id_user', $s->Id_user)->whereIn('Id_soal', $soalIds)->sum('nilai');
                $dijawab = HasilLatihan::where('Id_user', $s->Id_user)->whereIn('Id_soal', $soalIds)->count();
                $s->nilai_rata     = $totalPoinMaks > 0 ? round($diraih / $totalPoinMaks * 100, 1) : 0;
                $s->jumlah_jawaban = $dijawab;
                return $s;
            });

        $totalSiswa = $siswaList->count();
        $siswaAktif = $siswaList->where('jumlah_jawaban', '>', 0)->count();
        $rataRata   = $siswaList->where('jumlah_jawaban', '>', 0)->avg('nilai_rata') ?? 0;

        $pdf = Pdf::loadView('guru.siswa.export-list', compact(
            'siswaList',
            'totalSiswa',
            'siswaAktif',
            'rataRata',
            'guru'
        ))->setPaper('a4', 'landscape');

        $filename = 'daftar-siswa-' . now()->format('Ymd') . '.pdf';
        return $pdf->download($filename);
    }

    public function show(User $siswa)
    {
        abort_unless($siswa->role === 'siswa', 404);
        $siswa->load('kelas');

        /** @var \App\Models\User $guru */
        $guru = Auth::user();

        $soalIds   = Soal::whereHas('materi', fn($q) => $q->where('Id_user', $guru->Id_user))->pluck('Id_soal');
        $totalPoin = Soal::whereIn('Id_soal', $soalIds)->sum('poin');

        $hasilSiswa = HasilLatihan::where('Id_user', $siswa->Id_user)
            ->whereIn('Id_soal', $soalIds)
            ->with('soal.materi', 'soal.kategori')
            ->latest('created_at')
            ->get();

        $sesiList = $hasilSiswa
            ->groupBy(fn($h) => $h->soal->materi_id . '_' . ($h->soal->kategori_id ?? 0))
            ->map(function ($group) use ($totalPoin) {
                $materi       = $group->first()->soal->materi;
                $kategori     = $group->first()->soal->kategori;
                $soalIds      = $group->pluck('Id_soal')->unique();
                $poinKelompok = $materi
                    ? $materi->soals()
                    ->when($kategori, fn($q) => $q->where('kategori_id', $kategori?->Id_kategori))
                    ->sum('poin')
                    : 0;
                $diraih  = $group->sum('nilai');
                $persen  = $poinKelompok > 0 ? round($diraih / $poinKelompok * 100) : 0;
                $lastAt  = $group->max('created_at');

                return (object) [
                    'materi'      => $materi,
                    'kategori'    => $kategori,
                    'poin_diraih' => $diraih,
                    'total_poin'  => $poinKelompok,
                    'persentase'  => $persen,
                    'dijawab'     => $soalIds->count(),
                    'selesai_at'  => $lastAt ? \Carbon\Carbon::parse($lastAt) : null,
                    'durasi'      => null,
                ];
            })
            ->sortByDesc('persentase')
            ->values();

        $page    = request()->get('page', 1);
        $perPage = 10;
        $sesiPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $sesiList->forPage($page, $perPage)->values(),
            $sesiList->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $diraihTotal = $hasilSiswa->sum('nilai');
        $rata        = $totalPoin > 0 ? round($diraihTotal / $totalPoin * 100, 1) : 0;
        $totalSesi   = $sesiList->count();

        return view('guru.siswa.show', [
            'siswa'     => $siswa,
            'sesiList'  => $sesiPaginated,
            'rata'      => $rata,
            'totalSesi' => $totalSesi,
        ]);
    }

    public function create()
    {
        $kelasList = Kelas::orderBy('nama')->get();
        return view('guru.siswa.create', compact('kelasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'kelas_id'    => 'required|exists:kelas,Id_kelas',
            'password'    => 'required|min:6|confirmed',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'nama'     => $request->nama,
            'email'    => $request->email,
            'kelas_id' => $request->kelas_id,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ];
        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = $request->file('foto_profil')->store('foto_profil', 'public');
        }
        User::create($data);
        return redirect()->route('guru.siswa.index')->with('success', 'Akun siswa berhasil dibuat.');
    }

    public function edit(User $siswa)
    {
        abort_unless($siswa->role === 'siswa', 404);
        $kelasList = Kelas::orderBy('nama')->get();
        return view('guru.siswa.edit', compact('siswa', 'kelasList'));
    }

    public function update(Request $request, User $siswa)
    {
        abort_unless($siswa->role === 'siswa', 404);
        $request->validate([
            'nama'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $siswa->Id_user . ',Id_user',
            'kelas_id'    => 'required|exists:kelas,Id_kelas',
            'password'    => 'nullable|min:6|confirmed',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = ['nama' => $request->nama, 'email' => $request->email, 'kelas_id' => $request->kelas_id];
        if ($request->filled('password'))     $data['password']   = Hash::make($request->password);
        if ($request->boolean('hapus_foto') && $siswa->foto_profil) {
            Storage::disk('public')->delete($siswa->foto_profil);
            $data['foto_profil'] = null;
        }
        if ($request->hasFile('foto_profil')) {
            if ($siswa->foto_profil) Storage::disk('public')->delete($siswa->foto_profil);
            $data['foto_profil'] = $request->file('foto_profil')->store('foto_profil', 'public');
        }

        $siswa->update($data);
        return redirect()->route('guru.siswa.show', $siswa)->with('success', 'Data siswa diperbarui.');
    }

    public function destroy(User $siswa)
    {
        abort_unless($siswa->role === 'siswa', 404);
        if ($siswa->foto_profil) Storage::disk('public')->delete($siswa->foto_profil);
        $siswa->delete();
        return redirect()->route('guru.siswa.index')->with('success', 'Akun siswa dihapus.');
    }

    // ── helper private ──────────────────────────────────────────────
    private function buildSiswaData(User $siswa): array
    {
        abort_unless($siswa->role === 'siswa', 404);
        $siswa->load('kelas');

        /** @var \App\Models\User $guru */
        $guru = Auth::user();

        $soalIds   = Soal::whereHas('materi', fn($q) => $q->where('Id_user', $guru->Id_user))->pluck('Id_soal');
        $totalPoin = Soal::whereIn('Id_soal', $soalIds)->sum('poin');

        $hasilSiswa = HasilLatihan::where('Id_user', $siswa->Id_user)
            ->whereIn('Id_soal', $soalIds)
            ->with('soal.materi', 'soal.kategori')
            ->latest('created_at')
            ->get();

        $sesiList = $hasilSiswa
            ->groupBy(fn($h) => $h->soal->materi_id . '_' . ($h->soal->kategori_id ?? 0))
            ->map(function ($group) {
                $materi       = $group->first()->soal->materi;
                $kategori     = $group->first()->soal->kategori;
                $poinKelompok = $materi
                    ? $materi->soals()
                    ->when($kategori, fn($q) => $q->where('kategori_id', $kategori?->Id_kategori))
                    ->sum('poin')
                    : 0;
                $diraih = $group->sum('nilai');
                $persen = $poinKelompok > 0 ? round($diraih / $poinKelompok * 100) : 0;
                $lastAt = $group->max('created_at');

                return (object) [
                    'materi'      => $materi,
                    'kategori'    => $kategori,
                    'poin_diraih' => $diraih,
                    'total_poin'  => $poinKelompok,
                    'persentase'  => $persen,
                    'dijawab'     => $group->pluck('Id_soal')->unique()->count(),
                    'selesai_at'  => $lastAt ? \Carbon\Carbon::parse($lastAt) : null,
                ];
            })
            ->sortByDesc('persentase')
            ->values();

        $diraihTotal = $hasilSiswa->sum('nilai');
        $rata        = $totalPoin > 0 ? round($diraihTotal / $totalPoin * 100, 1) : 0;

        return compact('siswa', 'sesiList', 'rata');
    }

    // ── Print (browser) ─────────────────────────────────────────────
    public function print(User $siswa)
    {
        $data = $this->buildSiswaData($siswa);
        return view('guru.siswa.print', $data);
    }

    // ── Export PDF per siswa ─────────────────────────────────────────
    public function exportPdf(User $siswa)
    {
        $data = $this->buildSiswaData($siswa);
        $pdf  = Pdf::loadView('guru.siswa.print', $data)
            ->setPaper('a4', 'portrait');
        $filename = 'laporan-' . Str::slug($siswa->nama) . '-' . now()->format('Ymd') . '.pdf';
        return $pdf->download($filename);
    }
}
