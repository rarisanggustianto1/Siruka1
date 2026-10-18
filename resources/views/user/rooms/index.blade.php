@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Ketersediaan Ruangan</h1>
    </div>


    <form method="GET" action="{{ route('user.rooms.index') }}" class="bg-white p-4 rounded-lg shadow flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-xs font-bold text-gray-600 mb-1">Minimal Kapasitas</label>
            <input type="number" name="min_kapasitas" value="{{ request('min_kapasitas') }}" placeholder="cth: 30" class="border p-2 text-sm rounded w-32">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-600 mb-1">Fasilitas</label>
            <div class="flex gap-2">
                @foreach($facilities as $f)
                    <label class="text-xs flex items-center bg-gray-100 px-2 py-1 rounded">
                        <input type="checkbox" name="facilities[]" value="{{ $f->id }}" 
                            {{ is_array(request('facilities')) && in_array($f->id, request('facilities')) ? 'checked' : '' }} class="mr-1">
                        {{ $f->nama_fasilitas }}
                    </label>
                @endforeach
            </div>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 text-sm rounded">Cari Ruangan</button>
    </form>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($rooms as $room)
            <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="h-40 bg-gray-200 flex items-center justify-center">
                        @if($room->foto)
                            <img src="{{ asset('storage/' . $room->foto) }}" class="h-full w-full object-cover">
                        @else
                            <span class="text-gray-400 text-sm">Tidak Ada Foto</span>
                        @endif
                    </div>
                    <div class="p-4 space-y-2">
                        <h2 class="font-bold text-lg text-gray-800">{{ $room->nama }}</h2>
                        <p class="text-xs text-gray-500">{{ $room->gedung }} (Lantai {{ $room->lantai }})</p>
                        <p class="text-sm font-semibold text-blue-600">Kapasitas: {{ $room->kapasitas }} orang</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach($room->facilities as $f)
                                <span class="bg-blue-50 text-blue-700 text-xs px-2 py-0.5 rounded">{{ $f->nama_fasilitas }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 border-t flex gap-2">
                    <a href="{{ route('user.rooms.show', $room) }}" class="w-1/2 text-center border border-blue-600 text-blue-600 py-1.5 rounded text-xs font-semibold">Cek Jadwal</a>
                    <a href="{{ route('user.bookings.create', ['room_id' => $room->id]) }}" class="w-1/2 text-center bg-blue-600 text-white py-1.5 rounded text-xs font-semibold">Booking</a>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-sm col-span-3">Tidak ada ruangan yang cocok dengan kriteria filter.</p>
        @endforelse
    </div>
    {{ $rooms->links() }}
</div>
@endsection