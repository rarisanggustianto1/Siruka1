<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomSchedule;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'room']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
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

        $bookings = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->paginate(10)
            ->withQueryString();

        $rooms = Room::orderBy('nama')->get();

        return view('admin.bookings.index', compact('bookings', 'rooms'));
    }

    public function approve(Booking $booking)
    {
        // Check if room is in maintenance
        if ($booking->room->status === 'maintenance') {
            return back()->with('error', "Persetujuan gagal: Ruangan '{$booking->room->nama}' saat ini berstatus Maintenance.");
        }

        // Check conflict with existing approved bookings
        if (RoomSchedule::hasConflict($booking->room_id, $booking->tanggal->toDateString(), $booking->jam_mulai, $booking->jam_selesai)) {
            return back()->with('error', 'Persetujuan gagal: waktu pengajuan bentrok dengan jadwal kuliah rutin ruangan.');
        }

        if (Booking::hasConflict($booking->room_id, $booking->tanggal->toDateString(), $booking->jam_mulai, $booking->jam_selesai, $booking->id)) {
            return back()->with('error', 'Persetujuan gagal: Terdapat jadwal booking lain yang telah disetujui pada ruangan, tanggal, dan rentang jam tersebut (Jadwal Bentrok).');
        }

        $booking->update([
            'status' => 'disetujui',
            'alasan_penolakan' => null,
        ]);

        return back()->with('success', "Pengajuan booking untuk '{$booking->room->nama}' berhasil disetujui.");
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'room.facilities']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function cetak(Booking $booking)
    {
        $booking->load(['user', 'room.facilities']);

        return view('admin.bookings.cetak', compact('booking'));
    }

    public function showRejectForm(Booking $booking)
    {
        $booking->load(['user', 'room']);

        return view('admin.bookings.reject', compact('booking'));
    }

    public function reject(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'alasan_penolakan' => ['required', 'string', 'min:5', 'max:500'],
        ], [
            'alasan_penolakan.required' => 'Wajib mengisi alasan penolakan booking.',
            'alasan_penolakan.min' => 'Alasan penolakan minimal 5 karakter.',
        ]);

        $booking->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $validated['alasan_penolakan'],
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', "Pengajuan booking untuk '{$booking->room->nama}' telah ditolak dengan alasan yang tercatat.");
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return back()->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
