<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Kelas extends Model
{
    use HasFactory;

    protected $table      = 'kelas';
    protected $primaryKey = 'Id_kelas';

    protected $fillable = ['nama', 'wali_kelas_id'];

    public function siswa()
    {
        return $this->hasMany(User::class, 'kelas_id', 'Id_kelas');
    }

    public function mataPelajarans()
    {
        return $this->hasMany(MataPelajaran::class, 'kelas_id', 'Id_kelas');
    }

    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id', 'Id_user');
    }
}