<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSpkController extends Controller
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
        $spk->load(['user', 'rpk', 'kegiatan', 'kegiatan.anggota', 'poinAddedBy']);
        
        $totalSpkDisetujui = Spk::where('user_id', $spk->user_id)->where('status', 'disetujui')->count();
        $totalPoin = Spk::where('user_id', $spk->user_id)->where('status', 'disetujui')->sum('poin');
        $riwayatSpk = Spk::where('user_id', $spk->user_id)->where('status', 'disetujui')->where('id', '!=', $spk->id)->latest()->take(5)->get();
        
        return view('admin.spk.show', compact('spk', 'totalSpkDisetujui', 'totalPoin', 'riwayatSpk'));
    }
    
    public function approve(Request $request, Spk $spk)
    {
        $request->validate(['catatan' => 'nullable|string|max:500']);
        $spk->update(['status' => 'disetujui', 'catatan_dosen' => $request->catatan ?? 'Disetujui oleh Admin']);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'SPK berhasil disetujui']);
        }
        return back()->with('success', 'SPK berhasil disetujui');
    }
    
    public function reject(Request $request, Spk $spk)
    {
        $request->validate(['catatan' => 'required|string|max:500'], ['catatan.required' => 'Alasan penolakan wajib diisi']);
        $spk->update(['status' => 'ditolak', 'catatan_dosen' => $request->catatan]);
        
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
        return back()->with('success', 'SPK berhasil dihapus');
    }

    public function kelolaPoin(Request $request)
    {
        $filterTahun = $request->tahun;
        $filterStatus = $request->status_poin;
        $search = $request->search;

        $query = Spk::with(['user', 'rpk', 'kegiatan', 'poinAddedBy'])->where('status', 'disetujui');

        if ($filterTahun) $query->where('tahun', $filterTahun);
        if ($filterStatus === 'sudah') $query->where('poin', '>', 0);
        elseif ($filterStatus === 'belum') $query->where(fn($q) => $q->whereNull('poin')->orWhere('poin', '<=', 0));
        if ($search) $query->where(fn($q) => $q->where('judul_kegiatan', 'like', "%{$search}%")->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$search}%")));

        $spks = $query->latest()->paginate(20)->withQueryString();
        $totalDisetujui = Spk::where('status', 'disetujui')->count();
        $totalDenganPoin = Spk::where('status', 'disetujui')->where('poin', '>', 0)->count();
        $totalTanpaPoin = $totalDisetujui - $totalDenganPoin;
        $totalPoin = Spk::where('status', 'disetujui')->sum('poin');
        $listTahun = Spk::distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('admin.spk.kelola-poin', compact('spks', 'totalDisetujui', 'totalDenganPoin', 'totalTanpaPoin', 'totalPoin', 'filterTahun', 'filterStatus', 'search', 'listTahun'));
    }

    /**
     * ⚡ Tambah Poin SPK via AJAX (Hanya untuk SPK yang belum ada poin)
     */
    public function tambahPoin(Request $request, Spk $spk)
    {
        if ($spk->status !== 'disetujui') {
            return response()->json(['success' => false, 'message' => 'Poin hanya dapat ditambahkan pada SPK yang sudah disetujui.'], 422);
        }

        if ($spk->poin > 0) {
            return response()->json(['success' => false, 'message' => 'Poin sudah ditambahkan sebelumnya. Gunakan Edit Poin.'], 422);
        }

        $validator = validator($request->all(), [
            'poin' => 'required|integer|min:1|max:100'
        ], [
            'poin.required' => 'Jumlah poin harus diisi',
            'poin.max' => 'Poin maksimal 100'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $spk->update(['poin' => $request->poin, 'poin_added_at' => now(), 'poin_added_by' => Auth::id()]);

        return response()->json([
            'success' => true,
            'message' => "Poin sebesar {$request->poin} berhasil ditambahkan!",
        ]);
    }

    /**
     * ⚡ Edit Poin SPK via AJAX (Untuk SPK yang sudah ada poin)
     */
    public function editPoin(Request $request, Spk $spk)
    {
        if ($spk->status !== 'disetujui') {
            return response()->json(['success' => false, 'message' => 'SPK harus disetujui untuk edit poin.'], 422);
        }

        $validator = validator($request->all(), [
            'poin' => 'required|integer|min:1|max:100'
        ], [
            'poin.required' => 'Jumlah poin harus diisi',
            'poin.max' => 'Poin maksimal 100'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $spk->update(['poin' => $request->poin, 'poin_added_at' => now(), 'poin_added_by' => Auth::id()]);

        return response()->json([
            'success' => true,
            'message' => "Poin berhasil diupdate menjadi {$request->poin}!",
        ]);
    }
}