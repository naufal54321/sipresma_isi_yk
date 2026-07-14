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
        // 1. Tangkap parameter dari form
        $search = $request->search;
        $filterTahun = $request->tahun;
        $filterStatus = $request->status;

        $spks = Spk::with(['user', 'rpk', 'kegiatan'])
            
            ->whereHas('user', function ($query) {
                $query->where('dosen_pembimbing_id', Auth::id());
            })

            // Logika pencarian teks bawaan Anda (Tetap Dipertahankan)
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

            // ---> TAMBAHAN: Filter Dropdown Tahun <---
            ->when($filterTahun, function ($query) use ($filterTahun) {
                return $query->where('tahun', $filterTahun);
            })

            // ---> TAMBAHAN: Filter Dropdown Status <---
            ->when($filterStatus, function ($query) use ($filterStatus) {
                return $query->where('status', $filterStatus);
            })

            ->latest()
            ->paginate(15);

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
        if ($spk->user->dosen_pembimbing_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $spk->update([
            'status' => 'disetujui',
            'catatan_dosen' => $request->catatan_dosen
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'SPK berhasil disetujui']);
        }

        return back()->with('success', 'SPK berhasil disetujui');
    }

    /**
     * Tolak SPK
     */
    public function reject(Request $request, Spk $spk)
    {
        if ($spk->user->dosen_pembimbing_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $spk->update([
            'status' => 'ditolak',
            'catatan_dosen' => $request->catatan_dosen
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'SPK berhasil ditolak']);
        }

        return back()->with('success', 'SPK berhasil ditolak');
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