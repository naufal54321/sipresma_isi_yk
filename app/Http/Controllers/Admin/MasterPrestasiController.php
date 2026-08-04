<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\MasterPrestasi;
use Illuminate\Http\Request;

class MasterPrestasiController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterPrestasi::query();

        if ($request->filled('search')) {
            $query->where('juara', 'like', '%' . $request->search . '%');
        }

        $prestasis = $query->latest()->paginate(10)->withQueryString();

        return view('admin.master-prestasi.index', compact('prestasis'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'juara' => 'required|string|max:255',
            'tingkat' => 'required|in:Universitas,Regional,Nasional,Internasional',
            'is_active' => 'required|in:0,1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $prestasi =         MasterPrestasi::create($request->only(['juara', 'tingkat', 'is_active']));

            return response()->json([
                'success' => true,
                'message' => 'Prestasi berhasil ditambahkan',
                'data' => $prestasi
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, MasterPrestasi $masterPrestasi)
    {
        $validator = \Validator::make($request->all(), [
            'juara' => 'required|string|max:255',
            'tingkat' => 'required|in:Universitas,Regional,Nasional,Internasional',
            'is_active' => 'required|in:0,1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $masterPrestasi->update($request->only(['juara', 'tingkat', 'is_active']));

            return response()->json([
                'success' => true,
                'message' => 'Prestasi berhasil diupdate',
                'data' => $masterPrestasi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(MasterPrestasi $masterPrestasi)
    {
        try {
            $dipakai = \App\Models\Spk::where('prestasi_id', $masterPrestasi->id)->count();

            if ($dipakai > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Tidak dapat dihapus — prestasi ini sudah digunakan oleh {$dipakai} SPK. Nonaktifkan saja jika ingin menyembunyikannya."
                ], 409);
            }

            $masterPrestasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data prestasi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(MasterPrestasi $masterPrestasi)
    {
        try {
            $masterPrestasi->toggleStatus();

            return response()->json([
                'success' => true,
                'message' => $masterPrestasi->is_active ? 'Prestasi berhasil diaktifkan' : 'Prestasi berhasil dinonaktifkan',
                'data' => $masterPrestasi->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }
    // MasterPrestasiController.php
    public function show(MasterPrestasi $masterPrestasi)
    {
        return response()->json($masterPrestasi);
    }
}


