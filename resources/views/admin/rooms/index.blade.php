@extends('layouts.admin')

@section('title', 'Master Ruangan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div><h1 class="text-2xl font-bold text-slate-900">Master Ruangan</h1><p class="mt-1 text-sm text-slate-500">Kelola data ruangan, fasilitas, dan status ketersediaan.</p></div>
        <a href="{{ route('admin.rooms.create') }}" class="siruka-primary-button rounded-lg px-4 py-2.5 text-sm font-bold">+ Tambah Ruangan</a>
    </div>
    <form method="GET" action="{{ route('admin.rooms.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="user-filters">
            <label class="text-xs font-bold text-slate-600">Cari nama, kode, atau gedung<input type="search" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." class="mt-1 w-full"></label>
            <label class="text-xs font-bold text-slate-600">Gedung<select name="gedung" class="mt-1 w-full"><option value="">Semua gedung</option>@foreach($gedungs as $building)<option value="{{ $building }}" @selected(request('gedung') === $building)>{{ $building }}</option>@endforeach</select></label>
            <button type="submit" class="siruka-primary-button rounded-lg px-5 py-2.5 text-sm font-bold">Cari</button>
        </div>
    </form>
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto"><table class="w-full min-w-[1050px] text-left text-sm">
            <thead><tr><th class="p-4">Kode</th><th class="p-4">Nama Ruangan</th><th class="p-4">Gedung / Lantai</th><th class="p-4">Kapasitas</th><th class="p-4">Fasilitas</th><th class="p-4">Status</th><th class="p-4">Aksi</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($rooms as $room)
                    @php($roomData = ['kode' => $room->kode, 'nama' => $room->nama, 'gedung' => $room->gedung, 'lantai' => $room->lantai, 'kapasitas' => $room->kapasitas, 'status' => ucfirst($room->status), 'deskripsi' => $room->deskripsi, 'facilities' => $room->facilities->pluck('nama_fasilitas')->implode(', ')])
                    <tr class="hover:bg-blue-50/40">
                        <td class="p-4 font-semibold text-slate-700">{{ $room->kode }}</td><td class="p-4 font-semibold text-slate-900">{{ $room->nama }}</td><td class="p-4 text-slate-600">{{ $room->gedung }} / Lt. {{ $room->lantai }}</td><td class="p-4">{{ $room->kapasitas }} orang</td>
                        <td class="p-4"><div class="flex max-w-xs flex-wrap gap-1">@forelse($room->facilities as $facility)<span class="rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-800">{{ $facility->nama_fasilitas }}</span>@empty<span class="text-slate-400">—</span>@endforelse</div></td>
                        <td class="p-4"><span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-800">{{ ucfirst($room->status) }}</span></td>
                        <td class="p-4"><div class="room-actions"><button type="button" class="inventory-action" data-room-details="{{ json_encode($roomData) }}">Lihat</button><a class="inventory-action" href="{{ route('admin.rooms.edit', $room) }}">Edit</a><form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" onsubmit="return confirm('Hapus ruangan ini?')">@csrf @method('DELETE')<button type="submit" class="inventory-action">Hapus</button></form></div></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="p-10 text-center text-slate-500">Ruangan tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table></div>
        <div class="border-t border-slate-100 p-4">{{ $rooms->links() }}</div>
    </section>
    <dialog id="room-view-modal" class="siruka-modal siruka-modal--small">
        <div class="siruka-modal__header"><h2 class="text-lg font-bold text-slate-900">Detail Ruangan</h2><button type="button" class="siruka-modal__close" onclick="this.closest('dialog').close()" aria-label="Tutup">&times;</button></div>
        <dl class="inventory-details mt-5 grid grid-cols-2 gap-3 text-sm"><dt>Kode</dt><dd data-room-detail="kode"></dd><dt>Nama</dt><dd data-room-detail="nama"></dd><dt>Gedung</dt><dd data-room-detail="gedung"></dd><dt>Lantai</dt><dd data-room-detail="lantai"></dd><dt>Kapasitas</dt><dd data-room-detail="kapasitas"></dd><dt>Status</dt><dd data-room-detail="status"></dd><dt class="col-span-2">Fasilitas</dt><dd data-room-detail="facilities" class="col-span-2"></dd><dt class="col-span-2">Deskripsi</dt><dd data-room-detail="deskripsi" class="col-span-2"></dd></dl>
    </dialog>
</div>
<script>
    document.querySelectorAll('[data-room-details]').forEach((button) => button.addEventListener('click', () => {
        const room = JSON.parse(button.dataset.roomDetails);
        Object.entries(room).forEach(([field, value]) => {
            const output = document.querySelector(`[data-room-detail="${field}"]`);
            if (output) output.textContent = value || '—';
        });
        document.getElementById('room-view-modal').showModal();
    }));
</script>
@endsection
