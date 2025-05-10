<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil_kuesioner', function (Blueprint $table) {
            $table->id();
            $table->foreignId('masyarakat_id')->constrained('masyarakat')->onDelete('cascade');
            $table->float('nilai_rata_rata', 3, 2);
            $table->enum('kategori_hasil', ['Sangat Sesuai', 'Sesuai', 'Kurang Sesuai', 'Tidak Sesuai']);
            $table->timestamp('tanggal_isi')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_kuesioner');
    }
};
