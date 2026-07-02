<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\EmailVerifiedSuccess; // 🔧 Panggil notifikasi yang akan kita buat
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth; // 🔧 Wajib dipanggil untuk fungsi logout

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // 1. Jika akun sudah diverifikasi sebelumnya
        if ($request->user()->hasVerifiedEmail()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->with('status_verified', 'Akun Anda sudah diverifikasi sebelumnya. Silakan login.');
        }

        // 2. Jika proses verifikasi email berhasil saat ini
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));

            // 🔧 Kirim email notifikasi sukses ke Gmail mahasiswa
            $request->user()->notify(new EmailVerifiedSuccess());
        }

        // 3. Paksa pengguna untuk Logout
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 4. Arahkan kembali ke halaman Login dengan membawa pesan sukses
        return redirect()->route('login')->with('status_verified', 'Email Anda berhasil diverifikasi! Silakan masuk kembali ke akun Anda.');
    }
}