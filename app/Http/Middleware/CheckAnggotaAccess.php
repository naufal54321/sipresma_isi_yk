<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAnggotaAccess
{
    public function handle(Request $request, Closure $next)
    {
        // 🔧 TIDAK ADA PEMBATASAN - Semua mahasiswa bisa CRUD
        return $next($request);
    }
}