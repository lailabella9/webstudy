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
        Schema::table('kelas', function (Blueprint $table) {
             $table->unsignedBigInteger('wali_kelas_id')->nullable()->after('nama');
        $table->foreign('wali_kelas_id')->references('Id_user')->on('users');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
              $table->dropForeign(['wali_kelas_id']);
        $table->dropColumn('wali_kelas_id');
            //
        });
    }
};
