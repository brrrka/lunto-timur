<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HealthFacility; // Pastikan ini diimpor
use App\Models\Disease; // Pastikan ini diimpor
use Carbon\Carbon;

class KesehatanPublicController extends Controller
{
    public function indexPublic(Request $request)
    {
        // Ambil data Fasilitas Kesehatan (untuk card)
        $healthFacilities = HealthFacility::orderBy('name')->paginate(9); // Contoh: 9 fasilitas per halaman

        // Ambil data Penyakit (untuk tabel)
        $queryDiseases = Disease::query();
        if ($request->has('year') && $request->year != '') {
            $queryDiseases->where('year', $request->year);
        }
        $availableYearsDiseases = Disease::select('year')
                                        ->distinct()
                                        ->orderBy('year', 'desc')
                                        ->pluck('year');

        if ($availableYearsDiseases->isEmpty()) {
            $availableYearsDiseases = collect([Carbon::now()->year]);
        }

        $diseases = $queryDiseases->orderBy('case_count', 'desc')->paginate(10);

        return view('user.pages.kesehatan.index', compact(
            'healthFacilities',
            'diseases',
            'availableYearsDiseases'
        ));
    }
}