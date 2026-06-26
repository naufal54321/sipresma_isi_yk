<?php

namespace App\Http\Controllers;

use App\Models\MasterPrestasi;
use Illuminate\Http\Request;

class MasterPrestasiController extends Controller
{
    public function index()
    {
        $prestasis = MasterPrestasi::latest()->paginate(10);
        return view('admin.master-prestasi.index', compact('prestasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'juara' => 'required|string|max:255',
            'poin' => 'required|integer|min:0',
            'tingkat' => 'required|string|in:Universitas,Regional,Nasional,Internasional', // 🔧 Validasi tingkat
            'is_active' => 'required|in:0,1',
        ]);

        MasterPrestasi::create([
            'juara' => $request->juara,
            'poin' => $request->poin,
            'tingkat' => $request->tingkat, // 🔧 Simpan tingkat
            'is_active' => $request->is_active == 1,
        ]);

        return back()->with('success', 'Data Master Prestasi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'juara' => 'required|string|max:255',
            'poin' => 'required|integer|min:0',
            'tingkat' => 'required|string|in:Universitas,Regional,Nasional,Internasional', // 🔧 Validasi tingkat
            'is_active' => 'required|in:0,1',
        ]);

        $prestasi = MasterPrestasi::findOrFail($id);

        $prestasi->update([
            'juara' => $request->juara,
            'poin' => $request->poin,
            'tingkat' => $request->tingkat, // 🔧 Update tingkat
            'is_active' => $request->is_active,
        ]);

        return back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $prestasi = MasterPrestasi::findOrFail($id);
        $prestasi->delete();

        return back()->with('success', 'Data berhasil dihapus!');
    }
}