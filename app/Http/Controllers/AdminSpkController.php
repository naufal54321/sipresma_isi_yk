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
        
        // Filter
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
        
        // Data untuk filter
        $tahunList = Spk::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        
        return view('admin.spk.index', compact('spks', 'tahunList'));
    }
    
    /**
     * Show detail SPK dengan statistik poin
     */
    public function show(Spk $spk)
    {
        $spk->load(['user', 'rpk', 'kegiatan', 'kegiatan.anggota', 'poinAddedBy']);
        
        // Statistik mahasiswa
        $totalSpkDisetujui = Spk::where('user_id', $spk->user_id)
                                ->where('status', 'disetujui')
                                ->count();
        
        $totalPoin = Spk::where('user_id', $spk->user_id)
                        ->where('status', 'disetujui')
                        ->sum('poin');
        
        // Riwayat SPK mahasiswa
        $riwayatSpk = Spk::where('user_id', $spk->user_id)
                         ->where('status', 'disetujui')
                         ->where('id', '!=', $spk->id)
                         ->latest()
                         ->take(5)
                         ->get();
        
        return view('admin.spk.show', compact(
            'spk', 
            'totalSpkDisetujui', 
            'totalPoin', 
            'riwayatSpk'
        ));
    }
    
    /**
     * Setujui SPK
     */
    public function approve(Request $request, Spk $spk)
    {
        $request->validate([
            'catatan' => 'nullable|string|max:500'
        ]);
        
        $spk->update([
            'status' => 'disetujui',
            'catatan_dosen' => $request->catatan ?? 'Disetujui oleh Admin'
        ]);
        
        // Jika request AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'SPK berhasil disetujui'
            ]);
        }
        
        return back()->with('success', 'SPK berhasil disetujui');
    }
    
    /**
     * Tolak SPK
     */
    public function reject(Request $request, Spk $spk)
    {
        $request->validate([
            'catatan' => 'required|string|max:500'
        ], [
            'catatan.required' => 'Alasan penolakan wajib diisi'
        ]);
        
        $spk->update([
            'status' => 'ditolak',
            'catatan_dosen' => $request->catatan
        ]);
        
        // Jika request AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'SPK berhasil ditolak'
            ]);
        }
        
        return back()->with('success', 'SPK berhasil ditolak');
    }
    
    /**
     * Hapus SPK
     */
    public function destroy(Spk $spk)
    {
        // Hapus semua file terkait
        $files = ['surat_tugas', 'sertifikat', 'foto_penyerahan', 'laporan', 'bukti'];
        foreach ($files as $field) {
            if ($spk->$field && \Storage::disk('public')->exists($spk->$field)) {
                \Storage::disk('public')->delete($spk->$field);
            }
        }
        
        $spk->delete();
        
        return back()->with('success', 'SPK berhasil dihapus');
    }

    /**
     * ⚡ Kelola Poin - Halaman khusus manajemen poin
     */
    public function kelolaPoin(Request $request)
    {
        $filterTahun = $request->tahun;
        $filterStatus = $request->status_poin;
        $search = $request->search;

        $query = Spk::with(['user', 'rpk', 'kegiatan', 'poinAddedBy'])
                    ->where('status', 'disetujui');

        // Filter tahun
        if ($filterTahun) {
            $query->where('tahun', $filterTahun);
        }

        // Filter status poin
        if ($filterStatus === 'sudah') {
            $query->where('poin', '>', 0);
        } elseif ($filterStatus === 'belum') {
            $query->where(function($q) {
                $q->whereNull('poin')
                  ->orWhere('poin', '<=', 0);
            });
        }

        // Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul_kegiatan', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQ) use ($search) {
                      $userQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $spks = $query->latest()->paginate(20)->withQueryString();
        
        // Statistik
        $totalDisetujui = Spk::where('status', 'disetujui')->count();
        $totalDenganPoin = Spk::where('status', 'disetujui')->where('poin', '>', 0)->count();
        $totalTanpaPoin = $totalDisetujui - $totalDenganPoin;
        $totalPoin = Spk::where('status', 'disetujui')->sum('poin');

        // List tahun untuk filter
        $listTahun = Spk::distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('admin.spk.kelola-poin', compact(
            'spks', 
            'totalDisetujui', 
            'totalDenganPoin', 
            'totalTanpaPoin',
            'totalPoin',
            'filterTahun',
            'filterStatus',
            'search',
            'listTahun'
        ));
    }

    /**
     * ⚡ Tambah Poin SPK via AJAX
     */
    public function tambahPoin(Request $request, Spk $spk)
    {
        // Validasi status SPK harus disetujui
        if ($spk->status !== 'disetujui') {
            return response()->json([
                'success' => false,
                'message' => 'Poin hanya dapat ditambahkan pada SPK yang sudah disetujui. Status saat ini: ' . ucfirst($spk->status)
            ], 422);
        }

        // Validasi poin belum ditambahkan
        if ($spk->poin > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Poin sudah ditambahkan sebelumnya sebesar ' . $spk->poin . ' poin.'
            ], 422);
        }

        // Validasi input
        $validator = validator($request->all(), [
            'poin' => 'required|integer|min:1|max:100'
        ], [
            'poin.required' => 'Jumlah poin harus diisi',
            'poin.integer' => 'Poin harus berupa angka bulat',
            'poin.min' => 'Poin minimal 1',
            'poin.max' => 'Poin maksimal 100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Simpan poin
        $spk->update([
            'poin' => $request->poin,
            'poin_added_at' => now(),
            'poin_added_by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => "Poin sebesar {$request->poin} berhasil ditambahkan ke SPK {$spk->judul_kegiatan}!",
            'data' => [
                'poin' => $spk->poin,
                'added_by' => Auth::user()->name,
                'added_at' => $spk->poin_added_at->format('d/m/Y H:i')
            ]
        ]);
    }
}