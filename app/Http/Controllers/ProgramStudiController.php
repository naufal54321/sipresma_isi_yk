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
            $query->where('nama_prodi', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $prodis = $query->latest()->paginate(10)->withQueryString();

        return view('admin.prodi.index', compact('prodis'));
    }

    /**
     * Show single prodi for AJAX edit.
     */
    public function show(ProgramStudi $prodi)
    {
        // Kembalikan data prodi sebagai JSON
        return response()->json($prodi);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'nama_prodi' => 'required|string|max:255|unique:program_studis,nama_prodi',
            'status' => 'required|in:aktif,tidak aktif'
        ], [
            'nama_prodi.required' => 'Nama program studi wajib diisi',
            'nama_prodi.unique' => 'Nama program studi sudah terdaftar',
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
            $prodi = ProgramStudi::create($request->all());

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
            'status' => 'required|in:aktif,tidak aktif'
        ], [
            'nama_prodi.required' => 'Nama program studi wajib diisi',
            'nama_prodi.unique' => 'Nama program studi sudah terdaftar',
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
            $prodi->update($request->all());

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
}