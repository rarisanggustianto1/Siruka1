@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Form Tambah Fasilitas -->
    <div class="bg-white p-6 rounded-lg shadow h-fit">
        <h2 class="text-lg font-bold mb-4 text-gray-800">Tambah Fasilitas</h2>
        <form action="{{ route('admin.facilities.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium">Nama Fasilitas</label>
                <input type="text" name="nama_fasilitas" placeholder="Contoh: Proyektor" class="w-full border p-2 rounded text-sm" required>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded text-sm font-semibold">Simpan</button>
        </form>
    </div>

    <!-- Tabel Fasilitas -->
    <div class="md:col-span-2 bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-4 text-gray-800">Master Fasilitas</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 text-sm">Nama Fasilitas</th>
                    <th class="p-3 text-sm">Digunakan di</th>
                    <th class="p-3 text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($facilities as $f)
                    <tr class="border-b">
                        <td class="p-3 text-sm font-medium">{{ $f->nama_fasilitas }}</td>
                        <td class="p-3 text-sm">{{ $f->rooms_count }} Ruangan</td>
                        <td class="p-3 text-sm">
                            <form action="{{ route('admin.facilities.destroy', $f) }}" method="POST" onsubmit="return confirm('Hapus fasilitas ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection