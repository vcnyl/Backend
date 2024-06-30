<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
        'no_telp',
        'alamat',
        'maps',
        'foto_rumah',
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'pelanggan', 'id');
    }
}
