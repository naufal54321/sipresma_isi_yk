<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityType;
use App\Models\CompetencyField;
use Illuminate\Http\Request;

class ActivityTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityType::with('competencyField')->withCount('pointRules');

        if ($request->competency_field_id) {
            $query->where('competency_field_id', $request->competency_field_id);
        }

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $types = $query->latest()->paginate(15)->withQueryString();
        $fields = CompetencyField::active()->get();

        return view('admin.activity-types.index', compact('types', 'fields'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'competency_field_id' => 'required|exists:competency_fields,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'evidence_required' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        ActivityType::create($request->only('competency_field_id', 'name', 'description', 'evidence_required', 'is_active'));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Jenis kegiatan berhasil ditambahkan']);
        }

        return redirect()->route('admin.activity-types.index')->with('success', 'Jenis kegiatan berhasil ditambahkan');
    }

    public function update(Request $request, ActivityType $activityType)
    {
        $request->validate([
            'competency_field_id' => 'required|exists:competency_fields,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'evidence_required' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $activityType->update($request->only('competency_field_id', 'name', 'description', 'evidence_required', 'is_active'));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Jenis kegiatan berhasil diperbarui']);
        }

        return redirect()->route('admin.activity-types.index')->with('success', 'Jenis kegiatan berhasil diperbarui');
    }

    public function destroy(Request $request, ActivityType $activityType)
    {
        if ($activityType->pointRules()->count() > 0) {
            $msg = 'Tidak dapat menghapus jenis kegiatan yang masih memiliki rules poin';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $msg]);
            }
            return redirect()->route('admin.activity-types.index')->with('error', $msg);
        }

        $activityType->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Jenis kegiatan berhasil dihapus']);
        }

        return redirect()->route('admin.activity-types.index')->with('success', 'Jenis kegiatan berhasil dihapus');
    }
}
