<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $today = Carbon::today()->toDateString();

        $stats = [
            'menunggu' => Booking::where('user_id', $userId)->where('status', 'menunggu')->count(),
            'disetujui' => Booking::where('user_id', $userId)->where('status', 'disetujui')->count(),
            'ditolak' => Booking::where('user_id', $userId)->where('status', 'ditolak')->count(),
            'total' => Booking::where('user_id', $userId)->count(),
        ];

        // Jadwal peminjaman terdekat (hari ini & mendatang)
        $upcomingBookings = Booking::with('room')
            ->where('user_id', $userId)
            ->where('tanggal', '>=', $today)
            ->whereIn('status', ['disetujui', 'menunggu'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->take(5)
            ->get();

        // Riwayat 5 pengajuan terakhir
        $recentBookings = Booking::with('room')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $availableRoomsCount = Room::where('status', 'tersedia')->count();

        return view('peminjam.dashboard', compact('stats', 'upcomingBookings', 'recentBookings', 'availableRoomsCount'));
    }
}
