<?php

namespace App\Http\Controllers;

use App\Models\Rpk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRpkController extends Controller
{
    public function index(Request $request)
    {
        // Ambil RPK beserta relasi user dan dosen pembimbingnya
        $query = Rpk::with(['user.dosenPembimbing']);

        // 1. Filter Pencarian (Nama Mhs, NIM, atau Judul Kegiatan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%")
                      ->orWhere('nim', 'like', "%{$search}%");
                })->orWhere('nama_kegiatan', 'like', "%{$search}%"); // sesuaikan field judul rpk Anda
            });
        }

        // 2. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Filter Dosen Pembimbing (Kuncian untuk Mahasiswa Tanpa Dosen)
        if ($request->filled('dosen_id')) {
            if ($request->dosen_id === 'tanpa_dosen') {
                $query->whereHas('user', function ($u) {
                    $u->whereNull('dosen_pembimbing_id');
                });
            } else {
                $query->whereHas('user', function ($u) use ($request) {
                    $u->where('dosen_pembimbing_id', $request->dosen_id);
                });
            }
        }

        $rpks = $query->latest()->paginate(10)->withQueryString();
        
        // Ambil daftar dosen untuk dropdown filter
        $dosens = User::role('Dosen')->orderBy('name')->get();

        return view('admin.rpk.index', compact('rpks', 'dosens'));
    }

    public function show(Rpk $rpk)
    {
        $rpk->load(['user.dosenPembimbing']);
        return view('admin.rpk.show', compact('rpk'));
    }

    public function updateStatus(Request $request, Rpk $rpk)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak,draft',
            'catatan' => 'nullable|string|max:500'
        ]);

        $rpk->update([
            'status' => $request->status,
            'catatan' => $request->catatan ?? $rpk->catatan,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status RPK berhasil diubah menjadi ' . strtoupper($request->status)
            ]);
        }

        return redirect()->route('admin.rpk.index')
            ->with('success', 'Status RPK milik ' . $rpk->user->name . ' berhasil diubah menjadi ' . strtoupper($request->status));
    }
}