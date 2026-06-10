<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Spk;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
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
        'nim',
        'prodi',
        'email',
        'password',
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
        ];
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

}