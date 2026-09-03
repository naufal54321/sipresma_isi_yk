<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointRule;
use App\Models\CompetencyField;
use App\Models\ActivityType;
use App\Models\ActivityScope;
use App\Models\ActivityRole;
use App\Models\AchievementType;
use Illuminate\Http\Request;

class PointRuleController extends Controller
{
    public function index(Request $request)
    {
        $query = PointRule::with(['competencyField', 'activityType', 'scope', 'role', 'achievement']);

        if ($request->competency_field_id) {
            $query->where('competency_field_id', $request->competency_field_id);
        }
        if ($request->activity_type_id) {
            $query->where('activity_type_id', $request->activity_type_id);
        }
        if ($request->scope_id) {
            $query->where('scope_id', $request->scope_id);
        }
        if ($request->role_id) {
            $query->where('role_id', $request->role_id);
        }
        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        }
        if ($request->search) {
            $query->whereHas('activityType', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
        }

        $rules = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => PointRule::count(),
            'active' => PointRule::where('is_active', true)->count(),
            'inactive' => PointRule::where('is_active', false)->count(),
            'per_field' => PointRule::selectRaw('competency_field_id, count(*) as total')
                ->groupBy('competency_field_id')
                ->with('competencyField')
                ->get()
                ->pluck('total', 'competencyField.name'),
        ];

        $fields = CompetencyField::active()->get();
        $types = ActivityType::active()->get();
        $scopes = ActivityScope::active()->get();
        $roles = ActivityRole::active()->get();

        return view('admin.point-rules.index', compact('rules', 'stats', 'fields', 'types', 'scopes', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'competency_field_id' => 'required|exists:competency_fields,id',
            'activity_type_id' => 'required|exists:activity_types,id',
            'scope_id' => 'nullable|exists:activity_scopes,id',
            'role_id' => 'nullable|exists:activity_roles,id',
            'achievement_id' => 'nullable|exists:achievement_types,id',
            'points' => 'required|integer|min:1|max:100',
            'max_usage' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $exists = PointRule::where('competency_field_id', $request->competency_field_id)
            ->where('activity_type_id', $request->activity_type_id)
            ->where('scope_id', $request->scope_id)
            ->where('role_id', $request->role_id)
            ->where('achievement_id', $request->achievement_id)
            ->exists();

        if ($exists) {
            $msg = 'Rule dengan kombinasi ini sudah ada';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $msg]);
            }
            return back()->with('error', $msg);
        }

        PointRule::create($request->only(
            'competency_field_id', 'activity_type_id', 'scope_id',
            'role_id', 'achievement_id', 'points', 'max_usage', 'is_active'
        ));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Rule poin berhasil ditambahkan']);
        }

        return redirect()->route('admin.point-rules.index')->with('success', 'Rule poin berhasil ditambahkan');
    }

    public function update(Request $request, PointRule $pointRule)
    {
        $request->validate([
            'competency_field_id' => 'required|exists:competency_fields,id',
            'activity_type_id' => 'required|exists:activity_types,id',
            'scope_id' => 'nullable|exists:activity_scopes,id',
            'role_id' => 'nullable|exists:activity_roles,id',
            'achievement_id' => 'nullable|exists:achievement_types,id',
            'points' => 'required|integer|min:1|max:100',
            'max_usage' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $exists = PointRule::where('competency_field_id', $request->competency_field_id)
            ->where('activity_type_id', $request->activity_type_id)
            ->where('scope_id', $request->scope_id)
            ->where('role_id', $request->role_id)
            ->where('achievement_id', $request->achievement_id)
            ->where('id', '!=', $pointRule->id)
            ->exists();

        if ($exists) {
            $msg = 'Rule dengan kombinasi ini sudah ada';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $msg]);
            }
            return back()->with('error', $msg);
        }

        $pointRule->update($request->only(
            'competency_field_id', 'activity_type_id', 'scope_id',
            'role_id', 'achievement_id', 'points', 'max_usage', 'is_active'
        ));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Rule poin berhasil diperbarui']);
        }

        return redirect()->route('admin.point-rules.index')->with('success', 'Rule poin berhasil diperbarui');
    }

    public function destroy(Request $request, PointRule $pointRule)
    {
        $pointRule->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Rule poin berhasil dihapus']);
        }

        return redirect()->route('admin.point-rules.index')->with('success', 'Rule poin berhasil dihapus');
    }
}
