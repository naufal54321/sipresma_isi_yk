<?php

namespace App\Http\Controllers;

use App\Models\User;

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

    public function approve(User $user)
{
    $user->update([
        'status' => 'aktif'
    ]);

    return redirect()
        ->route('admin.users.approval')
        ->with('success', 'Akun berhasil disetujui');
}

public function reject(User $user)
{
    $user->delete();

    return redirect()
        ->route('admin.users.approval')
        ->with('success', 'Akun ditolak dan dihapus');
}

   
}