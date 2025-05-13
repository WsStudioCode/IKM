<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $fillable = [
        'masyarakat_id',
        'isi',
        'status',
        'gambar'
    ];


    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class);
    }

    public function tindakLanjut()
    {
        return $this->hasOne(TindakLanjut::class);
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class);
    }

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
