<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;

class DosenKegiatanController extends Controller
{
    /**
     * List kegiatan mahasiswa
     */
    public function index()
{
    $kegiatans = Kegiatan::with('user')->get();

    return view('dosen.kegiatan.index', compact('kegiatans'));
}

    /**
     * Setujui kegiatan
     */
    public function approve(Kegiatan $kegiatan)
    {
        $kegiatan->update([
            'status' => 'disetujui'
        ]);

        return back()->with(
            'success',
            'Kegiatan berhasil disetujui'
        );
    }

    /**
     * Tolak kegiatan
     */
    public function reject(Kegiatan $kegiatan)
    {
        $kegiatan->update([
            'status' => 'ditolak'
        ]);

        return back()->with(
            'success',
            'Kegiatan berhasil ditolak'
        );
    }
}