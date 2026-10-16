@extends('layouts.peminjam')

@section('title', 'Ubah Pengajuan Booking')

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
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Ubah Pengajuan Peminjaman</h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui ruangan, tanggal, jam, atau keperluan sebelum diproses oleh Admin.</p>
        </div>

        <form action="{{ route('peminjam.bookings.update', $booking) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Pilih Ruangan (Pure HTML) -->
            <div>
                <label for="room_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Pilih Ruangan Kampus <span class="text-rose-500">*</span>
                </label>
                <select id="room_id" name="room_id" required
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none font-medium">
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>
                            {{ $room->nama }} &bull; {{ $room->gedung }} (Lt. {{ $room->lantai }}) &mdash; Kapasitas {{ $room->kapasitas }} Org
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal Peminjaman -->
            <div>
                <label for="tanggal" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Tanggal Peminjaman <span class="text-rose-500">*</span>
                </label>
                <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $booking->tanggal->toDateString()) }}"
                    min="{{ \Carbon\Carbon::today()->toDateString() }}" required
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none font-medium">
            </div>

            <!-- Jam Mulai & Jam Selesai -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="jam_mulai" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Jam Mulai <span class="text-rose-500">*</span>
                    </label>
                    <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', substr($booking->jam_mulai, 0, 5)) }}" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none font-medium">
                </div>

                <div>
                    <label for="jam_selesai" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Jam Selesai <span class="text-rose-500">*</span>
                    </label>
                    <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', substr($booking->jam_selesai, 0, 5)) }}" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none font-medium">
                </div>
            </div>

            <!-- Jumlah Peserta -->
            <div>
                <label for="jumlah_peserta" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Jumlah Peserta <span class="text-rose-500">*</span>
                </label>
                <input type="number" id="jumlah_peserta" name="jumlah_peserta" value="{{ old('jumlah_peserta', $booking->jumlah_peserta) }}" min="1" required
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <!-- Keperluan -->
            <div>
                <label for="keperluan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Keperluan / Agenda Peminjaman <span class="text-rose-500">*</span>
                </label>
                <textarea id="keperluan" name="keperluan" rows="3" required
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('keperluan', $booking->keperluan) }}</textarea>
            </div>

            <!-- Submit -->
            <div class="pt-6 border-t border-slate-200 flex items-center justify-end space-x-3">
                <a href="{{ route('peminjam.bookings.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/25 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
