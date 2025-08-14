<?php

namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
use App\Models\Umkm; 
use Illuminate\Http\Request;

class PublicUmkmController extends Controller
{
    /**
     * Menampilkan daftar semua UMKM untuk halaman publik.
     */
    public function indexPublic(Request $request)
    {
        // --- 1. Ambil UMKM Unggulan (yang punya foto, misal 6 terbaru) ---
        $featuredUmkms = Umkm::whereNotNull('photo') // Hanya UMKM yang memiliki foto
                              ->orderBy('created_at', 'desc') // Urutkan dari terbaru
                              ->take(6)                       // Ambil hanya 6
                              ->get();

        // --- 2. Ambil Seluruh UMKM untuk Tabel (dengan pencarian dan pagination) ---
        $query = Umkm::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_usaha', 'like', '%' . $search . '%')
                  ->orWhere('nama_pemilik', 'like', '%' . $search . '%');
        }

        $allUmkms = $query->paginate(15); // Ambil semua UMKM dengan pagination, 15 per halaman

        return view('user.pages.umkm.index', compact('featuredUmkms', 'allUmkms'));
    }
}