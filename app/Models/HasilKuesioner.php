<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKuesioner extends Model
{

    use HasFactory;

    protected $table = 'hasil_kuesioner';

    protected $fillable = [
        'masyarakat_id',
        'nilai_rata_rata',
        'kategori_hasil',
        'tanggal_isi',
    ];

    protected $casts = [
        'tanggal_isi' => 'datetime',
    ];

    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class);
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanKuesioner::class);
    }
}
