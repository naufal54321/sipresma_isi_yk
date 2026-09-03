<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityScope;
use Illuminate\Http\Request;

class ActivityScopeController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityScope::withCount('pointRules');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $scopes = $query->latest()->paginate(10)->withQueryString();
        return view('admin.activity-scopes.index', compact('scopes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        ActivityScope::create($request->only('code', 'name', 'is_active'));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Ruang lingkup berhasil ditambahkan']);
        }

        return redirect()->route('admin.activity-scopes.index')->with('success', 'Ruang lingkup berhasil ditambahkan');
    }

    public function update(Request $request, ActivityScope $activityScope)
    {
        $request->validate([
            'code' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $activityScope->update($request->only('code', 'name', 'is_active'));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Ruang lingkup berhasil diperbarui']);
        }

        return redirect()->route('admin.activity-scopes.index')->with('success', 'Ruang lingkup berhasil diperbarui');
    }

    public function destroy(Request $request, ActivityScope $activityScope)
    {
        if ($activityScope->pointRules()->count() > 0) {
            $msg = 'Tidak dapat menghapus ruang lingkup yang masih digunakan dalam rules';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $msg]);
            }
            return redirect()->route('admin.activity-scopes.index')->with('error', $msg);
        }

        $activityScope->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Ruang lingkup berhasil dihapus']);
        }

        return redirect()->route('admin.activity-scopes.index')->with('success', 'Ruang lingkup berhasil dihapus');
    }
}
