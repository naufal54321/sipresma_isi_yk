<?php

use App\Models\User;
use App\Models\Rpk;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithoutMiddleware;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'Mahasiswa', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'Dosen', 'guard_name' => 'web']);
});

test('mahasiswa can create rpk', function () {
    $mahasiswa = User::create([
        'name' => 'Mhs Test',
        'email' => 'mhs@test.com',
        'password' => bcrypt('password'),
        'nim' => '12345678',
        'prodi' => 'Teknik Informatika',
        'status' => 'aktif',
        'email_verified_at' => now(),
    ]);
    $mahasiswa->assignRole('Mahasiswa');
    
    // ⚡ Bypass middleware verified
    $response = $this->actingAs($mahasiswa)
        ->withoutMiddleware(\Illuminate\Auth\Middleware\EnsureEmailIsVerified::class)
        ->post('/rpks', [
            'tahun' => '2026',
            'semester' => 'Ganjil',
        ]);
    
    $response->assertStatus(302);
    
    $this->assertDatabaseHas('rpks', [
        'user_id' => $mahasiswa->id,
        'tahun' => '2026',
        'semester' => 'Ganjil',
        'status' => 'draft',
    ]);
});

test('admin can access dashboard', function () {
    $admin = User::create([
        'name' => 'Admin Test',
        'email' => 'admin3@test.com',
        'password' => bcrypt('password'),
        'nim' => '00000003',
        'status' => 'aktif',
        'email_verified_at' => now(),
    ]);
    $admin->assignRole('Admin');
    
    $response = $this->actingAs($admin)->get('/admin');
    $response->assertStatus(302);
});