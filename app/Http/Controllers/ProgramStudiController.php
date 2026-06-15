<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    public function index()
    {
        $prodis = ProgramStudi::latest()->get();
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