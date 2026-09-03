<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\CompetencyField;
use App\Models\ActivityType;
use App\Models\ActivityScope;
use App\Models\ActivityRole;
use Illuminate\Http\Request;

class RuleOptionsController extends Controller
{
    public function competencyFields()
    {
        $fields = CompetencyField::active()->select('id', 'name')->get();
        return response()->json($fields);
    }

    public function activityTypes(Request $request)
    {
        $query = ActivityType::active()->select('id', 'competency_field_id', 'name');

        if ($request->competency_field_id) {
            $query->where('competency_field_id', $request->competency_field_id);
        }

        return response()->json($query->get());
    }

    public function activityScopes()
    {
        $scopes = ActivityScope::active()->select('id', 'code', 'name')->get();
        return response()->json($scopes);
    }

    public function activityRoles(Request $request)
    {
        $query = ActivityRole::active()->select('id', 'name');

        if ($request->activity_type_id) {
            $roleIds = \App\Models\PointRule::where('activity_type_id', $request->activity_type_id)
                ->where('is_active', true)
                ->pluck('role_id')
                ->unique();
            $query->whereIn('id', $roleIds);
        }

        return response()->json($query->get());
    }

    public function preview(Request $request)
    {
        $query = \App\Models\PointRule::with(['competencyField', 'activityType', 'scope', 'role'])
            ->where('is_active', true);

        if ($request->competency_field_id) $query->where('competency_field_id', $request->competency_field_id);
        if ($request->activity_type_id) $query->where('activity_type_id', $request->activity_type_id);
        if ($request->scope_id) $query->where('scope_id', $request->scope_id);
        if ($request->role_id) $query->where('role_id', $request->role_id);

        $rule = $query->first();

        if ($rule) {
            return response()->json([
                'found' => true,
                'point_rule_id' => $rule->id,
                'points' => $rule->points,
                'full_path' => $rule->full_path,
            ]);
        }

        return response()->json(['found' => false]);
    }
}
