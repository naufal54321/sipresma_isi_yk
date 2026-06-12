<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenKegiatanController extends Controller
{
    /**
     * List kegiatan mahasiswa bimbingan
     */
    public function index(Request $request)
{
    $search = $request->search;

    $kegiatans = Kegiatan::whereHas('rpk.user', function ($q) {
            $q->where('dosen_pembimbing_id', Auth::id());
        })
        ->when($search, function ($query) use ($search) {

            $query->where(function ($q) use ($search) {

                $q->where('kegiatan', 'like', "%{$search}%")
                  ->orWhere('jenis', 'like', "%{$search}%")
                  ->orWhere('tingkat', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");

            })

            ->orWhereHas('rpk.user', function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");

            });

        })
        ->with('rpk.user')
        ->latest()
        ->get();

    return view('dosen.rpk.index', compact(
        'kegiatans',
        'search'
    ));
}

    /**
     * Setujui kegiatan
     */
    public function approve(Request $request, Kegiatan $kegiatan)
{
    if ($kegiatan->rpk->user->dosen_pembimbing_id !== Auth::id()) {
        abort(403, 'Unauthorized');
    }

    $kegiatan->update([
        'status' => 'disetujui',
        'catatan_dosen' => $request->catatan_dosen
    ]);

    return back()->with(
        'success',
        'Kegiatan berhasil disetujui'
    );
}

    /**
     * Tolak kegiatan
     */
    public function reject(Request $request, Kegiatan $kegiatan)
{
    if ($kegiatan->rpk->user->dosen_pembimbing_id !== Auth::id()) {
        abort(403, 'Unauthorized');
    }

    $kegiatan->update([
        'status' => 'ditolak',
        'catatan_dosen' => $request->catatan_dosen
    ]);

    return back()->with(
        'success',
        'Kegiatan berhasil ditolak'
    );
}

public function show(Kegiatan $kegiatan)
{
    return view(
        'dosen.kegiatan.show',
        compact('kegiatan')
    );
}

}