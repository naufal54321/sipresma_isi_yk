<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AchievementType;
use Illuminate\Http\Request;

class AchievementTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = AchievementType::withCount('pointRules');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $types = $query->latest()->paginate(10)->withQueryString();
        return view('admin.achievement-types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:achievement_types,name',
            'is_active' => 'boolean',
        ]);

        AchievementType::create($request->only('name', 'is_active'));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Hasil/prestasi berhasil ditambahkan']);
        }

        return redirect()->route('admin.achievement-types.index')->with('success', 'Hasil/prestasi berhasil ditambahkan');
    }

    public function update(Request $request, AchievementType $achievementType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:achievement_types,name,' . $achievementType->id,
            'is_active' => 'boolean',
        ]);

        $achievementType->update($request->only('name', 'is_active'));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Hasil/prestasi berhasil diperbarui']);
        }

        return redirect()->route('admin.achievement-types.index')->with('success', 'Hasil/prestasi berhasil diperbarui');
    }

    public function destroy(Request $request, AchievementType $achievementType)
    {
        if ($achievementType->pointRules()->count() > 0) {
            $msg = 'Tidak dapat menghapus hasil/prestasi yang masih digunakan dalam rules';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $msg]);
            }
            return redirect()->route('admin.achievement-types.index')->with('error', $msg);
        }

        $achievementType->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Hasil/prestasi berhasil dihapus']);
        }

        return redirect()->route('admin.achievement-types.index')->with('success', 'Hasil/prestasi berhasil dihapus');
    }
}
