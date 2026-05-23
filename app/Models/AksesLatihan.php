<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AksesLatihan extends Model
{
    protected $table      = 'akses_latihan';
    protected $primaryKey = 'Id_akses';

    protected $fillable = ['materi_id', 'kategori_id', 'is_buka', 'dibuka_at', 'ditutup_at'];

    protected $casts = [
        'is_buka'    => 'boolean',
        'dibuka_at'  => 'datetime',
        'ditutup_at' => 'datetime',
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id', 'Id_materi');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriLatihan::class, 'kategori_id', 'Id_kategori');
    }

    // Cek apakah akses sedang aktif
    public function isAktif(): bool
    {
        if (!$this->is_buka) return false;
        $now = now();
        if ($this->dibuka_at && $now->lt($this->dibuka_at)) return false;
        if ($this->ditutup_at && $now->gt($this->ditutup_at)) return false;
        return true;
    }
}
