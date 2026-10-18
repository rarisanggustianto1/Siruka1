<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->endOfMonth()->toDateString());
        $status = $request->query('status');
        $roomId = $request->query('room_id');
        $search = $request->query('search');

        $query = Booking::with(['user', 'room'])
            ->whereBetween('tanggal', [$startDate, $endDate]);

        if (! empty($status)) {
            $query->where('status', $status);
        }

        if (! empty($roomId)) {
            $query->where('room_id', $roomId);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('keperluan', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('nim_nip', 'like', "%{$search}%");
                    })
                    ->orWhereHas('room', function ($r) use ($search) {
                        $r->where('nama', 'like', "%{$search}%")
                            ->orWhere('kode', 'like', "%{$search}%");
                    });
            });
        }

        $periodQuery = Booking::whereBetween('tanggal', [$startDate, $endDate]);
        if (! empty($roomId)) {
            $periodQuery->where('room_id', $roomId);
        }

        $totalInPeriod = (clone $periodQuery)->count();
        $disetujuiCount = (clone $periodQuery)->where('status', 'disetujui')->count();
        $menungguCount = (clone $periodQuery)->where('status', 'menunggu')->count();
        $ditolakCount = (clone $periodQuery)->where('status', 'ditolak')->count();
        $dibatalkanCount = (clone $periodQuery)->where('status', 'dibatalkan')->count();

        $processedCount = $disetujuiCount + $ditolakCount;
        $approvalRate = $processedCount > 0 ? round(($disetujuiCount / $processedCount) * 100, 1) : 0;

        $topRoom = (clone $periodQuery)
            ->where('status', 'disetujui')
            ->selectRaw('room_id, count(*) as count')
            ->groupBy('room_id')
            ->orderByDesc('count')
            ->with('room')
            ->first();

        $bookings = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->paginate(15)
            ->withQueryString();

        $rooms = Room::orderBy('nama')->get();

        return view('admin.reports.index', compact(
            'bookings',
            'rooms',
            'startDate',
            'endDate',
            'status',
            'roomId',
            'search',
            'totalInPeriod',
            'disetujuiCount',
            'menungguCount',
            'ditolakCount',
            'dibatalkanCount',
            'approvalRate',
            'topRoom'
        ));
    }

    public function print(Request $request)
    {
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->endOfMonth()->toDateString());
        $status = $request->query('status');
        $roomId = $request->query('room_id');
        $search = $request->query('search');

        $query = Booking::with(['user', 'room'])
            ->whereBetween('tanggal', [$startDate, $endDate]);

        if (! empty($status)) {
            $query->where('status', $status);
        }

        if (! empty($roomId)) {
            $query->where('room_id', $roomId);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('keperluan', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('nim_nip', 'like', "%{$search}%");
                    })
                    ->orWhereHas('room', function ($r) use ($search) {
                        $r->where('nama', 'like', "%{$search}%")
                            ->orWhere('kode', 'like', "%{$search}%");
                    });
            });
        }

        $bookings = $query->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        $selectedRoom = ! empty($roomId) ? Room::find($roomId) : null;

        $stats = [
            'total' => $bookings->count(),
            'disetujui' => $bookings->where('status', 'disetujui')->count(),
            'menunggu' => $bookings->where('status', 'menunggu')->count(),
            'ditolak' => $bookings->where('status', 'ditolak')->count(),
            'dibatalkan' => $bookings->where('status', 'dibatalkan')->count(),
        ];

        return view('admin.reports.print', compact(
            'bookings',
            'startDate',
            'endDate',
            'status',
            'selectedRoom',
            'stats'
        ));
    }
}
