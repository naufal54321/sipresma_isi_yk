<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

class AccountRejectedMail extends Mailable
{
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this
            ->subject('Pendaftaran Akun SIPRESMA Ditolak')
            ->view('emails.account-rejected');
    }
}