<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LuasAreaProduksi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage; // Pastikan ini diimpor

class LuasAreaProduksiController extends Controller
{
    public function index(Request $request)
    {
        $query = LuasAreaProduksi::query();
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_komoditi', 'like', '%' . $search . '%')->orWhere('tipe_area', 'like', '%' . $search . '%');
        }
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }
        $luasAreaProduksi = $query->paginate(10);

        $availableYears = LuasAreaProduksi::select('tahun')
                                        ->distinct() // Ambil nilai tahun yang unik
                                        ->orderBy('tahun', 'desc') // Urutkan dari tahun terbaru
                                        ->pluck('tahun'); // Ambil hanya kolom 'tahun'
        
        return view('pages.pertanian-peternakan.luas-area-produksi.index', compact('luasAreaProduksi', 'availableYears'));
    }

    public function create() { return view('pages.pertanian-peternakan.luas-area-produksi.create'); }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_komoditi' => 'required|string|max:255',
            'tipe_area' => ['required', Rule::in(['Sawah', 'Tanaman Palawija'])],
            'luas_tanam' => 'required|numeric|min:0',
            'luas_panen' => 'required|numeric|min:0',
            'produksi' => 'required|numeric|min:0',
            'tahun' => 'nullable|integer|digits:4',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi image
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images/luas-area-produksi', 'public');
        }

        $validated['user_id'] = auth()->id();
        LuasAreaProduksi::create($validated);
        return redirect('/luas-area-produksi')->with('success', 'Data Luas Area Produksi berhasil ditambahkan!');
    }

    public function edit(LuasAreaProduksi $luasAreaProduksi) { return view('pages.pertanian-peternakan.luas-area-produksi.edit', compact('luasAreaProduksi')); }

    public function update(Request $request, LuasAreaProduksi $luasAreaProduksi)
    {
        $validated = $request->validate([
            'nama_komoditi' => 'required|string|max:255',
            'tipe_area' => ['required', Rule::in(['Sawah', 'Tanaman Palawija'])],
            'luas_tanam' => 'required|numeric|min:0',
            'luas_panen' => 'required|numeric|min:0',
            'produksi' => 'required|numeric|min:0',
            'tahun' => 'nullable|integer|digits:4',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'remove_image' => 'nullable|boolean', // Untuk checkbox hapus gambar
        ]);

        $imagePath = $luasAreaProduksi->image; // Ambil path gambar lama

        if ($request->hasFile('image')) {
            if ($imagePath) { Storage::disk('public')->delete($imagePath); }
            $imagePath = $request->file('image')->store('images/luas-area-produksi', 'public');
        } elseif ($request->boolean('remove_image')) {
            if ($imagePath) { Storage::disk('public')->delete($imagePath); }
            $imagePath = null;
        } else {
            unset($validated['image']); // Pastikan tidak menimpa dengan null jika tidak ada upload/hapus
        }

        $validated['user_id'] = auth()->id();
        $luasAreaProduksi->update($validated); // Gunakan $validated yang sudah diupdate
        $luasAreaProduksi->image = $imagePath; // Set kembali path gambar di model
        $luasAreaProduksi->save();

        return redirect('/luas-area-produksi')->with('success', 'Data Luas Area Produksi berhasil diperbarui!');
    }

    public function destroy(LuasAreaProduksi $luasAreaProduksi)
    {
        if ($luasAreaProduksi->image) { Storage::disk('public')->delete($luasAreaProduksi->image); }
        $luasAreaProduksi->delete();
        return redirect('/luas-area-produksi')->with('success', 'Data Luas Area Produksi berhasil dihapus!');
    }
}