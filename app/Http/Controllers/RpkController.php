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

        // Jika mahasiswa, tampilkan RPK miliknya DAN RPK di mana dia anggota
        if (Auth::user()->hasRole('Mahasiswa')) {
            $userId = Auth::id();
            
            $query->where(function($q) use ($userId) {
                // RPK milik sendiri
                $q->where('user_id', $userId);
                
                // 🔧 ATAU RPK di mana user adalah anggota
                $q->orWhereHas('kegiatans.anggota', function($subQ) use ($userId) {
                    $subQ->where('user_id', $userId);
                });
            });
        }

        // Filter
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

        return view('rpks.index', compact('rpks'));
    }

    /**
     * Form tambah RPK
     */
    public function create()
    {
        $masterKegiatans = MasterKegiatan::where('status', 'aktif')->get();

        return view('rpks.create', compact('masterKegiatans'));
    }

    /**
     * Simpan RPK
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
        ]);

        Rpk::create([
            'user_id' => Auth::id(),
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'status' => 'draft',
        ]);

        return redirect()
            ->route('rpks.index')
            ->with('success', 'RPK berhasil dibuat');
    }

    /**
     * Detail RPK + daftar kegiatan
     */
    // app/Http/Controllers/RpkController.php

public function show(Rpk $rpk)
{
    $user = Auth::user();
    
    // Admin & Dosen bisa lihat semua
    if ($user->hasRole(['Admin', 'Dosen'])) {
        $rpk->load(['user', 'kegiatans.masterKegiatan.anggota']);
        $masterKegiatans = MasterKegiatan::where('status', 'aktif')->get();
        $isPemilik = false;
        $isAnggota = false;
        
        return view('rpks.show', compact('rpk', 'masterKegiatans', 'isPemilik', 'isAnggota'));
    }
    
    // Cek peran
    $isPemilik = $rpk->user_id == $user->id;
    $isAnggota = !$isPemilik && $rpk->kegiatans()
        ->whereHas('anggota', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->exists();
    
    if (!$isPemilik && !$isAnggota) {
        abort(403, 'Anda tidak memiliki akses ke RPK ini.');
    }

    // Load data
    $rpk->load([
        'user',
        'kegiatans' => function($q) use ($user, $isAnggota) {
            if ($isAnggota) {
                // 🔧 Anggota hanya lihat kegiatan kelompoknya
                $q->whereHas('anggota', function($subQ) use ($user) {
                    $subQ->where('user_id', $user->id);
                });
            }
            $q->with(['masterKegiatan', 'anggota']);
        }
    ]);
    
    $masterKegiatans = MasterKegiatan::where('status', 'aktif')->get();

    return view('rpks.show', compact('rpk', 'masterKegiatans', 'isPemilik', 'isAnggota'));
}

    /**
     * Form edit RPK
     */
    public function edit(Rpk $rpk)
    {
        // 🔧 Hanya pemilik yang bisa edit
        if (Auth::user()->hasRole('Mahasiswa') && $rpk->user_id != Auth::id()) {
            abort(403, 'Anda tidak dapat mengedit RPK ini.');
        }
        
        // 🔧 Hanya bisa edit jika status draft atau ditolak
        if (!in_array($rpk->status, ['draft', 'ditolak'])) {
            return back()->with('error', 'RPK yang sudah diajukan/disetujui tidak dapat diedit.');
        }

        return view('rpks.edit', compact('rpk'));
    }

    /**
     * Update RPK
     */
    public function update(Request $request, Rpk $rpk)
    {
        // 🔧 Hanya pemilik yang bisa update
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
            'status' => 'draft', // 🔧 Kembali ke draft jika diupdate
        ]);

        return redirect()
            ->route('rpks.index')
            ->with('success', 'RPK berhasil diupdate');
    }

    /**
     * Hapus RPK
     */
    public function destroy(Rpk $rpk)
    {
        // 🔧 Hanya pemilik yang bisa hapus
        if (Auth::user()->hasRole('Mahasiswa') && $rpk->user_id != Auth::id()) {
            abort(403, 'Anda tidak dapat menghapus RPK ini.');
        }

        $rpk->delete();

        return redirect()
            ->route('rpks.index')
            ->with('success', 'RPK berhasil dihapus');
    }
}