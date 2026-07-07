<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = [
        'rpk_id',
        'master_kegiatan_id',
        'kegiatan',
        'judul_kegiatan',
        'tanggal_mulai',      // ⚡ UBAH: dari 'tanggal' ke 'tanggal_mulai'
        'tanggal_selesai',    // ⚡ TAMBAH: 'tanggal_selesai'
        'kategori',
        'peran',
        'jumlah_anggota',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_mulai' => 'date',     // ⚡ TAMBAH: casting ke date
        'tanggal_selesai' => 'date',   // ⚡ TAMBAH: casting ke date
    ];

    /**
     * Get the formatted date range
     *
     * @return string
     */
    public function getTanggalRangeAttribute()
    {
        if ($this->tanggal_mulai && $this->tanggal_selesai) {
            return $this->tanggal_mulai->format('d M Y') . ' - ' . $this->tanggal_selesai->format('d M Y');
        }
        
        if ($this->tanggal_mulai) {
            return $this->tanggal_mulai->format('d M Y');
        }
        
        return '-';
    }

    /**
     * Get the duration in days
     *
     * @return int|null
     */
    public function getDurasiHariAttribute()
    {
        if ($this->tanggal_mulai && $this->tanggal_selesai) {
            return $this->tanggal_mulai->diffInDays($this->tanggal_selesai) + 1;
        }
        
        return null;
    }

    public function rpk()
    {
        return $this->belongsTo(Rpk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function spks()
    {
        return $this->hasMany(Spk::class);
    }

    public function masterKegiatan()
    {
        return $this->belongsTo(MasterKegiatan::class);
    }

    public function anggota()
    {
        return $this->belongsToMany(User::class, 'kegiatan_user')
                    ->withPivot('peran') // 🔧 PENTING: Ambil kolom peran
                    ->withTimestamps();
    }
}