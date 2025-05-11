<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HasilIkmController;
use App\Http\Controllers\HasilKuesionerController;
use App\Http\Controllers\KategoriPertanyaanController;
use App\Http\Controllers\KuesionerController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TindakLanjutController;
use App\Models\HasilKuesioner;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
});


Route::get('/', [MasyarakatController::class, 'create'])->name('masyarakat.form');
Route::post('/masyarakat', [MasyarakatController::class, 'store'])->name('masyarakat.store');
Route::get('/masyarakat/kuesioner', [KuesionerController::class, 'index'])->name('kuesioner.form');
Route::post('/masyarakat/kuesioner', [KuesionerController::class, 'submit'])->name('kuesioner.submit');

Route::get('/masyarakat/pengaduan', [PengaduanController::class, 'createPengaduan'])->name('pengaduan.form');
Route::post('/masyarakat/pengaduan', [PengaduanController::class, 'storePengaduan'])->name('pengaduan.store');

Route::get('/tindak-lanjut', [TindakLanjutController::class, 'index'])->name('tindak-lanjut.index');
Route::get('/tindak-lanjut/{pengaduan}', [TindakLanjutController::class, 'show'])->name('tindak-lanjut.show');
Route::post('/tindak-lanjut/{pengaduan}/komentar', [TindakLanjutController::class, 'komentar'])->name('tindak-lanjut.komentar');



Route::get('/masyarakat/dashboard', function () {
    if (!session()->has('masyarakat_id')) {
        return redirect('/');
    }

    return view('responden.masyarakat');
})->name('responden.masyarakat');



Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Pertanyaan
    Route::get('/pertanyaan', [PertanyaanController::class, 'index'])->name('pertanyaan.index');
    Route::get('/pertanyaan/create', [PertanyaanController::class, 'create'])->name('pertanyaan.create');
    Route::post('/pertanyaan', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
    Route::get('/pertanyaan/{pertanyaan}/edit', [PertanyaanController::class, 'edit'])->name('pertanyaan.edit');
    Route::put('/pertanyaan/{pertanyaan}', [PertanyaanController::class, 'update'])->name('pertanyaan.update');
    Route::delete('/pertanyaan/{pertanyaan}', [PertanyaanController::class, 'destroy'])->name('pertanyaan.destroy');

    // Kategori Pertanyaan
    Route::get('/kategori-pertanyaan', [KategoriPertanyaanController::class, 'index'])->name('kategori-pertanyaan.index');
    Route::get('/kategori-pertanyaan/create', [KategoriPertanyaanController::class, 'create'])->name('kategori-pertanyaan.create');
    Route::post('/kategori-pertanyaan', [KategoriPertanyaanController::class, 'store'])->name('kategori-pertanyaan.store');
    Route::get('/kategori-pertanyaan/{kategoriPertanyaan}/edit', [KategoriPertanyaanController::class, 'edit'])->name('kategori-pertanyaan.edit');
    Route::put('/kategori-pertanyaan/{kategoriPertanyaan}', [KategoriPertanyaanController::class, 'update'])->name('kategori-pertanyaan.update');
    Route::delete('/kategori-pertanyaan/{kategoriPertanyaan}', [KategoriPertanyaanController::class, 'destroy'])->name('kategori-pertanyaan.destroy');

    // Masyarakat
    Route::get('/masyarakat', [MasyarakatController::class, 'index'])->name('masyarakat.index');
    Route::delete('/masyarakat/{masyarakat}', [MasyarakatController::class, 'destroy'])->name('masyarakat.destroy');

    // Hasil Kuesioner
    Route::get('/hasil-kuesioner', [HasilKuesionerController::class, 'index'])->name('hasil-kuesioner.index');
    Route::delete('/masyarakat/{masyarakat}', [MasyarakatController::class, 'destroy'])->name('masyarakat.destroy');

    // Pengaduan
    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/{pengaduan}/edit', [PengaduanController::class, 'edit'])->name('pengaduan.edit');
    Route::put('/pengaduan/{pengaduan}', [PengaduanController::class, 'update'])->name('pengaduan.update');
    Route::delete('/pengaduan/{pengaduan}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
