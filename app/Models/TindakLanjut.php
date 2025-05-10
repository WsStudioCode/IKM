<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    use HasFactory;

    protected $table = 'tindak_lanjut';

    protected $fillable = [
        'pengaduan_id',
        'tanggapan',
        'tanggal_tindak_lanjut',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class);
    }

    protected $casts = [
        'tanggal_tindak_lanjut' => 'datetime',
    ];
}
