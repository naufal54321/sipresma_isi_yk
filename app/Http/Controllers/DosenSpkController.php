<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use Illuminate\Http\Request;

class DosenSpkController extends Controller
{
    public function index()
{
    $spks = Spk::with(['user', 'rpk'])
        ->latest()
        ->get();

    return view('dosen.spk.index', compact('spks'));
}

     public function approve(Request $request, Spk $spk)
{
    $spk->update([
        'status' => 'disetujui',
        'catatan_dosen' => $request->catatan_dosen
    ]);

    return back();
}

public function reject(Request $request, Spk $spk)
{
    $spk->update([
        'status' => 'ditolak',
        'catatan_dosen' => $request->catatan_dosen
    ]);

    return back();
}

public function show(Spk $spk)
{
    return view('dosen.spk.show', compact('spk'));
}

}