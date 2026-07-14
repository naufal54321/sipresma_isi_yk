<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountApprovedMail;
use App\Mail\AccountRejectedMail;
use Illuminate\Http\Request;

class AdminUserApprovalController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('is_approved', false);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.approval', compact('users'));
    }

    public function approve(Request $request, User $user)
    {
        $user->update([
            'status' => 'aktif',
            'is_approved' => true,
        ]);

        if ($request->send_email == 1) {
            Mail::to($user->email)->send(new AccountApprovedMail($user));
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Akun berhasil disetujui']);
        }

        return back()->with('success', 'Akun berhasil disetujui');
    }

    public function reject(Request $request, User $user)
    {
        if ($request->send_email == 1) {
            Mail::to($user->email)->send(new AccountRejectedMail($user));
        }

        $userName = $user->name;
        $user->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Akun ' . $userName . ' berhasil ditolak']);
        }

        return back()->with('success', 'Akun berhasil ditolak');
    }
}
