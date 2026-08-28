<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;

use App\Models\Rpk;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\RpkStatusNotification;

class RpkController extends Controller
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
            ->where('dosen_pembimbing_id', Auth::id())

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
                           $kegiatan->where('kegiatan', 'like', "%{$search}%");
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
            ->paginate(15);

        return view('dosen.rpk.index', compact('rpks', 'search'));
    }

    /**
     * Setujui RPK
     */
    public function approve(Request $request, Rpk $rpk)
    {
        if ($rpk->dosen_pembimbing_id !== Auth::id()) {
            abort(403);
        }

        if ($rpk->status !== 'draft') {
            abort(403, 'RPK yang sudah diproses tidak dapat disetujui ulang.');
        }

        $rpk->update([
            'status' => 'disetujui',
            'catatan_dosen' => $request->catatan_dosen,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);
        DashboardService::clearAdminCache();

        // ⚡ NOTIFIKASI: Email ke mahasiswa saat RPK disetujui
        if ($rpk->user && $rpk->user->email) {
            try {
                Mail::to($rpk->user)->send(new RpkStatusNotification($rpk->fresh(), 'disetujui'));
            } catch (\Throwable $e) {
                Log::warning('Gagal kirim email status RPK disetujui: ' . $e->getMessage());
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'RPK berhasil disetujui']);
        }

        return back()->with('success', 'RPK berhasil disetujui');
    }

    /**
     * Tolak RPK
     */
    public function reject(Request $request, Rpk $rpk)
    {
        if ($rpk->dosen_pembimbing_id !== Auth::id()) {
            abort(403);
        }

        if ($rpk->status !== 'draft') {
            abort(403, 'RPK yang sudah diproses tidak dapat ditolak ulang.');
        }

        $rpk->update([
            'status' => 'ditolak',
            'catatan_dosen' => $request->catatan_dosen,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);
        DashboardService::clearAdminCache();

        // ⚡ NOTIFIKASI: Email ke mahasiswa saat RPK ditolak
        if ($rpk->user && $rpk->user->email) {
            try {
                Mail::to($rpk->user)->send(new RpkStatusNotification($rpk->fresh(), 'ditolak'));
            } catch (\Throwable $e) {
                Log::warning('Gagal kirim email status RPK ditolak: ' . $e->getMessage());
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'RPK berhasil ditolak']);
        }

        return back()->with('success', 'RPK berhasil ditolak');
    }

    /**
     * Detail RPK
     */
    public function show(Rpk $rpk)
    {
        if ($rpk->dosen_pembimbing_id != Auth::id()) {
            abort(403);
        }

        $rpk->load([
            'user',
            'kegiatans',
            'verifiedBy',
        ]);

        return view('dosen.rpk.show', compact('rpk'));
    }
}

