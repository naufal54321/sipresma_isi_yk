<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\Rpk;
use App\Models\Kegiatan;
use App\Models\MasterPrestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpkController extends Controller
{
    /**
     * Menampilkan daftar SPK
     */
    public function index(Request $request)
{
    $user = Auth::user();
    $filterTahun = $request->tahun;
    $filterStatus = $request->status;

    $query = Spk::with(['rpk', 'kegiatan', 'user']);

    // 🔧 PERBAIKAN: Semua mahasiswa bisa lihat SPK sendiri DAN SPK ketua (sebagai anggota)
    $query->where(function($q) use ($user) {
        $q->where('user_id', $user->id)  // SPK milik sendiri
          ->orWhereHas('kegiatan.anggota', function($subQ) use ($user) {
              $subQ->where('user_id', $user->id);  // SPK dari kegiatan di mana user adalah anggota
          });
    });

    $spks = $query->when($filterTahun, function ($q) use ($filterTahun) {
                $q->where('tahun', $filterTahun);
            })
            ->when($filterStatus, function ($q) use ($filterStatus) {
                $q->where('status', $filterStatus);
            })
            ->latest()
            ->get();

    $rpks = Rpk::where('user_id', $user->id)->where('status', 'disetujui')->get();

    $kegiatans = Kegiatan::whereHas('rpk', function ($q) use ($user) {
            $q->where('user_id', $user->id)->where('status', 'disetujui');
        })
        ->select('id', 'rpk_id', 'kegiatan', 'judul_kegiatan', 'tanggal', 'kategori')
        ->with('rpk')
        ->get();

    $prestasis = MasterPrestasi::where('is_active', true)->orderBy('juara')->get();

    return view('spks.index', compact('spks', 'rpks', 'kegiatans', 'prestasis'));
}

    public function create()
    {
        $rpks = Rpk::where('user_id', Auth::id())->get();
        $kegiatans = Kegiatan::whereHas('rpk', function ($query) {
            $query->where('user_id', Auth::id())->where('status', 'disetujui');
        })->select('id', 'rpk_id', 'kegiatan')->get();

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
            'prestasi_id' => 'required|exists:master_prestasis,id',
            'poin' => 'required|integer|min:0',
            'tingkat' => 'nullable|string|max:255',
            'bukti' => 'required|mimes:pdf|max:5120',
            'keterangan' => 'required'
        ]);

        $kegiatan = Kegiatan::where('id', $request->kegiatan_id)
            ->where('rpk_id', $request->rpk_id)
            ->whereHas('rpk', function ($query) {
                $query->where('user_id', Auth::id())->where('status', 'disetujui');
            })
            ->first();

        if (!$kegiatan) {
            return back()->withErrors([
                'kegiatan_id' => 'Kegiatan tidak sesuai dengan RPK yang dipilih atau RPK belum disetujui.'
            ])->withInput();
        }

        $prestasi = MasterPrestasi::findOrFail($request->prestasi_id);
        $file = $request->file('bukti')->store('bukti-spk', 'public');

        Spk::create([
            'user_id' => Auth::id(),
            'rpk_id' => $request->rpk_id,
            'kegiatan_id' => $request->kegiatan_id,
            'tahun' => $request->tahun,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'penyelenggara' => $request->penyelenggara,
            'kategori' => $request->kategori,
            'prestasi_id' => $request->prestasi_id,
            'hasil' => $prestasi->juara,
            'judul_kegiatan' => $kegiatan->judul_kegiatan ?? $kegiatan->kegiatan, // 🔧 DARI KEGIATAN RPK
            'poin' => $request->poin,
            'tingkat' => $prestasi->tingkat,
            'url_kegiatan' => $request->url_kegiatan,
            'bukti' => $file,
            'keterangan' => $request->keterangan,
            'status' => 'draft'
        ]);

        return redirect()->route('spks.index')->with('success', 'SPK berhasil ditambahkan');
    }

    public function show(Spk $spk)
    {
        $user = Auth::user();
        $isPemilik = $spk->user_id == $user->id;
        $isAnggota = !$isPemilik && $spk->kegiatan && $spk->kegiatan->anggota()->where('user_id', $user->id)->exists();
        
        if (!$isPemilik && !$isAnggota && !$user->hasRole(['Admin', 'Dosen'])) {
            abort(403, 'Anda tidak memiliki akses ke SPK ini.');
        }

        return view('spks.show', compact('spk'));
    }

    public function destroy(Spk $spk)
    {
        if ($spk->user_id != Auth::id()) {
            abort(403);
        }

        if (!in_array($spk->status, ['draft', 'ditolak'])) {
            return back()->with('error', 'SPK yang sudah disetujui tidak dapat dihapus.');
        }

        if ($spk->bukti && \Illuminate\Support\Facades\Storage::disk('public')->exists($spk->bukti)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($spk->bukti);
        }

        $spk->delete();
        return redirect()->route('spks.index')->with('success', 'SPK berhasil dihapus.');
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
            $q->where('user_id', Auth::id())->where('status', 'disetujui');
        })->get();
        $prestasis = MasterPrestasi::where('is_active', true)->orderBy('juara')->get();

        return view('spks.edit', compact('spk', 'rpks', 'kegiatans', 'prestasis'));
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
            'tanggal_kegiatan' => 'required|date',
            'penyelenggara' => 'required',
            'kategori' => 'required',
            'prestasi_id' => 'required|exists:master_prestasis,id',
            'poin' => 'required|integer|min:0',
            'tingkat' => 'nullable|string|max:255',
            'keterangan' => 'required',
            'bukti' => 'nullable|mimes:pdf|max:5120'
        ]);

        $kegiatan = Kegiatan::findOrFail($request->kegiatan_id); // 🔧 AMBIL KEGIATAN
        $prestasi = MasterPrestasi::findOrFail($request->prestasi_id);

        $data = [
            'tahun' => $request->tahun,
            'rpk_id' => $request->rpk_id,
            'kegiatan_id' => $request->kegiatan_id,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'penyelenggara' => $request->penyelenggara,
            'kategori' => $request->kategori,
            'prestasi_id' => $request->prestasi_id,
            'hasil' => $prestasi->juara,
            'judul_kegiatan' => $kegiatan->judul_kegiatan ?? $kegiatan->kegiatan, // 🔧 DARI KEGIATAN RPK
            'poin' => $request->poin,
            'tingkat' => $prestasi->tingkat,
            'url_kegiatan' => $request->url_kegiatan,
            'keterangan' => $request->keterangan,
            'status' => 'draft',
            'catatan_dosen' => null
        ];

        if ($request->hasFile('bukti')) {
            if ($spk->bukti && \Illuminate\Support\Facades\Storage::disk('public')->exists($spk->bukti)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($spk->bukti);
            }
            $data['bukti'] = $request->file('bukti')->store('bukti-spk', 'public');
        }

        $spk->update($data);
        return redirect()->route('spks.index')->with('success', 'SPK berhasil diperbaiki dan diajukan ulang');
    }
}