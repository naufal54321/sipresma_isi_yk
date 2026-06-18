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

    // Tambah index() jika belum ada
    public function index()
    {
        $users = User::with('roles')->latest()->get(); // ✅ DESC (baru ke lama)
        return view('admin.users.index', compact('users'));
    }

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

        // PERBAIKAN: Langsung simpan nilai prodi tanpa memaksa null
        $user = User::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'prodi' => $request->prodi, // <--- Ubah bagian ini
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
            'prodi' => 'nullable',
            'email' => 'required|email',
            'role' => 'required',
        ]);

        if ($request->role === 'Mahasiswa' && empty($request->prodi)) {
            return response()->json([
                'message' => 'Program Studi wajib diisi untuk Mahasiswa'
            ], 422);
        }

        // PERBAIKAN: Langsung simpan nilai prodi tanpa memaksa null
        $user->update([
            'name' => $request->name,
            'nim' => $request->nim,
            'prodi' => $request->prodi, // <--- Ubah bagian ini
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

    public function pembimbingIndex()
    {
        $mahasiswa = User::role('Mahasiswa')->get();
        $dosen = User::role('Dosen')->get();

        return view('admin.pembimbing.index', compact('mahasiswa', 'dosen'));
    }

    public function setPembimbing(Request $request)
{
    // 1. Tambahkan validasi ini untuk mencegah error 404
    $request->validate([
        'mahasiswa_id' => 'required|exists:users,id',
        'dosen_id'     => 'nullable|exists:users,id'
    ], [
        'mahasiswa_id.required' => 'Harap pilih mahasiswa terlebih dahulu.',
    ]);

    // 2. Karena sudah divalidasi 'required', baris ini dijamin tidak akan memicu 404
    $mahasiswa = User::findOrFail($request->mahasiswa_id);

    // 3. Logika Anda yang sudah rapi dipertahankan
    $mahasiswa->dosen_pembimbing_id = 
        $request->filled('dosen_id') 
        ? $request->dosen_id 
        : null;

    $mahasiswa->save();

    return back()->with('success', 'Data berhasil disimpan');
}

    public function getUsersData()
    {
        $users = User::orderBy('created_at', 'desc')->get();

        return response()->json($users);
    }
}
