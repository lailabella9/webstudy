<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table      = 'soal';
    protected $primaryKey = 'Id_soal';

    protected $fillable = ['materi_id', 'kategori_id', 'pertanyaan', 'tipe_soal', 'poin'];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id', 'Id_materi');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriLatihan::class, 'kategori_id', 'Id_kategori');
    }

    public function pilihanJawabans()
    {
        return $this->hasMany(PilihanJawaban::class, 'id_soal', 'Id_soal');
    }

    public function hasilLatihans()
    {
        return $this->hasMany(HasilLatihan::class, 'Id_soal', 'Id_soal');
    }

    public function jawabanBenar()
    {
        return $this->pilihanJawabans()->where('is_benar', true)->first();
    }
}
