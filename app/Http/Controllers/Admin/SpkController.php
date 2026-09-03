<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Spk;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SpkStatusNotification;

class SpkController extends Controller
{
    public function index(Request $request)
    {
        $query = Spk::with(['user', 'rpk', 'kegiatan', 'kegiatan.anggota', 'poinAddedBy']);
        
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%")
                         ->orWhere('nim', 'like', "%{$search}%");
                })->orWhereHas('kegiatan', function($subQ) use ($search) {
                    $subQ->where('kegiatan', 'like', "%{$search}%")
                         ->orWhere('judul_kegiatan', 'like', "%{$search}%");
                });
            });
        }
        
        $spks = $query->latest()->paginate(15)->withQueryString();
        $tahunList = Spk::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        
        return view('admin.spk.index', compact('spks', 'tahunList'));
    }
    
    public function show(Spk $spk)
    {
        $spk->load(['user', 'rpk', 'kegiatan', 'kegiatan.anggota', 'kegiatan.pointRule', 'kegiatan.pointRule.competencyField', 'kegiatan.pointRule.activityType', 'poinAddedBy', 'verifiedBy']);
        
        $totalSpkDisetujui = Spk::where('user_id', $spk->user_id)->where('status', 'disetujui')->count();
        $totalPoin = Spk::where('user_id', $spk->user_id)->where('status', 'disetujui')->sum('poin');
        $riwayatSpk = Spk::where('user_id', $spk->user_id)->where('status', 'disetujui')->where('id', '!=', $spk->id)->latest()->take(5)->get();

        $fileRequirements = [];
        if ($spk->kegiatan && $spk->kegiatan->pointRule) {
            $pr = $spk->kegiatan->pointRule;
            $fileRequirements = \App\Services\FileRequirementService::getRequiredFiles($pr->competencyField->name, $pr->activityType->name, $spk->peran_sifat);
        }
        
        return view('admin.spk.show', compact('spk', 'totalSpkDisetujui', 'totalPoin', 'riwayatSpk', 'fileRequirements'));
    }
    
    public function approve(Request $request, Spk $spk)
    {
        $request->validate(['catatan' => 'nullable|string|max:500']);

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
            'catatan_dosen' => $request->catatan ?? 'Disetujui oleh Admin',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);
        DashboardService::clearAdminCache();

        // ⚡ NOTIFIKASI: Email ke mahasiswa saat admin menyetujui SPK
        if ($spk->user && $spk->user->email) {
            try {
                Mail::to($spk->user)->send(new SpkStatusNotification($spk->fresh(), 'disetujui'));
            } catch (\Throwable $e) {
                Log::warning('Gagal kirim email status SPK disetujui (admin): ' . $e->getMessage());
            }
        }
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'SPK berhasil disetujui']);
        }
        return back()->with('success', 'SPK berhasil disetujui');
    }
    
    public function reject(Request $request, Spk $spk)
    {
        $request->validate(['catatan' => 'required|string|max:500'], ['catatan.required' => 'Alasan penolakan wajib diisi']);

        if ($spk->status !== 'draft') {
            abort(403, 'SPK yang sudah diproses tidak dapat ditolak ulang.');
        }

        $spk->update(['status' => 'ditolak', 'catatan_dosen' => $request->catatan, 'verified_by' => Auth::id(), 'verified_at' => now()]);
        DashboardService::clearAdminCache();

        // ⚡ NOTIFIKASI: Email ke mahasiswa saat admin menolak SPK
        if ($spk->user && $spk->user->email) {
            try {
                Mail::to($spk->user)->send(new SpkStatusNotification($spk->fresh(), 'ditolak'));
            } catch (\Throwable $e) {
                Log::warning('Gagal kirim email status SPK ditolak (admin): ' . $e->getMessage());
            }
        }
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'SPK berhasil ditolak']);
        }
        return back()->with('success', 'SPK berhasil ditolak');
    }
    
    public function destroy(Spk $spk)
    {
        $files = ['surat_tugas', 'sertifikat', 'foto_penyerahan', 'laporan'];
        foreach ($files as $field) {
            if ($spk->$field && \Storage::disk('public')->exists($spk->$field)) {
                \Storage::disk('public')->delete($spk->$field);
            }
        }
        $spk->delete();
        DashboardService::clearAdminCache();
        return back()->with('success', 'SPK berhasil dihapus');
    }
}

