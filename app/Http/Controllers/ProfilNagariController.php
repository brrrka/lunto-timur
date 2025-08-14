<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisiMisi;
use App\Models\VillageOfficial;

class ProfilNagariController extends Controller
{
    /**
     * Halaman Profil Nagari
     */
    public function profilNagariView()
    {
        $visi = VisiMisi::where('type', 'visi')->first();

        $misiItems = VisiMisi::where('type', 'misi')
            ->orderBy('order')
            ->get();

        // Ambil 4 perangkat desa untuk ditampilkan
        $officials = VillageOfficial::orderBy('order')
            ->orderBy('name')
            ->take(4)
            ->get();

        return view('user.pages.profil-nagari', compact('visi', 'misiItems', 'officials'));
    }

    /**
     * Halaman Perangkat Nagari
     */
    public function perangkatNagariView()
    {
        // Ambil semua perangkat desa
        $officials = VillageOfficial::orderBy('order')
            ->orderBy('name')
            ->get();

        return view('user.pages.perangkat-nagari', compact('officials'));
    }

    /**
     * Halaman Sejarah Nagari
     */
    public function sejarahNagariView()
    {
        return view('user.pages.sejarah-nagari');
    }
}
