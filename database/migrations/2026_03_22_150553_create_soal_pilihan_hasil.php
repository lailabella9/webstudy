<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel soal
        Schema::create('soal', function (Blueprint $table) {
            $table->id('Id_soal');
            $table->unsignedBigInteger('materi_id');
            $table->text('pertanyaan');
            $table->enum('tipe_soal', ['pilihan_ganda', 'benar_salah'])->default('pilihan_ganda');
            $table->integer('poin')->default(10);
            $table->timestamps();

            $table->foreign('materi_id')->references('Id_materi')->on('materi')->onDelete('cascade');
        });

        // Tabel pilihan jawaban
        Schema::create('pilihan_jawaban', function (Blueprint $table) {
            $table->id('Id_pilihan');
            $table->unsignedBigInteger('id_soal');
            $table->text('teks_pilihan');
            $table->boolean('is_benar')->default(false);

            $table->foreign('id_soal')->references('Id_soal')->on('soal')->onDelete('cascade');
        });

        // Tabel hasil latihan
        Schema::create('hasil_latihan', function (Blueprint $table) {
            $table->id('Id_hasil');
            $table->unsignedBigInteger('Id_user');
            $table->unsignedBigInteger('Id_soal');
            $table->text('jawaban_siswa')->nullable();
            $table->boolean('is_benar')->default(false);
            $table->integer('waktu')->nullable()->comment('detik pengerjaan');
            $table->integer('nilai')->default(0);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('Id_user')->references('Id_user')->on('users')->onDelete('cascade');
            $table->foreign('Id_soal')->references('Id_soal')->on('soal')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_latihan');
        Schema::dropIfExists('pilihan_jawaban');
        Schema::dropIfExists('soal');
    }
};
