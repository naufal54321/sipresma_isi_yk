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

    // Pencarian Nama Program Studi
    if ($request->filled('search')) {
        $query->where('nama_prodi', 'like', '%' . $request->search . '%');
    }

    // Filter Status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $prodis = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('admin.prodi.index', compact('prodis'));
}

    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255|unique:program_studis,nama_prodi',
            'status' => 'required'
        ]);

        ProgramStudi::create([
            'nama_prodi' => $request->nama_prodi,
            'status' => $request->status
        ]);

        return redirect()
            ->route('admin.prodi.index')
            ->with('success', 'Program Studi berhasil ditambahkan');
    }

    public function update(Request $request, ProgramStudi $prodi)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255|unique:program_studis,nama_prodi,' . $prodi->id,
            'status' => 'required'
        ]);

        $prodi->update([
            'nama_prodi' => $request->nama_prodi,
            'status' => $request->status
        ]);

        return redirect()
            ->route('admin.prodi.index')
            ->with('success', 'Program Studi berhasil diupdate');
    }

    public function destroy(ProgramStudi $prodi)
    {
        $prodi->delete();

        return redirect()
            ->route('admin.prodi.index')
            ->with('success', 'Program Studi berhasil dihapus');
    }
}