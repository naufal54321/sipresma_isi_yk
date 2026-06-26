<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();

        // 1. Cek kredensial
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
            ])->onlyInput('email');
        }

        // 2. Cek status (pending / ditolak / approved)
        if ($user->status === 'pending' || $user->is_approved == false) {
            return back()->withErrors([
                'email' => 'Akun Anda masih menunggu persetujuan admin.',
            ])->onlyInput('email');
        }

        if ($user->status === 'ditolak') {
            return back()->withErrors([
                'email' => 'Akun Anda telah ditolak oleh admin.',
            ])->onlyInput('email');
        }

        // 3. Login
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}