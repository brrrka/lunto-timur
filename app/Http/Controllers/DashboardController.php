<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\VillageOfficial; 
use App\Models\Gallery;
use App\Models\Umkm; 
use App\Models\LuasAreaProduksi;
use App\Models\PopulasiTanaman;
use App\Models\PopulasiTernak;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Fungsi untuk menampilkan halaman dashboard
    public function index(Request $request)
    {
        $totalResidents = Resident::count();

        // Statistik Jumlah Pengurus Nagari
        $totalOfficials = VillageOfficial::count();

        // Statistik Jumlah Foto Galeri
        $totalGalleryPhotos = Gallery::count();

        // Statistik Jumlah UMKM
        $totalUmkms = Umkm::count();

        // Filter tahun untuk produksi pertanian
        $selectedYearProduksi = $request->input('tahun_produksi', Carbon::now()->year);

        $produksiData = LuasAreaProduksi::select('nama_komoditi', DB::raw('SUM(produksi) as total_produksi'))
                                        ->where('tahun', $selectedYearProduksi)
                                        ->groupBy('nama_komoditi')
                                        ->orderBy('nama_komoditi') // Urutkan berdasarkan nama komoditi agar konsisten
                                        ->get();

        $labelsProduksi = $produksiData->pluck('nama_komoditi')->toArray();
        $valuesProduksi = $produksiData->pluck('total_produksi')->toArray();

        // Mengambil daftar tahun unik dari database LuasAreaProduksi untuk dropdown filter
        $availableYearsProduksi = LuasAreaProduksi::select('tahun')
                                                ->distinct()
                                                ->orderBy('tahun', 'desc')
                                                ->pluck('tahun');
        
        // Jika tidak ada data tahun di DB LuasAreaProduksi, tambahkan tahun sekarang
        if ($availableYearsProduksi->isEmpty()) {
            $availableYearsProduksi = collect([Carbon::now()->year]);
        }
 
        return view('pages.dashboard', compact('totalResidents', 'totalOfficials', 'totalGalleryPhotos', 'totalUmkms', 'labelsProduksi', 'valuesProduksi', 'selectedYearProduksi', 'availableYearsProduksi'));
    }
}
