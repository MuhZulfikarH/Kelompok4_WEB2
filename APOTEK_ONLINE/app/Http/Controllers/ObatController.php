<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\KategoriObat;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::with('kategori')->get();
        return view('admin.obat', compact('obats'));
    }

    public function create()
    {
        $kategori = KategoriObat::all();
        return view('admin.obat_create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required',
            'kategori_obat_id' => 'required',
            'stok'       => 'required|integer',
            'harga'      => 'required|numeric',
        ]);

        Obat::create($request->all());

        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        $kategori = KategoriObat::all();
        return view('admin.obat_edit', compact('obat', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->update($request->all());
        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Obat::destroy($id);
        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus.');
    }
}
