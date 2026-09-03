<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityRole;
use Illuminate\Http\Request;

class ActivityRoleController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityRole::withCount('pointRules');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $roles = $query->latest()->paginate(15)->withQueryString();
        return view('admin.activity-roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:activity_roles,name',
            'is_active' => 'boolean',
        ]);

        ActivityRole::create($request->only('name', 'is_active'));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Peran berhasil ditambahkan']);
        }

        return redirect()->route('admin.activity-roles.index')->with('success', 'Peran berhasil ditambahkan');
    }

    public function update(Request $request, ActivityRole $activityRole)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:activity_roles,name,' . $activityRole->id,
            'is_active' => 'boolean',
        ]);

        $activityRole->update($request->only('name', 'is_active'));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Peran berhasil diperbarui']);
        }

        return redirect()->route('admin.activity-roles.index')->with('success', 'Peran berhasil diperbarui');
    }

    public function destroy(Request $request, ActivityRole $activityRole)
    {
        if ($activityRole->pointRules()->count() > 0) {
            $msg = 'Tidak dapat menghapus peran yang masih digunakan dalam rules poin';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $msg]);
            }
            return redirect()->route('admin.activity-roles.index')->with('error', $msg);
        }

        $activityRole->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Peran berhasil dihapus']);
        }

        return redirect()->route('admin.activity-roles.index')->with('success', 'Peran berhasil dihapus');
    }
}
