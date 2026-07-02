<?php

namespace App\Http\Controllers;

use App\Models\MasterKegiatan;
use Illuminate\Http\Request;

class MasterKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterKegiatan::query();

        // Pencarian Teks
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_kegiatan', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kegiatans = $query->latest()->paginate(10)->withQueryString();

        return view('admin.kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        return view('admin.kegiatan.create');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'nama_kegiatan' => 'required|string|max:255',
            'status' => 'required|in:aktif,tidak aktif',
        ], [
            'nama_kegiatan.required' => 'Nama kegiatan wajib diisi',
            'nama_kegiatan.max' => 'Nama kegiatan maksimal 255 karakter',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            // Response untuk AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            // Response untuk traditional form submit
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan data
        try {
            $kegiatan = MasterKegiatan::create([
                'nama_kegiatan' => $request->nama_kegiatan,
                'status' => $request->status,
            ]);

            // Response untuk AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kegiatan berhasil ditambahkan',
                    'data' => $kegiatan
                ], 201);
            }

            // Response untuk traditional form submit
            return redirect()
                ->route('admin.kegiatan.index')
                ->with('success', 'Data berhasil ditambahkan');
                
        } catch (\Exception $e) {
            // Response untuk AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan data: ' . $e->getMessage()
                ], 500);
            }

            // Response untuk traditional form submit
            return redirect()
                ->back()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(MasterKegiatan $kegiatan)
    {
        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, MasterKegiatan $kegiatan)
    {
        $validator = \Validator::make($request->all(), [
            'nama_kegiatan' => 'required|string|max:255',
            'status' => 'required|in:aktif,tidak aktif',
        ], [
            'nama_kegiatan.required' => 'Nama kegiatan wajib diisi',
            'nama_kegiatan.max' => 'Nama kegiatan maksimal 255 karakter',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            // Response untuk AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            // Response untuk traditional form submit
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update data
        try {
            $kegiatan->update([
                'nama_kegiatan' => $request->nama_kegiatan,
                'status' => $request->status,
            ]);

            // Response untuk AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kegiatan berhasil diperbarui',
                    'data' => $kegiatan
                ]);
            }

            // Response untuk traditional form submit
            return redirect()
                ->route('admin.kegiatan.index')
                ->with('success', 'Kegiatan berhasil diperbarui');
                
        } catch (\Exception $e) {
            // Response untuk AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui data: ' . $e->getMessage()
                ], 500);
            }

            // Response untuk traditional form submit
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(MasterKegiatan $kegiatan)
    {
        try {
            $namaKegiatan = $kegiatan->nama_kegiatan;
            $kegiatan->delete();

            // Response untuk AJAX
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Kegiatan \"{$namaKegiatan}\" berhasil dihapus"
                ]);
            }

            // Response untuk traditional form submit
            return redirect()
                ->route('admin.kegiatan.index')
                ->with('success', 'Data kegiatan berhasil dihapus');
                
        } catch (\Exception $e) {
            // Response untuk AJAX
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus data: ' . $e->getMessage()
                ], 500);
            }

            // Response untuk traditional form submit
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}