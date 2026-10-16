@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>

    <!-- Card Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-indigo-500">
            <p class="text-xs font-bold text-indigo-600 uppercase">Total Ruangan</p>
            <p class="text-2xl font-bold text-gray-800">{{ $totalRuangan }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
            <p class="text-xs font-bold text-blue-600 uppercase">Total Peminjam</p>
            <p class="text-2xl font-bold text-gray-800">{{ $totalPengguna }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-yellow-500">
            <p class="text-xs font-bold text-yellow-600 uppercase">Menunggu Persetujuan</p>
            <p class="text-2xl font-bold text-gray-800">{{ $bookingMenunggu }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
            <p class="text-xs font-bold text-green-600 uppercase">Booking Hari Ini</p>
            <p class="text-2xl font-bold text-gray-800">{{ $bookingHariIni }}</p>
        </div>
    </div>

    <!-- Tabel 5 Pengajuan Terbaru -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold text-gray-800 mb-4">5 Pengajuan Terbaru Menunggu Persetujuan</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-3 text-sm font-semibold">Peminjam</th>
                        <th class="p-3 text-sm font-semibold">Ruangan</th>
                        <th class="p-3 text-sm font-semibold">Tanggal & Jam</th>
                        <th class="p-3 text-sm font-semibold">Keperluan</th>
                        <th class="p-3 text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $b)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 text-sm">{{ $b->user->name }} ({{ $b->user->nim_nip ?? '-' }})</td>
                            <td class="p-3 text-sm">{{ $b->room->nama }}</td>
                            <td class="p-3 text-sm">{{ $b->tanggal }} | {{ $b->jam_mulai }} - {{ $b->jam_selesai }}</td>
                            <td class="p-3 text-sm">{{ $b->keperluan }}</td>
                            <td class="p-3 text-sm">
                                <a href="{{ route('admin.bookings.index') }}" class="text-indigo-600 font-semibold hover:underline">Kelola</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-3 text-center text-sm text-gray-500">Tidak ada pengajuan baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection