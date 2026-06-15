<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\User; // 1. Import the User model

class AccountApprovedMail extends Mailable
{
    public User $user; // 2. Add the type hint to the property

    public function __construct(User $user) // 3. Add the type hint to the parameter
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Akun Berhasil Disetujui')
                    ->view('emails.account-approved');
    }
}