<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPertanyaan extends Model
{
    use HasFactory;

    protected $table = 'kategori_pertanyaan';

    protected $fillable = ['nama'];

    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class, 'kategori_id');
    }
}
