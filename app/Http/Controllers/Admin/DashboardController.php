<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        $totalRuangan = Room::count();
        $totalPengguna = User::whereIn('role', ['peminjam', 'user'])->count();
        $bookingMenunggu = Booking::where('status', 'menunggu')->count();
        $bookingHariIni = Booking::where('tanggal', $today)->where('status', 'disetujui')->count();

        $stats = [
            'total_ruangan' => $totalRuangan,
            'total_pengguna' => $totalPengguna,
            'booking_menunggu' => $bookingMenunggu,
            'booking_hari_ini' => $bookingHariIni,
            'total_fasilitas' => Facility::count(),
            'ruangan_maintenance' => Room::where('status', 'maintenance')->count(),
        ];

        // 5 pengajuan terbaru yang menunggu persetujuan
        $pendingBookings = Booking::with(['user', 'room'])
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentBookings = $pendingBookings;

        // Jadwal booking hari ini
        $todayBookings = Booking::with(['user', 'room'])
            ->where('tanggal', $today)
            ->where('status', 'disetujui')
            ->orderBy('jam_mulai')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'pendingBookings',
            'todayBookings',
            'totalRuangan',
            'totalPengguna',
            'bookingMenunggu',
            'bookingHariIni',
            'recentBookings'
        ));
    }
}
