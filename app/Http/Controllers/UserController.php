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
    | INDEX AJAX & SERVER-SIDE SEARCH
    |-----------------------------------
    */
    public function index(Request $request)
{
    $query = User::with('roles')
        ->where('status', 'aktif')  // Hanya aktif
        ->whereNotNull('status')     // Tidak null
        ->where('status', '!=', 'pending') // Bukan pending
        ->where('status', '!=', 'ditolak') // Bukan ditolak
        ->latest();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('nim', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%')
              ->orWhere('prodi', 'like', '%' . $search . '%');
        });
    }

    if ($request->filled('role')) {
        $query->role($request->role);
    }

    $users = $query->paginate(10)->appends($request->all());

    return view('admin.dashboard', compact('users'));
}

    /*
    |-----------------------------------
    | STORE AJAX (Admin daftarkan user)
    |-----------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nim' => 'required|unique:users,nim',
            'prodi' => 'nullable',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        if ($request->role === 'Mahasiswa' && empty($request->prodi)) {
            return response()->json([
                'message' => 'Program Studi wajib diisi untuk Mahasiswa'
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'is_approved' => true,
            'status' => 'aktif',
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
            'prodi' => 'nullable',
            'email' => 'required|email',
            'role' => 'required',
        ]);

        if ($request->role === 'Mahasiswa' && empty($request->prodi)) {
            return response()->json([
                'message' => 'Program Studi wajib diisi untuk Mahasiswa'
            ], 422);
        }

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

    /*
    |-----------------------------------
    | DOSEN PEMBIMBING
    |-----------------------------------
    */
    public function pembimbingIndex(Request $request)
    {
        $dosen = User::role('Dosen')->get();

        // 🔧 Hanya mahasiswa dengan status 'aktif'
        $query = User::role('Mahasiswa')
            ->where('status', 'aktif')
            ->with('dosenPembimbing');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $mahasiswa = $query->latest()->paginate(10);

        return view('admin.pembimbing.index', compact('mahasiswa', 'dosen'));
    }

    public function setPembimbing(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'dosen_id'     => 'nullable|exists:users,id'
        ], [
            'mahasiswa_id.required' => 'Harap pilih mahasiswa terlebih dahulu.',
        ]);

        $mahasiswa = User::findOrFail($request->mahasiswa_id);
        $mahasiswa->dosen_pembimbing_id = $request->dosen_id;
        $mahasiswa->save();

        $pesan = $request->dosen_id
            ? 'Dosen pembimbing berhasil diatur.'
            : 'Dosen pembimbing berhasil dihapus.';

        return back()->with('success', $pesan);
    }

    public function getUsersData()
    {
        // 🔧 Hanya user aktif
        $users = User::where('status', 'aktif')->orderBy('created_at', 'desc')->get();
        return response()->json($users);
    }
}