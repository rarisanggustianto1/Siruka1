<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $selectedRoom = $request->integer('room_id') ?: null;
        $query = Facility::with(['rooms' => fn ($rooms) => $rooms->when($selectedRoom, fn ($filtered) => $filtered->where('rooms.id', $selectedRoom))])->withCount('rooms');

        if ($request->filled('search')) {
            $query->where('nama_fasilitas', 'like', "%{$request->search}%");
        }

        if ($request->filled('kondisi')) {
            $query->whereHas('rooms', fn ($rooms) => $rooms->wherePivot('kondisi', $request->string('kondisi')->toString()));
        }

        if ($request->filled('tahun')) {
            $query->whereHas('rooms', fn ($rooms) => $rooms->wherePivot('tahun', $request->integer('tahun')));
        }

        $facilities = $query->orderBy('nama_fasilitas')->paginate(10)->withQueryString();

        $rooms = Room::orderBy('nama')->get();

        return view('admin.facilities.index', compact('facilities', 'rooms', 'selectedRoom'));
    }

    public function inventory(Request $request)
    {
        $facilityIdToIgnore = $request->input('facility_id')
            ?: Facility::where('nama_fasilitas', $request->input('nama_fasilitas'))->value('id');

        $validated = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'facility_id' => ['nullable', 'exists:facilities,id'],
            'nama_fasilitas' => ['required', 'string', 'max:255', Rule::unique('facilities', 'nama_fasilitas')->ignore($facilityIdToIgnore)],
            'jumlah' => ['required', 'integer', 'min:1'],
            'kondisi' => ['required', 'in:baik,rusak ringan,rusak berat,perlu perbaikan'],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'kode_barang' => ['nullable', 'string', 'max:50'],
            'nomor_inventaris' => ['nullable', 'string', 'max:100'],
            'tahun' => ['nullable', 'integer', 'between:1900,2100'],
        ]);
        $room = Room::findOrFail($validated['room_id']);
        $facility = isset($validated['facility_id'])
            ? Facility::findOrFail($validated['facility_id'])
            : Facility::firstOrCreate(['nama_fasilitas' => $validated['nama_fasilitas']]);

        if (isset($validated['facility_id']) && $facility->nama_fasilitas !== $validated['nama_fasilitas']) {
            $facility->update(['nama_fasilitas' => $validated['nama_fasilitas']]);
        }

        $room->facilities()->syncWithoutDetaching([$facility->id => [
            'kode_barang' => $validated['kode_barang'] ?? null,
            'nomor_inventaris' => $validated['nomor_inventaris'] ?? null,
            'tahun' => $validated['tahun'] ?? null,
            'jumlah' => $validated['jumlah'], 'kondisi' => $validated['kondisi'], 'catatan' => $validated['catatan'] ?? null,
        ]]);

        return redirect()->route('admin.facilities.index', ['room_id' => $room->id])->with('success', 'Inventaris fasilitas ruangan berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_fasilitas' => ['required', 'string', 'max:255', 'unique:facilities,nama_fasilitas'],
        ], [
            'nama_fasilitas.required' => 'Nama fasilitas wajib diisi.',
            'nama_fasilitas.unique' => 'Fasilitas dengan nama ini sudah ada.',
        ]);

        Facility::create($validated);

        return redirect()->route('admin.facilities.index')
            ->with('success', "Fasilitas '{$validated['nama_fasilitas']}' berhasil ditambahkan.");
    }

    public function edit(Facility $facility)
    {
        return view('admin.facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'nama_fasilitas' => ['required', 'string', 'max:255', 'unique:facilities,nama_fasilitas,'.$facility->id],
        ], [
            'nama_fasilitas.required' => 'Nama fasilitas wajib diisi.',
            'nama_fasilitas.unique' => 'Fasilitas dengan nama ini sudah ada.',
        ]);

        $facility->update($validated);

        return redirect()->route('admin.facilities.index')
            ->with('success', "Fasilitas berhasil diperbarui menjadi '{$validated['nama_fasilitas']}'.");
    }

    public function destroy(Facility $facility)
    {
        // Batasan: fasilitas yang masih terpakai di ruangan tidak bisa dihapus
        $roomCount = $facility->rooms()->count();
        if ($roomCount > 0) {
            return back()->with('error', "Fasilitas '{$facility->nama_fasilitas}' tidak dapat dihapus karena sedang terpasang di {$roomCount} ruangan.");
        }

        $facility->delete();

        return redirect()->route('admin.facilities.index')
            ->with('success', "Fasilitas '{$facility->nama_fasilitas}' berhasil dihapus.");
    }
}
