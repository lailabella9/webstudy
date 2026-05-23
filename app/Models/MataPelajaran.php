<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MataPelajaran extends Model
{
    protected $table      = 'mata_pelajaran';
    protected $primaryKey = 'Id_mapel';
    protected $fillable   = ['nama', 'deskripsi', 'thumbnail', 'Id_user', 'kelas_id', 'urutan'];
    public function guru()
    {
        return $this->belongsTo(User::class, 'Id_user', 'Id_user');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'Id_kelas');
    }
    public function materis()
    {
        return $this->hasMany(Materi::class, 'mapel_id', 'Id_mapel')->orderBy('urutan');
    }
    public function totalSoal(): int
    {
        return Soal::whereHas('materi', fn($q) => $q->where('mapel_id', $this->Id_mapel))->count();
    }
}
