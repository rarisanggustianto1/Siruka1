@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Peminjam</h1>

    <!-- Ringkasan Status -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-yellow-500">
            <p class="text-xs font-bold text-yellow-600 uppercase">Pengajuan Menunggu</p>
            <p class="text-2xl font-bold text-gray-800">{{ $menunggu }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
            <p class="text-xs font-bold text-green-600 uppercase">Pengajuan Disetujui</p>
            <p class="text-2xl font-bold text-gray-800">{{ $disetujui }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-red-500">
            <p class="text-xs font-bold text-red-600 uppercase">Pengajuan Ditolak</p>
            <p class="text-2xl font-bold text-gray-800">{{ $ditolak }}</p>
        </div>
    </div>

    <!-- Peminjaman Terdekat -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Jadwal Peminjaman Terdekat Anda</h2>
        <div class="space-y-3">
            @forelse($upcomingBookings as $b)
                <div class="flex justify-between items-center border p-3 rounded">
                    <div>
                        <p class="font-bold text-indigo-600">{{ $b->room->nama }}</p>
                        <p class="text-xs text-gray-500">{{ $b->tanggal }} | {{ $b->jam_mulai }} - {{ $b->jam_selesai }}</p>
                    </div>
                    <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-semibold">Disetujui</span>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Belum ada peminjaman ruangan yang disetujui dalam waktu dekat.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection