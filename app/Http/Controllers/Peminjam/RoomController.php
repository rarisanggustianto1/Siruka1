<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('facilities');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%")
                    ->orWhere('gedung', 'like', "%{$search}%");
            });
        }

        if ($request->filled('gedung')) {
            $query->where('gedung', $request->gedung);
        }

        if ($request->filled('min_kapasitas')) {
            $query->where('kapasitas', '>=', (int) $request->min_kapasitas);
        }

        if ($request->filled('facility_id')) {
            $query->whereHas('facilities', function ($q) use ($request) {
                $q->where('facilities.id', $request->facility_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rooms = $query->orderBy('nama')->paginate(9)->withQueryString();
        $buildings = Room::distinct()->pluck('gedung')->sort()->values();
        $facilities = Facility::orderBy('nama_fasilitas')->get();

        return view('peminjam.rooms.index', compact('rooms', 'buildings', 'facilities'));
    }

    public function show(Request $request, Room $room)
    {
        $room->load('facilities');

        // Selected date for checking availability, default today
        $selectedDate = $request->query('tanggal', Carbon::today()->toDateString());

        // Approved bookings for the room on this selected date
        $approvedBookings = Booking::with('user')
            ->where('room_id', $room->id)
            ->where('tanggal', $selectedDate)
            ->where('status', 'disetujui')
            ->orderBy('jam_mulai')
            ->get();

        // Also get pending bookings if any (to show indicator)
        $pendingBookings = Booking::with('user')
            ->where('room_id', $room->id)
            ->where('tanggal', $selectedDate)
            ->where('status', 'menunggu')
            ->orderBy('jam_mulai')
            ->get();

        return view('peminjam.rooms.show', compact('room', 'selectedDate', 'approvedBookings', 'pendingBookings'));
    }

    /**
     * JSON Endpoint for checking room availability on a date
     */
    public function scheduleJson(Request $request, Room $room)
    {
        $date = $request->query('tanggal', Carbon::today()->toDateString());

        $bookings = Booking::where('room_id', $room->id)
            ->where('tanggal', $date)
            ->where('status', 'disetujui')
            ->orderBy('jam_mulai')
            ->get(['id', 'jam_mulai', 'jam_selesai', 'keperluan']);

        return response()->json([
            'room' => [
                'id' => $room->id,
                'nama' => $room->nama,
                'status' => $room->status,
                'kapasitas' => $room->kapasitas,
            ],
            'tanggal' => $date,
            'is_maintenance' => $room->status === 'maintenance',
            'bookings' => $bookings,
        ]);
    }
}
