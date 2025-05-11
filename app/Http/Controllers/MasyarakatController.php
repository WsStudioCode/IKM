<?php

namespace App\Http\Controllers;

use App\DataTables\MasyarakatDataTable;
use App\Models\Masyarakat;
use Illuminate\Http\Request;

class MasyarakatController extends Controller
{
    public function index(MasyarakatDataTable $datatable)
    {
        return $datatable->render('admin.masyarakat.index');
    }

    public function create()
    {
        return view('welcome');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'umur' => 'required|integer|min:1|max:120',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:100',
            'agama' => 'required|in:Hindu, Islam, Budha, Katolik, Kristen, Konghucu',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
        ]);

        $masyarakat = Masyarakat::create($validated);

        session(['masyarakat_id' => $masyarakat->id]);

        return redirect()->route('responden.masyarakat')->with('success', 'Data masyarakat berhasil disimpan!');
    }
}
