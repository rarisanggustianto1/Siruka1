@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-lg shadow h-fit">
        <h2 class="text-lg font-bold mb-4 text-gray-800">Tambah Peminjam Baru</h2>
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm font-medium">Nama Lengkap</label>
                <input type="text" name="name" class="w-full border p-2 rounded text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" class="w-full border p-2 rounded text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium">NIM / NIP</label>
                <input type="text" name="nim_nip" class="w-full border p-2 rounded text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium">No. HP</label>
                <input type="text" name="no_hp" class="w-full border p-2 rounded text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" class="w-full border p-2 rounded text-sm" required>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded text-sm font-semibold">Tambah User</button>
        </form>
    </div>

    <div class="md:col-span-2 bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-4 text-gray-800">Daftar Peminjam</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 text-sm">Nama</th>
                    <th class="p-3 text-sm">NIM / NIP</th>
                    <th class="p-3 text-sm">Email / HP</th>
                    <th class="p-3 text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                    <tr class="border-b">
                        <td class="p-3 text-sm font-medium">{{ $u->name }}</td>
                        <td class="p-3 text-sm">{{ $u->nim_nip ?? '-' }}</td>
                        <td class="p-3 text-sm">{{ $u->email }}<br><span class="text-xs text-gray-500">{{ $u->no_hp }}</span></td>
                        <td class="p-3 text-sm">
                            <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection