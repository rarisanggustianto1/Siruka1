@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow space-y-4">
    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Daftar Ruangan</h1>
        <a href="{{ route('admin.rooms.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">+ Tambah Ruangan</a>
    </div>

    <!-- Filter & Search -->
    <form method="GET" action="{{ route('admin.rooms.index') }}" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/kode..." class="border p-2 text-sm rounded w-full md:w-1/3">
        <select name="gedung" class="border p-2 text-sm rounded">
            <option value="">Semua Gedung</option>
            @foreach($gedungs as $g)
                <option value="{{ $g }}" {{ request('gedung') == $g ? 'selected' : '' }}>{{ $g }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 text-sm rounded">Filter</button>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 text-sm">Kode</th>
                    <th class="p-3 text-sm">Nama Ruangan</th>
                    <th class="p-3 text-sm">Gedung / Lantai</th>
                    <th class="p-3 text-sm">Kapasitas</th>
                    <th class="p-3 text-sm">Fasilitas</th>
                    <th class="p-3 text-sm">Status</th>
                    <th class="p-3 text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm font-semibold">{{ $room->kode }}</td>
                        <td class="p-3 text-sm">{{ $room->nama }}</td>
                        <td class="p-3 text-sm">{{ $room->gedung }} / Lt. {{ $room->lantai }}</td>
                        <td class="p-3 text-sm">{{ $room->kapasitas }} orang</td>
                        <td class="p-3 text-sm">
                            @foreach($room->facilities as $f)
                                <span class="bg-gray-200 text-gray-800 text-xs px-2 py-0.5 rounded">{{ $f->nama_fasilitas }}</span>
                            @endforeach
                        </td>
                        <td class="p-3 text-sm">
                            <span class="px-2 py-1 rounded text-xs text-white {{ $room->status == 'tersedia' ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </td>
                        <td class="p-3 text-sm space-x-1">
                            <a href="{{ route('admin.rooms.edit', $room) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="inline" onsubmit="return confirm('Hapus ruangan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="p-3 text-center text-sm text-gray-500">Data tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $rooms->links() }}
</div>
@endsection