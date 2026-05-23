<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat tabel kelas
        Schema::create('kelas', function (Blueprint $table) {
            $table->bigIncrements('Id_kelas');
            $table->string('nama', 100)
                ->comment('contoh: 10 RPL, 11 RPL, 12 TKJ');
            $table->timestamps();
        });

        // 2. Isi data awal kelas
        DB::table('kelas')->insert([
            [
                'nama' => '10 RPL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => '11 RPL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => '12 RPL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => '10 TKJ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => '11 TKJ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => '12 TKJ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 3. Tambah kelas_id ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('kelas_id')
                ->nullable()
                ->after('role');

            $table->foreign('kelas_id')
                ->references('Id_kelas')
                ->on('kelas')
                ->nullOnDelete();
        });

        // 4. Tambah kelas_id ke tabel mata_pelajaran
        Schema::table('mata_pelajaran', function (Blueprint $table) {
            $table->unsignedBigInteger('kelas_id')
                ->nullable()
                ->after('Id_user');

            $table->foreign('kelas_id')
                ->references('Id_kelas')
                ->on('kelas')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus foreign key users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });

        // Hapus foreign key mata_pelajaran
        Schema::table('mata_pelajaran', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });

        // Hapus tabel kelas
        Schema::dropIfExists('kelas');
    }
};
