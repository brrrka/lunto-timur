<?php

namespace App\Http\Controllers;

use App\Models\Gallery; // Import model Gallery
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk upload/hapus file
use Carbon\Carbon; // Untuk memformat tanggal

class GalleryController extends Controller
{
    // --- Admin Methods ---

    // Menampilkan daftar semua item galeri di halaman admin.
    public function index()
    {
        $galleries = Gallery::orderBy('activity_date', 'desc')->paginate(10); // Urutkan terbaru, dengan pagination
        return view('pages.gallery.index', compact('galleries')); // Path view admin
    }

    // Menampilkan form untuk membuat item galeri baru.
    public function create()
    {
        return view('pages.gallery.create'); 
    }

    // Menyimpan item galeri baru ke database.
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240', 
            'activity_date' => 'required|date',
        ]);

        $photoPath = $request->file('photo')->store('photos/gallery', 'public'); 

        Gallery::create([
            'photo' => $photoPath,
            'activity_date' => Carbon::parse($validatedData['activity_date']),
            'user_id' => auth()->id(), 
        ]);

        return redirect('/gallery')->with('success', 'Item galeri berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit item galeri yang ada.
    public function edit(Gallery $gallery) 
    {
        return view('pages.gallery.edit', compact('gallery'));
    }

    // Memperbarui item galeri di database.
    public function update(Request $request, Gallery $gallery) // Menggunakan Route Model Binding
    {
        $validatedData = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // Foto opsional saat update
            'activity_date' => 'required|date',
            'remove_photo' => 'nullable|boolean', // Untuk checkbox hapus foto
        ]);

        $photoPath = $gallery->photo;

        if ($request->hasFile('photo')) {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath); // Hapus foto lama
            }
            $photoPath = $request->file('photo')->store('photos/gallery', 'public');
        } elseif ($request->boolean('remove_photo')) { // Periksa checkbox hapus
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = null; // Set path menjadi null jika dihapus
        }

        $gallery->update([
            'photo' => $photoPath,
            'activity_date' => Carbon::parse($validatedData['activity_date']),
            'user_id' => auth()->id(), // Catat user terakhir yang update
        ]);

        return redirect('/gallery')->with('success', 'Item galeri berhasil diperbarui!');
    }

    // Menghapus item galeri dari database.
    public function destroy(Gallery $gallery) // Menggunakan Route Model Binding
    {
        if ($gallery->photo) {
            Storage::disk('public')->delete($gallery->photo); // Hapus foto dari storage
        }
        $gallery->delete();

        return redirect('/gallery')->with('success', 'Item galeri berhasil dihapus!');
    }

    // --- Public Methods ---

    // Menampilkan semua item galeri di halaman publik.
    public function indexPublic()
    {
        // Ambil semua item galeri, diurutkan berdasarkan tanggal kegiatan terbaru
        $galleries = Gallery::orderBy('activity_date', 'desc')->paginate(12);

        return view('user.pages.galeri.index', compact('galleries')); // Path view publik
    }
}