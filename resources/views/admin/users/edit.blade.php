@extends('layouts.admin')

@section('title', 'Ubah Pengguna - ' . $user->name)
@section('page_title', 'Ubah Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-800">Edit Akun: {{ $user->name }}</h2>
                <p class="text-xs text-slate-500">Perbarui data profil pengguna atau atur ulang kata sandi.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">
                &larr; Kembali
            </a>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 sm:p-8 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Email Kampus <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div>
                    <label for="role" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Role Akun <span class="text-rose-500">*</span>
                    </label>
                    <select id="role" name="role" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="peminjam" {{ in_array(old('role', $user->role), ['peminjam', 'user']) ? 'selected' : '' }}>Peminjam (Mahasiswa / User)</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nim_nip" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        NIM (Nomor Induk Mahasiswa)
                    </label>
                    <input type="text" id="nim_nip" name="nim_nip" value="{{ old('nim_nip', $user->nim_nip) }}"
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div>
                    <label for="no_hp" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nomor HP / WhatsApp
                    </label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Ganti Kata Sandi (Kosongkan jika tidak diubah)
                </label>
                <input type="password" id="password" name="password"
                    placeholder="Minimal 6 karakter"
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="pt-4 border-t border-slate-200 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-600/25 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
