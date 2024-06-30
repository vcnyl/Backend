<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tanggal',
        'pelanggan',
        'progress',
        'waktu',
        'catatan',
        'tugas',
        'karyawan1',
        'karyawan2',
        'karyawan3',
        'karyawan4',
        'karyawan5',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan', 'id');
    }

    public function karyawan1()
    {
        return $this->belongsTo(User::class, 'karyawan1', 'id');
    }

    public function karyawan2()
    {
        return $this->belongsTo(User::class, 'karyawan2', 'id');
    }

    public function karyawan3()
    {
        return $this->belongsTo(User::class, 'karyawan3', 'id');
    }

    public function karyawan4()
    {
        return $this->belongsTo(User::class, 'karyawan4', 'id');
    }

    public function karyawan5()
    {
        return $this->belongsTo(User::class, 'karyawan5', 'id');
    }
}
