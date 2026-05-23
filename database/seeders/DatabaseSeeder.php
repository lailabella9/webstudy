<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ══════════════════════════════════════════
        //  1. USERS
        // ══════════════════════════════════════════
        $guru = User::create([
            'nama'     => 'Pak Budi',
            'email'    => 'guru@cbt.test',
            'password' => Hash::make('password'),
            'role'     => 'guru',
        ]);

        User::create([
            'nama'     => 'Siti Rahayu',
            'email'    => 'siswa@cbt.test',
            'password' => Hash::make('password'),
            'role'     => 'siswa',
        ]);

        User::create([
            'nama'     => 'Ahmad Fauzi',
            'email'    => 'siswa2@cbt.test',
            'password' => Hash::make('password'),
            'role'     => 'siswa',
        ]);

        // ══════════════════════════════════════════
        //  2. KATEGORI LATIHAN
        // ══════════════════════════════════════════
        $kategoriIds = [];

        $kategoris = [
            ['nama' => 'Latihan Harian', 'ikon' => 'bi-pencil-square',    'warna' => '#0ea5e9', 'urutan' => 1],
            ['nama' => 'UTS',            'ikon' => 'bi-clipboard2-check', 'warna' => '#f97316', 'urutan' => 2],
            ['nama' => 'UAS',            'ikon' => 'bi-trophy',           'warna' => '#7c3aed', 'urutan' => 3],
        ];

        foreach ($kategoris as $data) {
            $id = DB::table('kategori_latihan')->insertGetId(array_merge($data, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
            $kategoriIds[$data['nama']] = $id;
        }

        // ══════════════════════════════════════════
        //  3. MATA PELAJARAN
        // ══════════════════════════════════════════
        $mapelMatematika = DB::table('mata_pelajaran')->insertGetId([
            'nama'       => 'Matematika',
            'deskripsi'  => 'Mata pelajaran yang mempelajari bilangan, bangun, dan logika.',
            'thumbnail'  => null,
            'Id_user'    => $guru->Id_user,
            'urutan'     => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mapelBindo = DB::table('mata_pelajaran')->insertGetId([
            'nama'       => 'Bahasa Indonesia',
            'deskripsi'  => 'Mata pelajaran yang mempelajari tata bahasa, sastra, dan komunikasi.',
            'thumbnail'  => null,
            'Id_user'    => $guru->Id_user,
            'urutan'     => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mapelIPA = DB::table('mata_pelajaran')->insertGetId([
            'nama'       => 'IPA',
            'deskripsi'  => 'Ilmu Pengetahuan Alam: fisika, kimia, dan biologi dasar.',
            'thumbnail'  => null,
            'Id_user'    => $guru->Id_user,
            'urutan'     => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ══════════════════════════════════════════
        //  4. MATERI + SOAL + PILIHAN JAWABAN
        // ══════════════════════════════════════════

        // ── MATEMATIKA ──────────────────────────
        $this->buatBab($guru->Id_user, $mapelMatematika, $kphpategoriIds, [
            [
                'judul'     => 'Bab 1 — Bilangan Bulat',
                'deskripsi' => 'Pengenalan bilangan bulat positif, negatif, dan nol.',
                'urutan'    => 1,
                'konten'    => "Bilangan bulat adalah himpunan bilangan yang terdiri dari:\n"
                    . "• Bilangan bulat negatif: ..., -3, -2, -1\n"
                    . "• Nol: 0\n"
                    . "• Bilangan bulat positif: 1, 2, 3, ...\n\n"
                    . "Operasi Bilangan Bulat\n"
                    . "Penjumlahan, pengurangan, perkalian, dan pembagian pada bilangan bulat "
                    . "mengikuti aturan tanda:\n"
                    . "positif × positif = positif\n"
                    . "negatif × negatif = positif\n"
                    . "positif × negatif = negatif",
                'soal' => [
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Hasil dari (-5) + 8 adalah ...',
                        'pilihan' => ['3', '-3', '13', '-13'],
                        'benar' => 0
                    ],

                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Hasil dari (-4) × (-3) adalah ...',
                        'pilihan' => ['-12', '12', '-7', '7'],
                        'benar' => 1
                    ],

                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Bilangan nol (0) termasuk bilangan bulat.',
                        'pilihan' => ['Benar', 'Salah'],
                        'benar' => 0
                    ],

                    [
                        'kategori' => 'UTS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 15,
                        'pertanyaan' => 'Nilai dari (-6) + (-4) + 10 adalah ...',
                        'pilihan' => ['0', '2', '-2', '20'],
                        'benar' => 0
                    ],

                    [
                        'kategori' => 'UTS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 15,
                        'pertanyaan' => 'Suhu di puncak gunung -8°C dan di kaki gunung 17°C. Selisih suhunya adalah ...',
                        'pilihan' => ['9°C', '25°C', '-25°C', '-9°C'],
                        'benar' => 1
                    ],

                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Urutan yang benar dari terkecil ke terbesar: -5, 3, -1, 0, 7 adalah ...',
                        'pilihan' => ['-5,-1,0,3,7', '-1,-5,0,3,7', '7,3,0,-1,-5', '0,-1,-5,3,7'],
                        'benar' => 0
                    ],
                ],
            ],
            [
                'judul'     => 'Bab 2 — Pecahan',
                'deskripsi' => 'Operasi pada pecahan biasa, campuran, dan desimal.',
                'urutan'    => 2,
                'konten'    => "Pecahan adalah bilangan yang dinyatakan dalam bentuk a/b di mana b ≠ 0.\n\n"
                    . "Jenis Pecahan:\n"
                    . "• Pecahan biasa  : 1/2, 3/4, 2/5\n"
                    . "• Pecahan campuran: 1½, 2¾\n"
                    . "• Pecahan desimal : 0,5 ; 0,75\n\n"
                    . "Menyamakan Penyebut\n"
                    . "Untuk menjumlahkan atau mengurangkan pecahan, "
                    . "penyebut harus disamakan terlebih dahulu menggunakan KPK.",
                'soal' => [
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Hasil dari 1/2 + 1/3 adalah ...',
                        'pilihan' => ['2/5', '5/6', '1/6', '2/6'],
                        'benar' => 1
                    ],

                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Bentuk desimal dari 3/4 adalah ...',
                        'pilihan' => ['0,25', '0,5', '0,75', '1,25'],
                        'benar' => 2
                    ],

                    [
                        'kategori' => 'UTS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 15,
                        'pertanyaan' => 'Hasil dari 2/3 × 3/4 adalah ...',
                        'pilihan' => ['6/7', '1/2', '5/7', '5/12'],
                        'benar' => 1
                    ],

                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 20,
                        'pertanyaan' => '0,5 sama nilainya dengan 1/2.',
                        'pilihan' => ['Benar', 'Salah'],
                        'benar' => 0
                    ],
                ],
            ],
        ]);

        // ── BAHASA INDONESIA ────────────────────
        $this->buatBab($guru->Id_user, $mapelBindo, $kategoriIds, [
            [
                'judul'     => 'Bab 1 — Teks Deskripsi',
                'deskripsi' => 'Memahami struktur dan ciri-ciri teks deskripsi.',
                'urutan'    => 1,
                'konten'    => "Teks deskripsi adalah teks yang menggambarkan suatu objek secara rinci "
                    . "sehingga pembaca seolah-olah melihat, mendengar, atau merasakan objek tersebut.\n\n"
                    . "Struktur Teks Deskripsi:\n"
                    . "1. Identifikasi  — pengenalan objek\n"
                    . "2. Deskripsi bagian — penjelasan detail bagian-bagian objek\n"
                    . "3. Simpulan/kesan — kesan penulis tentang objek\n\n"
                    . "Ciri Kebahasaan:\n"
                    . "• Menggunakan kata sifat (indah, besar, merah)\n"
                    . "• Menggunakan kata kerja aksi\n"
                    . "• Menggunakan majas (perbandingan, personifikasi)",
                'soal' => [
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Tujuan utama teks deskripsi adalah ...',
                        'pilihan' => [
                            'Menceritakan urutan kejadian',
                            'Menggambarkan objek secara rinci',
                            'Meyakinkan pembaca',
                            'Menjelaskan cara membuat sesuatu',
                        ],
                        'benar' => 1
                    ],

                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Teks deskripsi selalu diawali dengan bagian identifikasi.',
                        'pilihan' => ['Benar', 'Salah'],
                        'benar' => 0
                    ],

                    [
                        'kategori' => 'UTS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 15,
                        'pertanyaan' => 'Berikut yang merupakan ciri kebahasaan teks deskripsi adalah ...',
                        'pilihan' => [
                            'Banyak menggunakan kata hubung waktu',
                            'Banyak menggunakan kata sifat',
                            'Banyak menggunakan kata perintah',
                            'Banyak menggunakan kata tanya',
                        ],
                        'benar' => 1
                    ],

                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Bagian teks deskripsi yang berisi pengenalan objek disebut ...',
                        'pilihan' => ['Deskripsi', 'Simpulan', 'Identifikasi', 'Orientasi'],
                        'benar' => 2
                    ],
                ],
            ],
            [
                'judul'     => 'Bab 2 — Teks Narasi',
                'deskripsi' => 'Memahami ciri-ciri dan struktur teks narasi.',
                'urutan'    => 2,
                'konten'    => "Teks narasi adalah teks yang menceritakan suatu rangkaian peristiwa secara kronologis.\n\n"
                    . "Struktur:\n"
                    . "1. Orientasi   — pengenalan tokoh, latar, dan waktu\n"
                    . "2. Komplikasi  — munculnya masalah atau konflik\n"
                    . "3. Resolusi    — penyelesaian masalah\n\n"
                    . "Unsur Narasi:\n"
                    . "• Tokoh dan penokohan\n"
                    . "• Latar (tempat, waktu, suasana)\n"
                    . "• Alur (maju, mundur, campuran)\n"
                    . "• Sudut pandang penulis",
                'soal' => [
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Urutan struktur teks narasi yang benar adalah ...',
                        'pilihan' => [
                            'Komplikasi – Orientasi – Resolusi',
                            'Orientasi – Resolusi – Komplikasi',
                            'Orientasi – Komplikasi – Resolusi',
                            'Resolusi – Komplikasi – Orientasi',
                        ],
                        'benar' => 2
                    ],

                    [
                        'kategori' => 'UTS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 15,
                        'pertanyaan' => 'Bagian teks narasi yang berisi penyelesaian konflik disebut ...',
                        'pilihan' => ['Orientasi', 'Komplikasi', 'Resolusi', 'Identifikasi'],
                        'benar' => 2
                    ],

                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 20,
                        'pertanyaan' => 'Alur maju berarti cerita diceritakan dari masa depan ke masa lalu.',
                        'pilihan' => ['Benar', 'Salah'],
                        'benar' => 1
                    ],
                ],
            ],
        ]);

        // ── IPA ─────────────────────────────────
        $this->buatBab($guru->Id_user, $mapelIPA, $kategoriIds, [
            [
                'judul'     => 'Bab 1 — Sel dan Organisme',
                'deskripsi' => 'Pengertian sel, bagian-bagian sel, dan perbedaan sel hewan dan tumbuhan.',
                'urutan'    => 1,
                'konten'    => "Sel adalah unit terkecil kehidupan yang mampu menjalankan fungsi-fungsi dasar makhluk hidup.\n\n"
                    . "Bagian Utama Sel:\n"
                    . "• Membran sel  — pelindung dan pengatur zat masuk/keluar\n"
                    . "• Sitoplasma   — cairan tempat organel berada\n"
                    . "• Nukleus      — pusat kendali sel, menyimpan DNA\n\n"
                    . "Perbedaan Sel Hewan & Tumbuhan:\n"
                    . "Dinding sel  : hanya ada di sel tumbuhan\n"
                    . "Kloroplas    : hanya ada di sel tumbuhan\n"
                    . "Vakuola      : kecil di sel hewan, besar di sel tumbuhan",
                'soal' => [
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Organel sel yang berfungsi sebagai pusat kendali sel adalah ...',
                        'pilihan' => ['Mitokondria', 'Ribosom', 'Nukleus', 'Vakuola'],
                        'benar' => 2
                    ],

                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Sel tumbuhan memiliki dinding sel, sedangkan sel hewan tidak.',
                        'pilihan' => ['Benar', 'Salah'],
                        'benar' => 0
                    ],

                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Kloroplas hanya ditemukan pada ...',
                        'pilihan' => ['Sel hewan', 'Sel tumbuhan', 'Keduanya', 'Bakteri'],
                        'benar' => 1
                    ],

                    [
                        'kategori' => 'UTS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 15,
                        'pertanyaan' => 'Fungsi membran sel adalah ...',
                        'pilihan' => [
                            'Tempat fotosintesis berlangsung',
                            'Mengatur lalu lintas zat masuk dan keluar sel',
                            'Menyimpan informasi genetik',
                            'Menghasilkan energi sel',
                        ],
                        'benar' => 1
                    ],

                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Organel yang menghasilkan energi (ATP) bagi sel adalah ...',
                        'pilihan' => ['Nukleus', 'Kloroplas', 'Mitokondria', 'Ribosom'],
                        'benar' => 2
                    ],
                ],
            ],
            [
                'judul'     => 'Bab 2 — Sistem Pencernaan',
                'deskripsi' => 'Organ-organ pencernaan manusia dan fungsinya.',
                'urutan'    => 2,
                'konten'    => "Sistem pencernaan manusia berfungsi mengubah makanan menjadi zat gizi yang dapat diserap tubuh.\n\n"
                    . "Urutan Organ Pencernaan:\n"
                    . "Mulut → Kerongkongan → Lambung → Usus Halus → Usus Besar → Anus\n\n"
                    . "Fungsi Tiap Organ:\n"
                    . "• Mulut       : mencerna secara mekanik (gigi) dan kimiawi (enzim amilase)\n"
                    . "• Lambung      : mencerna protein dengan enzim pepsin dan asam HCl\n"
                    . "• Usus halus   : menyerap sari-sari makanan\n"
                    . "• Usus besar   : menyerap air dan membentuk feses",
                'soal' => [
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Organ pencernaan yang berfungsi menyerap sari makanan adalah ...',
                        'pilihan' => ['Lambung', 'Usus halus', 'Usus besar', 'Kerongkongan'],
                        'benar' => 1
                    ],

                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Enzim amilase ditemukan di mulut dan berfungsi mencerna karbohidrat.',
                        'pilihan' => ['Benar', 'Salah'],
                        'benar' => 0
                    ],

                    [
                        'kategori' => 'UTS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 15,
                        'pertanyaan' => 'Asam HCl pada lambung berfungsi untuk ...',
                        'pilihan' => [
                            'Mencerna lemak',
                            'Mematikan kuman dan mengaktifkan enzim pepsin',
                            'Menyerap vitamin',
                            'Membentuk feses',
                        ],
                        'benar' => 1
                    ],

                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Urutan organ pencernaan yang benar dari awal hingga akhir adalah ...',
                        'pilihan' => [
                            'Mulut – Lambung – Kerongkongan – Usus Halus – Usus Besar – Anus',
                            'Mulut – Kerongkongan – Lambung – Usus Halus – Usus Besar – Anus',
                            'Mulut – Kerongkongan – Usus Halus – Lambung – Usus Besar – Anus',
                            'Mulut – Lambung – Usus Halus – Usus Besar – Kerongkongan – Anus',
                        ],
                        'benar' => 1
                    ],
                ],
            ],
        ]);

        // ══════════════════════════════════════════
        //  SELESAI
        // ══════════════════════════════════════════
        $this->command->info('');
        $this->command->info('✅ Seed selesai!');
        $this->command->info('');
        $this->command->info('  👤 Akun:');
        $this->command->info('     Guru   : guru@cbt.test   / password');
        $this->command->info('     Siswa 1: siswa@cbt.test  / password');
        $this->command->info('     Siswa 2: siswa2@cbt.test / password');
        $this->command->info('');
        $this->command->info('  📚 Mata Pelajaran : Matematika, Bahasa Indonesia, IPA');
        $this->command->info('  📖 Materi         : 2 bab per mapel (total 6 bab)');
        $this->command->info('  ❓ Soal           : Latihan Harian, UTS, UAS per bab');
        $this->command->info('  🏷️  Kategori       : Latihan Harian, UTS, UAS');
        $this->command->info('');
    }

    // ═══════════════════════════════════════════════════════════
    //  HELPER — insert bab beserta soal & pilihan jawaban
    // ═══════════════════════════════════════════════════════════
    private function buatBab(
        int   $idUser,
        int   $mapelId,
        array $kategoriIds,
        array $babList
    ): void {
        foreach ($babList as $bab) {

            $materiId = DB::table('materi')->insertGetId([
                'mapel_id'    => $mapelId,
                'judul'       => $bab['judul'],
                'deskripsi'   => $bab['deskripsi'],
                'konten'      => $bab['konten'],
                'urutan'      => $bab['urutan'],
                'Id_user'     => $idUser,
                'file_materi' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            foreach ($bab['soal'] as $s) {
                $soalId = DB::table('soal')->insertGetId([
                    'materi_id'   => $materiId,
                    'kategori_id' => $kategoriIds[$s['kategori']] ?? null,
                    'pertanyaan'  => $s['pertanyaan'],
                    'tipe_soal'   => $s['tipe'],
                    'poin'        => $s['poin'],
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);

                foreach ($s['pilihan'] as $idx => $teks) {
                    DB::table('pilihan_jawaban')->insert([
                        'id_soal'      => $soalId,
                        'teks_pilihan' => $teks,
                        'is_benar'     => ($idx === $s['benar']),
                    ]);
                }
            }
        }
    }
}
