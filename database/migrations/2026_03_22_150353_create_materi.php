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
        Schema::create('materi', function (Blueprint $table) {
            $table->id('Id_materi');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->longText('konten');
            $table->integer('urutan')->default(0);
            $table->string('file_materi')->nullable();
            $table->unsignedBigInteger('Id_user');
            $table->timestamps();

            $table->foreign('Id_user')->references('Id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};
