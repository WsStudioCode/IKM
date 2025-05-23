<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class TindakLanjutController extends Controller
{
    public function index()
    {
        $pengaduan = \App\Models\Pengaduan::with([
            'masyarakat',
            'tindakLanjut',
            'komentar' => function ($q) {
                $q->with('masyarakat')->latest()->limit(10);
            }
        ])
            ->orderByDesc('created_at')
            ->get();

        return view('responden.tindaklanjut', compact('pengaduan'));
    }


    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load(['masyarakat', 'tindakLanjut', 'komentar.masyarakat']);
        return view('responden.tindaklanjut-detail', compact('pengaduan'));
    }


    public function komentar(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'isi' => 'required|string|max:1000',
        ]);

        Komentar::create([
            'masyarakat_id' => session('masyarakat_id'),
            'pengaduan_id' => $pengaduan->id,
            'isi' => $request->isi,
        ]);

        if (str_contains(url()->previous(), '/tindak-lanjut/' . $pengaduan->id)) {
            return redirect()->route('tindak-lanjut.show', $pengaduan)->with('success', 'Komentar berhasil dikirim.');
        }

        return redirect()->route('tindak-lanjut.index')->with('success', 'Komentar dikirim.');
    }

    public function updateTanggapan(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'tanggapan' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('tindak_lanjut', 'public');
        }

        $pengaduan->tindakLanjut()->updateOrCreate(
            ['pengaduan_id' => $pengaduan->id],
            [
                'tanggapan' => [$request->tanggapan],
                'gambar' => [$gambar],
                'tanggal_tindak_lanjut' => now(),
            ]
        );

        return back()->with('success', 'Tanggapan berhasil dikirim.');
    }
}
