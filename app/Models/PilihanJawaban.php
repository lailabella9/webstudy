<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilihanJawaban extends Model
{
    protected $table = 'pilihan_jawaban';
    protected $primaryKey = 'Id_pilihan';
    public $timestamps = false;

    protected $fillable = ['id_soal', 'teks_pilihan', 'is_benar'];

    protected $casts = ['is_benar' => 'boolean'];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_soal', 'Id_soal');
    }
}
