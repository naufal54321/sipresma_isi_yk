<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase; // Wajib ada untuk mereset database setiap test

    public function test_halaman_login_bisa_dibuka_dengan_lancar()
    {
        $response = $this->get('/login'); // Sesuaikan URL ini jika rute login Anda berbeda
        
        $response->assertStatus(200);
    }
}