<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\Rpk;
use App\Models\Kegiatan;
use App\Models\MasterPrestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $query->where(function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhereHas('kegiatan.anggota', function($subQ) use ($user) {
                  $subQ->where('user_id', $user->id);
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
            ->select('id', 'rpk_id', 'kegiatan', 'judul_kegiatan', 'tanggal_mulai', 'tanggal_selesai', 'kategori')
            ->with('rpk')
            ->get();

        $prestasis = MasterPrestasi::where('is_active', true)->orderBy('juara')->get();

        return view('mahasiswa.spks.index', compact('spks', 'rpks', 'kegiatans', 'prestasis'));
    }

    public function create()
    {
        $rpks = Rpk::where('user_id', Auth::id())->get();
        
        $kegiatans = Kegiatan::whereHas('rpk', function ($query) {
            $query->where('user_id', Auth::id())->where('status', 'disetujui');
        })->select('id', 'rpk_id', 'kegiatan', 'judul_kegiatan', 'tanggal_mulai', 'tanggal_selesai', 'kategori')->get();

        return view('mahasiswa.spks.create', compact('rpks', 'kegiatans'));
    }

    /**
     * Simpan SPK (SUPPORT AJAX)
     */
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
            'tingkat' => 'nullable|string|max:255',
            'keterangan' => 'required',
            'url_kegiatan' => 'required|url|max:500',
            'link_drive' => 'required|url|max:500',
            'surat_tugas' => 'required|mimes:pdf|max:5120',
            'sertifikat' => 'required|mimes:pdf,jpg,jpeg,png|max:5120',
            'foto_penyerahan' => 'required|mimes:jpg,jpeg,png|max:5120',
            'laporan' => 'required|mimes:pdf|max:5120',
        ], [
            'url_kegiatan.required' => 'URL Kegiatan wajib diisi',
            'url_kegiatan.url' => 'URL Kegiatan harus berupa URL yang valid',
            'link_drive.required' => 'Link Google Drive wajib diisi',
            'link_drive.url' => 'Link Google Drive harus berupa URL yang valid',
            'surat_tugas.required' => 'Surat Tugas wajib diupload',
            'sertifikat.required' => 'Sertifikat / Foto Piala wajib diupload',
            'foto_penyerahan.required' => 'Foto Penyerahan Piagam wajib diupload',
            'laporan.required' => 'Laporan wajib diupload',
        ]);

        $kegiatan = Kegiatan::where('id', $request->kegiatan_id)
            ->where('rpk_id', $request->rpk_id)
            ->whereHas('rpk', function ($query) {
                $query->where('user_id', Auth::id())->where('status', 'disetujui');
            })
            ->first();

        if (!$kegiatan) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kegiatan tidak sesuai dengan RPK yang dipilih atau RPK belum disetujui.'
                ], 422);
            }
            return back()->withErrors([
                'kegiatan_id' => 'Kegiatan tidak sesuai dengan RPK yang dipilih atau RPK belum disetujui.'
            ])->withInput();
        }

        $prestasi = MasterPrestasi::findOrFail($request->prestasi_id);
        
        $suratTugas = $request->file('surat_tugas')->store('surat-tugas', 'public');
        $sertifikat = $request->file('sertifikat')->store('sertifikat', 'public');
        $fotoPenyerahan = $request->file('foto_penyerahan')->store('foto-penyerahan', 'public');
        $laporan = $request->file('laporan')->store('laporan', 'public');

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
            'judul_kegiatan' => $kegiatan->judul_kegiatan ?? $kegiatan->kegiatan,
            'poin' => 0,
            'tingkat' => $prestasi->tingkat,
            'url_kegiatan' => $request->url_kegiatan,
            'link_drive' => $request->link_drive,
            'surat_tugas' => $suratTugas,
            'sertifikat' => $sertifikat,
            'foto_penyerahan' => $fotoPenyerahan,
            'laporan' => $laporan,
            'keterangan' => $request->keterangan,
            'status' => 'draft'
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'SPK berhasil ditambahkan'
            ]);
        }

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

        return view('mahasiswa.spks.show', compact('spk'));
    }

    /**
     * Hapus SPK (SUPPORT AJAX)
     */
    public function destroy(Spk $spk)
    {
        if ($spk->user_id != Auth::id()) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            abort(403);
        }

        if (!in_array($spk->status, ['draft', 'ditolak'])) {
            $message = 'SPK yang sudah disetujui tidak dapat dihapus.';
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->with('error', $message);
        }

        $files = ['surat_tugas', 'sertifikat', 'foto_penyerahan', 'laporan'];
        foreach ($files as $field) {
            if ($spk->$field && Storage::disk('public')->exists($spk->$field)) {
                Storage::disk('public')->delete($spk->$field);
            }
        }

        $spk->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'SPK berhasil dihapus'
            ]);
        }

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
        })->select('id', 'rpk_id', 'kegiatan', 'judul_kegiatan', 'tanggal_mulai', 'tanggal_selesai', 'kategori')->get();
        
        $prestasis = MasterPrestasi::where('is_active', true)->orderBy('juara')->get();

        return view('mahasiswa.spks.edit', compact('spk', 'rpks', 'kegiatans', 'prestasis'));
    }

    /**
     * Update SPK (SUPPORT AJAX)
     */
    public function update(Request $request, Spk $spk)
    {
        if ($spk->user_id != Auth::id()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
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
            'tingkat' => 'nullable|string|max:255',
            'keterangan' => 'required',
            'url_kegiatan' => 'required|url|max:500',
            'link_drive' => 'required|url|max:500',
            'surat_tugas' => 'nullable|mimes:pdf|max:5120',
            'sertifikat' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'foto_penyerahan' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'laporan' => 'nullable|mimes:pdf|max:5120',
        ], [
            'url_kegiatan.required' => 'URL Kegiatan wajib diisi',
            'link_drive.required' => 'Link Google Drive wajib diisi',
        ]);

        $kegiatan = Kegiatan::findOrFail($request->kegiatan_id);
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
            'judul_kegiatan' => $kegiatan->judul_kegiatan ?? $kegiatan->kegiatan,
            'tingkat' => $prestasi->tingkat,
            'url_kegiatan' => $request->url_kegiatan,
            'link_drive' => $request->link_drive,
            'keterangan' => $request->keterangan,
            'status' => 'draft',
            'catatan_dosen' => null
        ];

        if ($request->hasFile('surat_tugas')) {
            if ($spk->surat_tugas && Storage::disk('public')->exists($spk->surat_tugas)) {
                Storage::disk('public')->delete($spk->surat_tugas);
            }
            $data['surat_tugas'] = $request->file('surat_tugas')->store('surat-tugas', 'public');
        }

        if ($request->hasFile('sertifikat')) {
            if ($spk->sertifikat && Storage::disk('public')->exists($spk->sertifikat)) {
                Storage::disk('public')->delete($spk->sertifikat);
            }
            $data['sertifikat'] = $request->file('sertifikat')->store('sertifikat', 'public');
        }

        if ($request->hasFile('foto_penyerahan')) {
            if ($spk->foto_penyerahan && Storage::disk('public')->exists($spk->foto_penyerahan)) {
                Storage::disk('public')->delete($spk->foto_penyerahan);
            }
            $data['foto_penyerahan'] = $request->file('foto_penyerahan')->store('foto-penyerahan', 'public');
        }

        if ($request->hasFile('laporan')) {
            if ($spk->laporan && Storage::disk('public')->exists($spk->laporan)) {
                Storage::disk('public')->delete($spk->laporan);
            }
            $data['laporan'] = $request->file('laporan')->store('laporan', 'public');
        }

        $spk->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'SPK berhasil diperbaiki dan diajukan ulang'
            ]);
        }

        return redirect()->route('spks.index')->with('success', 'SPK berhasil diperbaiki dan diajukan ulang');
    }

    /**
     * Tambah Poin (Admin only)
     */
    public function tambahPoin(Request $request, Spk $spk)
    {
        if (!Auth::user()->hasRole('Admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk menambah poin.'
            ], 403);
        }

        if ($spk->status !== 'disetujui') {
            return response()->json([
                'success' => false,
                'message' => 'Poin hanya dapat ditambahkan pada SPK yang sudah disetujui. Status saat ini: ' . ucfirst($spk->status)
            ], 422);
        }

        if ($spk->poin > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Poin sudah ditambahkan sebelumnya sebesar ' . $spk->poin . ' poin oleh ' . ($spk->poinAddedBy->name ?? 'Admin') . '.'
            ], 422);
        }

        $validator = validator($request->all(), [
            'poin' => 'required|integer|min:1|max:100'
        ], [
            'poin.required' => 'Jumlah poin harus diisi',
            'poin.integer' => 'Poin harus berupa angka bulat',
            'poin.min' => 'Poin minimal 1',
            'poin.max' => 'Poin maksimal 100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $spk->update([
            'poin' => $request->poin,
            'poin_added_at' => now(),
            'poin_added_by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => "Poin sebesar {$request->poin} berhasil ditambahkan ke SPK {$spk->judul_kegiatan}!",
            'data' => [
                'poin' => $spk->poin,
                'added_by' => Auth::user()->name,
                'added_at' => $spk->poin_added_at->format('d/m/Y H:i')
            ]
        ]);
    }

    /**
     * Halaman kelola poin untuk Admin
     */
    public function kelolaPoin(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $filterTahun = $request->tahun;
        $filterStatus = $request->status_poin;
        $search = $request->search;

        $query = Spk::with(['user', 'rpk', 'kegiatan', 'poinAddedBy'])
                    ->where('status', 'disetujui');

        if ($filterTahun) {
            $query->where('tahun', $filterTahun);
        }

        if ($filterStatus === 'sudah') {
            $query->where('poin', '>', 0);
        } elseif ($filterStatus === 'belum') {
            $query->where(function($q) {
                $q->whereNull('poin')->orWhere('poin', '<=', 0);
            });
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul_kegiatan', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQ) use ($search) {
                      $userQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $spks = $query->latest()->paginate(20)->withQueryString();
        
        $totalDisetujui = Spk::where('status', 'disetujui')->count();
        $totalDenganPoin = Spk::where('status', 'disetujui')->where('poin', '>', 0)->count();
        $totalTanpaPoin = $totalDisetujui - $totalDenganPoin;
        $totalPoin = Spk::where('status', 'disetujui')->sum('poin');
        $listTahun = Spk::distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('admin.spk.kelola-poin', compact(
            'spks', 'totalDisetujui', 'totalDenganPoin', 'totalTanpaPoin',
            'totalPoin', 'filterTahun', 'filterStatus', 'search', 'listTahun'
        ));
    }
}