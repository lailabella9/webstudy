<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilLatihan extends Model
{
    protected $table = 'hasil_latihan';
    protected $primaryKey = 'Id_hasil';
    public $timestamps = false;

    protected $fillable = [
        'Id_user',
        'Id_soal',
        'jawaban_siswa',
        'is_benar',
        'waktu',
        'nilai',
    ];

    protected $casts = [
        'is_benar'   => 'boolean',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Id_user', 'Id_user');
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'Id_soal', 'Id_soal');
    }
}
