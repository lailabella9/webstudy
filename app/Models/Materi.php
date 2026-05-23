<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $table      = 'materi';
    protected $primaryKey = 'Id_materi';

    protected $fillable = ['mapel_id', 'judul', 'deskripsi', 'konten', 'urutan', 'Id_user', 'file_materi'];

    // Mata pelajaran induk
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id', 'Id_mapel');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'Id_user', 'Id_user');
    }

    public function soals()
    {
        return $this->hasMany(Soal::class, 'materi_id', 'Id_materi');
    }

    // Soal per kategori
    public function soalsByKategori(int $kategoriId)
    {
        return $this->soals()->where('kategori_id', $kategoriId);
    }

    // Akses latihan (buka/tutup per kategori)
    public function aksesLatihans()
    {
        return $this->hasMany(AksesLatihan::class, 'materi_id', 'Id_materi');
    }

    // public function sesiLatihans()
    // {
    //     return $this->hasMany(SesiLatihan::class, 'Id_materi', 'Id_materi');
    // }

    public function hasFile(): bool
    {
        return !empty($this->file_materi);
    }

    // Cek apakah kategori tertentu dibuka untuk siswa
    public function isKategoriDibuka(int $kategoriId): bool
    {
        $akses = $this->aksesLatihans()
            ->where('kategori_id', $kategoriId)
            ->first();

        return $akses ? $akses->isAktif() : false;
    }
}
