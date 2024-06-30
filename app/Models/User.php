<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
        'level',
        'username',
        'password',
        'no_telp',
        'email',
        'nik',
        'foto',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function jadwal1()
    {
        return $this->hasMany(Jadwal::class, 'karyawan1', 'id');
    }

    public function jadwal2()
    {
        return $this->hasMany(Jadwal::class, 'karyawan2', 'id');
    }

    public function jadwal3()
    {
        return $this->hasMany(Jadwal::class, 'karyawan3', 'id');
    }

    public function jadwal4()
    {
        return $this->hasMany(Jadwal::class, 'karyawan4', 'id');
    }

    public function jadwal5()
    {
        return $this->hasMany(Jadwal::class, 'karyawan5', 'id');
    }

}
