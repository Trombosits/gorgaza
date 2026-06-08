<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        return view('Admin.facilities.index', [
            'facilities' => Facility::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('Admin.facilities.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_fasilitas' => 'required|string|max:100',
            'jenis' => 'required|string|max:50',
            'harga_per_jam' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        Facility::create($data);

        return redirect('/admin/facilities')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Facility $facility)
    {
        return view('Admin.facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $data = $request->validate([
            'nama_fasilitas' => 'required|string|max:100',
            'jenis' => 'required|string|max:50',
            'harga_per_jam' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $facility->update($data);

        return redirect('/admin/facilities')->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();
        return redirect('/admin/facilities')->with('success', 'Fasilitas berhasil dihapus.');
    }
}
