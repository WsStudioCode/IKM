<?php

namespace App\Models;

use App\Enums\PendidikanEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masyarakat extends Model
{
    use HasFactory;

    protected $table = 'masyarakat';

    protected $fillable = [
        'nama',
        'umur',
        'jenis_kelamin',
        'pendidikan',
        'pekerjaan',
        'agama',
        'alamat',
        'no_telp',
    ];

    protected $casts = [
        'tanggal_mengisi' => 'datetime',
        'pendidikan' => PendidikanEnum::class,
    ];

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }
}
