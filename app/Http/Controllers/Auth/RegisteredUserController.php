<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:30'],
            'prodi' => ['required', 'string', 'max:100'],
            'angkatan' => ['required', 'string', 'max:4'],    // ⚡ TAMBAH
            'semester' => ['required', 'string', 'max:2'],    // ⚡ TAMBAH
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'angkatan' => $request->angkatan,    // ⚡ TAMBAH
            'semester' => $request->semester,    // ⚡ TAMBAH
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
            // 🔧 UBAH: Langsung aktifkan karena verifikasi sekarang diurus oleh Email
            'status' => 'aktif',
        ]);

        $user->assignRole('Mahasiswa');

        // Ini yang akan mengirimkan email
        event(new Registered($user));

        // 🔧 UBAH: Loginkan user secara otomatis setelah daftar
        Auth::login($user);

        // 🔧 UBAH: Arahkan ke dashboard. 
        // Middleware 'verified' di routes/web.php akan otomatis mencegatnya 
        // dan menampilkan halaman "Periksa Email Anda".
        return redirect()->route('dashboard');
    }
}