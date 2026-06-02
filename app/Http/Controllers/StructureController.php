<?php

namespace App\Http\Controllers;

use App\Models\Structure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StructureController extends Controller
{
    public function index()
    {
        $structures = Structure::orderBy('order', 'asc')->get();
        return view('admin.structures.index', compact('structures'));
    }

    public function create()
    {
        return view('admin.structures.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order'    => 'required|integer|min:0',
        ]);

        $data = $request->only('name', 'position', 'order');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('structures', 'public');
        }

        Structure::create($data);

        return redirect()->route('structures.index')->with('success', 'Anggota struktur berhasil ditambahkan.');
    }

    public function edit(Structure $structure)
    {
        return view('admin.structures.edit', compact('structure'));
    }

    public function update(Request $request, Structure $structure)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order'    => 'required|integer|min:0',
        ]);

        $data = $request->only('name', 'position', 'order');

        if ($request->hasFile('image')) {
            if ($structure->image && Storage::disk('public')->exists($structure->image)) {
                Storage::disk('public')->delete($structure->image);
            }
            $data['image'] = $request->file('image')->store('structures', 'public');
        }

        $structure->update($data);

        return redirect()->route('structures.index')->with('success', 'Anggota struktur berhasil diperbarui.');
    }

    public function destroy(Structure $structure)
    {
        if ($structure->image && Storage::disk('public')->exists($structure->image)) {
            Storage::disk('public')->delete($structure->image);
        }
        $structure->delete();

        return redirect()->route('structures.index')->with('success', 'Anggota struktur berhasil dihapus.');
    }
}
