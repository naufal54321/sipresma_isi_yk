<?php

namespace App\Http\Controllers;

use App\Models\MasterKegiatan;
use Illuminate\Http\Request;

class MasterKegiatanController extends Controller
{
   
   public function index(Request $request)
{
    $query = MasterKegiatan::query();

    if ($request->filled('search')) {

        $query->where(function ($q) use ($request) {

            $q->where('nama_kegiatan', 'like', '%' . $request->search . '%')
              ->orWhere('jenis', 'like', '%' . $request->search . '%')
              ->orWhere('tingkat', 'like', '%' . $request->search . '%')
              ->orWhere('hasil', 'like', '%' . $request->search . '%')
              ->orWhere('status', 'like', '%' . $request->search . '%');
        });
    }

    $kegiatans = $query->latest()->get();

    return view('admin.kegiatan.index', compact('kegiatans'));
}

    public function create()
    {
        return view('admin.kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'jenis' => 'required',
            'tingkat' => 'required',
            'hasil' => 'required',
            'poin' => 'required|numeric',
            'status' => 'required',
        ]);

        MasterKegiatan::create($request->all());

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(MasterKegiatan $kegiatan)
{
    return view('admin.kegiatan.edit', compact('kegiatan'));
}

public function update(Request $request, MasterKegiatan $kegiatan)
{
    $request->validate([
        'nama_kegiatan' => 'required',
        'jenis' => 'required',
        'tingkat' => 'required',
        'hasil' => 'required',
        'poin' => 'required|numeric',
        'status' => 'required',
    ]);

    $kegiatan->update($request->all());

    return redirect()
        ->route('admin.kegiatan.index')
        ->with('success', 'Kegiatan berhasil diperbarui');
}
    
public function destroy(MasterKegiatan $kegiatan)
{
    $kegiatan->delete();

    return redirect()
        ->route('admin.kegiatan.index')
        ->with('success', 'Data kegiatan berhasil dihapus');
}



}