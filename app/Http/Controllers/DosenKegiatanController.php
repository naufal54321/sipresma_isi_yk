<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Support\Facades\Auth;

class DosenKegiatanController extends Controller
{
    /**
     * List kegiatan mahasiswa bimbingan
     */
    public function index()
    {
        $kegiatans = Kegiatan::whereHas('rpk.user', function ($q) {
                $q->where('dosen_pembimbing_id', Auth::id());
            })
            ->with('rpk.user')
            ->get();

        return view('dosen.kegiatan.index', compact('kegiatans'));
    }

    /**
     * Setujui kegiatan
     */
    public function approve(Kegiatan $kegiatan)
    {
        // optional security: pastikan dosen hanya bisa approve mahasiswa bimbingannya
        if ($kegiatan->rpk->user->dosen_pembimbing_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $kegiatan->update([
            'status' => 'disetujui'
        ]);

        return back()->with('success', 'Kegiatan berhasil disetujui');
    }

    /**
     * Tolak kegiatan
     */
    public function reject(Kegiatan $kegiatan)
    {
        // optional security check
        if ($kegiatan->rpk->user->dosen_pembimbing_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $kegiatan->update([
            'status' => 'ditolak'
        ]);

        return back()->with('success', 'Kegiatan berhasil ditolak');
    }
}