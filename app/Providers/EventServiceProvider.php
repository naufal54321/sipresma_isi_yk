<?php

namespace App\Providers;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            \App\Listeners\LogAuthActivity::class . '@login',
        ],
        Logout::class => [
            \App\Listeners\LogAuthActivity::class . '@logout',
        ],
        Failed::class => [
            \App\Listeners\LogAuthActivity::class . '@failed',
        ],
        Registered::class => [
            \App\Listeners\LogAuthActivity::class . '@registered',
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }
}
