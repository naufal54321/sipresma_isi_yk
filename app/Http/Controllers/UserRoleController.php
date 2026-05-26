<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRoleController extends Controller
{
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required'
        ]);

        // Admin tidak bisa mengubah role dirinya sendiri
        if(Auth::id() == $user->id){

            return back()->with(
                'error',
                'Role akun sendiri tidak bisa diubah'
            );

        }

        $user->syncRoles([$request->role]);

        return back()->with(
            'success',
            'Role berhasil diperbarui'
        );
    }
}