<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'Mahasiswa', 'guard_name' => 'web']);
});

test('admin can create new user', function () {
    $admin = User::create([
        'name' => 'Admin Test',
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
        'nim' => '00000001',
        'status' => 'aktif',
        'email_verified_at' => now(),
    ]);
    $admin->assignRole('Admin');
    
    $response = $this->actingAs($admin)->post('/admin/users', [
        'name' => 'Test Mahasiswa',
        'nim' => '12345678',
        'prodi' => 'Teknik Informatika',
        'email' => 'test@example.com',
        'password' => 'password',
        'role' => 'Mahasiswa',
        'angkatan' => '2023',
        'semester' => '5',
    ]);
    
    $response->assertStatus(200);
    
    $this->assertDatabaseHas('users', [
        'name' => 'Test Mahasiswa',
        'nim' => '12345678',
        'angkatan' => '2023',
        'semester' => '5',
    ]);
});

test('user can be assigned role', function () {
    $user = User::create([
        'name' => 'Test User',
        'email' => 'user@test.com',
        'password' => bcrypt('password'),
        'nim' => '12345679',
        'status' => 'aktif',
        'email_verified_at' => now(),
    ]);
    $user->assignRole('Mahasiswa');
    
    $this->assertTrue($user->hasRole('Mahasiswa'));
});