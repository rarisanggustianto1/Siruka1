<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomSchedule extends Model
{
    protected $fillable = ['room_id', 'day_of_week', 'jam_mulai', 'jam_selesai', 'nama_kegiatan', 'jenis', 'kelas', 'periode', 'aktif'];

    protected function casts(): array
    {
        return ['day_of_week' => 'integer', 'aktif' => 'boolean'];
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public static function hasConflict(int $roomId, string $date, string $start, string $end): bool
    {
        $dayOfWeek = (int) Carbon::parse($date)->dayOfWeekIso;

        return static::query()
            ->where('room_id', $roomId)
            ->where('day_of_week', $dayOfWeek)
            ->where('aktif', true)
            ->where('jam_mulai', '<', $end)
            ->where('jam_selesai', '>', $start)
            ->exists();
    }
}
