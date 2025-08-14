<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Str; 
use Illuminate\Validation\Rule;

class UmkmController extends Controller
{
    /**
     * Menampilkan daftar semua UMKM di halaman admin.
     */
    public function index(Request $request)
    {
        $query = Umkm::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_usaha', 'like', '%' . $search . '%')
                  ->orWhere('nama_pemilik', 'like', '%' . $search . '%');
        }

        $umkms = $query->paginate(10); // Sesuaikan pagination
        return view('pages.umkms.index', compact('umkms'));
    }

    /**
     * Menampilkan form untuk membuat UMKM baru.
     */
    public function create()
    {
        return view('pages.umkms.create');
    }

    /**
     * Menyimpan UMKM baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255', // NIK bisa unik
            'alamat_usaha' => 'nullable|string',
            'no_hp_usaha' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Foto opsional, 2MB
        ]);

        $validated['slug'] = Str::slug($validated['nama_usaha']);
        // Pastikan slug unik
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Umkm::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('umkm_photos', 'public'); // Simpan foto di storage/app/public/umkm_photos
        }

        $validated['user_id'] = auth()->id(); // Catat admin yang membuat

        Umkm::create($validated);

        return redirect('/umkms')->with('success', 'Data UMKM berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail satu UMKM (opsional).
     */
    public function show(Umkm $umkm)
    {
        return view('pages.umkms.show', compact('umkm'));
    }

    /**
     * Menampilkan form untuk mengedit UMKM yang ada.
     */
    public function edit(Umkm $umkm) // Menggunakan Route Model Binding dengan slug
    {
        return view('pages.umkms.edit', compact('umkm'));
    }

    /**
     * Memperbarui UMKM di database.
     */
    public function update(Request $request, Umkm $umkm) // Menggunakan Route Model Binding
    {
        $validated = $request->validate([
            'nama_usaha' => ['required', 'string', 'max:255'],
            'nama_pemilik' => 'required|string|max:255',
            'alamat_usaha' => 'nullable|string',
            'no_hp_usaha' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'remove_photo' => 'nullable|boolean', // Untuk checkbox hapus foto
        ]);

        $validated['slug'] = Str::slug($validated['nama_usaha']);
        // Pastikan slug unik saat update, abaikan slug diri sendiri
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Umkm::where('slug', $validated['slug'])->where('id', '!=', $umkm->id)->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        $photoPath = $umkm->photo; // Ambil path foto lama

        if ($request->hasFile('photo')) {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath); // Hapus foto lama
            }
            $photoPath = $request->file('photo')->store('umkm_photos', 'public');
        } elseif ($request->boolean('remove_photo')) { // Periksa checkbox hapus
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = null;
        } else {
            unset($validated['photo']); // Pertahankan foto lama jika tidak ada upload baru dan tidak dihapus
        }

        $validated['user_id'] = auth()->id(); // Catat admin yang update
        $umkm->update($validated);
        $umkm->photo = $photoPath; // Set kembali path foto di model setelah update
        $umkm->save(); // Simpan perubahan path foto


        return redirect('/umkms')->with('success', 'Data UMKM berhasil diperbarui!');
    }

    /**
     * Menghapus UMKM dari database.
     */
    public function destroy(Umkm $umkm) // Menggunakan Route Model Binding
    {
        if ($umkm->photo) {
            Storage::disk('public')->delete($umkm->photo); // Hapus foto dari storage
        }
        $umkm->delete();

        return redirect('/umkms')->with('success', 'Data UMKM berhasil dihapus!');
    }
}