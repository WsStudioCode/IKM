<?php

namespace App\Http\Controllers;

use App\DataTables\PengaduanDataTable;
use App\Models\Masyarakat;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PengaduanDataTable $dataTable)
    {
        return $dataTable->render('admin.pengaduan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $masyarakat = Masyarakat::all();
        return view('admin.pengaduan.create', compact('masyarakat'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load(['masyarakat', 'tindakLanjut']);

        $komentar = $pengaduan->komentar()
            ->with('masyarakat')
            ->latest()
            ->paginate(5);

        return view('admin.pengaduan.detail', compact('pengaduan', 'komentar'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'masyarakat_id' => 'required|exists:masyarakat,id',
            'isi' => 'required|string',
            'status' => 'required|in:Menunggu,Diproses,Selesai',
        ]);

        Pengaduan::create($request->only('masyarakat_id', 'isi', 'status'));

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengaduan $pengaduan)
    {
        $masyarakat = Masyarakat::all();
        return view('admin.pengaduan.edit', compact('pengaduan', 'masyarakat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'masyarakat_id' => 'required|exists:masyarakat,id',
            'isi' => 'required|string',
            'status' => 'required|in:Menunggu,Diproses,Selesai',
            'tanggapan' => 'nullable|string',
        ]);

        $pengaduan->update([
            'masyarakat_id' => $request->masyarakat_id,
            'isi' => $request->isi,
            'status' => $request->status,
        ]);

        if ($request->filled('tanggapan')) {
            $pengaduan->tindakLanjut()->updateOrCreate(
                ['pengaduan_id' => $pengaduan->id],
                ['tanggapan' => $request->tanggapan, 'tanggal_tindak_lanjut' => now()]
            );
        }

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan & tindak lanjut berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengaduan $pengaduan)
    {
        $pengaduan->delete();
        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
    }

    public function createPengaduan()
    {
        return view('responden.pengaduan');
    }

    public function storePengaduan(Request $request)
    {
        $request->validate([
            'isi' => 'required|string|max:1000',
        ]);

        Pengaduan::create([
            'masyarakat_id' => session('masyarakat_id'),
            'isi' => $request->isi,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('responden.masyarakat')->with('success', 'Pengaduan berhasil dikirim! Menunggu tindak lanjut.');
    }
}
