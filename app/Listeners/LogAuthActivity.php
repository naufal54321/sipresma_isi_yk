<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LogAuthActivity implements ShouldQueue
{
    public function __construct(
        protected Request $request
    ) {}

    public function login(Login $event): void
    {
        activity('auth')
            ->causedBy($event->user)
            ->performedOn($event->user)
            ->event('login')
            ->withProperties([
                'ip' => $this->request->ip(),
                'user_agent' => Str::limit($this->request->userAgent(), 150),
            ])
            ->log('Login berhasil');
    }

    public function logout(Logout $event): void
    {
        activity('auth')
            ->causedBy($event->user)
            ->performedOn($event->user)
            ->event('logout')
            ->withProperties([
                'ip' => $this->request->ip(),
            ])
            ->log('Logout');
    }

    public function failed(Failed $event): void
    {
        activity('auth')
            ->event('login_failed')
            ->withProperties([
                'email' => $event->credentials['email'] ?? '-',
                'ip' => $this->request->ip(),
            ])
            ->log('Login gagal: ' . ($event->credentials['email'] ?? '-'));
    }

    public function registered(Registered $event): void
    {
        activity('auth')
            ->causedBy($event->user)
            ->performedOn($event->user)
            ->event('registered')
            ->withProperties([
                'ip' => $this->request->ip(),
            ])
            ->log('Pendaftaran akun baru');
    }
}
