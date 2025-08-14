<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelembagaanTani; // Import model KelembagaanTani
use App\Models\LuasAreaProduksi; // Import model LuasAreaProduksi
use App\Models\PopulasiTanaman; // Import model PopulasiTanaman

class PertanianController extends Controller
{
    /**
     * Menampilkan halaman indeks publik untuk fitur pertanian.
     */
    public function indexPublic()
    {
        // Ambil jumlah data untuk masing-masing kategori
        $totalKelembagaanTani = KelembagaanTani::count();
        $totalLuasAreaProduksi = LuasAreaProduksi::count();
        $totalPopulasiTanaman = PopulasiTanaman::count();


        return view('user.pages.pertanian.index', compact(
            'totalKelembagaanTani',
            'totalLuasAreaProduksi',
            'totalPopulasiTanaman'
        ));
    }

    public function kelembagaanTaniPublic(Request $request)
    {
        $query = KelembagaanTani::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_poktan', 'like', '%' . $search . '%') 
                  ->orWhere('kelas_kemampuan', 'like', '%' . $search . '%'); 
        }

        $kelembagaanTani = $query->paginate(10);

        return view('user.pages.pertanian.kelembagaan-tani', compact('kelembagaanTani'));
    }

    public function luasAreaProduksiPublic(Request $request)
    {
        $query = LuasAreaProduksi::query();

        // Tambahkan fitur pencarian dan filter tahun jika diperlukan
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_komoditi', 'like', '%' . $search . '%')
                  ->orWhere('tipe_area', 'like', '%' . $search . '%');
        }
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        // Ambil data dengan pagination, 10 data per halaman
        $luasAreaProduksi = $query->orderBy('tahun', 'desc')->orderBy('nama_komoditi')->paginate(9);

        // Ambil tahun unik untuk filter
        $availableYears = LuasAreaProduksi::select('tahun')
                                        ->distinct()
                                        ->orderBy('tahun', 'desc')
                                        ->pluck('tahun');

        return view('user.pages.pertanian.luas-area-produksi', compact('luasAreaProduksi', 'availableYears'));
    }

    public function populasiTanamanPublic(Request $request)
    {
        $query = PopulasiTanaman::query();

        // Tambahkan fitur pencarian dan filter tahun jika diperlukan
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_komoditi', 'like', '%' . $search . '%')
                  ->orWhere('tipe_tanaman', 'like', '%' . $search . '%');
        }
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        // Ambil data dengan pagination, 10 data per halaman
        $populasiTanaman = $query->orderBy('tahun', 'desc')->orderBy('nama_komoditi')->paginate(9);

        // Ambil tahun unik untuk filter
        $availableYears = PopulasiTanaman::select('tahun')
                                        ->distinct()
                                        ->orderBy('tahun', 'desc')
                                        ->pluck('tahun');

        return view('user.pages.pertanian.populasi-tanaman', compact('populasiTanaman', 'availableYears'));
    }
}