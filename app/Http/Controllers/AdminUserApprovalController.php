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
        $users = User::where(
            'status',
            'pending'
        )->latest()->get();

        return view(
            'admin.users.approval',
            compact('users')
        );
    }

    public function approve(Request $request, User $user)
{
    $user->update([
        'status' => 'aktif'
    ]);

    if ($request->send_email == 1) {
        Mail::to($user->email)
            ->send(new AccountApprovedMail($user));
    }

    return back()->with('success', 'Akun berhasil disetujui');
}

    public function reject(Request $request, User $user)
{
    if ($request->send_email == 1) {
        Mail::to($user->email)
            ->send(new AccountRejectedMail($user));
    }

    $user->delete();

    return back()->with('success', 'Akun berhasil ditolak');
}
}