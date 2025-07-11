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
use App\Models\Masyarakat;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
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

// Halaman utama baru
// Route::get('/', function () {
//     return view('landingpage');
// });

Route::get('/', function (Request $request) {
    $query = Pengaduan::with(['masyarakat', 'tindakLanjut'])->withCount('komentar');

    if ($request->filled('q')) {
        $query->where('isi', 'like', '%' . $request->q . '%');
    }

    $pengaduan = $query->latest()->paginate(5);

    $pelaporTerbaru = Pengaduan::with('masyarakat')
        ->latest()
        ->take(8)
        ->get()
        ->pluck('masyarakat')
        ->unique('id')
        ->values();

    $laporanSukses = Pengaduan::where('status', 'Selesai')
        ->latest()
        ->take(5)
        ->get();

    $kuesioner = HasilKuesioner::with('masyarakat')->get();

    $nilaiIKM = round($kuesioner->avg('nilai_rata_rata'), 2);
    $jumlahResponden = $kuesioner->count();
    $pria = $kuesioner->where('masyarakat.jenis_kelamin', 'Laki-laki')->count();
    $wanita = $kuesioner->where('masyarakat.jenis_kelamin', 'Perempuan')->count();

    $pendidikan = [
        'SMA_SMK' => $kuesioner->filter(fn($k) => str_contains($k->masyarakat->pendidikan->value ?? '', 'SMA'))->count(),
        'D1-D3' => $kuesioner->filter(fn($k) => in_array($k->masyarakat->pendidikan->value ?? '', ['D1', 'D2', 'D3']))->count(),
        'D4-S1' => $kuesioner->filter(fn($k) => in_array($k->masyarakat->pendidikan->value ?? '', ['D4', 'S1']))->count(),
        'S2-S3' => $kuesioner->filter(fn($k) => in_array($k->masyarakat->pendidikan->value ?? '', ['S2', 'S3']))->count(),
    ];

    $periode = [
        'awal' => optional($kuesioner->min('tanggal_isi'))->format('d M Y'),
        'akhir' => optional($kuesioner->max('tanggal_isi'))->format('d M Y'),
    ];
    $waLink = session('wa_link');
//     return view('responden.masyarakat', compact('pengaduan', 'pelaporTerbaru', 'laporanSukses', 'nilaiIKM', 'jumlahResponden', 'pria', 'wanita', 'pendidikan', 'periode', 'waLink'));
// })->name('responden.masyarakat');

    // Rekapitulasi IKM
    $rekap = \App\Models\JawabanKuesioner::selectRaw('
                pertanyaan_id,
                COUNT(*) as total_responden,
                SUM(jawaban) as total_skor,
                ROUND(AVG(jawaban), 2) as rata_rata_jawaban
            ')
            ->groupBy('pertanyaan_id')
            ->get();

        $totalIKM = $rekap->sum(function ($item) {
            return $item->rata_rata_jawaban * 0.11;
        });

        $nilaiAkhirIKM = round($totalIKM * 25, 2);
        return view('responden.masyarakat', compact('pengaduan', 'pelaporTerbaru', 'laporanSukses', 'nilaiIKM', 'jumlahResponden', 'pria', 'wanita', 'pendidikan', 'periode', 'waLink', 'nilaiAkhirIKM'));
    })->name('responden.masyarakat');

Route::get('/masyarakat/form-registrasi', [MasyarakatController::class, 'create'])->name('masyarakat.form');
Route::post('/masyarakat', [MasyarakatController::class, 'store'])->name('masyarakat.store');

Route::middleware('masyarakat.session')->group(function () {
    Route::get('/masyarakat/kuesioner', [KuesionerController::class, 'index'])->name('kuesioner.form');
    Route::post('/masyarakat/kuesioner', [KuesionerController::class, 'submit'])->name('kuesioner.submit');

    Route::get('/masyarakat/pengaduan', [PengaduanController::class, 'createPengaduan'])->name('pengaduan.form');
    Route::post('/masyarakat/pengaduan', [PengaduanController::class, 'storePengaduan'])->name('pengaduan.store');

    Route::get('/tindak-lanjut', [TindakLanjutController::class, 'index'])->name('tindak-lanjut.index');
    Route::get('/tindak-lanjut/{pengaduan}', [TindakLanjutController::class, 'show'])->name('tindak-lanjut.show');
    Route::post('/tindak-lanjut/{pengaduan}/komentar', [TindakLanjutController::class, 'komentar'])->name('tindak-lanjut.komentar');
});



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
    Route::get('/hasil-kuesioner/{hasil}', [HasilKuesionerController::class, 'show'])->name('hasil-kuesioner.show'); // Show detail hasil kuesioner
    
    Route::delete('/masyarakat/{masyarakat}', [MasyarakatController::class, 'destroy'])->name('masyarakat.destroy');
    Route::get('/kepuasan/export', [AdminController::class, 'exportKepuasan'])
        ->name('admin.export.kepuasan');
    Route::get('/kuesioner/export-pdf', [\App\Http\Controllers\HasilKuesionerController::class, 'exportPDF'])->name('hasilkuesioner.export.pdf');
    Route::get('/kuesioner/export-excel', [HasilKuesionerController::class, 'exportExcel'])->name('hasilkuesioner.export.excel');


    // Pengaduan
    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/{pengaduan}/edit', [PengaduanController::class, 'edit'])->name('pengaduan.edit');
    Route::put('/pengaduan/{pengaduan}', [PengaduanController::class, 'update'])->name('pengaduan.update');
    Route::delete('/pengaduan/{pengaduan}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');

    Route::get('/pengaduan/export/pdf', [PengaduanController::class, 'exportPDF'])->name('pengaduan.export.pdf');
    Route::get('/pengaduan/export/excel', [PengaduanController::class, 'exportExcel'])->name('pengaduan.export.excel');
    Route::get('/rekap-pertanyaan', [HasilKuesionerController::class, 'rekapPerPertanyaan'])->name('rekap.pertanyaan.index');


    // tindak lanjut
    Route::put('/pengaduan/{pengaduan}/tanggapan', [TindakLanjutController::class, 'updateTanggapan'])->name('tindak-lanjut.tanggapan.update');


    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';