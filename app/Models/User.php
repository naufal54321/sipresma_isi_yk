<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Spk;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nim',
        'prodi',
        'angkatan',              // ⚡ TAMBAH
        'semester',              // ⚡ TAMBAH
        'dosen_pembimbing_id',
        'status',
        'is_approved',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
        ];
    }

    // ⚡ TAMBAH: Scope untuk filter berdasarkan angkatan
    public function scopeAngkatan($query, $angkatan)
    {
        return $query->where('angkatan', $angkatan);
    }

    // ⚡ TAMBAH: Scope untuk filter berdasarkan semester
    public function scopeSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    // ⚡ TAMBAH: Scope untuk mahasiswa saja
    public function scopeMahasiswa($query)
    {
        return $query->role('Mahasiswa');
    }

    public function rpks()
    {
        return $this->hasMany(Rpk::class);
    }

    public function mahasiswaBimbingan()
    {
        return $this->hasMany(User::class, 'dosen_pembimbing_id');
    }

    public function dosenPembimbing()
    {
        return $this->belongsTo(User::class, 'dosen_pembimbing_id');
    }

    public function scopeMahasiswaBimbingan($query, $dosenId)
    {
        return $query->where('dosen_pembimbing_id', $dosenId);
    }

    public function spks()
    {
        return $this->hasMany(Spk::class);
    }

    // Relasi ke kegiatan sebagai anggota
    public function kegiatanAnggota()
    {
        return $this->belongsToMany(Kegiatan::class, 'kegiatan_user')
                    ->withTimestamps();
    }
}