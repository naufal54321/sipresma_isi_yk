<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;

use App\Models\Rpk;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\RpkSubmitted;

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
        DashboardService::clearAdminCache();

        // ⚡ NOTIFIKASI: Email ke Admin saat RPK dibuat oleh mahasiswa
        $admins = \App\Models\User::role('Admin')->whereNotNull('email')->get();
        if ($admins->isNotEmpty()) {
            try {
                Mail::to($admins)->send(new RpkSubmitted($rpk->refresh()));
            } catch (\Throwable $e) {
                Log::warning('Gagal kirim email RPK submitted ke admin: ' . $e->getMessage());
            }
        }

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
            $rpk->load(['user', 'kegiatans', 'verifiedBy']);
            $isPemilik = false;
            $isAnggota = false;

            return view('mahasiswa.rpks.show', compact('rpk', 'isPemilik', 'isAnggota'));
        }

        $isPemilik = $rpk->user_id == $user->id;
        $kegiatansQuery = $rpk->kegiatans();
        $isAnggota = !$isPemilik && $kegiatansQuery
            ->whereHas('anggota', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->exists();

        if (!$isPemilik && !$isAnggota) {
            abort(403, 'Anda tidak memiliki akses ke RPK ini.');
        }

        $rpk->load([
            'user',
            'verifiedBy',
            'kegiatans' => function ($q) use ($user, $isAnggota) {
                if ($isAnggota) {
                    $q->whereHas('anggota', function ($subQ) use ($user) {
                        $subQ->where('user_id', $user->id);
                    });
                }
                $q->with(['anggota']);
            }
        ]);

        $mahasiswaList = \App\Models\User::role('Mahasiswa')->where('id', '!=', $user->id)->orderBy('name')->get();

        return view('mahasiswa.rpks.show', compact('rpk', 'mahasiswaList', 'isPemilik', 'isAnggota'));
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

        return redirect()->route('rpks.show', $rpk->id)->with('error', 'Fitur edit RPK belum tersedia.');
    }

    /**
     * Update RPK
     */
    public function update(Request $request, Rpk $rpk)
    {
        if (Auth::user()->hasRole('Mahasiswa') && $rpk->user_id != Auth::id()) {
            abort(403, 'Anda tidak dapat mengupdate RPK ini.');
        }

        if (!in_array($rpk->status, ['draft', 'ditolak'])) {
            return back()->with('error', 'RPK yang sudah diajukan/disetujui tidak dapat diubah.');
        }

        $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
        ]);

        $rpk->update([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'status' => 'draft',
        ]);
        DashboardService::clearAdminCache();

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

        if (!in_array($rpk->status, ['draft', 'ditolak'])) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'RPK yang sedang diajukan atau sudah disetujui tidak dapat dihapus.'
                ], 422);
            }
            return back()->with('error', 'RPK yang sedang diajukan atau sudah disetujui tidak dapat dihapus.');
        }

        $rpk->delete();
        DashboardService::clearAdminCache();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'RPK berhasil dihapus'
            ]);
        }

        return redirect()->route('rpks.index')->with('success', 'RPK berhasil dihapus');
    }
}

