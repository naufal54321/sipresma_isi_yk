<?php

use App\Models\User;
use App\Models\ProgramStudi;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
});

test('admin can create program studi', function () {
    $admin = User::create([
        'name' => 'Admin Test',
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
        'nim' => '00000001',
        'status' => 'aktif',
        'email_verified_at' => now(),
    ]);
    $admin->assignRole('Admin');
    
    $response = $this->actingAs($admin)->post('/admin/prodi', [
        'nama_prodi' => 'S1 Test Prodi',
        'status' => 'aktif',
    ]);
    
    $response->assertStatus(201); // ⚡ POST = 201 Created
    
    $this->assertDatabaseHas('program_studis', [
        'nama_prodi' => 'S1 Test Prodi',
        'status' => 'aktif',
    ]);
});

test('admin can view prodi list', function () {
    $admin = User::create([
        'name' => 'Admin Test',
        'email' => 'admin2@test.com',
        'password' => bcrypt('password'),
        'nim' => '00000002',
        'status' => 'aktif',
        'email_verified_at' => now(),
    ]);
    $admin->assignRole('Admin');
    
    ProgramStudi::create([
        'nama_prodi' => 'S1 Test Prodi',
        'status' => 'aktif',
    ]);
    
    $response = $this->actingAs($admin)->get('/admin/prodi');
    
    $response->assertStatus(200); // ⚡ GET = 200 OK
    $response->assertSee('S1 Test Prodi');
});