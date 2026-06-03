<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /*
    |-----------------------------------
    | CREATE (TIDAK DIPAKAI AJAX)
    |-----------------------------------
    */
    public function create()
    {
        return view('admin.users.create');
    }

    /*
    |-----------------------------------
    | STORE AJAX
    |-----------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nim' => 'required|unique:users,nim',
            'prodi' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return response()->json([
            'message' => 'success',
            'user' => $user->load('roles')
        ]);
    }

    /*
    |-----------------------------------
    | SHOW AJAX (EDIT DATA)
    |-----------------------------------
    */
    public function show(User $user)
    {
        return response()->json(
            $user->load('roles')
        );
    }

    /*
    |-----------------------------------
    | UPDATE AJAX
    |-----------------------------------
    */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'nim' => 'required',
            'prodi' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'email' => $request->email,
        ]);

        $user->syncRoles([$request->role]);

        return response()->json([
            'message' => 'updated',
            'user' => $user->load('roles')
        ]);
    }

    /*
    |-----------------------------------
    | DELETE AJAX
    |-----------------------------------
    */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'deleted'
        ]);
    }
}