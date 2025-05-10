<?php

namespace App\Http\Controllers;

use App\DataTables\PertanyaanDataTable;
use App\Models\Pertanyaan;
use App\Models\KategoriPertanyaan;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    public function index(PertanyaanDataTable $dataTable)
    {
        return $dataTable->render('admin.pertanyaan.index');
    }

    public function create()
    {
        $kategoriList = KategoriPertanyaan::all();
        return view('admin.pertanyaan.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi_pertanyaan' => 'required|string',
            'kategori_id' => 'nullable|exists:kategori_pertanyaan,id',
        ]);

        Pertanyaan::create([
            'isi_pertanyaan' => $request->isi_pertanyaan,
            'kategori_id' => $request->kategori_id,
            'aktif' => true,
        ]);

        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function edit(Pertanyaan $pertanyaan)
    {
        $kategoriList = KategoriPertanyaan::all();
        return view('admin.pertanyaan.edit', compact('pertanyaan', 'kategoriList'));
    }

    public function update(Request $request, Pertanyaan $pertanyaan)
    {
        $request->validate([
            'isi_pertanyaan' => 'required|string',
            'kategori_id' => 'nullable|exists:kategori_pertanyaan,id',
        ]);

        $pertanyaan->update([
            'isi_pertanyaan' => $request->isi_pertanyaan,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroy(Pertanyaan $pertanyaan)
    {
        $pertanyaan->delete();

        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
