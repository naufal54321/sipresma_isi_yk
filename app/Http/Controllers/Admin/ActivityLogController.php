<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer');

        // Filter by user
        if ($request->user_id) {
            $query->where('causer_id', $request->user_id);
        }

        // Filter by model (subject_type)
        if ($request->model) {
            $modelMap = [
                'user' => User::class,
                'rpk' => \App\Models\Rpk::class,
                'kegiatan' => \App\Models\Kegiatan::class,
                'spk' => \App\Models\Spk::class,
                'point_rule' => \App\Models\PointRule::class,
                'competency_field' => \App\Models\CompetencyField::class,
                'activity_type' => \App\Models\ActivityType::class,
                'activity_scope' => \App\Models\ActivityScope::class,
                'activity_role' => \App\Models\ActivityRole::class,
                'achievement_type' => \App\Models\AchievementType::class,
                'program_studi' => \App\Models\ProgramStudi::class,
            ];
            if (isset($modelMap[$request->model])) {
                $query->where('subject_type', $modelMap[$request->model]);
            }
        }

        // Filter by action/event
        if ($request->event) {
            $query->where('event', $request->event);
        }

        // Filter by log_name
        if ($request->log_name) {
            $query->where('log_name', $request->log_name);
        }

        // Filter by date range
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('properties', 'like', "%{$search}%");
            });
        }

        $activities = $query->latest()->paginate(20)->withQueryString();

        // Get distinct models for filter dropdown
        $models = Activity::distinct()
            ->whereNotNull('subject_type')
            ->pluck('subject_type')
            ->mapWithKeys(fn($type) => [
                class_basename($type) => $type,
            ])
            ->toArray();

        // Get distinct events for filter dropdown
        $events = Activity::distinct()
            ->whereNotNull('event')
            ->pluck('event')
            ->toArray();

        // Get users for filter dropdown
        $users = User::whereIn('id', Activity::whereNotNull('causer_id')->distinct()->pluck('causer_id'))->get(['id', 'name']);

        return view('admin.logs.index', compact('activities', 'models', 'events', 'users'));
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Log berhasil dihapus']);
        }

        return back()->with('success', 'Log berhasil dihapus');
    }
}
