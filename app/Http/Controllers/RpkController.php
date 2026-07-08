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
    public function index(Request $request)
    {
        $filterTahun = $request->tahun;
        $filterSemester = $request->semester;
        $filterStatus = $request->status;

        $query = Rpk::with(['user', 'kegiatans']);

        if (Auth::user()->hasRole('Mahasiswa')) {
            $userId = Auth::id();
            $query->where(function ($q) use ($userId) {
                $q->where('user_id', $userId);
                $q->orWhereHas('kegiatans.anggota', function ($subQ) use ($userId) {
                    $subQ->where('user_id', $userId);
                });
            });
        }

        if ($filterTahun) {
            $query->where('tahun', $filterTahun);
        }

        if ($filterSemester) {
            $query->where('semester', $filterSemester);
        }

        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        $rpks = $query->latest()->get();

        return view('mahasiswa.rpks.index', compact('rpks'));
    }

    /**
     * Form tambah RPK
     */
    public function create()
    {
        $masterKegiatans = MasterKegiatan::where('status', 'aktif')->get();
        return view('mahasiswa.rpks.create', compact('masterKegiatans'));
    }

    /**
     * Simpan RPK (SUPPORT AJAX)
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
        ]);

        $rpk = Rpk::create([
            'user_id' => Auth::id(),
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'status' => 'draft',
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'RPK berhasil dibuat',
                'data' => $rpk->load('user')
            ]);
        }

        return redirect()->route('rpks.index')->with('success', 'RPK berhasil dibuat');
    }

    /**
     * Detail RPK + daftar kegiatan
     */
    public function show(Rpk $rpk)
    {
        $user = Auth::user();

        if ($user->hasRole(['Admin', 'Dosen'])) {
            $rpk->load(['user', 'kegiatans.masterKegiatan.anggota']);
            $masterKegiatans = MasterKegiatan::where('status', 'aktif')->get();
            $isPemilik = false;
            $isAnggota = false;

            return view('mahasiswa.rpks.show', compact('rpk', 'masterKegiatans', 'isPemilik', 'isAnggota'));
        }

        $isPemilik = $rpk->user_id == $user->id;
        $isAnggota = !$isPemilik && $rpk->kegiatans()
            ->whereHas('anggota', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->exists();

        if (!$isPemilik && !$isAnggota) {
            abort(403, 'Anda tidak memiliki akses ke RPK ini.');
        }

        $rpk->load([
            'user',
            'kegiatans' => function ($q) use ($user, $isAnggota) {
                if ($isAnggota) {
                    $q->whereHas('anggota', function ($subQ) use ($user) {
                        $subQ->where('user_id', $user->id);
                    });
                }
                $q->with(['masterKegiatan', 'anggota']);
            }
        ]);

        $masterKegiatans = MasterKegiatan::where('status', 'aktif')->get();

        return view('mahasiswa.rpks.show', compact('rpk', 'masterKegiatans', 'isPemilik', 'isAnggota'));
    }

    /**
     * Form edit RPK
     */
    public function edit(Rpk $rpk)
    {
        if (Auth::user()->hasRole('Mahasiswa') && $rpk->user_id != Auth::id()) {
            abort(403, 'Anda tidak dapat mengedit RPK ini.');
        }

        if (!in_array($rpk->status, ['draft', 'ditolak'])) {
            return back()->with('error', 'RPK yang sudah diajukan/disetujui tidak dapat diedit.');
        }

        return view('mahasiswa.rpks.edit', compact('rpk'));
    }

    /**
     * Update RPK
     */
    public function update(Request $request, Rpk $rpk)
    {
        if (Auth::user()->hasRole('Mahasiswa') && $rpk->user_id != Auth::id()) {
            abort(403, 'Anda tidak dapat mengupdate RPK ini.');
        }

        $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'kategori' => 'required',
        ]);

        $rpk->update([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'kategori' => $request->kategori,
            'status' => 'draft',
        ]);

        return redirect()->route('rpks.index')->with('success', 'RPK berhasil diupdate');
    }

    /**
     * Hapus RPK (SUPPORT AJAX)
     */
    public function destroy(Rpk $rpk)
    {
        if (Auth::user()->hasRole('Mahasiswa') && $rpk->user_id != Auth::id()) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat menghapus RPK ini.'
                ], 403);
            }
            abort(403, 'Anda tidak dapat menghapus RPK ini.');
        }

        $rpk->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'RPK berhasil dihapus'
            ]);
        }

        return redirect()->route('rpks.index')->with('success', 'RPK berhasil dihapus');
    }
}