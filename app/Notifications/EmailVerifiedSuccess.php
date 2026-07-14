<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerifiedSuccess extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail']; // Menggunakan jalur email
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Akun PRATAMA Berhasil Diverifikasi! 🎉')
            ->greeting('Selamat, ' . $notifiable->name . '!')
            ->line('Email Anda telah resmi diverifikasi oleh sistem.')
            ->line('Sekarang Anda sudah memiliki akses penuh untuk menggunakan seluruh fitur di PRATAMA (Prestasi dan Talenta Mahasiswa).')
            ->action('Masuk ke Dashboard', url('/login'))
            ->line('Selamat beraktivitas dan raih prestasimu!')
            ->salutation('Salam hormat, UPA TIK ISI Yogyakarta');
    }
}