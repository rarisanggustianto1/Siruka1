@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-xl font-bold mb-4 text-gray-800">Tambah Ruangan Baru</h1>
    <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Kode Ruangan</label>
                <input type="text" name="kode" value="{{ old('kode') }}" class="w-full border p-2 rounded text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Nama Ruangan</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border p-2 rounded text-sm" required>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium">Gedung</label>
                <input type="text" name="gedung" value="{{ old('gedung') }}" class="w-full border p-2 rounded text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Lantai</label>
                <input type="number" name="lantai" value="{{ old('lantai') }}" class="w-full border p-2 rounded text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Kapasitas (Orang)</label>
                <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" class="w-full border p-2 rounded text-sm" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium">Status Ruangan</label>
            <select name="status" class="w-full border p-2 rounded text-sm">
                <option value="tersedia">Tersedia</option>
                <option value="maintenance">Maintenance</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Pilih Fasilitas</label>
            <div class="grid grid-cols-3 gap-2 border p-3 rounded">
                @foreach($facilities as $f)
                    <label class="inline-flex items-center text-sm">
                        <input type="checkbox" name="facilities[]" value="{{ $f->id }}" class="mr-2"> {{ $f->nama_fasilitas }}
                    </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium">Foto Ruangan</label>
            <input type="file" name="foto" class="w-full border p-2 rounded text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="w-full border p-2 rounded text-sm">{{ old('deskripsi') }}</textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm font-semibold">Simpan Ruangan</button>
    </form>
</div>
@endsection