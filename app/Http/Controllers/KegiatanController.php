<?php

namespace App\Http\Controllers;

use App\Models\Rpk;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Models\MasterKegiatan;



class KegiatanController extends Controller
{



public function verifikasi()
{
    $kegiatans = Kegiatan::with('rpk.user')->latest()->get();

    return view('dosen.kegiatan.index', compact('kegiatans'));
}

public function setujui(Kegiatan $kegiatan)
{
    $kegiatan->update([
        'status' => 'disetujui'
    ]);

    return back()->with('success', 'Kegiatan disetujui');
}

public function tolak(Kegiatan $kegiatan)
{
    $kegiatan->update([
        'status' => 'ditolak'
    ]);

    return back()->with('success', 'Kegiatan ditolak');
}
    /**
     * Display a listing of the resource.
     */
    public function index(Rpk $rpk)
    {
        $kegiatans = $rpk->kegiatans;

        return view('kegiatans.index', compact(
            'rpk',
            'kegiatans'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */

public function create(Rpk $rpk)
{
    $masterKegiatans = MasterKegiatan::where(
        'status',
        'aktif'
    )->get();

    return view('kegiatans.create', compact(
        'rpk',
        'masterKegiatans'
    ));
}

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request, Rpk $rpk)
{
    $request->validate([
        'master_kegiatan_id' => 'required',
        'tanggal' => 'required|date',
        'kategori' => 'required',
    ]);

    $master = MasterKegiatan::findOrFail(
        $request->master_kegiatan_id
    );

    Kegiatan::create([
        'rpk_id' => $rpk->id,
        'master_kegiatan_id' => $master->id,

        'kegiatan' => $master->nama_kegiatan,
        'jenis' => $master->jenis,
        'tingkat' => $master->tingkat,
        'hasil' => $master->hasil,

        'tanggal' => $request->tanggal,

        'kategori' => $request->kategori,

        'peran' => $request->kategori == 'Individu'
            ? 'Individu'
            : $request->peran,

        'jumlah_anggota' => $request->kategori == 'Kelompok'
            ? $request->jumlah_anggota
            : null,

        'status' => 'draft',
    ]);

    // UBAH BAGIAN INI SAJA
    return redirect()
        ->route('rpks.show', $rpk->id)
        ->with('success', 'Kegiatan berhasil ditambahkan');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kegiatan $kegiatan)
    {
        $masterKegiatans = MasterKegiatan::where('status', 'aktif')->get();
        
        // TAMBAHKAN BARIS INI (Mengambil data RPK dari relasi Kegiatan)
        $rpk = $kegiatan->rpk; 

        return view('kegiatans.edit', compact(
            'kegiatan',
            'masterKegiatans',
            'rpk' // TAMBAHKAN RPK DI SINI
        ));
    }

    /**
     * Update the specified resource in storage.
     */
   /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Kegiatan $kegiatan)
{
    $request->validate([
        'master_kegiatan_id' => 'required',
        'tanggal' => 'required|date',
        'kategori' => 'required',
    ]);

    $master = MasterKegiatan::findOrFail(
        $request->master_kegiatan_id
    );

    $kegiatan->update([
        'master_kegiatan_id' => $master->id,

        'kegiatan' => $master->nama_kegiatan,
        'jenis' => $master->jenis,
        'tingkat' => $master->tingkat,
        'hasil' => $master->hasil,

        'tanggal' => $request->tanggal,

        'kategori' => $request->kategori,

        'peran' => $request->kategori == 'Individu'
            ? 'Individu'
            : $request->peran,

        'jumlah_anggota' => $request->kategori == 'Kelompok'
            ? $request->jumlah_anggota
            : null,
    ]);

    // ---- UBAH BAGIAN INI ----
    return redirect()
        ->route('rpks.show', $kegiatan->rpk_id) // Ganti 'kegiatans.index' menjadi 'rpks.show'
        ->with('success', 'Kegiatan berhasil diperbarui');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kegiatan $kegiatan)
{
    if (!in_array($kegiatan->status, ['draft', 'ditolak'])) {
        return back()->with(
            'error',
            'Kegiatan yang sudah disetujui tidak dapat dihapus.'
        );
    }

    $kegiatan->delete();

    return back()->with(
        'success',
        'Kegiatan berhasil dihapus.'
    );
}
}