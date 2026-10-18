@extends('layouts.admin')

@section('title', 'Inventaris Fasilitas')

@section('content')
@php
    $inventoryItems = $facilities->flatMap(fn ($facility) => $facility->rooms->map(fn ($room) => ['facility' => $facility, 'room' => $room]));
    $totalUnits = $inventoryItems->sum(fn ($item) => $item['room']->pivot->jumlah);
    $goodUnits = $inventoryItems->filter(fn ($item) => $item['room']->pivot->kondisi === 'baik')->sum(fn ($item) => $item['room']->pivot->jumlah);
    $repairUnits = $inventoryItems->filter(fn ($item) => $item['room']->pivot->kondisi === 'perlu perbaikan' || $item['room']->pivot->kondisi === 'rusak ringan')->sum(fn ($item) => $item['room']->pivot->jumlah);
    $brokenUnits = $inventoryItems->filter(fn ($item) => $item['room']->pivot->kondisi === 'rusak berat')->sum(fn ($item) => $item['room']->pivot->jumlah);
@endphp
<div class="space-y-6">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach([['Total Aset', $totalUnits], ['Baik', $goodUnits], ['Perlu Perbaikan', $repairUnits], ['Rusak', $brokenUnits]] as [$label, $value])
            <div class="inventory-stat rounded-2xl p-5 text-white shadow-sm"><p class="text-xs font-semibold uppercase tracking-wide">{{ $label }}</p><p class="mt-2 text-3xl font-black">{{ $value }}</p><p class="mt-1 text-xs">Unit inventaris tercatat</p></div>
        @endforeach
    </div>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="inventory-toolbar">
            <form method="GET" class="inventory-filters">
                <label class="text-xs font-bold text-slate-600">Cari Fasilitas
                    <input name="search" value="{{ request('search') }}" placeholder="Nama atau kategori fasilitas" class="mt-1 w-full">
                </label>
                <label class="text-xs font-bold text-slate-600">Filter Ruangan
                    <select name="room_id" class="mt-1 w-full"><option value="">Semua ruangan</option>@foreach($rooms as $room)<option value="{{ $room->id }}" @selected($selectedRoom === $room->id)>{{ $room->nama }}</option>@endforeach</select>
                </label>
                <button class="siruka-primary-button rounded-lg px-4 py-2.5 text-sm font-bold">Cari</button>
            </form>
            <button type="button" onclick="openInventoryModal()" class="siruka-primary-button rounded-lg px-4 py-2.5 text-sm font-bold">+ Tambah Fasilitas</button>
        </div>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="inventory-table w-full min-w-[1050px] text-left text-sm">
                <thead class="text-xs uppercase tracking-wide"><tr><th class="p-4">Kode</th><th class="p-4">Nama Barang</th><th class="p-4">No. Inventaris</th><th class="p-4">Tahun</th><th class="p-4">Jml</th><th class="p-4">Ruangan</th><th class="p-4">Kondisi</th><th class="p-4">Keterangan</th><th class="p-4">Laporan</th><th class="p-4">Aksi</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($inventoryItems as $item)
                        @php($inventoryRoom = $item['room'])
                        @php($facility = $item['facility'])
                        @continue(request('tahun') && (string) $inventoryRoom->pivot->tahun !== (string) request('tahun'))
                        @php($inventoryData = ['facility_id' => $facility->id, 'nama_fasilitas' => $facility->nama_fasilitas, 'room_id' => $inventoryRoom->id, 'kode_barang' => $inventoryRoom->pivot->kode_barang, 'nomor_inventaris' => $inventoryRoom->pivot->nomor_inventaris, 'tahun' => $inventoryRoom->pivot->tahun, 'jumlah' => $inventoryRoom->pivot->jumlah, 'kondisi' => $inventoryRoom->pivot->kondisi, 'catatan' => $inventoryRoom->pivot->catatan])
                        <tr class="hover:bg-blue-50/40"><td class="p-4 text-slate-600">{{ $inventoryRoom->pivot->kode_barang ?: $inventoryRoom->kode }}</td><td class="p-4 font-semibold text-slate-900">{{ $facility->nama_fasilitas }}</td><td class="p-4 text-slate-600">{{ $inventoryRoom->pivot->nomor_inventaris ?: '—' }}</td><td class="p-4">{{ $inventoryRoom->pivot->tahun ?: '—' }}</td><td class="p-4 font-bold">{{ $inventoryRoom->pivot->jumlah }}</td><td class="p-4">{{ $inventoryRoom->nama }}</td><td class="p-4"><span class="inventory-condition inventory-condition--{{ str_replace(' ', '-', $inventoryRoom->pivot->kondisi) }}">{{ strtoupper($inventoryRoom->pivot->kondisi) }}</span></td><td class="p-4 text-slate-500">{{ $inventoryRoom->pivot->catatan ?: '—' }}</td><td class="p-4 text-slate-400">—</td><td class="p-4"><div class="flex items-center gap-2"><button type="button" class="inventory-action" data-view-inventory="{{ json_encode($inventoryData) }}">Lihat</button><button type="button" class="inventory-action" data-edit-inventory="{{ json_encode($inventoryData) }}">Edit</button><form action="{{ route('admin.facilities.inventory.destroy', [$inventoryRoom, $facility]) }}" method="POST" onsubmit="return confirm('Hapus aset ini dari ruangan?')">@csrf @method('DELETE')<button class="inventory-action" type="submit">Hapus</button></form></div></td></tr>
                    @empty
                        <tr><td colspan="10" class="p-10 text-center text-slate-500">Belum ada inventaris untuk filter ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 p-4">{{ $facilities->links() }}</div>
    </section>

    <dialog id="inventory-modal" class="siruka-modal">
        <div class="siruka-modal__header"><div><h2 id="inventory-modal-title" class="text-lg font-bold text-slate-900">Tambah Fasilitas</h2><p class="text-sm text-slate-500">Isi data barang, ruangan, dan kondisinya.</p></div><button type="button" class="siruka-modal__close" onclick="this.closest('dialog').close()" aria-label="Tutup">&times;</button></div>
        <form action="{{ route('admin.facilities.inventory') }}" method="POST" class="mt-5 grid gap-3 sm:grid-cols-2">
            @csrf
            <select id="inventory-room" name="room_id" required class="rounded-xl border-slate-300 text-sm"><option value="">Pilih ruangan</option>@foreach($rooms as $room)<option value="{{ $room->id }}" @selected($selectedRoom === $room->id)>{{ $room->nama }}</option>@endforeach</select>
            <input id="inventory-facility-id" type="hidden" name="facility_id">
            <input id="inventory-facility-name" name="nama_fasilitas" required maxlength="255" placeholder="Nama fasilitas / barang" class="rounded-xl border-slate-300 text-sm sm:col-span-2">
            <input id="inventory-code" name="kode_barang" maxlength="50" placeholder="Kode barang / kode meja" class="rounded-xl border-slate-300 text-sm">
            <input id="inventory-number" name="nomor_inventaris" maxlength="100" placeholder="Nomor inventaris" class="rounded-xl border-slate-300 text-sm">
            <input id="inventory-year" type="number" name="tahun" min="1900" max="2100" placeholder="Tahun perolehan" class="rounded-xl border-slate-300 text-sm">
            <input id="inventory-quantity" type="number" name="jumlah" min="1" value="1" required placeholder="Jumlah unit" class="rounded-xl border-slate-300 text-sm">
            <select id="inventory-condition" name="kondisi" required class="rounded-xl border-slate-300 text-sm"><option value="baik">Baik</option><option value="rusak ringan">Rusak ringan</option><option value="perlu perbaikan">Perlu perbaikan</option><option value="rusak berat">Rusak berat</option></select>
            <input id="inventory-note" name="catatan" maxlength="1000" placeholder="Keterangan" class="rounded-xl border-slate-300 text-sm">
            <div class="mt-2 flex justify-end gap-2 sm:col-span-2"><button type="button" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-600" onclick="this.closest('dialog').close()">Batal</button><button class="siruka-primary-button rounded-lg px-4 py-2 text-sm font-bold">Simpan Fasilitas</button></div>
        </form>
    </dialog>

    <dialog id="inventory-view-modal" class="siruka-modal siruka-modal--small">
        <div class="siruka-modal__header"><h2 class="text-lg font-bold text-slate-900">Detail Fasilitas</h2><button type="button" class="siruka-modal__close" onclick="this.closest('dialog').close()" aria-label="Tutup">&times;</button></div>
        <dl class="inventory-details mt-5 grid grid-cols-2 gap-3 text-sm"><dt>Nama fasilitas</dt><dd data-detail="nama_fasilitas"></dd><dt>Kode barang</dt><dd data-detail="kode_barang"></dd><dt>No. inventaris</dt><dd data-detail="nomor_inventaris"></dd><dt>Tahun</dt><dd data-detail="tahun"></dd><dt>Jumlah</dt><dd data-detail="jumlah"></dd><dt>Ruangan</dt><dd data-detail="room_name"></dd><dt>Kondisi</dt><dd data-detail="kondisi"></dd><dt>Keterangan</dt><dd data-detail="catatan"></dd></dl>
    </dialog>
</div>
<script>
    function openInventoryModal() {
        const form = document.querySelector('#inventory-modal form');
        form.reset();
        document.getElementById('inventory-facility-id').value = '';
        document.getElementById('inventory-modal-title').textContent = 'Tambah Fasilitas';
        document.getElementById('inventory-modal').showModal();
    }
    document.querySelectorAll('[data-edit-inventory]').forEach((button) => button.addEventListener('click', () => {
        const item = JSON.parse(button.dataset.editInventory);
        document.getElementById('inventory-modal-title').textContent = 'Edit Fasilitas';
        document.getElementById('inventory-facility-id').value = item.facility_id;
        document.getElementById('inventory-facility-name').value = item.nama_fasilitas;
        document.getElementById('inventory-room').value = item.room_id;
        ['kode_barang', 'nomor_inventaris', 'tahun', 'jumlah', 'kondisi', 'catatan'].forEach((field) => {
            const inputName = field === 'jumlah' ? 'quantity' : field === 'kondisi' ? 'condition' : field === 'catatan' ? 'note' : field === 'kode_barang' ? 'code' : field === 'nomor_inventaris' ? 'number' : 'year';
            document.getElementById(`inventory-${inputName}`).value = item[field] ?? '';
        });
        document.getElementById('inventory-modal').showModal();
    }));
    document.querySelectorAll('[data-view-inventory]').forEach((button) => button.addEventListener('click', () => {
        const item = JSON.parse(button.dataset.viewInventory);
        const roomName = button.closest('tr').children[5].textContent.trim();
        Object.entries({ ...item, room_name: roomName }).forEach(([field, value]) => {
            const output = document.querySelector(`[data-detail="${field}"]`);
            if (output) output.textContent = value || '—';
        });
        document.getElementById('inventory-view-modal').showModal();
    }));
</script>
@endsection
