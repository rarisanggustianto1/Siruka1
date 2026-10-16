@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow space-y-4">
    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Riwayat Pengajuan Booking Saya</h1>
        <a href="{{ route('user.bookings.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">+ Buat Pengajuan</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 text-sm">Ruangan</th>
                    <th class="p-3 text-sm">Tanggal & Waktu</th>
                    <th class="p-3 text-sm">Keperluan</th>
                    <th class="p-3 text-sm">Status</th>
                    <th class="p-3 text-sm">Catatan Admin</th>
                    <th class="p-3 text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm font-semibold">{{ $b->room->nama }}</td>
                        <td class="p-3 text-sm">{{ $b->tanggal }}<br><span class="text-xs text-gray-500">{{ $b->jam_mulai }} - {{ $b->jam_selesai }}</span></td>
                        <td class="p-3 text-sm">{{ $b->keperluan }}</td>
                        <td class="p-3 text-sm">
                            <span class="px-2 py-1 rounded text-xs text-white 
                                {{ $b->status == 'menunggu' ? 'bg-yellow-500' : ($b->status == 'disetujui' ? 'bg-green-500' : ($b->status == 'ditolak' ? 'bg-red-500' : 'bg-gray-500')) }}">
                                {{ ucfirst($b->status) }}
                            </span>
                        </td>
                        <td class="p-3 text-sm text-red-600 text-xs">{{ $b->alasan_penolakan ?? '-' }}</td>
                        <td class="p-3 text-sm">
                            @if($b->status === 'menunggu')
                                <form action="{{ route('user.bookings.cancel', $b) }}" method="POST" onsubmit="return confirm('Batalkan pengajuan ini?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-red-600 hover:underline text-xs">Batalkan</button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-3 text-center text-sm text-gray-500">Belum pernah membuat pengajuan booking.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $bookings->links() }}
</div>
@endsection