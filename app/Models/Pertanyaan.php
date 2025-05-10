<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';

    protected $fillable = ['isi_pertanyaan', 'kategori_id', 'aktif'];

    public $timestamps = true;

    /**
     * Relasi ke kategori pertanyaan
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriPertanyaan::class, 'kategori_id');
    }
}
