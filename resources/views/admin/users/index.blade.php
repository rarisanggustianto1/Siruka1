@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kelola Pengguna</h1>
            <p class="mt-1 text-sm text-slate-500">Cari, lihat, dan kelola akun peminjam maupun admin.</p>
        </div>
        <button type="button" class="siruka-primary-button rounded-lg px-4 py-2.5 text-sm font-bold" onclick="document.getElementById('user-create-modal').showModal()">+ Tambah Pengguna</button>
    </div>

    <form method="GET" action="{{ route('admin.users.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="user-filters">
            <label class="text-xs font-bold text-slate-600">Cari nama, email, atau NIM / NIP
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." class="mt-1 w-full">
            </label>
            <label class="text-xs font-bold text-slate-600">Peran
                <select name="role" class="mt-1 w-full"><option value="">Semua peran</option><option value="peminjam" @selected(request('role') === 'peminjam')>Peminjam</option><option value="user" @selected(request('role') === 'user')>Pengguna</option><option value="admin" @selected(request('role') === 'admin')>Admin</option></select>
            </label>
            <button type="submit" class="siruka-primary-button rounded-lg px-5 py-2.5 text-sm font-bold">Cari</button>
        </div>
    </form>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-5 py-4"><h2 class="font-bold text-slate-900">Daftar Pengguna</h2><p class="mt-1 text-xs text-slate-500">{{ $users->total() }} akun terdaftar</p></div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm">
                <thead><tr><th class="p-4">Nama</th><th class="p-4">NIM / NIP</th><th class="p-4">Email / HP</th><th class="p-4">Peran</th><th class="p-4">Booking</th><th class="p-4">Aksi</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-blue-50/40">
                            <td class="p-4 font-semibold text-slate-900">{{ $user->name }}</td><td class="p-4 text-slate-600">{{ $user->nim_nip ?: '—' }}</td>
                            <td class="p-4 text-slate-700">{{ $user->email }}<span class="mt-1 block text-xs text-slate-500">{{ $user->no_hp ?: '—' }}</span></td>
                            <td class="p-4"><span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-800">{{ ucfirst($user->role) }}</span></td><td class="p-4">{{ $user->bookings_count }}</td>
                            <td class="p-4"><form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">@csrf @method('DELETE')<button type="submit" class="inventory-action">Hapus</button></form></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-10 text-center text-slate-500">Pengguna tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 p-4">{{ $users->links() }}</div>
    </section>

    <dialog id="user-create-modal" class="siruka-modal">
        <div class="siruka-modal__header"><div><h2 class="text-lg font-bold text-slate-900">Tambah Pengguna</h2><p class="text-sm text-slate-500">Masukkan informasi akun baru.</p></div><button type="button" class="siruka-modal__close" onclick="this.closest('dialog').close()" aria-label="Tutup">&times;</button></div>
        <form action="{{ route('admin.users.store') }}" method="POST" class="user-create-form mt-5">
            @csrf
            <label>Nama lengkap<input name="name" value="{{ old('name') }}" required maxlength="255"></label>
            <label>Email<input type="email" name="email" value="{{ old('email') }}" required maxlength="255"></label>
            <label>NIM / NIP<input name="nim_nip" value="{{ old('nim_nip') }}" maxlength="50"></label>
            <label>No. HP<input name="no_hp" value="{{ old('no_hp') }}" maxlength="20"></label>
            <label>Peran<select name="role" required><option value="peminjam" @selected(old('role', 'peminjam') === 'peminjam')>Peminjam</option><option value="admin" @selected(old('role') === 'admin')>Admin</option><option value="user" @selected(old('role') === 'user')>Pengguna</option></select></label>
            <label>Password<input type="password" name="password" required minlength="6" autocomplete="new-password"></label>
            <div class="user-create-form__actions"><button type="button" class="siruka-secondary-button" onclick="this.closest('dialog').close()">Batal</button><button type="submit" class="siruka-primary-button rounded-lg px-4 py-2.5 text-sm font-bold">Simpan Pengguna</button></div>
        </form>
    </dialog>
</div>
@if($errors->any())
<script>document.addEventListener('DOMContentLoaded', () => document.getElementById('user-create-modal').showModal());</script>
@endif
@endsection
