<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomSchedule;
use Illuminate\Http\Request;

class RoomScheduleController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::orderBy('nama')->get();
        $schedules = RoomSchedule::with('room')
            ->when($request->filled('room_id'), fn ($query) => $query->where('room_id', $request->integer('room_id')))
            ->orderBy('room_id')->orderBy('day_of_week')->orderBy('jam_mulai')->paginate(30)->withQueryString();

        return view('admin.schedules.index', compact('rooms', 'schedules'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        RoomSchedule::create($validated);

        return back()->with('success', 'Jadwal rutin berhasil ditambahkan.');
    }

    public function update(Request $request, RoomSchedule $schedule)
    {
        $schedule->update($this->validated($request));

        return back()->with('success', 'Jadwal rutin berhasil diperbarui.');
    }

    public function destroy(RoomSchedule $schedule)
    {
        $schedule->delete();

        return back()->with('success', 'Jadwal rutin berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'day_of_week' => ['required', 'integer', 'between:1,7'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'in:teori,praktikum,responsi,lainnya'],
            'kelas' => ['nullable', 'string', 'max:100'],
            'periode' => ['required', 'string', 'max:100'],
            'aktif' => ['sometimes', 'boolean'],
        ]);
    }
}
