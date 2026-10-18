@extends('layouts.peminjam')

@section('title', 'Riwayat Pengajuan Booking')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Riwayat Pengajuan Booking</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Pantau status verifikasi pengajuan ruangan Anda atau ubah pengajuan yang masih berstatus Menunggu.</p>
        </div>
        <a href="{{ route('peminjam.bookings.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-600/20 transition-all self-start sm:self-auto">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajukan Peminjaman Baru
        </a>
    </div>


    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
        <form action="{{ route('peminjam.bookings.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <select name="status" class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                    class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="flex items-center space-x-2">
                <button type="submit" class="flex-1 py-2 px-4 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs shadow-sm transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['status', 'tanggal']))
                    <a href="{{ route('peminjam.bookings.index') }}" class="py-2 px-3 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100 text-xs font-semibold">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>


    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3.5 px-6">Ruangan</th>
                        <th class="py-3.5 px-6">Jadwal Tanggal & Waktu</th>
                        <th class="py-3.5 px-6">Peserta</th>
                        <th class="py-3.5 px-6">Keperluan Kegiatan</th>
                        <th class="py-3.5 px-6">Status Pengajuan</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $booking->room->nama }}</div>
                                <div class="text-xs text-slate-500 font-medium">{{ $booking->room->gedung }} &bull; Lt. {{ $booking->room->lantai }} ({{ $booking->room->kode }})</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('dddd, D MMM Y') }}</div>
                                <div class="text-xs font-mono font-bold text-blue-600">{{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }} WIB</div>
                            </td>
                            <td class="py-4 px-6 text-slate-700">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-slate-100 text-slate-800">
                                    {{ $booking->jumlah_peserta }} Orang
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-600 max-w-xs">
                                <p class="text-xs line-clamp-2" title="{{ $booking->keperluan }}">{{ $booking->keperluan }}</p>
                                @if($booking->status === 'ditolak' && $booking->alasan_penolakan)

                                    <details class="mt-1">
                                        <summary class="text-[11px] font-bold text-rose-600 hover:underline cursor-pointer">
                                            Lihat Catatan Penolakan Admin
                                        </summary>
                                        <div class="mt-1.5 p-2.5 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 leading-relaxed">
                                            <span class="font-bold">Alasan:</span> {{ $booking->alasan_penolakan }}
                                        </div>
                                    </details>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $booking->status_badge_class }}">
                                    {{ $booking->status_label }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-1.5">
                                    <a href="{{ route('peminjam.bookings.show', $booking) }}"
                                        class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-colors" title="Lihat Rincian Booking">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    @if($booking->status === 'disetujui')
                                        <a href="{{ route('peminjam.bookings.cetak', $booking) }}" target="_blank"
                                            class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-xs font-bold transition-colors" title="Cetak Surat Izin">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            Cetak Bukti
                                        </a>
                                    @endif

                                    @if($booking->status === 'menunggu')

                                        <a href="{{ route('peminjam.bookings.edit', $booking) }}"
                                            class="px-2.5 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-bold transition-colors">
                                            Ubah
                                        </a>


                                        <form action="{{ route('peminjam.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan booking ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-2.5 py-1.5 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-bold transition-colors">
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <p class="text-base font-semibold">Belum ada riwayat booking</p>
                                <p class="text-xs mt-1">Pengajuan peminjaman ruangan yang Anda kirim akan muncul di sini.</p>
                                <div class="mt-4">
                                    <a href="{{ route('peminjam.bookings.create') }}" class="px-4 py-2 rounded-xl bg-blue-600 text-white font-bold text-xs">
                                        Mulai Pinjam Ruangan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
