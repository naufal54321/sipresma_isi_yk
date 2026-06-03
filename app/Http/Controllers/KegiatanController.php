<?php

namespace App\Http\Controllers;

use App\Models\Rpk;
use App\Models\Kegiatan;
use Illuminate\Http\Request;


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
        return view('kegiatans.create', compact('rpk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Rpk $rpk)
    {
        $request->validate([
            'kegiatan' => 'required',
            'jenis' => 'required',
            'tingkat' => 'required',
            'hasil' => 'required',
            'tanggal' => 'required|date',
            'peran' => 'required',
            'jumlah_anggota' =>
                'nullable|required_if:peran,Ketua|integer'
        ]);

        Kegiatan::create([
            'rpk_id' => $rpk->id,
            'kegiatan' => $request->kegiatan,
            'jenis' => $request->jenis,
            'tingkat' => $request->tingkat,
            'hasil' => $request->hasil,
            'tanggal' => $request->tanggal,
            'peran' => $request->peran,
            'jumlah_anggota' => $request->jumlah_anggota,
            'status' => 'draft'
        ]);

        return redirect()
            ->route('kegiatans.index', $rpk->id)
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}