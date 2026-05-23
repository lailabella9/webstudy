<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiLatihan extends Model
{
    protected $table      = 'sesi_latihan';
    protected $primaryKey = 'Id_sesi';

    protected $fillable = [
        'Id_user',
        'Id_materi',
        'kategori_id',
        'total_poin',
        'poin_diraih',
        'persentase',
        'durasi',
        'selesai_at',
    ];

    protected $casts = ['selesai_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class, 'Id_user', 'Id_user');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'Id_materi', 'Id_materi');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriLatihan::class, 'kategori_id', 'Id_kategori');
    }
}
