<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
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

        $rooms = $query->orderBy('nama')->paginate(6)->withQueryString();

        $buildings = Room::distinct()->pluck('gedung')->sort()->values();
        $facilities = Facility::orderBy('nama_fasilitas')->get();

        $stats = [
            'total_rooms' => Room::count(),
            'available_rooms' => Room::where('status', 'tersedia')->count(),
            'approved_bookings' => Booking::where('status', 'disetujui')->count(),
            'total_users' => User::whereIn('role', ['peminjam', 'user'])->count(),
        ];

        return view('landing', compact('rooms', 'buildings', 'facilities', 'stats'));
    }
}
