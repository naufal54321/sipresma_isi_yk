<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    public function index(Request $request)
    {
        $query = ProgramStudi::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_prodi', 'like', '%' . $request->search . '%')
                  ->orWhere('fakultas', 'like', '%' . $request->search . '%'); // ⚡ TAMBAH: cari juga di fakultas
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ⚡ TAMBAH: Filter fakultas
        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        $prodis = $query->latest()->paginate(10)->withQueryString();

        // ⚡ TAMBAH: List fakultas untuk dropdown filter
        $fakultasList = ProgramStudi::select('fakultas')
            ->distinct()
            ->whereNotNull('fakultas')
            ->orderBy('fakultas')
            ->pluck('fakultas');

        return view('admin.prodi.index', compact('prodis', 'fakultasList'));
    }

    /**
     * Show single prodi for AJAX edit.
     */
    public function show(ProgramStudi $prodi)
    {
        return response()->json($prodi);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'nama_prodi' => 'required|string|max:255|unique:program_studis,nama_prodi',
            'fakultas' => 'nullable|string|max:255', // ⚡ TAMBAH
            'status' => 'required|in:aktif,tidak aktif'
        ], [
            'nama_prodi.required' => 'Nama program studi wajib diisi',
            'nama_prodi.unique' => 'Nama program studi sudah terdaftar',
            'fakultas.max' => 'Nama fakultas maksimal 255 karakter', // ⚡ TAMBAH
            'status.required' => 'Status wajib dipilih',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $prodi = ProgramStudi::create([
                'nama_prodi' => $request->nama_prodi,
                'fakultas' => $request->fakultas, // ⚡ TAMBAH
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Program Studi berhasil ditambahkan',
                'data' => $prodi
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, ProgramStudi $prodi)
    {
        $validator = \Validator::make($request->all(), [
            'nama_prodi' => 'required|string|max:255|unique:program_studis,nama_prodi,' . $prodi->id,
            'fakultas' => 'nullable|string|max:255', // ⚡ TAMBAH
            'status' => 'required|in:aktif,tidak aktif'
        ], [
            'nama_prodi.required' => 'Nama program studi wajib diisi',
            'nama_prodi.unique' => 'Nama program studi sudah terdaftar',
            'fakultas.max' => 'Nama fakultas maksimal 255 karakter', // ⚡ TAMBAH
            'status.required' => 'Status wajib dipilih',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $prodi->update([
                'nama_prodi' => $request->nama_prodi,
                'fakultas' => $request->fakultas, // ⚡ TAMBAH
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Program Studi berhasil diupdate',
                'data' => $prodi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(ProgramStudi $prodi)
    {
        try {
            $prodi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Program Studi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(ProgramStudi $prodi)
    {
        try {
            $prodi->toggleStatus();
            return response()->json([
                'success' => true,
                'message' => 'Status Program Studi berhasil diubah',
                'data' => $prodi->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ⚡ TAMBAH: Get list fakultas untuk dropdown
     */
    public function getFakultas()
    {
        $fakultas = ProgramStudi::select('fakultas')
            ->distinct()
            ->whereNotNull('fakultas')
            ->orderBy('fakultas')
            ->pluck('fakultas');

        return response()->json($fakultas);
    }
}