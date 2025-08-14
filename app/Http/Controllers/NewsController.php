<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\News; // Import model News
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk upload/hapus file
use Illuminate\Support\Str; // Untuk membuat slug

class NewsController extends Controller
{
    // Menampilkan daftar semua berita di halaman admin.
    public function index(Request $request)
    {
        $query = News::query(); // Mulai query dari model Resident
        // Jika ada parameter 'search' di URL
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'like', '%' . $search . '%'); // Cari di kolom NIK
        }
        
        $news = $query->with('user')->orderBy('published_at', 'desc')->paginate(10); // Pastikan .with('user') ada
        return view('pages.news.index', compact('news'));
    }

    // Menampilkan form untuk membuat berita baru.
    public function create()
    {
        return view('pages.news.create');
    }

    // Menyimpan berita baru ke database.
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240', 
            'published_at' => 'nullable|date',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails/news', 'public'); // Simpan di storage/app/public/thumbnails/news
        }

        News::create([
            'title' => $validatedData['title'],
            'slug' => Str::slug($validatedData['title']), // Otomatis buat slug dari judul
            'content' => $validatedData['content'],
            'thumbnail' => $thumbnailPath,
            'published_at' => $validatedData['published_at'] ?? now(), // Default: waktu sekarang jika kosong
            'user_id' => auth()->id(), // Ambil ID user yang sedang login
        ]);

        return redirect('/news')->with('success', 'Berita berhasil ditambahkan!');
    }

    // Menampilkan detail satu berita (opsional, biasanya untuk tampilan publik).
    public function show(News $news)
    {
        return view('pages.news.show', compact('news')); // Atau bisa diarahkan ke tampilan publik
    }

    // Menampilkan form untuk mengedit berita yang ada.
    public function edit(News $news) // Menggunakan Route Model Binding
    {
        return view('pages.news.edit', compact('news'));
    }

    // Memperbarui berita di database.
    public function update(Request $request, News $news) // Menggunakan Route Model Binding
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'published_at' => 'nullable|date',
            'remove_thumbnail' => 'nullable|boolean', // Untuk checkbox hapus thumbnail
        ]);

        $thumbnailPath = $news->thumbnail;

        if ($request->hasFile('thumbnail')) {
            if ($thumbnailPath) {
                Storage::disk('public')->delete($thumbnailPath); // Hapus thumbnail lama
            }
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails/news', 'public');
        } elseif ($request->boolean('remove_thumbnail')) { // Periksa checkbox hapus
            if ($thumbnailPath) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            $thumbnailPath = null;
        }

        $news->update([
            'title' => $validatedData['title'],
            'slug' => Str::slug($validatedData['title']), // Perbarui slug
            'content' => $validatedData['content'],
            'thumbnail' => $thumbnailPath,
            'published_at' => $validatedData['published_at'] ?? $news->published_at,
            'user_id' => auth()->id(), // Catat user terakhir yang update
        ]);

        return redirect('/news')->with('success', 'Berita berhasil diperbarui!');
    }

    // Menghapus berita dari database
    public function destroy(News $news) // Menggunakan Route Model Binding
    {
        if ($news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail); // Hapus thumbnail dari storage
        }
        $news->delete();

        return redirect('/news')->with('success', 'Berita berhasil dihapus!');
    }

    // Tampilan Publik
    public function indexPublic()
    {
        $news = News::whereNotNull('published_at')->orderBy('published_at', 'desc')->paginate(10);
        return view('user.pages.berita.index', compact('news'));
    }
    
    public function showPublic($slug)
    {
        // Temukan berita berdasarkan slug dan pastikan sudah dipublikasikan
        $newsItem = News::where('slug', $slug)
                        ->whereNotNull('published_at')
                        ->firstOrFail();

        // Ambil 6 berita terbaru lainnya, kecuali berita yang sedang dibaca saat ini
        $relatedNews = News::where('id', '!=', $newsItem->id) 
                           ->whereNotNull('published_at')     
                           ->orderBy('published_at', 'desc')  // Urutkan dari yang terbaru
                           ->take(6)                           // Ambil hanya 6
                           ->get();

        return view('user.pages.berita.show', compact('newsItem', 'relatedNews')); // Teruskan kedua variabel
    }
}