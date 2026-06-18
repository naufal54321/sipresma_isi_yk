<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\Rpk;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpkController extends Controller
{
    /**
     * Menampilkan daftar SPK
     */
    public function index(Request $request)
    {
        $filterTahun = $request->tahun;
        $filterStatus = $request->status;

        $spks = Spk::with(['rpk', 'kegiatan'])
            ->where('user_id', Auth::id())
            ->when($filterTahun, function ($q) use ($filterTahun) {
                $q->where('tahun', $filterTahun);
            })
            ->when($filterStatus, function ($q) use ($filterStatus) {
                $q->where('status', $filterStatus);
            })
            ->latest()
            ->get();

        // RPK untuk dropdown
        $rpks = Rpk::where('user_id', Auth::id())
            ->where('status', 'disetujui')
            ->get();

        // Semua kegiatan dari RPK yang disetujui
        $kegiatans = Kegiatan::whereHas('rpk', function ($q) {
            $q->where('user_id', Auth::id())
                ->where('status', 'disetujui');
        })
            ->select('id', 'rpk_id', 'kegiatan')
            ->get();

        return view('spks.index', compact(
            'spks',
            'rpks',
            'kegiatans'
        ));
    }

    public function create()
    {
        $rpks = Rpk::where('user_id', Auth::id())->get();

        $kegiatans = Kegiatan::whereHas('rpk', function ($query) {
            $query->where('user_id', Auth::id())
                ->where('status', 'disetujui');
        })
            ->select('id', 'rpk_id', 'kegiatan')
            ->get();

        return view('spks.create', compact(
            'rpks',
            'kegiatans'
        ));
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
        // Validasi kegiatan harus sesuai RPK yang dipilih
        $kegiatan = Kegiatan::where('id', $request->kegiatan_id)
            ->where('rpk_id', $request->rpk_id)
            ->whereHas('rpk', function ($query) {
                $query->where('user_id', Auth::id())
                    ->where('status', 'disetujui');
            })
            ->first();

        if (!$kegiatan) {
            return back()
                ->withErrors([
                    'kegiatan_id' => 'Kegiatan tidak sesuai dengan RPK yang dipilih atau RPK belum disetujui.'
                ])
                ->withInput();
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
    if ($spk->user_id != Auth::id()) {
        abort(403);
    }

    if (!in_array($spk->status, ['draft', 'ditolak'])) {
        return back()->with(
            'error',
            'SPK yang sudah disetujui tidak dapat dihapus.'
        );
    }

    // Tambahkan ini: Hapus file bukti fisik
    if ($spk->bukti && \Illuminate\Support\Facades\Storage::disk('public')->exists($spk->bukti)) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($spk->bukti);
    }

    $spk->delete();

    return redirect()
        ->route('spks.index')
        ->with('success', 'SPK berhasil dihapus.');
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

    public function edit(Spk $spk)
    {
        if ($spk->user_id != Auth::id()) {
            abort(403);
        }

        $rpks = Rpk::where('user_id', Auth::id())->get();

        $kegiatans = Kegiatan::whereHas('rpk', function ($q) {
            $q->where('user_id', Auth::id())
                ->where('status', 'disetujui');
        })->get();

        return view('spks.edit', compact(
            'spk',
            'rpks',
            'kegiatans'
        ));
    }

    public function update(Request $request, Spk $spk)
{
    if ($spk->user_id != Auth::id()) {
        abort(403);
    }

    $request->validate([
        'tahun' => 'required',
        'rpk_id' => 'required',
        'kegiatan_id' => 'required',
        'tanggal_kegiatan' => 'required|date', // Tambahkan validasi date
        'penyelenggara' => 'required',
        'kategori' => 'required',
        'keterangan' => 'required',
        'bukti' => 'nullable|mimes:pdf|max:5120' // Tambahkan validasi file! (Nullable karena user boleh tidak ganti file)
    ]);

    $data = [
        'tahun' => $request->tahun,
        'rpk_id' => $request->rpk_id,
        'kegiatan_id' => $request->kegiatan_id,
        'tanggal_kegiatan' => $request->tanggal_kegiatan,
        'penyelenggara' => $request->penyelenggara,
        'kategori' => $request->kategori,
        'url_kegiatan' => $request->url_kegiatan,
        'keterangan' => $request->keterangan,
        'status' => 'draft',
        'catatan_dosen' => null
    ];

    if ($request->hasFile('bukti')) {
        // (Opsional tapi disarankan) Hapus file lama jika ada
        if ($spk->bukti && \Illuminate\Support\Facades\Storage::disk('public')->exists($spk->bukti)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($spk->bukti);
        }
        
        $data['bukti'] = $request->file('bukti')->store('bukti-spk', 'public');
    }

    $spk->update($data);

    return redirect()
        ->route('spks.index')
        ->with('success', 'SPK berhasil diperbaiki dan diajukan ulang');
}
}
