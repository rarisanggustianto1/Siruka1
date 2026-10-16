@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white p-6 rounded-lg shadow space-y-4">
        <h1 class="text-2xl font-bold text-gray-800">{{ $room->nama }}</h1>
        <p class="text-sm text-gray-600">{{ $room->gedung }} - Lantai {{ $room->lantai }} | Kapasitas: {{ $room->kapasitas }} Orang</p>

        <!-- Form Filter Tanggal Ketersediaan -->
        <form method="GET" action="{{ route('user.rooms.show', $room) }}" class="flex items-center gap-3 border-t border-b py-3">
            <label class="text-sm font-semibold">Lihat Jadwal Tanggal:</label>
            <input type="date" name="tanggal" value="{{ $selectedDate }}" class="border p-1.5 text-sm rounded">
            <button type="submit" class="bg-indigo-600 text-white text-xs px-3 py-2 rounded">Cek</button>
        </form>

        <!-- Daftar Jam Terpakai -->
        <div>
            <h3 class="font-bold text-sm text-gray-700 mb-2">Jadwal Terpakai pada {{ $selectedDate }}:</h3>
            <div class="space-y-2">
                @forelse($occupiedSchedules as $s)
                    <div class="bg-red-50 border-l-4 border-red-500 p-3 text-xs">
                        <p class="font-bold text-red-700">{{ $s->jam_mulai }} - {{ $s->jam_selesai }}</p>
                        <p class="text-gray-600">Keperluan: {{ $s->keperluan }}</p>
                    </div>
                @empty
                    <p class="text-sm text-green-600 font-semibold bg-green-50 p-3 rounded">Belum ada peminjaman pada tanggal ini (Ruangan Kosong).</p>
                @endforelse
            </div>
        </div>

        <a href="{{ route('user.bookings.create', ['room_id' => $room->id]) }}" class="inline-block bg-indigo-600 text-white text-sm px-4 py-2 rounded font-semibold">Lanjut Ajukan Booking</a>
    </div>
</div>
@endsection