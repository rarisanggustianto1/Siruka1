<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'kode',
        'nama',
        'gedung',
        'lantai',
        'kapasitas',
        'deskripsi',
        'foto',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'lantai' => 'integer',
            'kapasitas' => 'integer',
        ];
    }

    /**
     * The facilities in this room (Many-to-Many).
     */
    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'facility_room', 'room_id', 'facility_id')->withPivot(['kode_barang', 'nomor_inventaris', 'tahun', 'jumlah', 'kondisi', 'catatan'])->withTimestamps();
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(RoomSchedule::class);
    }

    /**
     * Bookings for this room.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if room has active bookings (pending or approved today/future).
     */
    public function hasActiveBookings(): bool
    {
        return $this->bookings()
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->where('tanggal', '>=', now()->toDateString())
            ->exists();
    }

    /**
     * Check if room is available.
     */
    public function isAvailable(): bool
    {
        return $this->status === 'tersedia';
    }

    /**
     * Get photo URL or default placeholder.
     */
    public function getFotoUrlAttribute(): ?string
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return asset('storage/'.$this->foto);
        }

        return null;
    }
}
