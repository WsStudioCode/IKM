<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanKuesioner extends Model
{
    protected $table = 'jawaban_kuesioner';

    protected $fillable = [
        'masyarakat_id',
        'pertanyaan_id',
        'jawaban',
        'hasil_kuesioner_id'
    ];

    public $timestamps = false; // karena kita tidak pakai `created_at` dan `updated_at`

    // (Opsional) Relasi ke model Masyarakat dan Pertanyaan
    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class);
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }

    public function hasilKuesioner()
    {
        return $this->belongsTo(HasilKuesioner::class);
    }

}
