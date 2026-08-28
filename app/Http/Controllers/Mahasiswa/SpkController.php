<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;

use App\Models\Spk;
use App\Models\Rpk;
use App\Models\Kegiatan;
use App\Models\KkmRule;
use App\Services\DashboardService;
use App\Mail\SpkSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
                ->paginate(20);

        $rpks = Rpk::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->with('kegiatans')
            ->get();

        $kegiatans = Kegiatan::whereHas('rpk', function ($q) use ($user) {
                $q->where('user_id', $user->id)->where('status', 'disetujui');
            })
            ->select('id', 'rpk_id', 'kegiatan', 'judul_kegiatan', 'tanggal_mulai', 'tanggal_selesai', 'kategori', 'kkm_rule_id')
            ->with(['rpk', 'kkmRule'])
            ->get();

        $kkmRules = KkmRule::where('is_active', true)
            ->select('id', 'bidang', 'jenis_kegiatan', 'peran', 'poin')
            ->get();

        return view('mahasiswa.spks.index', compact('spks', 'rpks', 'kegiatans', 'kkmRules'));
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
                return $tanggalMulai->translatedFormat('d F Y');
            } else if ($tanggalMulai->format('m-Y') === $tanggalSelesai->format('m-Y')) {
                return $tanggalMulai->translatedFormat('d') . ' - ' . $tanggalSelesai->translatedFormat('d F Y');
            } else {
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
        return redirect()->route('spks.index')->with('error', 'Fitur tambah SPK belum tersedia.');
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
            'peran_sifat' => 'required|string|max:255',
            'judul_karya' => 'required|string|max:255',
            'biografi' => 'nullable|string|max:2000',
            'rincian' => 'nullable|string|max:3000',
            'kebaruan' => 'nullable|string|max:2000',
            'url_kegiatan' => 'required|url|max:500',
            'link_drive' => 'required|url|max:500',
            'surat_tugas' => 'nullable|mimes:pdf|max:5120',
            'sertifikat' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'foto_penyerahan' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'laporan' => 'nullable|mimes:pdf|max:5120',
        ], [
            'url_kegiatan.required' => 'URL Kegiatan wajib diisi',
            'url_kegiatan.url' => 'URL Kegiatan harus berupa URL yang valid',
            'link_drive.required' => 'Link Google Drive wajib diisi',
            'link_drive.url' => 'Link Google Drive harus berupa URL yang valid',
            'judul_karya.required' => 'Judul Karya/Inovasi/Riset/Prestasi wajib diisi',
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

        $kkmRule = $kegiatan->kkmRule;

        if ($kkmRule) {
            $sameJenisCount = Spk::where('user_id', Auth::id())
                ->whereHas('kegiatan.kkmRule', function ($q) use ($kkmRule) {
                    $q->where('bidang', $kkmRule->bidang)
                      ->where('jenis_kegiatan', $kkmRule->jenis_kegiatan);
                })
                ->count();

            if ($sameJenisCount >= 4) {
                $msg = "Anda sudah menginput maksimal 4 kegiatan dengan jenis yang sama ({$kkmRule->jenis_kegiatan}) di bidang ini.";
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $msg], 422);
                }
                return back()->withErrors(['kegiatan_id' => $msg])->withInput();
            }

            $required = \App\Services\FileRequirementService::getRequiredFileCols($kkmRule->bidang, $kkmRule->jenis_kegiatan, $request->peran_sifat);
            $fileLabels = [
                'surat_tugas' => 'Surat Tugas',
                'sertifikat' => 'Sertifikat',
                'foto_penyerahan' => 'Foto Penyerahan',
                'laporan' => 'Laporan',
            ];
            $mimes = [
                'surat_tugas' => 'pdf',
                'sertifikat' => 'pdf,jpg,jpeg,png',
                'foto_penyerahan' => 'pdf,jpg,jpeg,png',
                'laporan' => 'pdf',
            ];
            foreach ($required as $col) {
                if (!$request->hasFile($col)) {
                    $label = $fileLabels[$col] ?? $col;
                    $validator = \Validator::make([], []);
                    $validator->errors()->add($col, "File {$label} wajib diupload untuk peran/sifat ini.");
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }
        }

        $tanggalKegiatan = $this->formatTanggalKegiatan($kegiatan);
        
        $fileCols = ['surat_tugas', 'sertifikat', 'foto_penyerahan', 'laporan'];
        $dirs = ['surat-tugas', 'sertifikat', 'foto-penyerahan', 'laporan'];
        $filePaths = [];
        foreach ($fileCols as $idx => $col) {
            if ($request->hasFile($col)) {
                $filePaths[$col] = $request->file($col)->store($dirs[$idx], 'public');
            } else {
                $filePaths[$col] = null;
            }
        }

        $spk = Spk::create([
            'user_id' => Auth::id(),
            'rpk_id' => $request->rpk_id,
            'kegiatan_id' => $request->kegiatan_id,
            'tahun' => $request->tahun,
            'tanggal_kegiatan' => $tanggalKegiatan,
            'penyelenggara' => $request->penyelenggara,
            'kategori' => $request->kategori,
            'peran_sifat' => $request->peran_sifat,
            'judul_kegiatan' => $kegiatan->judul_kegiatan ?? $kegiatan->kegiatan,
            'poin' => 0,
            'judul_karya' => $request->judul_karya,
            'biografi' => $request->biografi,
            'rincian' => $request->rincian,
            'kebaruan' => $request->kebaruan,
            'url_kegiatan' => $request->url_kegiatan,
            'link_drive' => $request->link_drive,
            'surat_tugas' => $filePaths['surat_tugas'],
            'sertifikat' => $filePaths['sertifikat'],
            'foto_penyerahan' => $filePaths['foto_penyerahan'],
            'laporan' => $filePaths['laporan'],
            'status' => 'draft'
        ]);
        DashboardService::clearAdminCache();

        if ($spk->rpk?->dosen_pembimbing_id) {
            $dosen = \App\Models\User::find($spk->rpk->dosen_pembimbing_id);
            if ($dosen && $dosen->email) {
                try {
                    Mail::to($dosen)->send(new SpkSubmitted($spk->fresh()));
                } catch (\Throwable $e) {
                    Log::warning('Gagal kirim email SPK submitted ke dosen: ' . $e->getMessage());
                }
            }
        }

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

        $spk->load(['verifiedBy', 'kegiatan.kkmRule']);

        $fileRequirements = [];
        if ($spk->kegiatan && $spk->kegiatan->kkmRule) {
            $kkm = $spk->kegiatan->kkmRule;
            $fileRequirements = \App\Services\FileRequirementService::getRequiredFiles($kkm->bidang, $kkm->jenis_kegiatan, $spk->peran_sifat);
        }

        return view('mahasiswa.spks.show', compact('spk', 'fileRequirements'));
    }

    /**
     * Edit SPK
     */
    public function edit(Spk $spk)
    {
        if ($spk->user_id != Auth::id()) {
            abort(403);
        }
        return redirect()->route('spks.index')->with('error', 'Fitur edit SPK belum tersedia.');
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
            'peran_sifat' => 'required|string|max:255',
            'judul_karya' => 'required|string|max:255',
            'biografi' => 'nullable|string|max:2000',
            'rincian' => 'nullable|string|max:3000',
            'kebaruan' => 'nullable|string|max:2000',
            'url_kegiatan' => 'required|url|max:500',
            'link_drive' => 'required|url|max:500',
            'surat_tugas' => 'nullable|mimes:pdf|max:5120',
            'sertifikat' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'foto_penyerahan' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'laporan' => 'nullable|mimes:pdf|max:5120',
        ], [
            'url_kegiatan.required' => 'URL Kegiatan wajib diisi',
            'link_drive.required' => 'Link Google Drive wajib diisi',
            'judul_karya.required' => 'Judul Karya/Inovasi/Riset/Prestasi wajib diisi',
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

        $kkmRule = $kegiatan->kkmRule;
        if ($kkmRule) {
            $required = \App\Services\FileRequirementService::getRequiredFileCols($kkmRule->bidang, $kkmRule->jenis_kegiatan, $request->peran_sifat);
            $fileLabels = [
                'surat_tugas' => 'Surat Tugas',
                'sertifikat' => 'Sertifikat',
                'foto_penyerahan' => 'Foto Penyerahan',
                'laporan' => 'Laporan',
            ];
            foreach ($required as $col) {
                if (!$request->hasFile($col) && !$spk->$col) {
                    $label = $fileLabels[$col] ?? $col;
                    $validator = \Validator::make([], []);
                    $validator->errors()->add($col, "File {$label} wajib diupload untuk peran/sifat ini.");
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }
        }

        $tanggalKegiatan = $this->formatTanggalKegiatan($kegiatan);

        $data = [
            'tahun' => $request->tahun,
            'rpk_id' => $request->rpk_id,
            'kegiatan_id' => $request->kegiatan_id,
            'tanggal_kegiatan' => $tanggalKegiatan,
            'penyelenggara' => $request->penyelenggara,
            'kategori' => $request->kategori,
            'peran_sifat' => $request->peran_sifat,
            'judul_kegiatan' => $kegiatan->judul_kegiatan ?? $kegiatan->kegiatan,
            'judul_karya' => $request->judul_karya,
            'biografi' => $request->biografi,
            'rincian' => $request->rincian,
            'kebaruan' => $request->kebaruan,
            'url_kegiatan' => $request->url_kegiatan,
            'link_drive' => $request->link_drive,
            'status' => 'draft',
            'catatan_dosen' => null
        ];

        $fileCols = ['surat_tugas', 'sertifikat', 'foto_penyerahan', 'laporan'];
        $dirs = ['surat-tugas', 'sertifikat', 'foto-penyerahan', 'laporan'];
        foreach ($fileCols as $idx => $col) {
            if ($request->hasFile($col)) {
                if ($spk->$col && Storage::disk('public')->exists($spk->$col)) {
                    Storage::disk('public')->delete($spk->$col);
                }
                $data[$col] = $request->file($col)->store($dirs[$idx], 'public');
            }
        }

        $spk->update($data);
        DashboardService::clearAdminCache();

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
        DashboardService::clearAdminCache();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'SPK berhasil dihapus'
            ]);
        }

        return redirect()->route('spks.index')->with('success', 'SPK berhasil dihapus.');
    }


}

