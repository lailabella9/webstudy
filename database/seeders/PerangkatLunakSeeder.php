<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerangkatLunakSeeder extends Seeder
{
    public function run(): void
    {
        // ══════════════════════════════════════════
        //  Ambil data yang sudah ada
        // ══════════════════════════════════════════
        $guru = DB::table('users')->where('email', 'guru@cbt.test')->first();

        if (! $guru) {
            $this->command->error('User guru@cbt.test tidak ditemukan. Jalankan DatabaseSeeder terlebih dahulu.');
            return;
        }

        $kategoriIds = [];
        foreach (DB::table('kategori_latihan')->get() as $k) {
            $kategoriIds[$k->nama] = $k->Id_kategori;
        }

        // ══════════════════════════════════════════
        //  Urutan mapel berikutnya
        // ══════════════════════════════════════════
        $urutanMapel = DB::table('mata_pelajaran')->max('urutan') + 1;

        // ══════════════════════════════════════════
        //  MATA PELAJARAN 1: PEMROGRAMAN DASAR
        // ══════════════════════════════════════════
        $mapelPD = DB::table('mata_pelajaran')->insertGetId([
            'nama'       => 'Pemrograman Dasar',
            'deskripsi'  => 'Mata pelajaran yang mempelajari konsep dasar pemrograman komputer, algoritma, dan implementasi kode.',
            'thumbnail'  => null,
            'Id_user'    => $guru->Id_user,
            'urutan'     => $urutanMapel,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->buatBab($guru->Id_user, $mapelPD, $kategoriIds, [

            // ── BAB 1 ──────────────────────────────
            [
                'judul'     => 'Bab 1 — Pengantar Pemrograman',
                'deskripsi' => 'Konsep dasar pemrograman, algoritma, dan flowchart.',
                'urutan'    => 1,
                'konten'    => "Pemrograman adalah proses menulis instruksi yang dapat dieksekusi oleh komputer untuk menyelesaikan suatu tugas.\n\n"
                    . "Konsep Dasar:\n"
                    . "• Program   : sekumpulan instruksi yang ditulis dalam bahasa pemrograman\n"
                    . "• Algoritma : langkah-langkah logis untuk menyelesaikan masalah\n"
                    . "• Flowchart : representasi visual dari alur algoritma\n\n"
                    . "Simbol Flowchart:\n"
                    . "• Oval       : Start / End\n"
                    . "• Persegi panjang : Proses\n"
                    . "• Belah ketupat   : Keputusan (Decision)\n"
                    . "• Jajar genjang   : Input / Output\n\n"
                    . "Bahasa Pemrograman Populer:\n"
                    . "Python, Java, C++, JavaScript, PHP",
                'soal' => [
                    // 10 Latihan Harian
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Yang dimaksud dengan algoritma adalah ...',
                        'pilihan'    => ['Bahasa pemrograman tingkat tinggi', 'Langkah-langkah logis untuk menyelesaikan masalah', 'Kode biner komputer', 'Program yang sudah dikompilasi'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Simbol belah ketupat pada flowchart mewakili ...',
                        'pilihan'    => ['Proses', 'Input/Output', 'Keputusan (Decision)', 'Start/End'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Berikut yang termasuk bahasa pemrograman tingkat tinggi adalah ...',
                        'pilihan'    => ['Assembly', 'Bahasa Mesin', 'Python', 'Kode biner'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Flowchart adalah representasi visual dari alur algoritma.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Simbol oval pada flowchart digunakan untuk ...',
                        'pilihan'    => ['Proses perhitungan', 'Input data', 'Start dan End', 'Percabangan'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Proses mengubah kode sumber menjadi kode yang dapat dijalankan komputer disebut ...',
                        'pilihan'    => ['Debugging', 'Kompilasi', 'Instalasi', 'Eksekusi'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Bahasa Assembly termasuk bahasa pemrograman tingkat tinggi.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Kesalahan logika pada program disebut ...',
                        'pilihan'    => ['Syntax error', 'Logic error', 'Runtime error', 'Compile error'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Tujuan utama pembuatan algoritma sebelum coding adalah ...',
                        'pilihan'    => ['Mempercepat komputer', 'Memperjelas alur penyelesaian masalah', 'Menghemat memori', 'Mengurangi ukuran program'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Pseudocode adalah ...',
                        'pilihan'    => ['Kode rahasia', 'Representasi algoritma menggunakan bahasa sehari-hari yang menyerupai kode program', 'Bahasa pemrograman baru', 'Kode biner'],
                        'benar' => 1,
                    ],
                    // 10 UAS (Tugas Akhir)
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Urutan yang benar dalam membuat program adalah ...',
                        'pilihan'    => ['Coding – Algoritma – Testing – Analisis', 'Analisis – Algoritma – Coding – Testing', 'Testing – Coding – Algoritma – Analisis', 'Coding – Testing – Analisis – Algoritma'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah yang merupakan contoh bahasa pemrograman berorientasi objek?',
                        'pilihan'    => ['HTML', 'CSS', 'Java', 'SQL'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Interpreter menerjemahkan kode program baris per baris saat dijalankan.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Proses mencari dan memperbaiki kesalahan pada program disebut ...',
                        'pilihan'    => ['Compiling', 'Debugging', 'Rendering', 'Parsing'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah yang BUKAN merupakan tipe error dalam pemrograman?',
                        'pilihan'    => ['Syntax error', 'Logic error', 'Runtime error', 'Network error'],
                        'benar' => 3,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Simbol jajar genjang pada flowchart mewakili ...',
                        'pilihan'    => ['Proses', 'Keputusan', 'Input/Output', 'Start/End'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Satu masalah bisa diselesaikan dengan lebih dari satu algoritma.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah yang termasuk bahasa pemrograman scripting?',
                        'pilihan'    => ['C++', 'Java', 'Python', 'Pascal'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Apa yang dimaksud dengan source code?',
                        'pilihan'    => ['Kode biner hasil kompilasi', 'Kode yang ditulis programmer dalam bahasa pemrograman', 'File executable', 'Kode mesin'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Keuntungan menggunakan flowchart dalam perancangan program adalah ...',
                        'pilihan'    => ['Mengurangi ukuran program', 'Mempercepat eksekusi program', 'Mempermudah pemahaman alur logika program', 'Menghilangkan semua error'],
                        'benar' => 2,
                    ],
                ],
            ],

            // ── BAB 2 ──────────────────────────────
            [
                'judul'     => 'Bab 2 — Variabel dan Tipe Data',
                'deskripsi' => 'Memahami konsep variabel, konstanta, dan berbagai tipe data dalam pemrograman.',
                'urutan'    => 2,
                'konten'    => "Variabel adalah tempat penyimpanan data sementara di memori komputer yang nilainya dapat berubah.\n\n"
                    . "Tipe Data Dasar:\n"
                    . "• Integer  : bilangan bulat (contoh: 10, -5, 0)\n"
                    . "• Float    : bilangan desimal (contoh: 3.14, -2.5)\n"
                    . "• String   : teks/karakter (contoh: \"Halo\", 'Dunia')\n"
                    . "• Boolean  : nilai logika (True / False)\n"
                    . "• Char     : satu karakter (contoh: 'A', 'z')\n\n"
                    . "Konstanta: variabel yang nilainya tidak dapat berubah setelah dideklarasikan.\n\n"
                    . "Aturan Penamaan Variabel:\n"
                    . "• Tidak boleh diawali angka\n"
                    . "• Tidak boleh menggunakan spasi\n"
                    . "• Tidak boleh menggunakan kata kunci (keyword) bahasa pemrograman",
                'soal' => [
                    // 10 Latihan Harian
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Tipe data yang digunakan untuk menyimpan bilangan desimal adalah ...',
                        'pilihan'    => ['Integer', 'Boolean', 'Float', 'Char'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Nilai yang dapat disimpan oleh tipe data Boolean adalah ...',
                        'pilihan'    => ['0 dan 1 saja', 'True dan False', 'Semua angka', 'Semua karakter'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Nama variabel boleh diawali dengan angka.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Manakah penamaan variabel yang benar?',
                        'pilihan'    => ['1nilai', 'nilai pertama', 'nilai_pertama', 'int'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Tipe data yang digunakan untuk menyimpan teks adalah ...',
                        'pilihan'    => ['Integer', 'String', 'Boolean', 'Float'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Konstanta berbeda dari variabel karena ...',
                        'pilihan'    => ['Tidak perlu dideklarasikan', 'Nilainya tidak bisa berubah setelah ditetapkan', 'Hanya bisa menyimpan angka', 'Tidak menggunakan memori'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Tipe data char hanya menyimpan satu karakter.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Nilai 3.14 dalam pemrograman disimpan dengan tipe data ...',
                        'pilihan'    => ['Integer', 'String', 'Boolean', 'Float'],
                        'benar' => 3,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Manakah yang merupakan contoh tipe data integer?',
                        'pilihan'    => ['"100"', '3.14', '100', 'True'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Dalam Python, untuk menyimpan nama "Budi" ke variabel nama, penulisan yang benar adalah ...',
                        'pilihan'    => ['nama = Budi', 'nama = "Budi"', '"nama" = Budi', 'nama : "Budi"'],
                        'benar' => 1,
                    ],
                    // 10 UAS (Tugas Akhir)
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Tipe data yang paling tepat untuk menyimpan nilai status kelulusan (lulus/tidak lulus) adalah ...',
                        'pilihan'    => ['Integer', 'String', 'Boolean', 'Float'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah penamaan variabel yang TIDAK valid?',
                        'pilihan'    => ['nilaiSiswa', 'nilai_siswa', '_nilai', '2nilai'],
                        'benar' => 3,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Tipe data String dapat menyimpan kombinasi huruf, angka, dan simbol.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Deklarasi variabel diperlukan karena ...',
                        'pilihan'    => ['Memperindah kode program', 'Memberitahu komputer jenis data yang akan disimpan sehingga memori dapat dialokasikan', 'Membuat program lebih cepat', 'Mengurangi jumlah baris kode'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Jika variabel x = 5 dan x = 10, nilai x sekarang adalah ...',
                        'pilihan'    => ['5', '15', '10', 'Error'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Apa yang terjadi jika kita mencoba mengubah nilai konstanta?',
                        'pilihan'    => ['Tidak ada yang terjadi', 'Nilai berhasil diubah', 'Program menghasilkan error', 'Nilai konstanta berlipat ganda'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Tipe data integer dapat menyimpan bilangan pecahan seperti 1.5.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Dalam pemrograman, casting adalah ...',
                        'pilihan'    => ['Membuat variabel baru', 'Mengubah tipe data suatu nilai ke tipe data lain', 'Menghapus variabel', 'Menggandakan nilai variabel'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Fungsi len("Halo") pada Python akan menghasilkan ...',
                        'pilihan'    => ['Halo', '4', '"Halo"', 'Error'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Tipe data manakah yang memiliki ukuran memori paling kecil?',
                        'pilihan'    => ['Integer', 'Float', 'String', 'Boolean'],
                        'benar' => 3,
                    ],
                ],
            ],

            // ── BAB 3 ──────────────────────────────
            [
                'judul'     => 'Bab 3 — Operator dan Ekspresi',
                'deskripsi' => 'Berbagai jenis operator dalam pemrograman dan cara penggunaannya.',
                'urutan'    => 3,
                'konten'    => "Operator adalah simbol yang digunakan untuk melakukan operasi pada satu atau lebih nilai (operand).\n\n"
                    . "Jenis-jenis Operator:\n"
                    . "1. Operator Aritmatika  : +, -, *, /, % (modulus), ** (pangkat)\n"
                    . "2. Operator Perbandingan: ==, !=, >, <, >=, <=\n"
                    . "3. Operator Logika      : AND, OR, NOT\n"
                    . "4. Operator Penugasan   : =, +=, -=, *=, /=\n\n"
                    . "Prioritas Operator (dari tinggi ke rendah):\n"
                    . "1. Tanda kurung ()\n"
                    . "2. Pangkat **\n"
                    . "3. Perkalian * dan Pembagian /\n"
                    . "4. Penjumlahan + dan Pengurangan -",
                'soal' => [
                    // 10 Latihan Harian
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Hasil dari 10 % 3 adalah ...',
                        'pilihan'    => ['3', '1', '0', '2'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Operator == digunakan untuk ...',
                        'pilihan'    => ['Penugasan nilai', 'Memeriksa kesamaan dua nilai', 'Membandingkan lebih besar', 'Operasi logika'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Operator % (modulus) menghasilkan sisa bagi dua bilangan.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Hasil dari 2 ** 4 adalah ...',
                        'pilihan'    => ['8', '6', '16', '12'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'True AND False menghasilkan ...',
                        'pilihan'    => ['True', 'False', 'Error', 'None'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Operator yang digunakan untuk memeriksa ketidaksamaan adalah ...',
                        'pilihan'    => ['==', '>=', '!=', '<='],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Operasi 5 += 3 berarti nilai variabel menjadi 8.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Hasil dari NOT True adalah ...',
                        'pilihan'    => ['True', 'False', '0', '1'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Dalam ekspresi 3 + 4 * 2, hasil yang benar adalah ...',
                        'pilihan'    => ['14', '11', '10', '16'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'True OR False menghasilkan ...',
                        'pilihan'    => ['True', 'False', 'None', 'Error'],
                        'benar' => 0,
                    ],
                    // 10 UAS
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Hasil dari (3 + 4) * 2 adalah ...',
                        'pilihan'    => ['11', '14', '10', '16'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Ekspresi 10 / 4 dalam Python 3 menghasilkan ...',
                        'pilihan'    => ['2', '2.5', '3', '2.0'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Operator = dan == memiliki fungsi yang sama dalam pemrograman.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah yang merupakan operator logika?',
                        'pilihan'    => ['+, -, *, /', '==, !=, >, <', 'AND, OR, NOT', '=, +=, -='],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Hasil dari 15 % 4 adalah ...',
                        'pilihan'    => ['3', '4', '1', '2'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Operator // dalam Python digunakan untuk ...',
                        'pilihan'    => ['Pembagian biasa', 'Pembagian bulat (floor division)', 'Modulus', 'Pangkat'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Ekspresi (5 > 3) AND (2 < 4) menghasilkan nilai True.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah urutan prioritas operator yang benar dari tertinggi ke terendah?',
                        'pilihan'    => ['(), **, *, /, +, -', '+, -, *, /, **', '**, +, -, *, /', '*, /, +, -, **'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Ekspresi x -= 5 setara dengan ...',
                        'pilihan'    => ['x = 5 - x', 'x = x - 5', 'x = x + 5', 'x = -5'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Hasil dari NOT (5 > 3) adalah ...',
                        'pilihan'    => ['True', 'False', '5', 'Error'],
                        'benar' => 1,
                    ],
                ],
            ],

            // ── BAB 4 ──────────────────────────────
            [
                'judul'     => 'Bab 4 — Struktur Percabangan',
                'deskripsi' => 'Penggunaan if, if-else, dan if-elif-else untuk pengambilan keputusan dalam program.',
                'urutan'    => 4,
                'konten'    => "Struktur percabangan digunakan ketika program perlu mengambil keputusan berdasarkan suatu kondisi.\n\n"
                    . "Jenis Percabangan:\n"
                    . "1. if          : dieksekusi jika kondisi True\n"
                    . "2. if-else     : pilihan alternatif jika kondisi False\n"
                    . "3. if-elif-else: percabangan berganda\n"
                    . "4. switch-case : percabangan berdasarkan nilai (C, Java, PHP)\n\n"
                    . "Contoh Python:\n"
                    . "nilai = 75\n"
                    . "if nilai >= 80:\n"
                    . "    print('A')\n"
                    . "elif nilai >= 70:\n"
                    . "    print('B')\n"
                    . "else:\n"
                    . "    print('C')",
                'soal' => [
                    // 10 Latihan Harian
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Struktur if-else digunakan ketika ...',
                        'pilihan'    => ['Program selalu berjalan sama', 'Ada dua kemungkinan jalur eksekusi berdasarkan kondisi', 'Program perlu melakukan pengulangan', 'Ada lebih dari 10 kondisi'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Jika nilai = 85, maka program if-elif: if nilai >= 90: "A" elif nilai >= 80: "B" else: "C" akan mencetak ...',
                        'pilihan'    => ['A', 'B', 'C', 'Error'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Blok else akan dieksekusi jika semua kondisi if dan elif bernilai False.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Keyword yang digunakan untuk percabangan berganda di Python adalah ...',
                        'pilihan'    => ['else if', 'elif', 'elseif', 'switch'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Kondisi dalam pernyataan if harus bernilai ...',
                        'pilihan'    => ['Integer', 'String', 'Boolean (True/False)', 'Float'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Percabangan bersarang (nested if) adalah ...',
                        'pilihan'    => ['Dua percabangan yang berjalan bersamaan', 'Percabangan di dalam percabangan lain', 'Percabangan tanpa kondisi', 'Percabangan dengan banyak else'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Dalam Python, indentasi (spasi) sangat penting untuk menentukan blok kode.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Jika usia = 17, kondisi manakah yang bernilai True?',
                        'pilihan'    => ['usia > 17', 'usia == 18', 'usia >= 17', 'usia < 17'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Manakah yang merupakan sintaks if yang benar di Python?',
                        'pilihan'    => ['if (x > 0) {', 'if x > 0:', 'IF x > 0 THEN', 'if x > 0 then'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Berapa banyak blok else yang boleh ada dalam satu pernyataan if?',
                        'pilihan'    => ['Tidak ada batasan', 'Maksimal 2', 'Hanya 1', 'Maksimal 5'],
                        'benar' => 2,
                    ],
                    // 10 UAS
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Program: x=10; if x>5: print("besar") else: print("kecil"). Outputnya adalah ...',
                        'pilihan'    => ['kecil', 'besar', 'Error', 'Tidak ada output'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah penggunaan switch-case yang tepat dibandingkan if-elif?',
                        'pilihan'    => ['Ketika kondisi berbentuk range nilai', 'Ketika memeriksa satu variabel terhadap banyak nilai diskrit', 'Ketika ada dua kondisi saja', 'Ketika tidak ada kondisi'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Jika kondisi if bernilai True, blok else tidak akan dieksekusi.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Untuk memeriksa apakah angka adalah bilangan genap, kondisi yang tepat adalah ...',
                        'pilihan'    => ['angka % 2 == 1', 'angka / 2 == 0', 'angka % 2 == 0', 'angka // 2 == 0'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Jika nilai = 60, elif nilai >= 70: "B", maka output program adalah ...',
                        'pilihan'    => ['B', 'Tidak ada output dari elif tersebut', 'Error', '70'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Kondisi "x > 0 AND x < 10" dalam Python ditulis sebagai ...',
                        'pilihan'    => ['x > 0 AND x < 10', 'x > 0 and x < 10', '0 < x > 10', 'x > 0 && x < 10'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Dalam satu struktur if, dapat terdapat lebih dari satu blok elif.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Apa yang dimaksud dengan short-circuit evaluation dalam kondisi logika?',
                        'pilihan'    => ['Evaluasi yang selalu menghasilkan error', 'Evaluasi yang berhenti setelah hasil sudah pasti tanpa memeriksa semua kondisi', 'Evaluasi yang mengecek semua kondisi meskipun hasilnya sudah pasti', 'Evaluasi perulangan'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Untuk mengecek apakah tahun adalah tahun kabisat (habis dibagi 4), kondisi yang tepat adalah ...',
                        'pilihan'    => ['tahun % 4 != 0', 'tahun / 4 == 0', 'tahun % 4 == 0', 'tahun > 4'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah yang bukan merupakan keuntungan menggunakan percabangan?',
                        'pilihan'    => ['Program lebih fleksibel', 'Program dapat merespons input berbeda', 'Program selalu lebih cepat', 'Program dapat mengambil keputusan otomatis'],
                        'benar' => 2,
                    ],
                ],
            ],

            // ── BAB 5 ──────────────────────────────
            [
                'judul'     => 'Bab 5 — Struktur Perulangan',
                'deskripsi' => 'Penggunaan for loop dan while loop untuk mengeksekusi kode secara berulang.',
                'urutan'    => 5,
                'konten'    => "Struktur perulangan (loop) digunakan untuk mengeksekusi blok kode secara berulang selama kondisi terpenuhi.\n\n"
                    . "Jenis Perulangan:\n"
                    . "1. for loop   : perulangan dengan jumlah iterasi yang sudah diketahui\n"
                    . "2. while loop : perulangan selama kondisi True\n"
                    . "3. do-while   : minimal sekali dieksekusi sebelum kondisi diperiksa\n\n"
                    . "Keyword Khusus:\n"
                    . "• break    : menghentikan perulangan\n"
                    . "• continue : melewati iterasi saat ini\n"
                    . "• pass     : tidak melakukan apa-apa (Python)\n\n"
                    . "Contoh Python:\n"
                    . "for i in range(5):\n"
                    . "    print(i)  # Mencetak 0,1,2,3,4",
                'soal' => [
                    // 10 Latihan Harian
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Perulangan for digunakan ketika ...',
                        'pilihan'    => ['Jumlah iterasi tidak diketahui', 'Jumlah iterasi sudah diketahui', 'Tidak perlu kondisi', 'Hanya dieksekusi sekali'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'range(1, 6) pada Python menghasilkan ...',
                        'pilihan'    => ['1, 2, 3, 4, 5, 6', '1, 2, 3, 4, 5', '0, 1, 2, 3, 4, 5', '1, 2, 3, 4'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Keyword break digunakan untuk menghentikan perulangan sebelum kondisi habis.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Infinite loop terjadi ketika ...',
                        'pilihan'    => ['Loop berjalan terlalu cepat', 'Kondisi while tidak pernah menjadi False', 'Loop menggunakan range()', 'Ada keyword break'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'for i in range(5): akan menjalankan loop sebanyak ...',
                        'pilihan'    => ['4 kali', '5 kali', '6 kali', '0 kali'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Keyword continue dalam perulangan berfungsi untuk ...',
                        'pilihan'    => ['Menghentikan perulangan', 'Melewati iterasi saat ini dan lanjut ke iterasi berikutnya', 'Mengulang dari awal', 'Keluar dari program'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'while True: adalah contoh infinite loop.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Nested loop adalah ...',
                        'pilihan'    => ['Loop yang sangat cepat', 'Loop di dalam loop', 'Loop dengan banyak kondisi', 'Loop tanpa variabel'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'range(0, 10, 2) menghasilkan ...',
                        'pilihan'    => ['0, 1, 2, 3, 4, 5, 6, 7, 8, 9', '0, 2, 4, 6, 8', '2, 4, 6, 8, 10', '0, 2, 4, 6, 8, 10'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Perulangan while digunakan ketika ...',
                        'pilihan'    => ['Jumlah iterasi pasti', 'Kondisi iterasi bergantung pada nilai yang berubah-ubah', 'Hanya perlu 1 iterasi', 'Mengulang string'],
                        'benar' => 1,
                    ],
                    // 10 UAS
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Kode: i=0; while i<5: i+=1. Loop berjalan sebanyak ...',
                        'pilihan'    => ['4 kali', '5 kali', '6 kali', 'Infinite loop'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Untuk mencetak deret 1 2 3 4 5, kode Python yang tepat adalah ...',
                        'pilihan'    => ['for i in range(5): print(i)', 'for i in range(1, 6): print(i)', 'for i in range(0, 5): print(i)', 'for i in range(1, 5): print(i)'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Keyword break akan menghentikan hanya iterasi saat ini, bukan seluruh loop.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Loop manakah yang menjamin eksekusi minimal satu kali?',
                        'pilihan'    => ['for loop', 'while loop', 'do-while loop', 'Semua loop'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Untuk menghitung jumlah 1+2+3+...+100, struktur yang paling tepat adalah ...',
                        'pilihan'    => ['if-else', 'for loop dengan akumulator', 'Percabangan berganda', 'Satu pernyataan assignment'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Apa output dari: for i in range(3): if i==1: continue; print(i)?',
                        'pilihan'    => ['0 1 2', '0 2', '1 2', '0 1'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Nested loop dengan n iterasi luar dan m iterasi dalam mengeksekusi blok kode n*m kali.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Untuk iterasi mundur dari 10 ke 1, range() yang tepat adalah ...',
                        'pilihan'    => ['range(10, 0)', 'range(10, 0, -1)', 'range(1, 10, -1)', 'range(10, 1)'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah yang akan menyebabkan infinite loop?',
                        'pilihan'    => ['i = 0; while i < 5: i += 1', 'i = 0; while i < 5: i -= 1', 'for i in range(10):', 'while False:'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Pada nested for loop, perulangan manakah yang paling sering dieksekusi?',
                        'pilihan'    => ['Loop terluar', 'Loop terdalam', 'Semua sama', 'Bergantung pada kondisi'],
                        'benar' => 1,
                    ],
                ],
            ],

            // ── BAB 6 ──────────────────────────────
            [
                'judul'     => 'Bab 6 — Array dan List',
                'deskripsi' => 'Konsep array dan list sebagai struktur data untuk menyimpan banyak nilai.',
                'urutan'    => 6,
                'konten'    => "Array adalah struktur data yang menyimpan kumpulan nilai dengan tipe data yang sama dalam satu variabel.\n\n"
                    . "Di Python, struktur data serupa disebut List yang lebih fleksibel.\n\n"
                    . "Karakteristik Array/List:\n"
                    . "• Indeks dimulai dari 0\n"
                    . "• Dapat diakses menggunakan indeks\n"
                    . "• Memiliki panjang (length)\n\n"
                    . "Operasi List Python:\n"
                    . "• append()  : menambah elemen di akhir\n"
                    . "• remove()  : menghapus elemen\n"
                    . "• len()     : mengetahui panjang list\n"
                    . "• sort()    : mengurutkan list\n"
                    . "• index()   : mencari posisi elemen\n\n"
                    . "Contoh: buah = ['apel', 'mangga', 'jeruk']\n"
                    . "buah[0] menghasilkan 'apel'",
                'soal' => [
                    // 10 Latihan Harian
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Indeks pertama pada array/list dimulai dari ...',
                        'pilihan'    => ['1', '0', '-1', 'Bergantung bahasa'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Jika data = [10, 20, 30, 40], maka data[2] adalah ...',
                        'pilihan'    => ['10', '20', '30', '40'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Indeks negatif -1 pada Python mengacu pada elemen terakhir list.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Fungsi len([5, 10, 15, 20]) menghasilkan ...',
                        'pilihan'    => ['3', '4', '5', '50'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Metode append() pada list digunakan untuk ...',
                        'pilihan'    => ['Menghapus elemen', 'Mengurutkan list', 'Menambah elemen di akhir list', 'Mencari elemen'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'List dalam Python berbeda dengan array karena ...',
                        'pilihan'    => ['List lebih lambat', 'List bisa menyimpan tipe data berbeda dalam satu list', 'List tidak memiliki indeks', 'List hanya bisa menyimpan angka'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Array dua dimensi dapat digunakan untuk menyimpan data tabel.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Cara menghapus elemen "apel" dari list buah = ["apel", "mangga"] adalah ...',
                        'pilihan'    => ['buah.delete("apel")', 'buah.remove("apel")', 'buah.pop("apel")', 'delete buah[0]'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Untuk mengakses baris ke-2 kolom ke-1 dari matriks m, sintaksnya adalah ...',
                        'pilihan'    => ['m[2][1]', 'm[1][0]', 'm(2,1)', 'm[2,1]'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'list.sort() akan mengurutkan list secara ...',
                        'pilihan'    => ['Acak', 'Ascending (menaik) secara default', 'Descending (menurun) secara default', 'Tidak mengurutkan'],
                        'benar' => 1,
                    ],
                    // 10 UAS
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Slicing angka[1:4] dari list [0,10,20,30,40,50] menghasilkan ...',
                        'pilihan'    => ['[0, 10, 20]', '[10, 20, 30]', '[10, 20, 30, 40]', '[20, 30, 40]'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah yang BUKAN metode bawaan list Python?',
                        'pilihan'    => ['append()', 'sort()', 'reverse()', 'add()'],
                        'benar' => 3,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Elemen list Python dapat diubah nilainya setelah dideklarasikan.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Cara menambah elemen di posisi tertentu pada list adalah ...',
                        'pilihan'    => ['append()', 'insert()', 'add()', 'push()'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Jika a = [1,2,3] dan b = [4,5,6], maka a + b menghasilkan ...',
                        'pilihan'    => ['[5, 7, 9]', '[1,2,3,4,5,6]', 'Error', '[4,5,6,1,2,3]'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Perbedaan list dan tuple di Python adalah ...',
                        'pilihan'    => ['List menggunakan () sedangkan tuple menggunakan []', 'List dapat diubah (mutable) sedangkan tuple tidak (immutable)', 'Tuple lebih lambat', 'Tidak ada perbedaan'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Indeks list Python bisa bernilai negatif untuk mengakses elemen dari belakang.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Untuk mengetahui apakah "apel" ada dalam list buah, kode yang tepat adalah ...',
                        'pilihan'    => ['"apel" == buah', '"apel" in buah', 'buah.has("apel")', 'buah.contains("apel")'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Metode pop() pada list berfungsi untuk ...',
                        'pilihan'    => ['Menambah elemen', 'Menghapus dan mengembalikan elemen terakhir', 'Mengurutkan', 'Membalik urutan'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Apa output dari: print([1,2,3] * 2)?',
                        'pilihan'    => ['[2,4,6]', '[1,2,3,1,2,3]', 'Error', '[3,6,9]'],
                        'benar' => 1,
                    ],
                ],
            ],

            // ── BAB 7 ──────────────────────────────
            [
                'judul'     => 'Bab 7 — Fungsi dan Prosedur',
                'deskripsi' => 'Membuat dan menggunakan fungsi untuk modularisasi kode program.',
                'urutan'    => 7,
                'konten'    => "Fungsi adalah blok kode yang dapat dipanggil berkali-kali untuk menjalankan tugas tertentu.\n\n"
                    . "Komponen Fungsi:\n"
                    . "• Nama fungsi\n"
                    . "• Parameter (input)\n"
                    . "• Tubuh fungsi\n"
                    . "• Return value (nilai kembalian)\n\n"
                    . "Jenis Fungsi:\n"
                    . "• Built-in function: print(), len(), input(), int(), str()\n"
                    . "• User-defined function: fungsi yang dibuat programmer\n\n"
                    . "Contoh Python:\n"
                    . "def luas_persegi(sisi):\n"
                    . "    return sisi * sisi\n\n"
                    . "hasil = luas_persegi(5)  # hasil = 25\n\n"
                    . "Scope Variabel:\n"
                    . "• Lokal  : hanya bisa diakses di dalam fungsi\n"
                    . "• Global : bisa diakses di seluruh program",
                'soal' => [
                    // 10 Latihan Harian
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Keyword yang digunakan untuk mendefinisikan fungsi di Python adalah ...',
                        'pilihan'    => ['func', 'function', 'def', 'define'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Nilai yang dikembalikan oleh fungsi ditentukan oleh keyword ...',
                        'pilihan'    => ['send', 'output', 'return', 'result'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Fungsi print() adalah contoh built-in function Python.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Parameter adalah ...',
                        'pilihan'    => ['Nilai yang dikembalikan fungsi', 'Variabel yang menerima nilai saat fungsi dipanggil', 'Nama fungsi', 'Badan fungsi'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Fungsi tanpa return value akan mengembalikan ...',
                        'pilihan'    => ['0', 'Error', 'None', 'False'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Keuntungan utama menggunakan fungsi dalam pemrograman adalah ...',
                        'pilihan'    => ['Membuat program lebih lambat', 'Menghindari pengulangan kode dan memudahkan pemeliharaan', 'Menambah ukuran file', 'Membuat variabel lebih banyak'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Variabel lokal dapat diakses dari luar fungsi tempat ia dideklarasikan.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Fungsi rekursif adalah ...',
                        'pilihan'    => ['Fungsi tanpa parameter', 'Fungsi yang memanggil dirinya sendiri', 'Fungsi dengan banyak return', 'Fungsi built-in'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Argumen adalah ...',
                        'pilihan'    => ['Nama fungsi saat dipanggil', 'Nilai yang dikirim saat fungsi dipanggil', 'Tipe data fungsi', 'Badan fungsi'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Manakah yang merupakan contoh pemanggilan fungsi?',
                        'pilihan'    => ['def hitung():', 'hitung()', 'return hitung', 'function hitung'],
                        'benar' => 1,
                    ],
                    // 10 UAS
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Fungsi: def tambah(a, b): return a+b. Pemanggilan tambah(3, 4) menghasilkan ...',
                        'pilihan'    => ['34', '7', 'a+b', 'Error'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Apa yang dimaksud dengan default parameter?',
                        'pilihan'    => ['Parameter yang tidak bisa diubah', 'Parameter dengan nilai bawaan jika tidak diberikan argumen', 'Parameter pertama fungsi', 'Parameter global'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Fungsi bisa mengembalikan lebih dari satu nilai di Python.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Untuk menggunakan variabel global di dalam fungsi Python, kita menggunakan keyword ...',
                        'pilihan'    => ['global', 'extern', 'public', 'static'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Lambda function adalah ...',
                        'pilihan'    => ['Fungsi rekursif', 'Fungsi anonim satu baris', 'Fungsi dengan banyak parameter', 'Fungsi built-in'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Kode: def f(x=5): return x*2. Pemanggilan f() menghasilkan ...',
                        'pilihan'    => ['Error', '5', '10', '0'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Prosedur adalah fungsi yang tidak mengembalikan nilai (return void/None).',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah yang benar tentang rekursi?',
                        'pilihan'    => ['Selalu lebih efisien dari iterasi', 'Membutuhkan base case untuk menghentikan pemanggilan', 'Tidak bisa digunakan untuk faktorial', 'Tidak menggunakan stack memori'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Apa yang dimaksud dengan *args pada parameter fungsi Python?',
                        'pilihan'    => ['Pointer ke memori', 'Menerima jumlah argumen tak terbatas sebagai tuple', 'Argumen wajib', 'Argumen keyword'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Modularisasi program menggunakan fungsi memberikan keuntungan ...',
                        'pilihan'    => ['Program selalu lebih cepat', 'Kode lebih terorganisir, mudah di-debug dan digunakan kembali', 'Mengurangi jumlah variabel', 'Menghilangkan semua error'],
                        'benar' => 1,
                    ],
                ],
            ],

            // ── BAB 8 ──────────────────────────────
            [
                'judul'     => 'Bab 8 — Pengenalan OOP',
                'deskripsi' => 'Konsep dasar Object-Oriented Programming: kelas, objek, atribut, dan metode.',
                'urutan'    => 8,
                'konten'    => "OOP (Object-Oriented Programming) adalah paradigma pemrograman yang mengorganisasi kode\n"
                    . "dalam bentuk objek yang memiliki atribut dan perilaku.\n\n"
                    . "Konsep Utama OOP:\n"
                    . "1. Class     : cetak biru/template untuk membuat objek\n"
                    . "2. Object    : instance dari class\n"
                    . "3. Atribut   : data/properti milik objek\n"
                    . "4. Method    : fungsi yang dimiliki oleh class\n\n"
                    . "4 Pilar OOP:\n"
                    . "• Enkapsulasi  : menyembunyikan detail implementasi\n"
                    . "• Inheritance  : pewarisan sifat dari class induk\n"
                    . "• Polimorfisme : satu interface, banyak implementasi\n"
                    . "• Abstraksi    : menyederhanakan kompleksitas\n\n"
                    . "Contoh Python:\n"
                    . "class Siswa:\n"
                    . "    def __init__(self, nama, nilai):\n"
                    . "        self.nama = nama\n"
                    . "        self.nilai = nilai\n"
                    . "    def info(self):\n"
                    . "        return f'{self.nama}: {self.nilai}'",
                'soal' => [
                    // 10 Latihan Harian
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Dalam OOP, class adalah ...',
                        'pilihan'    => ['Instance dari objek', 'Cetak biru/template untuk membuat objek', 'Fungsi biasa', 'Tipe data primitif'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Objek adalah ...',
                        'pilihan'    => ['Template class', 'Instance (wujud nyata) dari sebuah class', 'Tipe data', 'Fungsi dalam class'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Method __init__ pada Python adalah konstruktor yang dipanggil saat objek dibuat.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Pewarisan sifat dari class induk ke class anak dalam OOP disebut ...',
                        'pilihan'    => ['Enkapsulasi', 'Polimorfisme', 'Inheritance', 'Abstraksi'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Manakah yang merupakan contoh atribut dari class Mobil?',
                        'pilihan'    => ['Metode bergerak()', 'Warna, merek, kecepatan', 'Fungsi berhenti()', 'Nama class'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Enkapsulasi dalam OOP berarti ...',
                        'pilihan'    => ['Class tidak bisa di-inherit', 'Menyembunyikan detail implementasi dan melindungi data', 'Satu method bisa melakukan banyak hal', 'Class tidak memiliki atribut'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Dari satu class dapat dibuat banyak objek.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Parameter self pada method Python mengacu pada ...',
                        'pilihan'    => ['Class itu sendiri', 'Objek saat ini yang memanggil method', 'Fungsi induk', 'Nilai default'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Cara membuat objek dari class Siswa di Python adalah ...',
                        'pilihan'    => ['Siswa.new()', 'obj = Siswa()', 'create Siswa()', 'new Siswa()'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Polimorfisme dalam OOP berarti ...',
                        'pilihan'    => ['Satu class hanya punya satu method', 'Satu interface/method dapat memiliki banyak bentuk/implementasi', 'Class tidak bisa diwariskan', 'Objek tidak bisa diubah'],
                        'benar' => 1,
                    ],
                    // 10 UAS
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Class Hewan memiliki method bersuara(). Class Kucing mewarisi Hewan dan override bersuara() menjadi "Meow". Ini contoh ...',
                        'pilihan'    => ['Enkapsulasi', 'Abstraksi', 'Polimorfisme', 'Agregasi'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Access modifier private pada atribut class berarti ...',
                        'pilihan'    => ['Bisa diakses dari mana saja', 'Hanya bisa diakses dalam class itu sendiri', 'Hanya bisa diakses class turunan', 'Tidak bisa diakses sama sekali'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Python mendukung multiple inheritance (satu class mewarisi lebih dari satu class).',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Method yang secara khusus dipanggil saat objek dihapus dari memori disebut ...',
                        'pilihan'    => ['Konstruktor', 'Destruktor', 'Setter', 'Getter'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Dalam Python, atribut class yang diawali __ (dua underscore) adalah ...',
                        'pilihan'    => ['Atribut publik', 'Atribut protected', 'Atribut private', 'Atribut static'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Apa perbedaan class method dan instance method?',
                        'pilihan'    => ['Tidak ada perbedaan', 'Class method menggunakan @classmethod dan menerima cls, instance method menerima self', 'Instance method lebih cepat', 'Class method tidak bisa mengakses atribut'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Abstraksi bertujuan menyederhanakan kompleksitas dengan menampilkan hanya fitur penting.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Composisi dalam OOP berarti ...',
                        'pilihan'    => ['Class mewarisi class lain', 'Sebuah class mengandung objek dari class lain sebagai atribut', 'Method memiliki banyak parameter', 'Membuat banyak objek dari satu class'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Getter dan setter digunakan dalam OOP untuk ...',
                        'pilihan'    => ['Mempercepat program', 'Mengakses dan mengubah atribut private secara terkontrol', 'Membuat class baru', 'Mewarisi class'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah yang BUKAN merupakan pilar OOP?',
                        'pilihan'    => ['Enkapsulasi', 'Inheritance', 'Rekursi', 'Polimorfisme'],
                        'benar' => 2,
                    ],
                ],
            ],
        ]);

        // ══════════════════════════════════════════
        //  MATA PELAJARAN 2: SISTEM KOMPUTER
        // ══════════════════════════════════════════
        $mapelSK = DB::table('mata_pelajaran')->insertGetId([
            'nama'       => 'Sistem Komputer',
            'deskripsi'  => 'Mata pelajaran yang mempelajari komponen hardware, software, sistem operasi, dan jaringan komputer.',
            'thumbnail'  => null,
            'Id_user'    => $guru->Id_user,
            'urutan'     => $urutanMapel + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->buatBab($guru->Id_user, $mapelSK, $kategoriIds, [

            // ── BAB 1 ──────────────────────────────
            [
                'judul'     => 'Bab 1 — Pengantar Sistem Komputer',
                'deskripsi' => 'Pengertian komputer, sejarah singkat, dan generasi komputer.',
                'urutan'    => 1,
                'konten'    => "Komputer adalah perangkat elektronik yang dapat menerima input, mengolah data, dan menghasilkan output.\n\n"
                    . "Generasi Komputer:\n"
                    . "• Gen 1 (1940-1956) : Tabung vakum, ENIAC\n"
                    . "• Gen 2 (1956-1963) : Transistor, lebih kecil dan hemat energi\n"
                    . "• Gen 3 (1964-1971) : IC (Integrated Circuit)\n"
                    . "• Gen 4 (1971-skrg) : Mikroprosesor, komputer pribadi\n"
                    . "• Gen 5 (skrg-masa depan): AI, komputasi kuantum\n\n"
                    . "Konsep Dasar Sistem Komputer:\n"
                    . "Input → Proses → Output → Storage\n\n"
                    . "Jenis Komputer:\n"
                    . "• Supercomputer\n"
                    . "• Mainframe\n"
                    . "• Minicomputer\n"
                    . "• PC (Personal Computer)\n"
                    . "• Mobile Device",
                'soal' => [
                    // 10 Latihan Harian
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Komputer generasi pertama menggunakan komponen ...',
                        'pilihan'    => ['Transistor', 'IC (Integrated Circuit)', 'Tabung vakum', 'Mikroprosesor'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Urutan pemrosesan data pada komputer yang benar adalah ...',
                        'pilihan'    => ['Output → Input → Proses', 'Input → Proses → Output', 'Proses → Input → Output', 'Storage → Input → Output'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Komputer generasi kedua menggunakan transistor sebagai pengganti tabung vakum.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'ENIAC adalah contoh komputer generasi ...',
                        'pilihan'    => ['Kedua', 'Ketiga', 'Pertama', 'Keempat'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Jenis komputer yang memiliki kemampuan komputasi paling tinggi adalah ...',
                        'pilihan'    => ['PC', 'Laptop', 'Mainframe', 'Supercomputer'],
                        'benar' => 3,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'IC (Integrated Circuit) digunakan pada komputer generasi ...',
                        'pilihan'    => ['Pertama', 'Kedua', 'Ketiga', 'Keempat'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Smartphone termasuk dalam kategori mobile device.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Komputer yang biasa digunakan untuk keperluan pribadi disebut ...',
                        'pilihan'    => ['Supercomputer', 'Mainframe', 'PC (Personal Computer)', 'Minicomputer'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Komputer generasi keempat ditandai dengan digunakannya ...',
                        'pilihan'    => ['Tabung vakum', 'IC', 'Transistor', 'Mikroprosesor'],
                        'benar' => 3,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Kecerdasan buatan (AI) diidentikkan dengan komputer generasi ...',
                        'pilihan'    => ['Ketiga', 'Keempat', 'Kelima', 'Keenam'],
                        'benar' => 2,
                    ],
                    // 10 UAS
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Kelemahan utama komputer generasi pertama adalah ...',
                        'pilihan'    => ['Terlalu kecil', 'Ukuran sangat besar, panas, dan boros listrik', 'Tidak bisa melakukan kalkulasi', 'Terlalu mahal'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah yang BUKAN termasuk komponen utama sistem komputer?',
                        'pilihan'    => ['Hardware', 'Software', 'Brainware', 'Firmware'],
                        'benar' => 3,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Brainware adalah komponen manusia yang mengoperasikan komputer.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah yang merupakan contoh output dari sebuah komputer?',
                        'pilihan'    => ['Data yang diketik', 'Foto yang di-scan', 'Dokumen yang dicetak printer', 'Input dari keyboard'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Fungsi storage pada sistem komputer adalah ...',
                        'pilihan'    => ['Memproses data', 'Menampilkan output', 'Menyimpan data secara permanen', 'Memasukkan data'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Perkembangan dari generasi ke generasi komputer umumnya menuju ke arah ...',
                        'pilihan'    => ['Ukuran lebih besar', 'Lebih hemat energi, lebih kecil, dan lebih cepat', 'Lebih mahal', 'Lebih sulit digunakan'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Mainframe biasa digunakan oleh perusahaan besar untuk memproses data dalam jumlah masif.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Komputasi kuantum adalah ciri khas komputer generasi ...',
                        'pilihan'    => ['Keempat', 'Ketiga', 'Kelima', 'Kedua'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Contoh perangkat input komputer adalah ...',
                        'pilihan'    => ['Monitor dan printer', 'Speaker dan proyektor', 'Keyboard dan mouse', 'Hard disk dan RAM'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Minicomputer berbeda dari PC karena ...',
                        'pilihan'    => ['Minicomputer lebih kecil dari PC', 'Minicomputer dapat melayani banyak pengguna sekaligus', 'PC lebih mahal', 'Minicomputer tidak bisa tersambung jaringan'],
                        'benar' => 1,
                    ],
                ],
            ],

            // ── BAB 2 ──────────────────────────────
            [
                'judul'     => 'Bab 2 — Perangkat Keras (Hardware)',
                'deskripsi' => 'Komponen-komponen hardware komputer dan fungsinya.',
                'urutan'    => 2,
                'konten'    => "Perangkat keras (hardware) adalah komponen fisik yang dapat dilihat dan disentuh.\n\n"
                    . "Komponen Utama Hardware:\n"
                    . "1. CPU (Central Processing Unit)\n"
                    . "   • ALU (Arithmetic Logic Unit) : melakukan operasi matematika dan logika\n"
                    . "   • CU (Control Unit) : mengatur dan mengendalikan operasi CPU\n"
                    . "   • Register : memori ultra-cepat di dalam CPU\n\n"
                    . "2. Memori\n"
                    . "   • RAM (Random Access Memory) : memori sementara, data hilang jika mati\n"
                    . "   • ROM (Read Only Memory) : memori permanen, berisi BIOS\n"
                    . "   • Cache Memory : memori sangat cepat antara CPU dan RAM\n\n"
                    . "3. Storage : HDD, SSD, Flash Drive\n\n"
                    . "4. Perangkat Input : keyboard, mouse, scanner, webcam\n\n"
                    . "5. Perangkat Output : monitor, printer, speaker",
                'soal' => [
                    // 10 Latihan Harian
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'CPU sering disebut sebagai otak komputer karena ...',
                        'pilihan'    => ['Menyimpan semua data', 'Memproses semua instruksi dan data', 'Menampilkan output', 'Menerima input'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'RAM bersifat volatile artinya ...',
                        'pilihan'    => ['Data tersimpan permanen', 'Data hilang ketika komputer dimatikan', 'Tidak bisa diakses CPU', 'Sangat lambat'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'ROM menyimpan BIOS yang berisi instruksi untuk booting komputer.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Bagian CPU yang melakukan operasi matematika dan logika adalah ...',
                        'pilihan'    => ['Control Unit', 'Register', 'ALU', 'Cache'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'SSD lebih unggul dari HDD karena ...',
                        'pilihan'    => ['Kapasitas lebih besar', 'Lebih murah', 'Lebih cepat dan tidak memiliki bagian bergerak', 'Lebih tahan panas'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Monitor termasuk perangkat ...',
                        'pilihan'    => ['Input', 'Proses', 'Output', 'Storage'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Cache memory lebih cepat dari RAM tetapi kapasitasnya lebih kecil.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Perangkat yang berfungsi mengubah dokumen fisik menjadi data digital adalah ...',
                        'pilihan'    => ['Printer', 'Proyektor', 'Scanner', 'Webcam'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Satuan kecepatan clock CPU adalah ...',
                        'pilihan'    => ['MHz/GHz', 'GB/TB', 'MB/s', 'Watt'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Motherboard berfungsi sebagai ...',
                        'pilihan'    => ['Sumber daya listrik komputer', 'Papan utama penghubung semua komponen hardware', 'Perangkat output utama', 'Media penyimpanan data'],
                        'benar' => 1,
                    ],
                    // 10 UAS
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Perbedaan antara RAM dan ROM adalah ...',
                        'pilihan'    => ['RAM lebih mahal', 'RAM bersifat sementara sedangkan ROM permanen', 'ROM lebih cepat', 'RAM tidak bisa diakses CPU'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Semakin besar kapasitas RAM, maka ...',
                        'pilihan'    => ['Komputer semakin lambat', 'Komputer bisa menjalankan lebih banyak program sekaligus', 'Storage semakin besar', 'CPU semakin cepat'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'GPU (Graphics Processing Unit) khusus dirancang untuk memproses grafis dan gambar.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'PSU (Power Supply Unit) berfungsi ...',
                        'pilihan'    => ['Menyimpan data', 'Mengubah arus AC menjadi DC untuk komponen komputer', 'Memproses data', 'Mendinginkan CPU'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah yang termasuk storage sekunder?',
                        'pilihan'    => ['RAM', 'Cache Memory', 'Register', 'Hard Disk Drive'],
                        'benar' => 3,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Koneksi interface yang umum digunakan SSD modern adalah ...',
                        'pilihan'    => ['IDE', 'SATA dan NVMe', 'SCSI', 'USB 2.0'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Heatsink dan kipas pendingin (cooler) digunakan untuk menjaga suhu CPU agar tidak overheat.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Touchscreen merupakan perangkat yang berfungsi sebagai ...',
                        'pilihan'    => ['Hanya input', 'Hanya output', 'Input dan output sekaligus', 'Storage'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Hirarki memori dari tercepat ke terlambat adalah ...',
                        'pilihan'    => ['HDD → RAM → Cache → Register', 'Register → Cache → RAM → HDD', 'RAM → Cache → Register → HDD', 'Cache → Register → RAM → HDD'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Kecepatan transfer data SSD NVMe dibandingkan HDD konvensional adalah ...',
                        'pilihan'    => ['Sama saja', 'SSD NVMe jauh lebih cepat hingga 5-10x lipat', 'HDD lebih cepat', 'Bergantung kapasitas'],
                        'benar' => 1,
                    ],
                ],
            ],

            // ── BAB 3 ──────────────────────────────
            [
                'judul'     => 'Bab 3 — Perangkat Lunak (Software)',
                'deskripsi' => 'Jenis-jenis perangkat lunak dan fungsinya dalam sistem komputer.',
                'urutan'    => 3,
                'konten'    => "Perangkat lunak (software) adalah program atau instruksi yang menjalankan hardware.\n\n"
                    . "Klasifikasi Software:\n"
                    . "1. Sistem Operasi (OS)\n"
                    . "   Contoh: Windows, macOS, Linux, Android, iOS\n\n"
                    . "2. Perangkat Lunak Aplikasi\n"
                    . "   • Aplikasi pengolah kata   : Microsoft Word, LibreOffice Writer\n"
                    . "   • Aplikasi spreadsheet      : Excel, Google Sheets\n"
                    . "   • Aplikasi presentasi       : PowerPoint, Canva\n"
                    . "   • Aplikasi browser          : Chrome, Firefox, Edge\n"
                    . "   • Aplikasi multimedia       : VLC, Audacity\n\n"
                    . "3. Perangkat Lunak Pengembang\n"
                    . "   • Compiler, Interpreter, IDE (VS Code, IntelliJ)\n\n"
                    . "4. Berdasarkan Lisensi:\n"
                    . "   • Freeware  : gratis digunakan\n"
                    . "   • Shareware : coba dulu, bayar untuk fitur penuh\n"
                    . "   • Open source: kode dapat dilihat dan dimodifikasi\n"
                    . "   • Proprietary: kode tertutup, berbayar",
                'soal' => [
                    // 10 Latihan Harian
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Software yang berfungsi sebagai perantara antara hardware dan aplikasi pengguna adalah ...',
                        'pilihan'    => ['Aplikasi Office', 'Sistem Operasi', 'Browser', 'Compiler'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Microsoft Word adalah contoh perangkat lunak ...',
                        'pilihan'    => ['Sistem operasi', 'Aplikasi pengolah kata', 'Compiler', 'Driver'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Linux adalah contoh sistem operasi open source.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Software yang kode sumbernya dapat dilihat, dimodifikasi, dan didistribusikan disebut ...',
                        'pilihan'    => ['Freeware', 'Shareware', 'Open source', 'Proprietary'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Driver adalah software yang berfungsi untuk ...',
                        'pilihan'    => ['Mengolah dokumen', 'Menghubungkan hardware dengan sistem operasi', 'Browsing internet', 'Memutar video'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Contoh sistem operasi untuk smartphone adalah ...',
                        'pilihan'    => ['Windows dan macOS', 'Android dan iOS', 'Linux dan Ubuntu', 'Chrome OS dan Windows'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Freeware adalah software gratis yang boleh digunakan tanpa batasan.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'IDE (Integrated Development Environment) adalah software yang digunakan untuk ...',
                        'pilihan'    => ['Memutar musik', 'Membuat dan mengembangkan program', 'Browsing internet', 'Mengedit foto'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Google Chrome termasuk jenis software ...',
                        'pilihan'    => ['Sistem operasi', 'Browser / peramban web', 'Compiler', 'Antivirus'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Shareware adalah software yang ...',
                        'pilihan'    => ['Selalu gratis selamanya', 'Bisa dicoba gratis namun perlu bayar untuk fitur lengkap atau setelah masa trial', 'Kode sumbernya terbuka', 'Tidak bisa dijalankan'],
                        'benar' => 1,
                    ],
                    // 10 UAS
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Perbedaan antara freeware dan open source adalah ...',
                        'pilihan'    => ['Tidak ada perbedaan', 'Freeware gratis digunakan tapi kode tertutup, open source kode dapat dimodifikasi', 'Open source selalu berbayar', 'Freeware kode terbuka'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah yang termasuk software antivirus?',
                        'pilihan'    => ['Google Chrome', 'Avast dan Kaspersky', 'Microsoft Excel', 'VLC Media Player'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Sistem operasi bertanggung jawab mengelola memori, CPU, dan perangkat I/O.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Software proprietary berarti ...',
                        'pilihan'    => ['Gratis dan kode terbuka', 'Kode tertutup dan dimiliki oleh perusahaan tertentu', 'Boleh dimodifikasi siapa saja', 'Tidak memerlukan lisensi'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Contoh software pengolah spreadsheet adalah ...',
                        'pilihan'    => ['Microsoft Word', 'Adobe Photoshop', 'Microsoft Excel', 'Mozilla Firefox'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'BIOS (Basic Input Output System) termasuk kategori software ...',
                        'pilihan'    => ['Aplikasi', 'Firmware', 'Open source', 'Freeware'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Virus komputer adalah jenis software berbahaya yang termasuk kategori malware.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah yang BUKAN merupakan contoh sistem operasi desktop?',
                        'pilihan'    => ['Windows 11', 'macOS Ventura', 'Ubuntu Linux', 'Android 14'],
                        'benar' => 3,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Fungsi utama kernel dalam sistem operasi adalah ...',
                        'pilihan'    => ['Menampilkan antarmuka grafis', 'Mengelola sumber daya hardware dan menghubungkan software dengan hardware', 'Menyimpan data pengguna', 'Membuka aplikasi'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah yang merupakan kelebihan software open source?',
                        'pilihan'    => ['Selalu lebih cepat dari proprietary', 'Komunitas dapat berkontribusi memperbaiki bug dan menambah fitur', 'Tidak pernah memiliki bug', 'Selalu memiliki dukungan resmi 24 jam'],
                        'benar' => 1,
                    ],
                ],
            ],

            // ── BAB 4 ──────────────────────────────
            [
                'judul'     => 'Bab 4 — Sistem Operasi',
                'deskripsi' => 'Fungsi, jenis, dan cara kerja sistem operasi komputer.',
                'urutan'    => 4,
                'konten'    => "Sistem Operasi (OS) adalah software yang mengelola semua sumber daya hardware dan menyediakan\n"
                    . "layanan bagi program aplikasi.\n\n"
                    . "Fungsi Sistem Operasi:\n"
                    . "1. Manajemen proses     : mengatur eksekusi program\n"
                    . "2. Manajemen memori     : mengalokasikan RAM untuk program\n"
                    . "3. Manajemen file       : mengorganisasi data di storage\n"
                    . "4. Manajemen perangkat  : mengelola I/O devices\n"
                    . "5. Keamanan            : autentikasi pengguna, proteksi data\n\n"
                    . "Jenis OS berdasarkan tampilan:\n"
                    . "• CLI (Command Line Interface) : berbasis teks, contoh: MS-DOS, Terminal Linux\n"
                    . "• GUI (Graphical User Interface): berbasis grafis, contoh: Windows, macOS\n\n"
                    . "Proses Booting:\n"
                    . "Power ON → POST → BIOS → Bootloader → Kernel → OS siap",
                'soal' => [
                    // 10 Latihan Harian
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Fungsi utama sistem operasi adalah ...',
                        'pilihan'    => ['Membuat dokumen', 'Mengelola sumber daya hardware dan menyediakan layanan bagi program', 'Browsing internet', 'Menyimpan foto'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'CLI berbeda dari GUI karena ...',
                        'pilihan'    => ['CLI menggunakan gambar dan ikon', 'CLI menggunakan perintah teks', 'GUI lebih lambat', 'CLI tidak membutuhkan keyboard'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Proses POST (Power-On Self Test) terjadi saat komputer pertama kali dinyalakan.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Multitasking pada sistem operasi berarti ...',
                        'pilihan'    => ['Satu komputer untuk banyak pengguna', 'Banyak program berjalan bersamaan', 'Komputer bekerja sangat cepat', 'Banyak CPU dalam satu komputer'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Kernel adalah ...',
                        'pilihan'    => ['Antarmuka grafis OS', 'Inti dari sistem operasi yang berinteraksi langsung dengan hardware', 'Program aplikasi', 'File sistem'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Sistem file yang umum digunakan di Windows adalah ...',
                        'pilihan'    => ['ext4', 'HFS+', 'NTFS', 'APFS'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Task Manager di Windows digunakan untuk memonitor dan mengelola proses yang berjalan.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Perintah dir pada Command Prompt Windows berfungsi untuk ...',
                        'pilihan'    => ['Menghapus file', 'Menampilkan daftar file dan folder', 'Membuat folder baru', 'Pindah direktori'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Urutan proses booting yang benar adalah ...',
                        'pilihan'    => ['BIOS → POST → Kernel → Bootloader', 'POST → BIOS → Bootloader → Kernel', 'Kernel → BIOS → POST → Bootloader', 'Bootloader → POST → BIOS → Kernel'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Virtual memory adalah teknik yang memungkinkan ...',
                        'pilihan'    => ['CPU bekerja lebih cepat', 'Sebagian storage digunakan sebagai tambahan RAM', 'Komputer terhubung ke internet', 'Banyak OS berjalan sekaligus'],
                        'benar' => 1,
                    ],
                    // 10 UAS
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Perbedaan single-user OS dan multi-user OS adalah ...',
                        'pilihan'    => ['Single-user lebih canggih', 'Multi-user memungkinkan banyak pengguna mengakses sistem sekaligus', 'Single-user lebih mahal', 'Multi-user lebih lambat'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Sistem operasi real-time (RTOS) digunakan pada ...',
                        'pilihan'    => ['Komputer gaming', 'Sistem yang memerlukan respons dalam waktu sangat ketat seperti kontrol mesin industri', 'Server web', 'Laptop biasa'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Deadlock terjadi ketika dua atau lebih proses saling menunggu sumber daya yang dipegang proses lain.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Format disk adalah proses ...',
                        'pilihan'    => ['Mengkompres data', 'Menyiapkan media penyimpanan dengan sistem file tertentu', 'Mengenkripsi data', 'Membackup data'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Manakah perintah Linux untuk melihat isi direktori?',
                        'pilihan'    => ['dir', 'ls', 'show', 'list'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Swap space pada Linux berfungsi sebagai ...',
                        'pilihan'    => ['Ruang kosong di hard disk', 'Virtual memory menggunakan storage saat RAM penuh', 'Tempat menyimpan OS', 'Partisi backup'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Windows menggunakan sistem file ext4 secara default.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Penjadwalan proses (process scheduling) pada OS bertujuan ...',
                        'pilihan'    => ['Menghapus proses yang lambat', 'Mengalokasikan waktu CPU secara efisien ke banyak proses', 'Menambah RAM', 'Memperbarui OS'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Hypervisor digunakan untuk ...',
                        'pilihan'    => ['Mempercepat koneksi internet', 'Menjalankan mesin virtual (virtual machine)', 'Mengenkripsi data', 'Mengelola printer'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Blue Screen of Death (BSOD) di Windows menandakan ...',
                        'pilihan'    => ['Update berhasil', 'Error kritis pada sistem yang memaksa OS berhenti', 'Komputer terlalu panas saja', 'Virus terdeteksi'],
                        'benar' => 1,
                    ],
                ],
            ],

            // ── BAB 5 ──────────────────────────────
            [
                'judul'     => 'Bab 5 — Jaringan Komputer Dasar',
                'deskripsi' => 'Konsep dasar jaringan komputer, topologi, dan protokol.',
                'urutan'    => 5,
                'konten'    => "Jaringan komputer adalah kumpulan perangkat yang saling terhubung untuk berbagi data dan sumber daya.\n\n"
                    . "Jenis Jaringan:\n"
                    . "• LAN (Local Area Network) : jaringan area kecil (sekolah, kantor)\n"
                    . "• WAN (Wide Area Network)  : jaringan area luas (antar kota/negara)\n"
                    . "• MAN (Metropolitan Area Network): jaringan kota\n"
                    . "• PAN (Personal Area Network): jaringan personal (Bluetooth)\n\n"
                    . "Topologi Jaringan:\n"
                    . "• Bus   : semua perangkat terhubung ke satu kabel utama\n"
                    . "• Star  : semua perangkat terhubung ke switch/hub pusat\n"
                    . "• Ring  : perangkat terhubung membentuk lingkaran\n"
                    . "• Mesh  : setiap perangkat terhubung ke semua perangkat lain\n\n"
                    . "Perangkat Jaringan:\n"
                    . "Router, Switch, Hub, Access Point, Modem",
                'soal' => [
                    // 10 Latihan Harian
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'LAN adalah jaringan yang mencakup area ...',
                        'pilihan'    => ['Satu negara', 'Satu kota', 'Area kecil seperti gedung atau sekolah', 'Seluruh dunia'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Topologi jaringan yang semua perangkat terhubung ke switch pusat adalah ...',
                        'pilihan'    => ['Bus', 'Ring', 'Star', 'Mesh'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Router berfungsi untuk menghubungkan dua atau lebih jaringan yang berbeda.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Protokol yang digunakan untuk mengakses halaman web adalah ...',
                        'pilihan'    => ['FTP', 'SMTP', 'HTTP/HTTPS', 'POP3'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'IP Address digunakan untuk ...',
                        'pilihan'    => ['Mengidentifikasi secara unik setiap perangkat dalam jaringan', 'Kecepatan koneksi internet', 'Nama domain website', 'Ukuran bandwidth'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Topologi Bus memiliki kelemahan yaitu ...',
                        'pilihan'    => ['Terlalu banyak kabel', 'Jika kabel utama putus, seluruh jaringan terganggu', 'Tidak bisa terhubung internet', 'Tidak mendukung wireless'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Switch bekerja pada layer Data Link dan dapat membaca MAC Address.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'DNS (Domain Name System) berfungsi untuk ...',
                        'pilihan'    => ['Menyimpan halaman web', 'Mengubah nama domain menjadi IP address', 'Mengenkripsi data', 'Mengelola email'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Bluetooth adalah contoh jaringan ...',
                        'pilihan'    => ['LAN', 'WAN', 'PAN', 'MAN'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Satuan kecepatan jaringan adalah ...',
                        'pilihan'    => ['MHz', 'GB', 'Mbps/Gbps', 'Watt'],
                        'benar' => 2,
                    ],
                    // 10 UAS
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Model OSI memiliki berapa layer?',
                        'pilihan'    => ['4', '5', '7', '8'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'IPv4 menggunakan berapa bit untuk alamat IP?',
                        'pilihan'    => ['8 bit', '16 bit', '32 bit', '64 bit'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Topologi Mesh memberikan keandalan tinggi karena ada banyak jalur alternatif.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Protokol TCP/IP bekerja pada layer ...',
                        'pilihan'    => ['Application layer saja', 'Transport dan Network layer', 'Physical layer', 'Data Link layer saja'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Perbedaan Hub dan Switch adalah ...',
                        'pilihan'    => ['Hub lebih cepat', 'Switch lebih cerdas: mengirim data hanya ke perangkat tujuan, bukan broadcast ke semua', 'Hub lebih mahal', 'Switch tidak mendukung jaringan besar'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'DHCP Server berfungsi untuk ...',
                        'pilihan'    => ['Menyimpan halaman web', 'Memberikan IP address secara otomatis kepada perangkat di jaringan', 'Memblokir virus', 'Mengenkripsi komunikasi'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'WAN (Wide Area Network) dapat mencakup jaringan antar benua seperti internet.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Firewall dalam jaringan berfungsi untuk ...',
                        'pilihan'    => ['Mempercepat internet', 'Memfilter lalu lintas jaringan berdasarkan aturan keamanan', 'Menyimpan data', 'Mengelola DNS'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Protokol HTTPS berbeda dari HTTP karena ...',
                        'pilihan'    => ['Lebih lambat', 'Menggunakan enkripsi SSL/TLS sehingga data lebih aman', 'Hanya untuk gambar', 'Tidak memerlukan DNS'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Ping adalah perintah yang digunakan untuk ...',
                        'pilihan'    => ['Mengunduh file', 'Menguji konektivitas antara dua perangkat di jaringan', 'Mengelola DNS', 'Memblokir IP'],
                        'benar' => 1,
                    ],
                ],
            ],

            // ── BAB 6 ──────────────────────────────
            [
                'judul'     => 'Bab 6 — Keamanan Komputer',
                'deskripsi' => 'Ancaman keamanan digital dan cara melindungi sistem komputer.',
                'urutan'    => 6,
                'konten'    => "Keamanan komputer adalah praktik melindungi sistem, jaringan, dan data dari ancaman digital.\n\n"
                    . "Jenis Ancaman:\n"
                    . "• Virus       : program yang mereplikasi diri dan merusak data\n"
                    . "• Worm        : menyebar sendiri melalui jaringan\n"
                    . "• Trojan      : program berbahaya yang menyamar sebagai software sah\n"
                    . "• Ransomware  : mengenkripsi data dan meminta tebusan\n"
                    . "• Phishing    : penipuan untuk mencuri informasi pribadi\n"
                    . "• Spyware     : mengintai aktivitas pengguna\n\n"
                    . "Cara Perlindungan:\n"
                    . "• Menggunakan antivirus yang up-to-date\n"
                    . "• Update sistem operasi secara rutin\n"
                    . "• Password yang kuat dan unik\n"
                    . "• Autentikasi dua faktor (2FA)\n"
                    . "• Backup data secara berkala\n"
                    . "• Tidak mengklik link mencurigakan",
                'soal' => [
                    // 10 Latihan Harian
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Malware yang mengenkripsi data korban dan meminta uang tebusan disebut ...',
                        'pilihan'    => ['Spyware', 'Adware', 'Ransomware', 'Worm'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Phishing adalah serangan yang bertujuan untuk ...',
                        'pilihan'    => ['Merusak hardware', 'Mencuri informasi pribadi dengan cara menipu', 'Memperlambat internet', 'Menghapus file sistem'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Password yang kuat sebaiknya menggunakan kombinasi huruf, angka, dan simbol.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Trojan horse dalam konteks keamanan komputer adalah ...',
                        'pilihan'    => ['Program yang menyebar melalui email', 'Program berbahaya yang menyamar sebagai software yang berguna', 'Program yang mempercepat komputer', 'Antivirus berbayar'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => '2FA (Two-Factor Authentication) meningkatkan keamanan karena ...',
                        'pilihan'    => ['Password menjadi lebih pendek', 'Memerlukan dua jenis verifikasi untuk login', 'Login lebih cepat', 'Menghapus password'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Worm berbeda dari virus karena ...',
                        'pilihan'    => ['Worm lebih kecil ukurannya', 'Worm dapat menyebar sendiri tanpa menginfeksi file lain', 'Worm tidak berbahaya', 'Virus lebih cepat menyebar'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Backup data penting untuk dilakukan secara berkala sebagai langkah pencegahan kehilangan data.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Enkripsi data bertujuan untuk ...',
                        'pilihan'    => ['Mempercepat transfer data', 'Mengubah data menjadi format yang tidak bisa dibaca tanpa kunci', 'Menghapus data', 'Memperkecil ukuran data'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Software antivirus bekerja dengan cara ...',
                        'pilihan'    => ['Menghapus semua file asing', 'Mendeteksi dan menghapus/mengkarantina malware berdasarkan definisi virus', 'Mengenkripsi semua file', 'Memblokir semua koneksi internet'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Social engineering dalam keamanan komputer adalah ...',
                        'pilihan'    => ['Serangan teknis pada jaringan', 'Manipulasi psikologis untuk mendapatkan informasi rahasia', 'Program berbahaya', 'Teknik enkripsi'],
                        'benar' => 1,
                    ],
                    // 10 UAS
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'DDoS (Distributed Denial of Service) attack bertujuan untuk ...',
                        'pilihan'    => ['Mencuri data pengguna', 'Membanjiri server dengan traffic sehingga tidak bisa melayani pengguna sah', 'Mengenkripsi data korban', 'Mengintai aktivitas pengguna'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Tanda-tanda komputer terinfeksi malware antara lain ...',
                        'pilihan'    => ['Komputer menjadi lebih cepat', 'Performa menurun drastis, muncul pop-up, file hilang', 'Baterai lebih awet', 'Koneksi internet lebih stabil'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'HTTPS menjamin keamanan website dari semua jenis serangan siber.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'VPN (Virtual Private Network) digunakan untuk ...',
                        'pilihan'    => ['Mempercepat internet', 'Mengenkripsi koneksi dan menyembunyikan IP address', 'Memblokir virus', 'Menyimpan data di cloud'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Aturan password yang baik menurut standar keamanan adalah ...',
                        'pilihan'    => ['Gunakan tanggal lahir agar mudah diingat', 'Minimal 8 karakter, kombinasi huruf besar/kecil, angka, simbol', 'Gunakan nama sendiri', 'Password sama untuk semua akun'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Spyware berbahaya karena ...',
                        'pilihan'    => ['Memperlambat download', 'Secara diam-diam memantau dan mengirim aktivitas pengguna ke pihak ketiga', 'Menggunakan terlalu banyak RAM', 'Membuat tampilan berubah'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Zero-day vulnerability adalah celah keamanan yang belum diketahui atau diperbaiki oleh pembuat software.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Langkah pertama yang harus dilakukan jika komputer terinfeksi ransomware adalah ...',
                        'pilihan'    => ['Segera membayar tebusan', 'Mengisolasi perangkat dari jaringan dan menghubungi ahli IT', 'Menghapus semua file', 'Mematikan antivirus'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Digital forensics adalah ...',
                        'pilihan'    => ['Antivirus terbaru', 'Ilmu yang mempelajari pemulihan dan investigasi bukti digital dari kejahatan siber', 'Teknik enkripsi', 'Jenis firewall'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Mengapa update sistem operasi secara rutin penting untuk keamanan?',
                        'pilihan'    => ['Membuat tampilan lebih indah', 'Menambal celah keamanan (patch) yang ditemukan', 'Meningkatkan kecepatan CPU', 'Menambah kapasitas storage'],
                        'benar' => 1,
                    ],
                ],
            ],

            // ── BAB 7 ──────────────────────────────
            [
                'judul'     => 'Bab 7 — Pemeliharaan Komputer',
                'deskripsi' => 'Cara merawat dan memelihara komputer agar tetap optimal.',
                'urutan'    => 7,
                'konten'    => "Pemeliharaan komputer adalah serangkaian tindakan untuk menjaga komputer bekerja optimal.\n\n"
                    . "Pemeliharaan Hardware:\n"
                    . "• Membersihkan debu dari komponen (CPU, kipas, keyboard)\n"
                    . "• Memastikan sirkulasi udara baik untuk mencegah overheat\n"
                    . "• Memeriksa kondisi kabel dan koneksi\n"
                    . "• Menggunakan UPS (Uninterruptible Power Supply) untuk proteksi listrik\n\n"
                    . "Pemeliharaan Software:\n"
                    . "• Update OS dan aplikasi secara berkala\n"
                    . "• Scan virus secara rutin\n"
                    . "• Defragmentasi hard disk (HDD)\n"
                    . "• Membersihkan file sementara (temporary files)\n"
                    . "• Disk Cleanup dan Disk Check\n"
                    . "• Uninstall software yang tidak digunakan\n\n"
                    . "Manajemen Penyimpanan:\n"
                    . "• Backup data ke cloud atau media eksternal\n"
                    . "• Menjaga kapasitas disk tidak penuh (minimal 15-20% kosong)",
                'soal' => [
                    // 10 Latihan Harian
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Defragmentasi hard disk bertujuan untuk ...',
                        'pilihan'    => ['Menghapus virus', 'Menyusun ulang fragmen data agar akses lebih cepat', 'Menambah kapasitas disk', 'Mengenkripsi data'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'UPS (Uninterruptible Power Supply) digunakan untuk ...',
                        'pilihan'    => ['Mempercepat CPU', 'Melindungi komputer dari mati listrik mendadak', 'Menyimpan data', 'Mendinginkan komputer'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Defragmentasi tidak disarankan untuk SSD karena dapat memperpendek umur SSD.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Cara yang benar untuk membersihkan debu dari dalam casing komputer adalah ...',
                        'pilihan'    => ['Menggunakan kain basah', 'Menggunakan penyedot debu biasa', 'Menggunakan blower/kompresor udara khusus elektronik', 'Dicuci dengan air'],
                        'benar' => 2,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Temporary files pada komputer sebaiknya dihapus karena ...',
                        'pilihan'    => ['Berbahaya seperti virus', 'Menumpuk dan memenuhi ruang penyimpanan', 'Memperlambat CPU', 'Merusak RAM'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Indikasi hard disk akan mengalami kerusakan (failing) antara lain ...',
                        'pilihan'    => ['Komputer lebih cepat', 'Muncul bunyi klik aneh, bad sector, atau waktu baca/tulis sangat lambat', 'RAM bertambah', 'Internet lebih cepat'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'benar_salah',
                        'poin' => 5,
                        'pertanyaan' => 'Thermal paste pada CPU perlu diganti secara berkala (setiap 2-3 tahun) untuk menjaga efisiensi pendinginan.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Startup program yang tidak diperlukan sebaiknya ...',
                        'pilihan'    => ['Dibiarkan saja', 'Dinonaktifkan untuk mempercepat booting', 'Dihapus sepenuhnya dari sistem', 'Dijadikan prioritas'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Perintah chkdsk pada Windows digunakan untuk ...',
                        'pilihan'    => ['Defragmentasi disk', 'Memeriksa dan memperbaiki error pada sistem file', 'Memformat disk', 'Mengenkripsi disk'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'Latihan Harian',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 10,
                        'pertanyaan' => 'Mengapa hard disk tidak boleh terisi penuh?',
                        'pilihan'    => ['Agar tidak overheat', 'OS memerlukan ruang kosong untuk virtual memory dan operasi sistem', 'Agar tidak terkena virus', 'Supaya tampilan lebih bagus'],
                        'benar' => 1,
                    ],
                    // 10 UAS
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Strategi backup yang baik menggunakan aturan 3-2-1, yaitu ...',
                        'pilihan'    => ['3 backup, 2 lokasi, 1 offsite', '3 file, 2 folder, 1 drive', '3 format, 2 enkripsi, 1 kompresi', '3 kali sehari, 2 media, 1 cloud'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Overheating pada CPU dapat disebabkan oleh ...',
                        'pilihan'    => ['RAM terlalu besar', 'Thermal paste kering, kipas tidak berputar, atau ventilasi buruk', 'Storage terlalu penuh', 'Koneksi internet buruk'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'SSD tidak memerlukan defragmentasi karena cara kerjanya berbeda dari HDD.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Incremental backup berbeda dari full backup karena ...',
                        'pilihan'    => ['Incremental lebih lambat', 'Incremental hanya membackup data yang berubah sejak backup terakhir', 'Full backup lebih kecil', 'Keduanya sama saja'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Alat ukur yang digunakan teknisi untuk mengukur tegangan listrik pada komponen komputer adalah ...',
                        'pilihan'    => ['Termometer', 'Multimeter', 'Tachometer', 'Barometer'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Troubleshooting komputer adalah proses ...',
                        'pilihan'    => ['Memasang komponen baru', 'Mengidentifikasi, menganalisis, dan menyelesaikan masalah pada komputer', 'Membersihkan komputer', 'Update software'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'benar_salah',
                        'poin' => 10,
                        'pertanyaan' => 'Kondensasi (embun) pada komponen elektronik dapat menyebabkan kerusakan serius.',
                        'pilihan'    => ['Benar', 'Salah'],
                        'benar' => 0,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'SMART (Self-Monitoring, Analysis and Reporting Technology) pada hard disk digunakan untuk ...',
                        'pilihan'    => ['Mempercepat akses data', 'Memonitor kesehatan dan memprediksi kegagalan hard disk', 'Mengenkripsi data', 'Mengelola partisi'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Pencegahan ESD (Electrostatic Discharge) saat memperbaiki komputer dilakukan dengan ...',
                        'pilihan'    => ['Memakai sarung tangan karet', 'Memakai gelang antistatis dan bekerja di permukaan yang tidak konduktif', 'Mematikan lampu', 'Membuka casing saat komputer menyala'],
                        'benar' => 1,
                    ],
                    [
                        'kategori' => 'UAS',
                        'tipe' => 'pilihan_ganda',
                        'poin' => 20,
                        'pertanyaan' => 'Jika komputer sering restart sendiri, kemungkinan penyebabnya adalah ...',
                        'pilihan'    => ['Hard disk terlalu kosong', 'Overheat, RAM rusak, atau power supply bermasalah', 'Software terlalu banyak', 'Internet terlalu cepat'],
                        'benar' => 1,
                    ],
                ],
            ],

        ]);

        // ══════════════════════════════════════════
        //  INFO AKHIR
        // ══════════════════════════════════════════
        $this->command->info('');
        $this->command->info('✅ PerangkatLunakSeeder selesai!');
        $this->command->info('');
        $this->command->info('  📚 Mata Pelajaran Baru:');
        $this->command->info('     • Pemrograman Dasar   (8 bab)');
        $this->command->info('     • Sistem Komputer     (7 bab)');
        $this->command->info('');
        $this->command->info('  ❓ Soal per bab: 10 Latihan Harian + 10 UAS (Tugas Akhir)');
        $this->command->info('  📊 Total soal baru: ' . ((8 + 7) * 20) . ' soal');
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
