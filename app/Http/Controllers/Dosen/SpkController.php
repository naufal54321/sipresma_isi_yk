<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;

use App\Models\Spk;
use App\Models\KkmRule;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SpkStatusNotification;

class SpkController extends Controller
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
            
            ->whereHas('rpk', function ($query) {
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
                           $kegiatan->where('kegiatan', 'like', "%{$search}%");
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
        if ($spk->rpk?->dosen_pembimbing_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        if ($spk->status !== 'draft') {
            abort(403, 'SPK yang sudah diproses tidak dapat disetujui ulang.');
        }

        $kkmRule = $spk->kegiatan->pointRule;
        $poin = $kkmRule ? $kkmRule->points : 0;

        $spk->update([
            'status' => 'disetujui',
            'poin' => $poin,
            'poin_added_at' => now(),
            'poin_added_by' => Auth::id(),
            'catatan_dosen' => $request->catatan_dosen,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);
        DashboardService::clearAdminCache();

        // ⚡ NOTIFIKASI: Email ke mahasiswa saat SPK disetujui
        if ($spk->user && $spk->user->email) {
            try {
                Mail::to($spk->user)->send(new SpkStatusNotification($spk->fresh(), 'disetujui'));
            } catch (\Throwable $e) {
                Log::warning('Gagal kirim email status SPK disetujui: ' . $e->getMessage());
            }
        }

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
        if ($spk->rpk?->dosen_pembimbing_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        if ($spk->status !== 'draft') {
            abort(403, 'SPK yang sudah diproses tidak dapat ditolak ulang.');
        }

        $spk->update([
            'status' => 'ditolak',
            'catatan_dosen' => $request->catatan_dosen,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);
        DashboardService::clearAdminCache();

        // ⚡ NOTIFIKASI: Email ke mahasiswa saat SPK ditolak
        if ($spk->user && $spk->user->email) {
            try {
                Mail::to($spk->user)->send(new SpkStatusNotification($spk->fresh(), 'ditolak'));
            } catch (\Throwable $e) {
                Log::warning('Gagal kirim email status SPK ditolak: ' . $e->getMessage());
            }
        }

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
        if ($spk->rpk?->dosen_pembimbing_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $spk->load(['verifiedBy', 'kegiatan.pointRule', 'kegiatan.pointRule.competencyField', 'kegiatan.pointRule.activityType']);

        $fileRequirements = [];
        if ($spk->kegiatan && $spk->kegiatan->pointRule) {
            $pr = $spk->kegiatan->pointRule;
            $fileRequirements = \App\Services\FileRequirementService::getRequiredFiles($pr->competencyField->name, $pr->activityType->name, $spk->peran_sifat);
        }

        return view('dosen.spk.show', compact('spk', 'fileRequirements'));
    }
}

