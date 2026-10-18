<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'room_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'keperluan',
        'jumlah_peserta',
        'status',
        'alasan_penolakan',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'jumlah_peserta' => 'integer',
        ];
    }

    /**
     * User who created the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Room booked.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Check if a proposed booking time conflicts with a pending or approved booking.
     */
    public static function hasConflict(int $roomId, string $tanggal, string $jamMulai, string $jamSelesai, ?int $excludeId = null): bool
    {
        $jamMulaiFormatted = strlen($jamMulai) === 5 ? $jamMulai.':00' : $jamMulai;
        $jamSelesaiFormatted = strlen($jamSelesai) === 5 ? $jamSelesai.':00' : $jamSelesai;

        $jamMulai5 = substr($jamMulai, 0, 5);
        $jamSelesai5 = substr($jamSelesai, 0, 5);

        $query = static::where('room_id', $roomId)
            ->whereDate('tanggal', $tanggal)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->where(function ($q) use ($jamMulaiFormatted, $jamSelesaiFormatted, $jamMulai5, $jamSelesai5) {
                $q->where(function ($sub) use ($jamSelesaiFormatted, $jamSelesai5) {
                    $sub->where('jam_mulai', '<', $jamSelesaiFormatted)
                        ->orWhere('jam_mulai', '<', $jamSelesai5);
                })->where(function ($sub) use ($jamMulaiFormatted, $jamMulai5) {
                    $sub->where('jam_selesai', '>', $jamMulaiFormatted)
                        ->orWhere('jam_selesai', '>', $jamMulai5);
                });
            });

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Formatted time range (e.g. 08:00 - 10:00 WIB).
     */
    public function getFormattedWaktuAttribute(): string
    {
        $mulai = substr((string) $this->jam_mulai, 0, 5);
        $selesai = substr((string) $this->jam_selesai, 0, 5);

        return "{$mulai} - {$selesai} WIB";
    }

    /**
     * Human readable status badge label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'disetujui' => 'Disetujui',
            'menunggu' => 'Menunggu',
            'ditolak' => 'Ditolak',
            'dibatalkan' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }
}
