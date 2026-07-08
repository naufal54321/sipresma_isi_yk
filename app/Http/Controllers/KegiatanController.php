<?php

namespace App\Http\Controllers;

use App\Models\Rpk;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Models\MasterKegiatan;
use App\Models\MasterPrestasi;
use Illuminate\Support\Facades\Log;

class KegiatanController extends Controller
{
    public function verifikasi()
    {
        $kegiatans = Kegiatan::with('rpk.user')->latest()->get();
        return view('dosen.kegiatan.index', compact('kegiatans'));
    }

    public function index(Rpk $rpk)
    {
        $kegiatans = $rpk->kegiatans;
        return view('mahasiswa.kegiatans.index', compact('rpk', 'kegiatans'));
    }

    public function create(Rpk $rpk)
    {
        $masterKegiatans = MasterKegiatan::where('status', 'aktif')->get();
        $prestasis = MasterPrestasi::where('is_active', true)->get();
        return view('mahasiswa.kegiatans.create', compact('rpk', 'masterKegiatans', 'prestasis'));
    }

    public function store(Request $request, Rpk $rpk)
    {
        $request->validate([
            'master_kegiatan_id' => 'required|exists:master_kegiatans,id',
            'judul_kegiatan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kategori' => 'required|in:Individu,Kelompok',
            'peran' => 'nullable|string|max:255',
            'jumlah_anggota' => 'nullable|integer|min:1',
            'anggota_ids' => 'nullable|string',
        ], [
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
        ]);

        $master = MasterKegiatan::findOrFail($request->master_kegiatan_id);

        $kegiatan = Kegiatan::create([
            'rpk_id' => $rpk->id,
            'master_kegiatan_id' => $master->id,
            'kegiatan' => $master->nama_kegiatan,
            'jenis' => $master->jenis ?? '-',
            'judul_kegiatan' => $request->judul_kegiatan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'kategori' => $request->kategori,
            'peran' => $request->kategori == 'Individu' ? 'Individu' : ($request->peran ?? 'Anggota'),
            'jumlah_anggota' => $request->kategori == 'Kelompok' ? $request->jumlah_anggota : null,
        ]);

        if ($request->filled('anggota_ids')) {
            $anggotaIds = explode(',', $request->anggota_ids);
            $anggotaIds = array_filter($anggotaIds);

            if (!empty($anggotaIds)) {
                $syncData = [];
                foreach ($anggotaIds as $userId) {
                    $syncData[$userId] = ['peran' => 'Anggota'];
                }
                $kegiatan->anggota()->sync($syncData);
            }
        }

        $rpk->update(['status' => 'draft']);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kegiatan berhasil ditambahkan',
                'data' => $kegiatan
            ]);
        }

        return redirect()
            ->route('rpks.show', $rpk->id)
            ->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function edit(Kegiatan $kegiatan)
    {
        $masterKegiatans = MasterKegiatan::where('status', 'aktif')->get();
        $prestasis = MasterPrestasi::where('is_active', true)->get();
        $rpk = $kegiatan->rpk;

        return view('mahasiswa.kegiatans.edit', compact('kegiatan', 'masterKegiatans', 'prestasis', 'rpk'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'master_kegiatan_id' => 'required|exists:master_kegiatans,id',
            'judul_kegiatan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kategori' => 'required|in:Individu,Kelompok',
            'peran' => 'nullable|string|max:255',
            'jumlah_anggota' => 'nullable|integer|min:1',
            'anggota_ids' => 'nullable|string',
        ], [
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
        ]);

        $master = MasterKegiatan::findOrFail($request->master_kegiatan_id);

        $kegiatan->update([
            'master_kegiatan_id' => $master->id,
            'kegiatan' => $master->nama_kegiatan,
            'jenis' => $master->jenis ?? '-',
            'judul_kegiatan' => $request->judul_kegiatan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'kategori' => $request->kategori,
            'peran' => $request->kategori == 'Individu' ? 'Individu' : ($request->peran ?? 'Anggota'),
            'jumlah_anggota' => $request->kategori == 'Kelompok' ? $request->jumlah_anggota : null,
        ]);

        if ($request->filled('anggota_ids')) {
            $anggotaIds = explode(',', $request->anggota_ids);
            $anggotaIds = array_filter($anggotaIds);

            if (!empty($anggotaIds)) {
                $syncData = [];
                foreach ($anggotaIds as $userId) {
                    $syncData[$userId] = ['peran' => 'Anggota'];
                }
                $kegiatan->anggota()->sync($syncData);
            } else {
                $kegiatan->anggota()->detach();
            }
        } else {
            $kegiatan->anggota()->detach();
        }

        $kegiatan->rpk->update(['status' => 'draft']);

        return redirect()
            ->route('rpks.show', $kegiatan->rpk_id)
            ->with('success', 'Kegiatan berhasil diperbarui');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        if (!in_array($kegiatan->rpk->status, ['draft', 'ditolak'])) {
            $message = 'Kegiatan tidak dapat dihapus karena RPK sedang diajukan atau sudah disetujui.';
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message
                ], 422);
            }
            
            return back()->with('error', $message);
        }

        $kegiatan->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kegiatan berhasil dihapus'
            ]);
        }

        return back()->with('success', 'Kegiatan berhasil dihapus.');
    }
}