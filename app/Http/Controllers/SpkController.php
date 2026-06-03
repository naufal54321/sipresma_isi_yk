<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\Rpk;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpkController extends Controller
{
    public function index()
    {
        $spks = Spk::with(['rpk', 'kegiatan'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('spks.index', compact('spks'));
    }

    public function create()
    {
        $rpks = Rpk::where('user_id', Auth::id())->get();

        // 🔥 FIX: hanya kegiatan milik user + sudah disetujui
        $kegiatans = Kegiatan::whereHas('rpk', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->where('status', 'disetujui')
            ->get();

        return view('spks.create', compact('rpks', 'kegiatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'rpk_id' => 'required',
            'kegiatan_id' => 'required',
            'tanggal_kegiatan' => 'required|date',
            'penyelenggara' => 'required',
            'kategori' => 'required',
            'bukti' => 'required|mimes:pdf|max:5120',
            'keterangan' => 'required'
        ]);

        // 🔥 FIX: validasi kegiatan wajib disetujui
        $kegiatan = Kegiatan::findOrFail($request->kegiatan_id);

        if ($kegiatan->status !== 'disetujui') {
            return back()->with('error', 'SPK hanya bisa dibuat dari kegiatan yang sudah disetujui');
        }

        $file = $request->file('bukti')->store('bukti-spk', 'public');

        Spk::create([
            'user_id' => Auth::id(),
            'rpk_id' => $request->rpk_id,
            'kegiatan_id' => $request->kegiatan_id,
            'tahun' => $request->tahun,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'penyelenggara' => $request->penyelenggara,
            'kategori' => $request->kategori,
            'url_kegiatan' => $request->url_kegiatan,
            'bukti' => $file,
            'keterangan' => $request->keterangan,
            'status' => 'draft'
        ]);

        return redirect()
            ->route('spks.index')
            ->with('success', 'SPK berhasil ditambahkan');
    }

    public function show(Spk $spk)
    {
        return view('spks.show', compact('spk'));
    }

    public function destroy(Spk $spk)
    {
        $spk->delete();

        return redirect()->route('spks.index')
            ->with('success', 'SPK berhasil dihapus');
    }

    public function approve(Request $request, Spk $spk)
    {
        $spk->update([
            'status' => 'disetujui',
            'catatan_dosen' => $request->catatan_dosen
        ]);

        return back()->with('success', 'SPK disetujui');
    }

    public function reject(Request $request, Spk $spk)
    {
        $spk->update([
            'status' => 'ditolak',
            'catatan_dosen' => $request->catatan_dosen
        ]);

        return back()->with('success', 'SPK ditolak');
    }
}