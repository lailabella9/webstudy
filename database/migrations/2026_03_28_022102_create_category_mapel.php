<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Level 1: Mata Pelajaran
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id('Id_mapel');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('thumbnail')->nullable();
            $table->unsignedBigInteger('Id_user');
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('Id_user')->references('Id_user')->on('users')->onDelete('cascade');
        });

        // Tambah mapel_id ke materi (materi sekarang = Bab/Pembahasan)
        Schema::table('materi', function (Blueprint $table) {
            $table->unsignedBigInteger('mapel_id')->nullable()->after('Id_materi');
            $table->foreign('mapel_id')->references('Id_mapel')->on('mata_pelajaran')->onDelete('cascade');
        });

        // Kategori latihan: Harian, UTS, UAS (bisa ditambah guru)
        Schema::create('kategori_latihan', function (Blueprint $table) {
            $table->id('Id_kategori');
            $table->string('nama');           // "Soal Harian", "UTS", "UAS"
            $table->string('warna', 20)->default('#1a56db');
            $table->string('ikon', 50)->default('bi-pencil');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // Tambah kategori_id ke soal
        Schema::table('soal', function (Blueprint $table) {
            $table->unsignedBigInteger('kategori_id')->nullable()->after('materi_id');
            $table->foreign('kategori_id')->references('Id_kategori')->on('kategori_latihan')->onDelete('set null');
        });

        // Tabel akses: guru buka/tutup soal per kategori per materi untuk siswa
        Schema::create('akses_latihan', function (Blueprint $table) {
            $table->id('Id_akses');
            $table->unsignedBigInteger('materi_id');
            $table->unsignedBigInteger('kategori_id');
            $table->boolean('is_buka')->default(false);
            $table->timestamp('dibuka_at')->nullable();
            $table->timestamp('ditutup_at')->nullable();
            $table->timestamps();

            $table->foreign('materi_id')->references('Id_materi')->on('materi')->onDelete('cascade');
            $table->foreign('kategori_id')->references('Id_kategori')->on('kategori_latihan')->onDelete('cascade');

            // Satu materi + satu kategori = satu record akses
            $table->unique(['materi_id', 'kategori_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akses_latihan');
        Schema::table('soal', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
        Schema::dropIfExists('kategori_latihan');
        Schema::table('materi', function (Blueprint $table) {
            $table->dropForeign(['mapel_id']);
            $table->dropColumn('mapel_id');
        });
        Schema::dropIfExists('mata_pelajaran');
    }
};
