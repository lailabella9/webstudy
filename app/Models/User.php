<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'Id_user';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'kelas_id',
        'foto_profil',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'Id_kelas');
    }

    // Relasi: guru membuat banyak materi
    public function materis()
    {
        return $this->hasMany(Materi::class, 'Id_user', 'Id_user');
    }

    // Relasi: siswa memiliki banyak hasil latihan
    public function hasilLatihans()
    {
        return $this->hasMany(HasilLatihan::class, 'Id_user', 'Id_user');
    }

    // public function sesiLatihans()
    // {
    //     return $this->hasMany(SesiLatihan::class, 'Id_user', 'Id_user');
    // }

    // Helper role
    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }
}
