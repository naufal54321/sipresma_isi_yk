<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;

use App\Models\Rpk;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\RpkSubmitted;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KegiatanController extends Controller
{
    public function create(Rpk $rpk)
    {
        return redirect()->route('rpks.show', $rpk->id)->with('error', 'Fitur tambah kegiatan belum tersedia.');
    }

    public function store(Request $request, Rpk $rpk)
    {
        if ($rpk->user_id !== Auth::id()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat menambahkan kegiatan ke RPK ini.'
                ], 403);
            }
            abort(403, 'Anda tidak dapat menambahkan kegiatan ke RPK ini.');
        }

        if (!in_array($rpk->status, ['draft', 'ditolak'])) {
            $message = 'Kegiatan tidak dapat ditambahkan karena RPK sedang diajukan atau sudah disetujui.';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->with('error', $message);
        }

        $request->validate([
            'kkm_rule_id' => 'required|exists:point_rules,id',
            'judul_kegiatan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kategori' => 'required|in:Individu,Kelompok',
            'jumlah_anggota' => 'nullable|integer|min:1',
            'anggota_ids' => 'nullable|string',
        ], [
            'kkm_rule_id.required' => 'Aturan KKM wajib dipilih',
            'kkm_rule_id.exists' => 'Aturan KKM tidak valid',
            'judul_kegiatan.required' => 'Judul kegiatan wajib diisi',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
        ]);

        $kkmRule = \App\Models\PointRule::with('activityType')->findOrFail($request->kkm_rule_id);

        $count = Kegiatan::whereHas('pointRule.activityType', function ($q) use ($kkmRule) {
            $q->where('name', $kkmRule->activityType->name);
        })->whereHas('rpk', function ($q) {
            $q->where('user_id', Auth::id());
        })->count();

        if ($count >= 4) {
            $message = "Batas maksimal 4 kegiatan untuk jenis \"{$kkmRule->activityType->name}\" sudah tercapai.";
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->with('error', $message);
        }

        $kegiatan = Kegiatan::create([
            'rpk_id' => $rpk->id,
            'point_rule_id' => $kkmRule->id,
            'kegiatan' => $kkmRule->activityType->name,
            'judul_kegiatan' => $request->judul_kegiatan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'kategori' => $request->kategori,
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

        if ($rpk->dosen_pembimbing_id) {
            $dosen = \App\Models\User::find($rpk->dosen_pembimbing_id);
            if ($dosen && $dosen->email) {
                try {
                    Mail::to($dosen)->send(new RpkSubmitted($rpk->refresh(), 'Dosen'));
                } catch (\Throwable $e) {
                    Log::warning('Gagal kirim email RPK submitted ke dosen: ' . $e->getMessage());
                }
            }
        }

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

    public function edit(Request $request, Kegiatan $kegiatan)
    {
        if ($kegiatan->rpk->user_id !== Auth::id()) abort(403);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $kegiatan,
            ]);
        }

        return redirect()->route('rpks.show', $kegiatan->rpk_id)
            ->with('error', 'Fitur edit kegiatan belum tersedia.');
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        if ($kegiatan->rpk->user_id !== Auth::id()) abort(403);

        if (!in_array($kegiatan->rpk->status, ['draft', 'ditolak'])) {
            $message = 'Kegiatan tidak dapat diubah karena RPK sedang diajukan atau sudah disetujui.';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->with('error', $message);
        }

        $request->validate([
            'kkm_rule_id' => 'required|exists:point_rules,id',
            'judul_kegiatan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kategori' => 'required|in:Individu,Kelompok',
            'jumlah_anggota' => 'nullable|integer|min:1',
            'anggota_ids' => 'nullable|string',
        ], [
            'kkm_rule_id.required' => 'Aturan KKM wajib dipilih',
            'kkm_rule_id.exists' => 'Aturan KKM tidak valid',
            'judul_kegiatan.required' => 'Judul kegiatan wajib diisi',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
        ]);

        $kkmRule = \App\Models\PointRule::with('activityType')->findOrFail($request->kkm_rule_id);

        $kegiatan->update([
            'point_rule_id' => $kkmRule->id,
            'kegiatan' => $kkmRule->activityType->name,
            'judul_kegiatan' => $request->judul_kegiatan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'kategori' => $request->kategori,
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

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kegiatan berhasil diperbarui',
                'data' => $kegiatan->fresh()->load('pointRule')
            ]);
        }

        return redirect()
            ->route('rpks.show', $kegiatan->rpk_id)
            ->with('success', 'Kegiatan berhasil diperbarui');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        if ($kegiatan->rpk->user_id !== Auth::id()) abort(403);
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

