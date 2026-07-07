<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🔧 Set Carbon ke Bahasa Indonesia
        Carbon::setLocale('id');
        
        // Konfigurasi Email Verifikasi
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifikasi Alamat Email - SIPRESMA')
                ->greeting('Halo, ' . $notifiable->name . '!')
                ->line('Terima kasih telah mendaftar di SIPRESMA (Sistem Informasi Prestasi Mahasiswa).')
                ->line('Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda:')
                ->action('Verifikasi Email Saya', $url)
                ->line('Jika Anda tidak merasa mendaftar di aplikasi ini, Anda tidak perlu melakukan tindakan apa pun.')
                ->salutation('Salam hormat, UPA TIK ISI Yogyakarta');
        });

        // Konfigurasi Email Reset Password
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Atur Ulang Kata Sandi - SIPRESMA')
                ->greeting('Halo, ' . $notifiable->name . '!')
                ->line('Kami menerima permintaan untuk mengatur ulang kata sandi akun SIPRESMA Anda.')
                ->action('Atur Ulang Kata Sandi', $url)
                ->line('Tautan ini akan kedaluwarsa dalam 60 menit.')
                ->line('Jika Anda tidak merasa mengajukan permintaan ini, silakan abaikan email ini.')
                ->salutation('Salam hormat, UPA TIK ISI Yogyakarta');
        });
    }
}