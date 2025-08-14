<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KelembagaanTani; // Import Model
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Untuk validasi unique pada update

class KelembagaanTaniController extends Controller
{
    /**
     * Menampilkan daftar Kelembagaan Tani.
     */
    public function index(Request $request)
    {
        $query = KelembagaanTani::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_poktan', 'like', '%' . $search . '%')
                  ->orWhere('nama_ketua', 'like', '%' . $search . '%')
                  ->orWhere('id_poktan', 'like', '%' . $search . '%');
        }

        $kelembagaanTani = $query->paginate(10);
        return view('pages.pertanian-peternakan.kelembagaan-tani.index', compact('kelembagaanTani'));
    }

    /**
     * Menampilkan form untuk membuat Kelembagaan Tani baru.
     */
    public function create()
    {
        return view('pages.pertanian-peternakan.kelembagaan-tani.create');
    }

    /**
     * Menyimpan Kelembagaan Tani baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_poktan' => 'required|string|max:255|unique:kelembagaan_tani',
            'kelas_kemampuan' => ['required', Rule::in(['Pemula', 'Lanjutan'])],
            'id_poktan' => 'nullable|string|max:255|unique:kelembagaan_tani',
            'jumlah_anggota' => 'required|integer|min:1',
            'nama_ketua' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:15',
            'alamat_sekretariat' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id(); // Catat admin yang membuat

        KelembagaanTani::create($validated);

        return redirect('/kelembagaan-tani')->with('success', 'Data Kelembagaan Tani berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit Kelembagaan Tani.
     */
    public function edit(KelembagaanTani $kelembagaanTani) // Route Model Binding
    {
        return view('pages.pertanian-peternakan.kelembagaan-tani.edit', compact('kelembagaanTani'));
    }

    /**
     * Memperbarui Kelembagaan Tani.
     */
    public function update(Request $request, KelembagaanTani $kelembagaanTani) // Route Model Binding
    {
        $validated = $request->validate([
            'nama_poktan' => ['required', 'string', 'max:255', Rule::unique('kelembagaan_tani')->ignore($kelembagaanTani->id)],
            'kelas_kemampuan' => ['required', Rule::in(['Pemula', 'Lanjutan'])],
            'id_poktan' => ['nullable', 'string', 'max:255', Rule::unique('kelembagaan_tani')->ignore($kelembagaanTani->id)],
            'jumlah_anggota' => 'required|integer|min:1',
            'nama_ketua' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:15',
            'alamat_sekretariat' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id(); // Catat admin yang terakhir mengupdate

        $kelembagaanTani->update($validated);

        return redirect('/kelembagaan-tani')->with('success', 'Data Kelembagaan Tani berhasil diperbarui!');
    }

    /**
     * Menghapus Kelembagaan Tani.
     */
    public function destroy(KelembagaanTani $kelembagaanTani) // Route Model Binding
    {
        $kelembagaanTani->delete();
        return redirect('/kelembagaan-tani')->with('success', 'Data Kelembagaan Tani berhasil dihapus!');
    }
}