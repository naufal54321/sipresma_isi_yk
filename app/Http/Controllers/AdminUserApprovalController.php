<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountApprovedMail;
use App\Mail\AccountRejectedMail;
use Illuminate\Http\Request;

class AdminUserApprovalController extends Controller
{
    public function index()
    {
        // 🔧 Hanya tampilkan user yang is_approved = false (belum disetujui)
        $users = User::where('is_approved', false)
            ->latest()
            ->get();

        return view('admin.users.approval', compact('users'));
    }

    public function approve(Request $request, User $user)
    {
        $user->update([
            'status' => 'aktif',        // 🔧 Status jadi aktif
            'is_approved' => true,      // 🔧 Approved = true
        ]);

        if ($request->send_email == 1) {
            Mail::to($user->email)->send(new AccountApprovedMail($user));
        }

        return back()->with('success', 'Akun berhasil disetujui');
    }

    public function reject(Request $request, User $user)
    {
        if ($request->send_email == 1) {
            Mail::to($user->email)->send(new AccountRejectedMail($user));
        }

        $user->delete();

        return back()->with('success', 'Akun berhasil ditolak');
    }
}
