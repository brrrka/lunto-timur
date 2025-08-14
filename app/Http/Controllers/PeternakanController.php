<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PopulasiTernak;

class PeternakanController extends Controller
{
    public function populasiTernakPublic(Request $request)
    {
        $query = PopulasiTernak::query();

        // Tambahkan fitur pencarian dan filter tahun jika diperlukan
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('jenis_ternak', 'like', '%' . $search . '%');
        }
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        // Ambil data dengan pagination, 10 data per halaman
        $populasiTernak = $query->orderBy('tahun', 'desc')->orderBy('jenis_ternak')->paginate(10);

        // Ambil tahun unik untuk filter
        $availableYears = PopulasiTernak::select('tahun')
                                        ->distinct()
                                        ->orderBy('tahun', 'desc')
                                        ->pluck('tahun');

        return view('user.pages.peternakan.index', compact('populasiTernak', 'availableYears'));
    }
}
