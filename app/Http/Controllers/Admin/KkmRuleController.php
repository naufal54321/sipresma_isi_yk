<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KkmRule;
use App\Models\PointRule;
use Illuminate\Http\Request;

class KkmRuleController extends Controller
{
    private function isDuplicate(Request $request, ?int $excludeId = null): bool
    {
        $query = KkmRule::where('bidang', $request->bidang)
            ->where('jenis_kegiatan', $request->jenis_kegiatan)
            ->where('ruang_lingkup', $request->ruang_lingkup)
            ->where('peran', $request->peran);

        if ($request->hasil) {
            $query->where('hasil', $request->hasil);
        } else {
            $query->whereNull('hasil');
        }

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    public function index(Request $request)
    {
        $query = KkmRule::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('jenis_kegiatan', 'like', '%' . $request->search . '%')
                  ->orWhere('ruang_lingkup', 'like', '%' . $request->search . '%')
                  ->orWhere('peran', 'like', '%' . $request->search . '%')
                  ->orWhere('hasil', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('bidang')) {
            $query->where('bidang', $request->bidang);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif');
        }

        $rules = $query->latest()->paginate(10)->withQueryString();

        return view('admin.kkm-rules.index', compact('rules'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'bidang' => 'required|in:Bidang Orientasi Kompetensi Profesional,Bidang Kompetensi Kepribadian dan Sosial',
            'jenis_kegiatan' => 'required|string|max:255',
            'ruang_lingkup' => 'required|string|max:255',
            'peran' => 'required|string|max:255',
            'hasil' => 'nullable|string|max:255',
            'poin' => 'required|integer|min:1|max:100',
            'is_active' => 'required|boolean',
        ], [
            'bidang.required' => 'Bidang wajib dipilih',
            'bidang.in' => 'Bidang tidak valid',
            'jenis_kegiatan.required' => 'Jenis kegiatan wajib diisi',
            'ruang_lingkup.required' => 'Ruang Lingkup wajib dipilih',
            'peran.required' => 'Peran wajib diisi',
            'poin.required' => 'Poin wajib diisi',
            'poin.integer' => 'Poin harus berupa angka',
            'poin.min' => 'Poin minimal 1',
            'poin.max' => 'Poin maksimal 100',
            'is_active.required' => 'Status wajib dipilih',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($this->isDuplicate($request)) {
            $msg = 'Aturan KKM dengan kombinasi Bidang, Jenis, Ruang Lingkup, Peran, dan Hasil sudah ada';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return redirect()->back()->with('error', $msg)->withInput();
        }

        try {
            $rule = KkmRule::create($request->only([
                'bidang', 'jenis_kegiatan', 'ruang_lingkup', 'peran', 'hasil', 'poin', 'is_active'
            ]));

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Aturan KKM berhasil ditambahkan',
                    'data' => $rule
                ], 201);
            }

            return redirect()->route('admin.kkm-rules.index')->with('success', 'Aturan KKM berhasil ditambahkan');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan data: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, KkmRule $kkm_rule)
    {
        $validator = \Validator::make($request->all(), [
            'bidang' => 'required|in:Bidang Orientasi Kompetensi Profesional,Bidang Kompetensi Kepribadian dan Sosial',
            'jenis_kegiatan' => 'required|string|max:255',
            'ruang_lingkup' => 'required|string|max:255',
            'peran' => 'required|string|max:255',
            'hasil' => 'nullable|string|max:255',
            'poin' => 'required|integer|min:1|max:100',
            'is_active' => 'required|boolean',
        ], [
            'bidang.required' => 'Bidang wajib dipilih',
            'bidang.in' => 'Bidang tidak valid',
            'jenis_kegiatan.required' => 'Jenis kegiatan wajib diisi',
            'ruang_lingkup.required' => 'Ruang Lingkup wajib dipilih',
            'peran.required' => 'Peran wajib diisi',
            'poin.required' => 'Poin wajib diisi',
            'poin.integer' => 'Poin harus berupa angka',
            'poin.min' => 'Poin minimal 1',
            'poin.max' => 'Poin maksimal 100',
            'is_active.required' => 'Status wajib dipilih',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($this->isDuplicate($request, $kkm_rule->id)) {
            $msg = 'Aturan KKM dengan kombinasi Bidang, Jenis, Ruang Lingkup, Peran, dan Hasil sudah ada';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return redirect()->back()->with('error', $msg)->withInput();
        }

        try {
            $kkm_rule->update($request->only([
                'bidang', 'jenis_kegiatan', 'ruang_lingkup', 'peran', 'hasil', 'poin', 'is_active'
            ]));

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Aturan KKM berhasil diperbarui',
                    'data' => $kkm_rule
                ]);
            }

            return redirect()->route('admin.kkm-rules.index')->with('success', 'Aturan KKM berhasil diperbarui');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui data: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(KkmRule $kkm_rule)
    {
        try {
            $kkm_rule->delete();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Aturan KKM berhasil dihapus'
                ]);
            }

            return redirect()->route('admin.kkm-rules.index')->with('success', 'Aturan KKM berhasil dihapus');

        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus data: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function options(Request $request)
    {
        $query = PointRule::with(['competencyField', 'activityType', 'scope', 'role', 'achievementType'])
            ->where('is_active', true);

        if ($request->filled('bidang')) {
            $query->where('competency_field_id', $request->bidang);
        }
        if ($request->filled('jenis_kegiatan')) {
            $query->where('activity_type_id', $request->jenis_kegiatan);
        }
        if ($request->filled('ruang_lingkup')) {
            $query->where('scope_id', $request->ruang_lingkup);
        }
        if ($request->filled('peran')) {
            $query->where('role_id', $request->peran);
        }
        if ($request->filled('hasil')) {
            $query->where('achievement_type_id', $request->hasil);
        }

        $rules = $query->get();

        $result = [
            'bidang' => PointRule::where('is_active', true)->pluck('competency_field_id')->filter()->unique()->values(),
            'jenis_kegiatan' => collect(),
            'ruang_lingkup' => collect(),
            'peran' => collect(),
            'hasil' => collect(),
            'preview' => null,
        ];

        if ($request->filled('bidang')) {
            $result['jenis_kegiatan'] = $rules->pluck('activity_type_id')->filter()->unique()->values();
        }

        if ($request->filled('bidang') && $request->filled('jenis_kegiatan')) {
            $result['ruang_lingkup'] = $rules->pluck('scope_id')->filter()->unique()->values();
            $result['peran'] = $rules->pluck('role_id')->filter()->unique()->values();
        }

        $hasHasil = $rules->whereNotNull('achievement_type_id')->isNotEmpty();
        if ($hasHasil) {
            $result['hasil'] = $rules->pluck('achievement_type_id')->filter()->unique()->values();
        }

        if ($rules->count() === 1) {
            $rule = $rules->first();
            $result['preview'] = [
                'kkm_rule_id' => $rule->id,
                'poin' => $rule->points,
            ];
        } elseif ($rules->count() > 1 && !$hasHasil) {
            $rule = $rules->first();
            $result['preview'] = [
                'kkm_rule_id' => $rule->id,
                'poin' => $rule->points,
            ];
        }

        return response()->json($result);
    }
}
