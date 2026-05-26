<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

public function create()
{
    return view('admin.users.create');
}

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

    return redirect()
        ->route('admin.dashboard')
        ->with('success', 'Pengguna berhasil ditambahkan');
}
    /**
     * Form edit pengguna
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update data pengguna
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

    // Update role
    $user->syncRoles([$request->role]);

    return redirect()
        ->route('admin.dashboard')
        ->with('success', 'Data pengguna berhasil diperbarui');
}

public function destroy(User $user)
{
    // Mencegah admin menghapus akun sendiri
    if ($user->id == Auth::id()) {

        return redirect()
            ->back()
            ->with('error', 'Anda tidak bisa menghapus akun sendiri');
    }

    $user->delete();

    return redirect()
        ->route('admin.dashboard')
        ->with('success', 'Pengguna berhasil dihapus');
}
}