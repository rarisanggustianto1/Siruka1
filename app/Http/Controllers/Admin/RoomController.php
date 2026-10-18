<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('facilities');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%")
                    ->orWhere('gedung', 'like', "%{$search}%");
            });
        }

        if ($request->filled('gedung')) {
            $query->where('gedung', $request->gedung);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rooms = $query->orderBy('nama')->paginate(10)->withQueryString();
        $buildings = Room::distinct()->pluck('gedung')->sort()->values();
        $gedungs = $buildings;

        return view('admin.rooms.index', compact('rooms', 'buildings', 'gedungs'));
    }

    public function create()
    {
        $facilities = Facility::orderBy('nama_fasilitas')->get();

        return view('admin.rooms.create', compact('facilities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:50', 'unique:rooms,kode'],
            'nama' => ['required', 'string', 'max:255'],
            'gedung' => ['required', 'string', 'max:255'],
            'lantai' => ['required', 'integer', 'min:1'],
            'kapasitas' => ['required', 'integer', 'min:1'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'in:tersedia,maintenance'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['exists:facilities,id'],
        ], [
            'kode.required' => 'Kode ruangan wajib diisi.',
            'kode.unique' => 'Kode ruangan ini sudah digunakan.',
            'nama.required' => 'Nama ruangan wajib diisi.',
            'gedung.required' => 'Gedung wajib diisi.',
            'lantai.required' => 'Lantai wajib diisi.',
            'kapasitas.required' => 'Kapasitas wajib diisi.',
            'kapasitas.min' => 'Kapasitas minimal 1 orang.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('rooms', 'public');
        }

        $room = Room::create($validated);

        if ($request->has('facilities')) {
            $room->facilities()->sync($request->facilities);
        }

        return redirect()->route('admin.rooms.index')
            ->with('success', "Ruangan '{$room->nama}' berhasil ditambahkan.");
    }

    public function edit(Room $room)
    {
        $room->load('facilities');
        $facilities = Facility::orderBy('nama_fasilitas')->get();

        return view('admin.rooms.edit', compact('room', 'facilities'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:50', Rule::unique('rooms', 'kode')->ignore($room->id)],
            'nama' => ['required', 'string', 'max:255'],
            'gedung' => ['required', 'string', 'max:255'],
            'lantai' => ['required', 'integer', 'min:1'],
            'kapasitas' => ['required', 'integer', 'min:1'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'in:tersedia,maintenance'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['exists:facilities,id'],
        ], [
            'kode.required' => 'Kode ruangan wajib diisi.',
            'kode.unique' => 'Kode ruangan ini sudah digunakan.',
            'nama.required' => 'Nama ruangan wajib diisi.',
            'gedung.required' => 'Gedung wajib diisi.',
            'lantai.required' => 'Lantai wajib diisi.',
            'kapasitas.required' => 'Kapasitas wajib diisi.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            if ($room->foto && Storage::disk('public')->exists($room->foto)) {
                Storage::disk('public')->delete($room->foto);
            }
            $validated['foto'] = $request->file('foto')->store('rooms', 'public');
        }

        $room->update($validated);

        $room->facilities()->sync($request->input('facilities', []));

        return redirect()->route('admin.rooms.index')
            ->with('success', "Data ruangan '{$room->nama}' berhasil diperbarui.");
    }

    public function destroy(Room $room)
    {
        // Aturan: Hapus ruangan diblokir jika masih punya booking aktif
        if ($room->hasActiveBookings()) {
            return back()->with('error', "Ruangan '{$room->nama}' tidak dapat dihapus karena masih memiliki peminjaman aktif yang menunggu atau disetujui.");
        }

        if ($room->foto && Storage::disk('public')->exists($room->foto)) {
            Storage::disk('public')->delete($room->foto);
        }

        $room->facilities()->detach();
        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', "Ruangan '{$room->nama}' berhasil dihapus.");
    }

    public function toggleStatus(Room $room)
    {
        $newStatus = $room->status === 'tersedia' ? 'maintenance' : 'tersedia';
        $room->update(['status' => $newStatus]);

        $statusLabel = $newStatus === 'tersedia' ? 'Tersedia' : 'Maintenance';

        return back()->with('success', "Status ruangan '{$room->nama}' berhasil diubah menjadi {$statusLabel}.");
    }
}
