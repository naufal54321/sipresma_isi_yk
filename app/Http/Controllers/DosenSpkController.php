<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenSpkController extends Controller
{
    /**
     * Daftar SPK mahasiswa bimbingan
     */
   public function index(Request $request)
{
    $search = $request->search;

    $spks = Spk::with(['user', 'rpk', 'kegiatan'])

        ->whereHas('user', function ($query) {
            $query->where('dosen_pembimbing_id', Auth::id());
        })

        ->when($search, function ($query) use ($search) {

            $query->where(function ($q) use ($search) {

                $q->where('status', 'like', "%{$search}%")

                  ->orWhereHas('user', function ($user) use ($search) {
                      $user->where('name', 'like', "%{$search}%")
                           ->orWhere('nim', 'like', "%{$search}%")
                           ->orWhere('prodi', 'like', "%{$search}%");
                  })

                  ->orWhereHas('kegiatan', function ($kegiatan) use ($search) {
                      $kegiatan->where('kegiatan', 'like', "%{$search}%")
                               ->orWhere('jenis', 'like', "%{$search}%");
                  })

                  ->orWhereHas('rpk', function ($rpk) use ($search) {
                      $rpk->where('tahun', 'like', "%{$search}%")
                          ->orWhere('semester', 'like', "%{$search}%");
                  });

            });

        })

        ->latest()
        ->get();

    return view('dosen.spk.index', compact(
        'spks',
        'search'
    ));
}

    /**
     * Setujui SPK
     */
    public function approve(Request $request, Spk $spk)
    {
        // Pastikan hanya dosen pembimbing yang bisa menyetujui
        if ($spk->user->dosen_pembimbing_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $spk->update([
            'status' => 'disetujui',
            'catatan_dosen' => $request->catatan_dosen
        ]);

        return back()->with(
            'success',
            'SPK berhasil disetujui'
        );
    }

    /**
     * Tolak SPK
     */
    public function reject(Request $request, Spk $spk)
    {
        // Pastikan hanya dosen pembimbing yang bisa menolak
        if ($spk->user->dosen_pembimbing_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $spk->update([
            'status' => 'ditolak',
            'catatan_dosen' => $request->catatan_dosen
        ]);

        return back()->with(
            'success',
            'SPK berhasil ditolak'
        );
    }

    /**
     * Detail SPK
     */
    public function show(Spk $spk)
    {
        // Pastikan hanya dosen pembimbing yang bisa melihat detail
        if ($spk->user->dosen_pembimbing_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('dosen.spk.show', compact('spk'));
    }
}