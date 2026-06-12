<?php

namespace App\Http\Controllers;

use App\Models\Rpk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenRpkController extends Controller
{
    /**
     * Daftar SPK mahasiswa bimbingan
     */
    public function index(Request $request)
    {
        // 1. Tangkap semua parameter dari form (Search Teks & Dropdown Filter)
        $search = $request->search;
        $filterTahun = $request->tahun;
        $filterSemester = $request->semester;
        $filterStatus = $request->status;

        $rpks = Rpk::with(['user', 'kegiatans'])
            
            // Hanya ambil RPK yang memiliki kegiatan
            ->has('kegiatans') 
            
            // Hanya untuk mahasiswa bimbingannya sendiri
            ->whereHas('user', function ($query) {
                $query->where('dosen_pembimbing_id', Auth::id());
            })

            // Logika Pencarian Teks Asli Milik Anda (Tetap Dipertahankan 100%)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('status', 'like', "%{$search}%")
                      ->orWhere('tahun', 'like', "%{$search}%")
                      ->orWhere('semester', 'like', "%{$search}%")

                      ->orWhereHas('user', function ($user) use ($search) {
                          $user->where('name', 'like', "%{$search}%")
                               ->orWhere('nim', 'like', "%{$search}%")
                               ->orWhere('prodi', 'like', "%{$search}%");
                      })

                      ->orWhereHas('kegiatans', function ($kegiatan) use ($search) {
                          $kegiatan->where('kegiatan', 'like', "%{$search}%")
                                   ->orWhere('jenis', 'like', "%{$search}%");
                      });
                });
            })

            // TAMBAHAN: Filter Dropdown Tahun
            ->when($filterTahun, function ($query) use ($filterTahun) {
                return $query->where('tahun', $filterTahun);
            })

            // TAMBAHAN: Filter Dropdown Semester
            ->when($filterSemester, function ($query) use ($filterSemester) {
                return $query->where('semester', $filterSemester);
            })

            // TAMBAHAN: Filter Dropdown Status
            ->when($filterStatus, function ($query) use ($filterStatus) {
                return $query->where('status', $filterStatus);
            })

            ->latest()
            ->get();

        return view('dosen.rpk.index', compact('rpks', 'search'));
    }

    /**
     * Setujui RPK
     */
    public function approve(Request $request, Rpk $rpk)
    {
        if ($rpk->user->dosen_pembimbing_id !== Auth::id()) {
            abort(403);
        }

        $rpk->update([
            'status' => 'disetujui',
            'catatan_dosen' => $request->catatan_dosen
        ]);

        return back()->with(
            'success',
            'RPK berhasil disetujui'
        );
    }

    /**
     * Tolak RPK
     */
    public function reject(Request $request, Rpk $rpk)
    {
        if ($rpk->user->dosen_pembimbing_id !== Auth::id()) {
            abort(403);
        }

        $rpk->update([
            'status' => 'ditolak',
            'catatan_dosen' => $request->catatan_dosen
        ]);

        return back()->with(
            'success',
            'RPK berhasil ditolak'
        );
    }

    /**
     * Detail RPK
     */
    public function show(Rpk $rpk)
    {
        if ($rpk->user->dosen_pembimbing_id != Auth::id()) {
            abort(403);
        }

        $rpk->load([
            'user',
            'kegiatans.masterKegiatan'
        ]);

        return view('dosen.rpk.show', compact('rpk'));
    }
}