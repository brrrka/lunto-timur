<?php

namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
use App\Models\HealthFacility; 
use App\Models\Disease;
use Illuminate\Http\Request;

class KesehatanController extends Controller
{
    /**
     * Menampilkan halaman indeks utama untuk manajemen data kesehatan.
     */
    public function index()
    {
        // Ambil jumlah data untuk ditampilkan di card (opsional)
        $totalHealthFacilities = HealthFacility::count();
        $totalDiseases = Disease::count();

        return view('pages.health.index', compact('totalHealthFacilities', 'totalDiseases'));
    }
}