<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Facility extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_fasilitas',
    ];

    /**
     * The rooms that have this facility.
     */
    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'facility_room', 'facility_id', 'room_id')->withTimestamps();
    }
}
