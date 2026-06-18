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
        // 1. Tangkap parameter dari form filter dropdown
        $filterTahun = $request->tahun;
        $filterSemester = $request->semester;
        $filterStatus = $request->status;

        // 2. Terapkan query filter
        $rpks = Rpk::with(['user', 'kegiatans'])
            ->where('user_id', Auth::id())

            // Jika tahun dipilih, saring berdasarkan tahun
            ->when($filterTahun, function ($query) use ($filterTahun) {
                return $query->where('tahun', $filterTahun);
            })

            // Jika semester dipilih, saring berdasarkan semester
            ->when($filterSemester, function ($query) use ($filterSemester) {
                return $query->where('semester', $filterSemester);
            })

            // Jika status dipilih, saring berdasarkan status
            ->when($filterStatus, function ($query) use ($filterStatus) {
                return $query->where('status', $filterStatus);
            })

            ->latest()
            ->get();

        return view('rpks.index', compact('rpks'));
    }

    /**
     * Form tambah RPK
     */
    public function create()
    {
        $masterKegiatans = MasterKegiatan::where(
            'status',
            'aktif'
        )->get();

        return view(
            'rpks.create',
            compact('masterKegiatans')
        );
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
            'user_id' => Auth::id(), // <-- Gunakan ini
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'status' => 'draft', // wajib
        ]);

        return redirect()
            ->route('rpks.index')
            ->with('success', 'RPK berhasil dibuat');
    }

    /**
     * Detail RPK + daftar kegiatan
     */
    /**
     * Detail RPK + daftar kegiatan
     */

    public function show(Rpk $rpk)
    {
        $rpk->load([
            'user',
            'kegiatans.masterKegiatan'
        ]);

        $masterKegiatans = MasterKegiatan::where('status', 'aktif')->get();

        return view('rpks.show', compact(
            'rpk',
            'masterKegiatans'
        ));
    }

    /**
     * Form edit RPK
     */
    public function edit(Rpk $rpk)
    {
        return view('rpks.edit', compact('rpk'));
    }

    /**
     * Update RPK
     */
    public function update(Request $request, Rpk $rpk)
    {
        $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'kategori' => 'required',
        ]);

        $rpk->update([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'kategori' => $request->kategori,
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
        $rpk->delete();

        return redirect()
            ->route('rpks.index')
            ->with('success', 'RPK berhasil dihapus');
    }
}
