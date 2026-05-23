<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriLatihan extends Model
{
    protected $table      = 'kategori_latihan';
    protected $primaryKey = 'Id_kategori';

    protected $fillable = ['nama', 'warna', 'ikon', 'urutan'];

    public function soals()
    {
        return $this->hasMany(Soal::class, 'kategori_id', 'Id_kategori');
    }

    public function aksesLatihans()
    {
        return $this->hasMany(AksesLatihan::class, 'kategori_id', 'Id_kategori');
    }
}
