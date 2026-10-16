<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $query = Facility::withCount('rooms');

        if ($request->filled('search')) {
            $query->where('nama_fasilitas', 'like', "%{$request->search}%");
        }

        $facilities = $query->orderBy('nama_fasilitas')->paginate(10)->withQueryString();

        return view('admin.facilities.index', compact('facilities'));
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
