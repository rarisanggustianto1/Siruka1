<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('room')->where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        $bookings = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('peminjam.bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $rooms = Room::where('status', 'tersedia')->orderBy('nama')->get();
        $selectedRoomId = $request->query('room_id');

        return view('peminjam.bookings.create', compact('rooms', 'selectedRoomId'));
    }

    public function store(Request $request)
    {
        $today = Carbon::today()->toDateString();

        $validated = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'tanggal' => ['required', 'date', 'after_or_equal:'.$today],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'keperluan' => ['required', 'string', 'max:500'],
            'jumlah_peserta' => ['required', 'integer', 'min:1'],
        ], [
            'room_id.required' => 'Silakan pilih ruangan yang akan dipinjam.',
            'room_id.exists' => 'Ruangan yang dipilih tidak valid.',
            'tanggal.required' => 'Tanggal peminjaman wajib diisi.',
            'tanggal.after_or_equal' => 'Tanggal booking tidak boleh di masa lalu.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',
            'keperluan.required' => 'Keperluan peminjaman wajib diisi.',
            'jumlah_peserta.required' => 'Jumlah peserta wajib diisi.',
            'jumlah_peserta.min' => 'Jumlah peserta minimal 1 orang.',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        // Batasan Jam Operasional Kampus: 07:00 - 22:00
        if ($validated['jam_mulai'] < '07:00' || $validated['jam_selesai'] > '22:00') {
            return back()->withInput()->withErrors([
                'jam_mulai' => 'Jam peminjaman harus berada di dalam jam operasional kampus (07:00 - 22:00 WIB).',
            ]);
        }

        // Batasan: Waktu yang sudah lewat hari ini
        if ($validated['tanggal'] === $today && $validated['jam_mulai'] < now()->format('H:i')) {
            return back()->withInput()->withErrors([
                'jam_mulai' => 'Jam mulai tidak boleh di waktu yang sudah terlewat untuk hari ini.',
            ]);
        }

        // Batasan 1: Ruangan berstatus Maintenance tidak bisa dibooking
        if ($room->status === 'maintenance') {
            return back()->withInput()->withErrors([
                'room_id' => "Ruangan '{$room->nama}' saat ini dalam status Maintenance dan tidak dapat dipesan.",
            ]);
        }

        // Batasan 2: Jumlah peserta tidak boleh melebihi kapasitas ruangan
        if ($validated['jumlah_peserta'] > $room->kapasitas) {
            return back()->withInput()->withErrors([
                'jumlah_peserta' => "Jumlah peserta ({$validated['jumlah_peserta']} orang) melebihi kapasitas maksimal ruangan {$room->nama} ({$room->kapasitas} orang).",
            ]);
        }

        // Batasan 3: Booking tidak boleh bentrok dengan booking berstatus Disetujui
        if (Booking::hasConflict($room->id, $validated['tanggal'], $validated['jam_mulai'], $validated['jam_selesai'])) {
            return back()->withInput()->withErrors([
                'jam_mulai' => "Jadwal bentrok: Ruangan '{$room->nama}' sudah dipesan & disetujui untuk peminjam lain pada tanggal dan jam tersebut.",
            ]);
        }

        // Simpan booking baru dengan status default 'menunggu'
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'tanggal' => $validated['tanggal'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'keperluan' => $validated['keperluan'],
            'jumlah_peserta' => $validated['jumlah_peserta'],
            'status' => 'menunggu',
        ]);

        return redirect()->route('peminjam.bookings.index')
            ->with('success', "Pengajuan peminjaman ruangan '{$room->nama}' berhasil dikirim! Menunggu persetujuan admin.");
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak melihat rincian peminjaman ini.');
        }

        $booking->load(['room.facilities', 'user']);

        return view('peminjam.bookings.show', compact('booking'));
    }

    public function cetak(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mencetak dokumen peminjaman ini.');
        }

        if ($booking->status !== 'disetujui') {
            return redirect()->route('peminjam.bookings.index')
                ->with('error', 'Surat bukti peminjaman hanya dapat dicetak setelah pengajuan disetujui oleh Administrator.');
        }

        $booking->load(['room.facilities', 'user']);

        return view('peminjam.bookings.cetak', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        // Peminjam hanya bisa mengubah booking miliknya sendiri
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses booking ini.');
        }

        // Hanya bisa diubah jika status masih 'menunggu'
        if ($booking->status !== 'menunggu') {
            return redirect()->route('peminjam.bookings.index')
                ->with('error', 'Pengajuan booking tidak dapat diubah karena sudah diproses ('.ucfirst($booking->status).').');
        }

        $rooms = Room::where('status', 'tersedia')->orWhere('id', $booking->room_id)->orderBy('nama')->get();

        return view('peminjam.bookings.edit', compact('booking', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        // Peminjam hanya bisa mengubah booking miliknya sendiri
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengubah booking ini.');
        }

        // Hanya bisa diubah jika status masih 'menunggu'
        if ($booking->status !== 'menunggu') {
            return redirect()->route('peminjam.bookings.index')
                ->with('error', 'Pengajuan booking tidak dapat diubah karena sudah diproses ('.ucfirst($booking->status).').');
        }

        $today = Carbon::today()->toDateString();

        $validated = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'tanggal' => ['required', 'date', 'after_or_equal:'.$today],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'keperluan' => ['required', 'string', 'max:500'],
            'jumlah_peserta' => ['required', 'integer', 'min:1'],
        ], [
            'room_id.required' => 'Silakan pilih ruangan yang akan dipinjam.',
            'tanggal.required' => 'Tanggal peminjaman wajib diisi.',
            'tanggal.after_or_equal' => 'Tanggal booking tidak boleh di masa lalu.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',
            'keperluan.required' => 'Keperluan peminjaman wajib diisi.',
            'jumlah_peserta.required' => 'Jumlah peserta wajib diisi.',
            'jumlah_peserta.min' => 'Jumlah peserta minimal 1 orang.',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        // Batasan Jam Operasional Kampus: 07:00 - 22:00
        if ($validated['jam_mulai'] < '07:00' || $validated['jam_selesai'] > '22:00') {
            return back()->withInput()->withErrors([
                'jam_mulai' => 'Jam peminjaman harus berada di dalam jam operasional kampus (07:00 - 22:00 WIB).',
            ]);
        }

        // Batasan: Waktu yang sudah lewat hari ini
        if ($validated['tanggal'] === $today && $validated['jam_mulai'] < now()->format('H:i')) {
            return back()->withInput()->withErrors([
                'jam_mulai' => 'Jam mulai tidak boleh di waktu yang sudah terlewat untuk hari ini.',
            ]);
        }

        // Ruangan berstatus Maintenance tidak bisa dibooking
        if ($room->status === 'maintenance') {
            return back()->withInput()->withErrors([
                'room_id' => "Ruangan '{$room->nama}' saat ini dalam status Maintenance dan tidak dapat dipesan.",
            ]);
        }

        // Kapasitas check
        if ($validated['jumlah_peserta'] > $room->kapasitas) {
            return back()->withInput()->withErrors([
                'jumlah_peserta' => "Jumlah peserta ({$validated['jumlah_peserta']} orang) melebihi kapasitas maksimal ruangan {$room->nama} ({$room->kapasitas} orang).",
            ]);
        }

        // Bentrok check
        if (Booking::hasConflict($room->id, $validated['tanggal'], $validated['jam_mulai'], $validated['jam_selesai'], $booking->id)) {
            return back()->withInput()->withErrors([
                'jam_mulai' => "Jadwal bentrok: Ruangan '{$room->nama}' sudah dipesan & disetujui untuk peminjam lain pada tanggal dan jam tersebut.",
            ]);
        }

        $booking->update([
            'room_id' => $room->id,
            'tanggal' => $validated['tanggal'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'keperluan' => $validated['keperluan'],
            'jumlah_peserta' => $validated['jumlah_peserta'],
        ]);

        return redirect()->route('peminjam.bookings.index')
            ->with('success', 'Data pengajuan peminjaman berhasil diperbarui.');
    }

    public function destroy(Booking $booking)
    {
        // Peminjam hanya bisa membatalkan booking miliknya sendiri
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak membatalkan booking ini.');
        }

        // Batalkan pengajuan hanya jika status masih Menunggu
        if ($booking->status !== 'menunggu') {
            return back()->with('error', 'Hanya booking berstatus Menunggu yang dapat dibatalkan.');
        }

        // Update status to 'dibatalkan' or delete.
        // As per spec: "Batalkan pengajuan hanya jika status masih Menunggu", status booking enum: "menunggu, disetujui, ditolak, dibatalkan"
        $booking->update(['status' => 'dibatalkan']);

        return redirect()->route('peminjam.bookings.index')
            ->with('success', 'Pengajuan peminjaman telah berhasil dibatalkan.');
    }
}
