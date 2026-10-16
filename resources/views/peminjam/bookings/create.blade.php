@extends('layouts.peminjam')

@section('title', 'Ajukan Peminjaman Ruangan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Breadcrumb & Back -->
    <div>
        <a href="{{ route('peminjam.bookings.index') }}" class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Riwayat Booking
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/60">
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Formulir Pengajuan Peminjaman Ruangan</h1>
            <p class="text-xs text-slate-500 mt-1">Pastikan jam selesai lebih besar dari jam mulai dan jumlah peserta tidak melebihi kapasitas ruangan.</p>
        </div>

        <form action="{{ route('peminjam.bookings.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf

            <!-- Pilih Ruangan (Pure HTML) -->
            <div>
                <label for="room_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Pilih Ruangan Kampus <span class="text-rose-500">*</span>
                </label>
                <select id="room_id" name="room_id" required
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none font-medium">
                    <option value="" disabled {{ old('room_id', $selectedRoomId) ? '' : 'selected' }}>-- Pilih Ruangan yang Tersedia --</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id', $selectedRoomId) == $room->id ? 'selected' : '' }}>
                            {{ $room->nama }} &bull; {{ $room->gedung }} (Lt. {{ $room->lantai }}) &mdash; Kapasitas {{ $room->kapasitas }} Org
                        </option>
                    @endforeach
                </select>
                <p class="text-[11px] text-slate-400 mt-1.5">
                    Ingin melihat jadwal ruangan sebelum memilih? <a href="{{ route('peminjam.rooms.index') }}" class="text-indigo-600 font-bold hover:underline" target="_blank">Lihat Katalog Ruangan &rarr;</a>
                </p>
            </div>

            <!-- Tanggal Peminjaman -->
            <div>
                <label for="tanggal" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Tanggal Peminjaman <span class="text-rose-500">* (Tidak Boleh Masa Lalu)</span>
                </label>
                <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', request('tanggal', \Carbon\Carbon::today()->toDateString())) }}"
                    min="{{ \Carbon\Carbon::today()->toDateString() }}" required
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none font-medium">
            </div>

            <!-- Jam Mulai & Jam Selesai -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="jam_mulai" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Jam Mulai <span class="text-rose-500">*</span>
                    </label>
                    <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', '08:00') }}" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none font-medium">
                </div>

                <div>
                    <label for="jam_selesai" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Jam Selesai <span class="text-rose-500">* (Lebih Besar dari Jam Mulai)</span>
                    </label>
                    <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', '10:00') }}" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none font-medium">
                </div>
            </div>

            <!-- Jumlah Peserta -->
            <div>
                <label for="jumlah_peserta" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Estimasi Jumlah Peserta <span class="text-rose-500">*</span>
                </label>
                <input type="number" id="jumlah_peserta" name="jumlah_peserta" value="{{ old('jumlah_peserta', 1) }}" min="1" required
                    placeholder="Contoh: 30"
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <p class="text-[11px] text-slate-400 mt-1">Jumlah peserta tidak boleh melebihi kapasitas maksimal ruangan yang dipilih.</p>
            </div>

            <!-- Keperluan -->
            <div>
                <label for="keperluan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Keperluan / Agenda Peminjaman <span class="text-rose-500">*</span>
                </label>
                <textarea id="keperluan" name="keperluan" rows="3" required
                    placeholder="Contoh: Kuliah Pengganti Mata Kuliah Jaringan Komputer, Rapat Kerja BEM, Seminar..."
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('keperluan') }}</textarea>
            </div>

            <!-- Submit -->
            <div class="pt-6 border-t border-slate-200 flex items-center justify-end space-x-3">
                <a href="{{ route('peminjam.bookings.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/25 transition-all">
                    Kirim Pengajuan Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
