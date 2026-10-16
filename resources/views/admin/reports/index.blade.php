@extends('layouts.admin')

@section('title', 'Laporan & Rekapitulasi Peminjaman')
@section('page_title', 'Laporan Peminjaman Ruangan')

@section('content')
<div class="space-y-6">
    <!-- Header with Print Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900">Rekapitulasi & Laporan Peminjaman</h2>
            <p class="text-xs text-slate-500 mt-0.5">Analisis data peminjaman ruangan kampus, statistik persetujuan, dan cetak laporan resmi.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.reports.print', request()->all()) }}" target="_blank"
                class="inline-flex items-center px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-md shadow-slate-900/20 transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak / Ekspor Laporan
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Ruangan</label>
                <select name="room_id" class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">Semua Ruangan</option>
                    @foreach($rooms as $r)
                        <option value="{{ $r->id }}" {{ $roomId == $r->id ? 'selected' : '' }}>{{ $r->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Status</label>
                <select name="status" class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="disetujui" {{ $status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="menunggu" {{ $status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="ditolak" {{ $status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="dibatalkan" {{ $status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 py-2 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/20 transition-all flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Tampilkan
                </button>
                @if(request()->hasAny(['start_date', 'end_date', 'room_id', 'status', 'search']))
                    <a href="{{ route('admin.reports.index') }}" class="py-2 px-3 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100 text-xs font-semibold">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Summary KPI Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pengajuan</p>
            <p class="text-2xl font-black text-slate-900 mt-1">{{ $totalInPeriod }}</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Periode Terpilih</p>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-emerald-100 bg-emerald-50/20 shadow-sm">
            <p class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Disetujui</p>
            <p class="text-2xl font-black text-emerald-600 mt-1">{{ $disetujuiCount }}</p>
            <p class="text-[11px] text-emerald-600/80 mt-0.5">{{ $approvalRate }}% Approval Rate</p>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-amber-100 bg-amber-50/20 shadow-sm">
            <p class="text-xs font-bold text-amber-700 uppercase tracking-wider">Menunggu</p>
            <p class="text-2xl font-black text-amber-600 mt-1">{{ $menungguCount }}</p>
            <p class="text-[11px] text-amber-600/80 mt-0.5">Belum Diproses</p>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-rose-100 bg-rose-50/20 shadow-sm">
            <p class="text-xs font-bold text-rose-700 uppercase tracking-wider">Ditolak</p>
            <p class="text-2xl font-black text-rose-600 mt-1">{{ $ditolakCount }}</p>
            <p class="text-[11px] text-rose-600/80 mt-0.5">{{ $dibatalkanCount }} Dibatalkan</p>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-indigo-100 bg-indigo-50/20 shadow-sm col-span-2 lg:col-span-1">
            <p class="text-xs font-bold text-indigo-700 uppercase tracking-wider">Ruang Terfavorit</p>
            <p class="text-sm font-extrabold text-slate-900 mt-1 truncate" title="{{ $topRoom->room->nama ?? 'Belum ada' }}">
                {{ $topRoom->room->nama ?? '-' }}
            </p>
            <p class="text-[11px] text-indigo-600/80 mt-0.5">
                {{ $topRoom ? $topRoom->count . ' kali dipinjam' : '0 peminjaman' }}
            </p>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                <h3 class="text-sm font-bold text-slate-800">Daftar Rekapitulasi ({{ $bookings->total() }} Data Ditemukan)</h3>
            </div>
            <span class="text-xs text-slate-400 font-medium">Periode: {{ \Carbon\Carbon::parse($startDate)->isoFormat('D MMM Y') }} &mdash; {{ \Carbon\Carbon::parse($endDate)->isoFormat('D MMM Y') }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3.5 px-6">ID & Tanggal</th>
                        <th class="py-3.5 px-6">Peminjam</th>
                        <th class="py-3.5 px-6">Ruangan</th>
                        <th class="py-3.5 px-6">Waktu</th>
                        <th class="py-3.5 px-6">Keperluan</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($bookings as $b)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="font-mono text-xs font-bold text-slate-500">#BK-{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <div class="text-xs font-semibold text-slate-800">{{ \Carbon\Carbon::parse($b->tanggal)->isoFormat('D MMM Y') }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $b->user->name }}</div>
                                <div class="text-xs text-slate-500">NIM: {{ $b->user->nim_nip ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-slate-900">{{ $b->room->nama }}</div>
                                <div class="text-xs text-slate-500">{{ $b->room->gedung }} (Lt. {{ $b->room->lantai }})</div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap font-mono text-xs text-indigo-700 font-bold">
                                {{ substr($b->jam_mulai, 0, 5) }} - {{ substr($b->jam_selesai, 0, 5) }} WIB
                            </td>
                            <td class="py-4 px-6 text-slate-600 max-w-xs">
                                <p class="text-xs truncate" title="{{ $b->keperluan }}">{{ $b->keperluan }}</p>
                                <span class="text-[11px] text-slate-400 font-medium">{{ $b->jumlah_peserta }} Peserta</span>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $b->status_badge_class }}">
                                    {{ $b->status_label }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-1.5">
                                    <a href="{{ route('admin.bookings.show', $b) }}" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors" title="Lihat Rincian">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    @if($b->status === 'disetujui')
                                        <a href="{{ route('admin.bookings.cetak', $b) }}" target="_blank" class="p-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors" title="Cetak Surat Izin">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <p class="text-base font-semibold">Tidak ada riwayat peminjaman pada filter ini</p>
                                <p class="text-xs mt-1">Coba sesuaikan rentang tanggal atau kriteria filter Anda.</p>
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
