<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Rpk;
use App\Models\User;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\RpkStatusNotification;
use App\Mail\PlottingMahasiswa;

class RpkController extends Controller
{
    public function index(Request $request)
    {
        $query = Rpk::with(['user', 'dosenPembimbing']);

        // 1. Filter Pencarian (Nama Mhs, NIM, atau Judul Kegiatan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%")
                      ->orWhere('nim', 'like', "%{$search}%");
                })->orWhereHas('kegiatans', fn($k) => $k->where('kegiatan', 'like', "%{$search}%"));
            });
        }

        // 2. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Filter Dosen Pembimbing — langsung dari kolom rpks.dosen_pembimbing_id
        if ($request->filled('dosen_id')) {
            if ($request->dosen_id === 'tanpa_dosen') {
                $query->whereNull('dosen_pembimbing_id');
            } else {
                $query->where('dosen_pembimbing_id', $request->dosen_id);
            }
        }

        $rpks = $query->latest()->paginate(10)->withQueryString();
        
        $dosens = User::role('Dosen')->where('status', 'aktif')->orderBy('name')->get();

        return view('admin.rpk.index', compact('rpks', 'dosens'));
    }

    public function dosenList()
    {
        $dosens = User::role('Dosen')
            ->where('status', 'aktif')
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($dosens->map(fn($d) => [
            'id' => (string) $d->id,
            'name' => $d->name,
        ]));
    }

    public function show(Rpk $rpk)
    {
        $rpk->load(['user', 'dosenPembimbing', 'verifiedBy']);
        return view('admin.rpk.show', compact('rpk'));
    }

    /**
     * AJAX: Atur dosen pembimbing untuk RPK
     */
    public function setPembimbing(Request $request, Rpk $rpk)
    {
        $request->validate([
            'dosen_id' => 'nullable|exists:users,id',
        ]);

        $rpk->update(['dosen_pembimbing_id' => $request->dosen_id ?: null]);
        DashboardService::clearAdminCache();

        // ⚡ NOTIFIKASI: Email ke dosen jika ditetapkan
        $emailSent = false;
        if ($request->dosen_id) {
            $dosen = User::find($request->dosen_id);
            if ($dosen && $dosen->email) {
                try {
                    Mail::to($dosen)->send(new PlottingMahasiswa($rpk->fresh(), $dosen));
                    $emailSent = true;
                } catch (\Throwable $e) {
                    Log::warning('Gagal kirim email plotting ke dosen: ' . $e->getMessage());
                }
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $request->dosen_id ? 'Dosen pembimbing berhasil diatur.' : 'Dosen pembimbing berhasil dihapus.',
                'dosen_name' => $request->dosen_id ? User::find($request->dosen_id)?->name : null,
                'email_sent' => $emailSent,
            ]);
        }

        return back()->with('success', 'Dosen pembimbing berhasil diatur.');
    }

    public function updateStatus(Request $request, Rpk $rpk)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak,draft',
            'catatan' => 'nullable|string|max:500'
        ]);

        $rpk->update([
            'status' => $request->status,
            'catatan_dosen' => $request->catatan ?? $rpk->catatan_dosen,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);
        DashboardService::clearAdminCache();

        // ⚡ NOTIFIKASI: Email ke mahasiswa saat admin menyetujui/menolak RPK
        if (in_array($request->status, ['disetujui', 'ditolak']) && $rpk->user && $rpk->user->email) {
            try {
                Mail::to($rpk->user)->send(new RpkStatusNotification($rpk->fresh(), $request->status));
            } catch (\Throwable $e) {
                Log::warning('Gagal kirim email status RPK (admin): ' . $e->getMessage());
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status RPK berhasil diubah menjadi ' . strtoupper($request->status)
            ]);
        }

        return redirect()->route('admin.rpk.index')
            ->with('success', 'Status RPK milik ' . $rpk->user->name . ' berhasil diubah menjadi ' . strtoupper($request->status));
    }
}
