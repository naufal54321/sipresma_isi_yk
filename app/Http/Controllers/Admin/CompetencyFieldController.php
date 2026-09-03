<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompetencyField;
use Illuminate\Http\Request;

class CompetencyFieldController extends Controller
{
    public function index(Request $request)
    {
        $query = CompetencyField::withCount('activityTypes');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $fields = $query->latest()->paginate(10)->withQueryString();
        return view('admin.competency-fields.index', compact('fields'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        CompetencyField::create($request->only('name', 'description', 'is_active'));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Bidang kompetensi berhasil ditambahkan']);
        }

        return redirect()->route('admin.competency-fields.index')->with('success', 'Bidang kompetensi berhasil ditambahkan');
    }

    public function update(Request $request, CompetencyField $competencyField)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $competencyField->update($request->only('name', 'description', 'is_active'));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Bidang kompetensi berhasil diperbarui']);
        }

        return redirect()->route('admin.competency-fields.index')->with('success', 'Bidang kompetensi berhasil diperbarui');
    }

    public function destroy(Request $request, CompetencyField $competencyField)
    {
        if ($competencyField->activityTypes()->count() > 0) {
            $msg = 'Tidak dapat menghapus bidang yang masih memiliki jenis kegiatan';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $msg]);
            }
            return redirect()->route('admin.competency-fields.index')->with('error', $msg);
        }

        $competencyField->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Bidang kompetensi berhasil dihapus']);
        }

        return redirect()->route('admin.competency-fields.index')->with('success', 'Bidang kompetensi berhasil dihapus');
    }
}
