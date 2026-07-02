<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudi extends Model
{
    use HasFactory;
    // Gunakan SoftDeletes jika ingin data tidak benar-benar terhapus (opsional)
    // use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'program_studis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_prodi', 
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'deleted_at', // Uncomment jika menggunakan SoftDeletes
    ];

    /**
     * The attributes that should be appended to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'is_active',
        'status_badge',
    ];

    /**
     * Default values for attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'aktif',
    ];

    // ============================================
    // ACCESSORS & MUTATORS
    // ============================================

    /**
     * Get the is_active attribute.
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'aktif';
    }

    /**
     * Get the status_badge attribute (HTML badge).
     */
    public function getStatusBadgeAttribute(): string
    {
        if ($this->status === 'aktif') {
            return '<span class="inline-flex items-center gap-1 min-w-[110px] justify-center bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-xs font-semibold border border-green-200">
                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>Aktif</span>';
        }
        
        return '<span class="inline-flex items-center gap-1 min-w-[110px] justify-center bg-red-100 text-red-700 px-3 py-1.5 rounded-full text-xs font-semibold border border-red-200">
            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>Tidak Aktif</span>';
    }

    /**
     * Set the nama_prodi attribute (auto-capitalize).
     */
    public function setNamaProdiAttribute($value): void
    {
        $this->attributes['nama_prodi'] = ucwords(strtolower(trim($value)));
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope a query to only include active program studi.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope a query to only include inactive program studi.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'tidak aktif');
    }

    /**
     * Scope a query to search by name.
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('nama_prodi', 'like', '%' . $search . '%');
        }
        
        return $query;
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeFilterByStatus($query, $status)
    {
        if ($status && in_array($status, ['aktif', 'tidak aktif'])) {
            return $query->where('status', $status);
        }
        
        return $query;
    }

    // ============================================
    // RELATIONSHIPS (Uncomment jika diperlukan)
    // ============================================

    /**
     * Get the mahasiswa for the program studi.
     */
    // public function mahasiswa()
    // {
    //     return $this->hasMany(Mahasiswa::class, 'prodi_id');
    // }

    /**
     * Get the pendaftar for the program studi.
     */
    // public function pendaftar()
    // {
    //     return $this->hasMany(Pendaftar::class, 'prodi_id');
    // }

    // ============================================
    // HELPER METHODS
    // ============================================

    /**
     * Check if program studi is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'aktif';
    }

    /**
     * Check if program studi can be deleted.
     */
    public function canBeDeleted(): bool
    {
        // Cek jika ada mahasiswa yang terdaftar di prodi ini
        // if ($this->mahasiswa()->exists()) {
        //     return false;
        // }
        
        return true;
    }

    /**
     * Toggle status program studi.
     */
    public function toggleStatus(): void
    {
        $this->status = $this->status === 'aktif' ? 'tidak aktif' : 'aktif';
        $this->save();
    }

    /**
     * Get the count of mahasiswa in this program studi.
     */
    public function getMahasiswaCount(): int
    {
        // if ($this->relationLoaded('mahasiswa')) {
        //     return $this->mahasiswa->count();
        // }
        // return $this->mahasiswa()->count();
        
        return 0;
    }

    // ============================================
    // BOOT METHOD (Optional)
    // ============================================

    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot()
    {
        parent::boot();

        // Sebelum menghapus, cek apakah prodi masih digunakan
        static::deleting(function ($prodi) {
            // if (!$prodi->canBeDeleted()) {
            //     throw new \Exception('Program Studi tidak dapat dihapus karena masih memiliki mahasiswa');
            // }
        });

        // Setelah membuat, log aktivitas (opsional)
        static::created(function ($prodi) {
            // \Log::info('Program Studi dibuat: ' . $prodi->nama_prodi);
        });

        // Setelah mengupdate, log aktivitas (opsional)
        static::updated(function ($prodi) {
            // \Log::info('Program Studi diupdate: ' . $prodi->nama_prodi);
        });

        // Setelah menghapus, log aktivitas (opsional)
        static::deleted(function ($prodi) {
            // \Log::info('Program Studi dihapus: ' . $prodi->nama_prodi);
        });
    }

    // ============================================
    // CUSTOM SERIALIZATION (Optional)
    // ============================================

    /**
     * Prepare the model for JSON serialization.
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        
        // Tambahkan custom fields
        $array['is_active'] = $this->isActive();
        $array['status_badge'] = $this->status_badge;
        $array['created_at_formatted'] = $this->created_at?->format('d M Y H:i');
        $array['updated_at_formatted'] = $this->updated_at?->format('d M Y H:i');
        
        return $array;
    }
}