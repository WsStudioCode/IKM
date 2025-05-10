<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriPertanyaanDataTable;
use App\Models\KategoriPertanyaan;
use Illuminate\Http\Request;

class KategoriPertanyaanController extends Controller
{
    public function index(KategoriPertanyaanDataTable $datatable)
    {
        return $datatable->render('admin.kategori.index');
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        KategoriPertanyaan::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(KategoriPertanyaan $kategoriPertanyaan)
    {
        return view('admin.kategori.edit', compact('kategoriPertanyaan'));
    }

    public function update(Request $request, KategoriPertanyaan $kategoriPertanyaan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategoriPertanyaan->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriPertanyaan $kategoriPertanyaan)
    {
        $kategoriPertanyaan->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
