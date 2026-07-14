<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\Rpk;
use App\Models\Kegiatan;
use App\Models\MasterPrestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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

    /**
     * Format range tanggal dari kegiatan
     */
    private function formatTanggalKegiatan($kegiatan)
    {
        $tanggalMulai = $kegiatan->tanggal_mulai ? Carbon::parse($kegiatan->tanggal_mulai) : null;
        $tanggalSelesai = $kegiatan->tanggal_selesai ? Carbon::parse($kegiatan->tanggal_selesai) : null;
        
        if ($tanggalMulai && $tanggalSelesai) {
            if ($tanggalMulai->format('Y-m-d') === $tanggalSelesai->format('Y-m-d')) {
                // Tanggal sama: "15 Januari 2025"
                return $tanggalMulai->translatedFormat('d F Y');
            } else if ($tanggalMulai->format('m-Y') === $tanggalSelesai->format('m-Y')) {
                // Bulan sama: "15 - 17 Januari 2025"
                return $tanggalMulai->translatedFormat('d') . ' - ' . $tanggalSelesai->translatedFormat('d F Y');
            } else {
                // Bulan berbeda: "30 Januari - 2 Februari 2025"
                return $tanggalMulai->translatedFormat('d F') . ' - ' . $tanggalSelesai->translatedFormat('d F Y');
            }
        } elseif ($tanggalMulai) {
            return $tanggalMulai->translatedFormat('d F Y');
        } else {
            return Carbon::now()->translatedFormat('d F Y');
        }
    }

    /**
     * Halaman create SPK
     */
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
            'penyelenggara' => 'required',
            'kategori' => 'required',
            'prestasi_id' => 'required|exists:master_prestasis,id',
            'tingkat' => 'nullable|string|max:255',
            'judul_karya' => 'required|string|max:255',
            'biografi' => 'nullable|string|max:2000',
            'rincian' => 'nullable|string|max:3000',
            'kebaruan' => 'nullable|string|max:2000',
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
            'judul_karya.required' => 'Judul Karya/Inovasi/Riset/Prestasi wajib diisi',
            'surat_tugas.required' => 'Surat Tugas wajib diupload',
            'surat_tugas.mimes' => 'Surat Tugas harus berformat PDF',
            'surat_tugas.max' => 'Ukuran Surat Tugas maksimal 5 MB',
            'sertifikat.required' => 'Sertifikat / Foto Piala wajib diupload',
            'sertifikat.mimes' => 'Sertifikat harus berformat PDF, JPG, JPEG, atau PNG',
            'sertifikat.max' => 'Ukuran Sertifikat maksimal 5 MB',
            'foto_penyerahan.required' => 'Foto Penyerahan Piagam wajib diupload',
            'foto_penyerahan.mimes' => 'Foto Penyerahan harus berformat JPG, JPEG, atau PNG',
            'foto_penyerahan.max' => 'Ukuran Foto Penyerahan maksimal 5 MB',
            'laporan.required' => 'Laporan wajib diupload',
            'laporan.mimes' => 'Laporan harus berformat PDF',
            'laporan.max' => 'Ukuran Laporan maksimal 5 MB',
        ]);

        // ⚡ AMBIL KEGIATAN UNTUK MENDAPATKAN RANGE TANGGAL
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

        // ⚡ FORMAT RANGE TANGGAL DARI KEGIATAN
        $tanggalKegiatan = $this->formatTanggalKegiatan($kegiatan);

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
            'tanggal_kegiatan' => $tanggalKegiatan, // ⚡ RANGE TANGGAL OTOMATIS
            'penyelenggara' => $request->penyelenggara,
            'kategori' => $request->kategori,
            'prestasi_id' => $request->prestasi_id,
            'hasil' => $prestasi->juara,
            'judul_kegiatan' => $kegiatan->judul_kegiatan ?? $kegiatan->kegiatan,
            'poin' => 0,
            'tingkat' => $prestasi->tingkat,
            'judul_karya' => $request->judul_karya,
            'biografi' => $request->biografi,
            'rincian' => $request->rincian,
            'kebaruan' => $request->kebaruan,
            'url_kegiatan' => $request->url_kegiatan,
            'link_drive' => $request->link_drive,
            'surat_tugas' => $suratTugas,
            'sertifikat' => $sertifikat,
            'foto_penyerahan' => $fotoPenyerahan,
            'laporan' => $laporan,
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

    /**
     * Tampilkan detail SPK
     */
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
     * Edit SPK
     */
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

        if (in_array($spk->status, ['disetujui', 'ditolak'])) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'SPK yang sudah ' . $spk->status . ' tidak dapat diubah'], 422);
            }
            return back()->with('error', 'SPK yang sudah ' . $spk->status . ' tidak dapat diubah');
        }

        $request->validate([
            'tahun' => 'required',
            'rpk_id' => 'required',
            'kegiatan_id' => 'required',
            'penyelenggara' => 'required',
            'kategori' => 'required',
            'prestasi_id' => 'required|exists:master_prestasis,id',
            'tingkat' => 'nullable|string|max:255',
            'judul_karya' => 'required|string|max:255',
            'biografi' => 'nullable|string|max:2000',
            'rincian' => 'nullable|string|max:3000',
            'kebaruan' => 'nullable|string|max:2000',
            'url_kegiatan' => 'required|url|max:500',
            'link_drive' => 'required|url|max:500',
            'surat_tugas' => 'nullable|mimes:pdf|max:5120',
            'sertifikat' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'foto_penyerahan' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            'laporan' => 'nullable|mimes:pdf|max:5120',
        ], [
            'url_kegiatan.required' => 'URL Kegiatan wajib diisi',
            'link_drive.required' => 'Link Google Drive wajib diisi',
            'judul_karya.required' => 'Judul Karya/Inovasi/Riset/Prestasi wajib diisi',
            'surat_tugas.max' => 'Ukuran Surat Tugas maksimal 5 MB',
            'sertifikat.max' => 'Ukuran Sertifikat maksimal 5 MB',
            'foto_penyerahan.max' => 'Ukuran Foto Penyerahan maksimal 5 MB',
            'laporan.max' => 'Ukuran Laporan maksimal 5 MB',
        ]);

        // ⚡ AMBIL KEGIATAN UNTUK MENDAPATKAN RANGE TANGGAL
        $kegiatan = Kegiatan::findOrFail($request->kegiatan_id);
        $prestasi = MasterPrestasi::findOrFail($request->prestasi_id);

        // ⚡ FORMAT RANGE TANGGAL DARI KEGIATAN
        $tanggalKegiatan = $this->formatTanggalKegiatan($kegiatan);

        $data = [
            'tahun' => $request->tahun,
            'rpk_id' => $request->rpk_id,
            'kegiatan_id' => $request->kegiatan_id,
            'tanggal_kegiatan' => $tanggalKegiatan, // ⚡ RANGE TANGGAL OTOMATIS
            'penyelenggara' => $request->penyelenggara,
            'kategori' => $request->kategori,
            'prestasi_id' => $request->prestasi_id,
            'hasil' => $prestasi->juara,
            'judul_kegiatan' => $kegiatan->judul_kegiatan ?? $kegiatan->kegiatan,
            'tingkat' => $prestasi->tingkat,
            'judul_karya' => $request->judul_karya,
            'biografi' => $request->biografi,
            'rincian' => $request->rincian,
            'kebaruan' => $request->kebaruan,
            'url_kegiatan' => $request->url_kegiatan,
            'link_drive' => $request->link_drive,
            'status' => 'draft',
            'catatan_dosen' => null
        ];

        // Upload file baru jika ada
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


}