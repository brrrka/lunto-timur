<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisiMisi;
use App\Models\Resident;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Umkm;
use App\Models\LuasAreaProduksi; 
use App\Models\PopulasiTanaman; 
use App\Models\PopulasiTernak; 

class LandingPageController extends Controller
{
    public function LandingPageView()
    {
        // Ambil data Visi
        $visi = VisiMisi::where('type', 'visi')->first();

        // Ambil semua data Misi, diurutkan berdasarkan 'order'
        $misiItems = VisiMisi::where('type', 'misi')->orderBy('order')->get();

        // Ambil semua data panduduk
        $totalPenduduk = Resident::count();
        $lakiLaki = Resident::where('gender', 'Pria')->count();
        $perempuan = Resident::where('gender', 'Wanita')->count(); 

        // Ambil semua data berita
        $latestNews = News::whereNotNull('published_at') // Hanya berita yang sudah dipublikasikan
        ->orderBy('published_at', 'desc') // Urutkan dari terbaru
        ->take(6)                           // Ambil hanya 6
        ->get();

        // --- Ambil UMKM Unggulan
        $featuredUmkms = Umkm::whereNotNull('photo') // Hanya UMKM yang memiliki foto
                              ->orderBy('created_at', 'desc') // Urutkan dari terbaru
                              ->take(6)                       // Ambil hanya 6
                              ->get();

        // Jumlah semua UMKM
        $jumlahUmkm = Umkm::count();

        $jumlahKomoditiLuasArea = LuasAreaProduksi::distinct('nama_komoditi')->count('nama_komoditi');
        $jumlahKomoditiPopulasiTanaman = PopulasiTanaman::distinct('nama_komoditi')->count('nama_komoditi');
         //Jumlahkan count dari masing-masing tabel.
        $jumlahPertanian = $jumlahKomoditiLuasArea + $jumlahKomoditiPopulasiTanaman; 

        $jumlahPeternakan = PopulasiTernak::count();



        // --- Ambil 6 Gambar Galeri Terbaru ---
        $latestGalleries = Gallery::orderBy('activity_date', 'desc') // Urutkan berdasarkan tanggal kegiatan terbaru
                                 ->take(6)                         // Ambil hanya 6
                                 ->get();
        return view('user.pages.index', compact('visi', 'misiItems', 'totalPenduduk', 'lakiLaki', 'perempuan', 'latestNews', 'latestGalleries', 'featuredUmkms', 'jumlahUmkm', 'jumlahPertanian', 'jumlahPeternakan',));
    }
}

