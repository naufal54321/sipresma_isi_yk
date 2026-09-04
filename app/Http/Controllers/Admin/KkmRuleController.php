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
        $query = PointRule::with(['competencyField', 'activityType', 'scope', 'role', 'achievement', 'fileRequirements'])
            ->where('is_active', true);

        if ($request->filled('competency_field_id')) {
            $query->where('competency_field_id', $request->competency_field_id);
        }
        if ($request->filled('activity_type_id')) {
            $query->where('activity_type_id', $request->activity_type_id);
        }
        if ($request->filled('scope_id')) {
            $query->where('scope_id', $request->scope_id);
        }
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }
        if ($request->filled('achievement_id')) {
            $query->where('achievement_id', $request->achievement_id);
        }

        $rules = $query->get();

        $bidangIds = $rules->pluck('competency_field_id')->filter()->unique()->values();
        $bidangItems = \App\Models\CompetencyField::whereIn('id', $bidangIds)
            ->orderBy('name')->get()->map(fn($f) => ['id' => $f->id, 'name' => $f->name]);

        $jenisItems = collect();
        $ruangItems = collect();
        $peranItems = collect();
        $hasilItems = collect();

        if ($request->filled('competency_field_id')) {
            $jenisIds = $rules->pluck('activity_type_id')->filter()->unique()->values();
            $jenisItems = \App\Models\ActivityType::whereIn('id', $jenisIds)
                ->orderBy('name')->get()->map(fn($t) => ['id' => $t->id, 'name' => $t->name]);
        }

        $hasScope = $request->filled('scope_id');

        if ($request->filled('competency_field_id') && $request->filled('activity_type_id')) {
            $scopeIds = $rules->pluck('scope_id')->filter()->unique()->values();
            $roleIds = $rules->pluck('role_id')->filter()->unique()->values();
            $ruangItems = \App\Models\ActivityScope::whereIn('id', $scopeIds)
                ->orderBy('name')->get()->map(fn($s) => ['id' => $s->id, 'name' => $s->name]);

            if ($hasScope) {
                $peranItems = $rules->map(fn($r) => [
                    'id' => $r->role->id ?? null,
                    'name' => $r->role->name ?? '-',
                    'poin' => $r->points,
                    'point_rule_id' => $r->id,
                    'file_requirements' => $r->fileRequirements->map(fn($f) => [
                        'col' => $f->file_column,
                        'label' => $f->label,
                        'accept' => $f->accept,
                        'required' => $f->is_required,
                    ])->toArray(),
                ])->values();
            } else {
                $peranItems = \App\Models\ActivityRole::whereIn('id', $roleIds)
                    ->orderBy('name')->get()->map(fn($r) => ['id' => $r->id, 'name' => $r->name]);
            }
        }

        $hasHasil = $rules->whereNotNull('achievement_id')->isNotEmpty();
        if ($hasHasil) {
            $hasilIds = $rules->pluck('achievement_id')->filter()->unique()->values();
            $hasilItems = \App\Models\AchievementType::whereIn('id', $hasilIds)
                ->orderBy('name')->get()->map(fn($a) => ['id' => $a->id, 'name' => $a->name]);
        }

        $preview = null;
        if ($rules->count() === 1) {
            $rule = $rules->first();
            $preview = ['kkm_rule_id' => $rule->id, 'poin' => $rule->points];
        } elseif ($rules->count() > 1 && !$hasHasil) {
            $rule = $rules->first();
            $preview = ['kkm_rule_id' => $rule->id, 'poin' => $rule->points];
        }

        return response()->json([
            'bidang' => $bidangItems,
            'jenis_kegiatan' => $jenisItems,
            'ruang_lingkup' => $ruangItems,
            'peran' => $peranItems,
            'hasil' => $hasilItems,
            'preview' => $preview,
        ]);
    }
}
