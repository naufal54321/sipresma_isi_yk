<?php

namespace App\Http\Controllers;

use App\Models\Rpk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterKegiatan;

class RpkController extends Controller
{
    /**
     * Menampilkan daftar RPK
     */
    public function index()
    {
        $rpks = Rpk::where('user_id', Auth::id())
            ->withCount('kegiatans')
            ->latest()
            ->get();

        return view('rpks.index', compact('rpks'));
    }

    /**
     * Form tambah RPK
     */
    public function create()
    {
         $masterKegiatans = MasterKegiatan::where(
        'status',
        'aktif'
    )->get();

    return view(
        'rpks.create',
        compact('masterKegiatans')
    );
    }

    /**
     * Simpan RPK
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
            
        ]);

        Rpk::create([
            'user_id' => Auth::id(),
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            
        ]);

        return redirect()
            ->route('rpks.index')
            ->with('success', 'RPK berhasil ditambahkan');
    }

    /**
     * Detail RPK + daftar kegiatan
     */
    /**
     * Detail RPK + daftar kegiatan
     */
    public function show(Rpk $rpk)
    {
        // Load relasi kegiatan bawaan RPK
        $rpk->load('kegiatans');

        // MENGAMBIL DATA MASTER KEGIATAN (Sama seperti di method create)
        $masterKegiatans = MasterKegiatan::where('status', 'aktif')->get();

        // MENGIRIMKAN KEDUA VARIABEL KE VIEW
        return view('rpks.show', compact('rpk', 'masterKegiatans'));
    }

    /**
     * Form edit RPK
     */
    public function edit(Rpk $rpk)
    {
        return view('rpks.edit', compact('rpk'));
    }

    /**
     * Update RPK
     */
    public function update(Request $request, Rpk $rpk)
    {
        $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'kategori' => 'required',
        ]);

        $rpk->update([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'kategori' => $request->kategori,
        ]);

        return redirect()
            ->route('rpks.index')
            ->with('success', 'RPK berhasil diupdate');
    }

    /**
     * Hapus RPK
     */
    public function destroy(Rpk $rpk)
    {
        $rpk->delete();

        return redirect()
            ->route('rpks.index')
            ->with('success', 'RPK berhasil dihapus');
    }
}