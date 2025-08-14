<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TourismSpot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Import Str untuk slug

class TourismSpotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TourismSpot::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%');
        }

        $tourismSpots = $query->paginate(10);

        return view('pages.tourism-spots.index', compact('tourismSpots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.tourism-spots.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_url' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'description' => 'required|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('tourism_spot_thumbnails', 'public');
        }

        TourismSpot::create($validated);

        return redirect('/tourism-spots')->with('success', 'Tempat wisata berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TourismSpot $tourismSpot)
    {
        return view('pages.tourism-spots.edit', compact('tourismSpot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TourismSpot $tourismSpot)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_url' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'description' => 'required|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        // Handle thumbnail update
        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama jika ada
            if ($tourismSpot->thumbnail) {
                Storage::disk('public')->delete($tourismSpot->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('tourism_spot_thumbnails', 'public');
        } else {
            // Pertahankan thumbnail lama jika tidak ada upload baru
            unset($validated['thumbnail']);
        }

        $tourismSpot->update($validated);

        return redirect('/tourism-spots')->with('success', 'Tempat wisata berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourismSpot $tourismSpot)
    {
        // Hapus thumbnail dari storage
        if ($tourismSpot->thumbnail) {
            Storage::disk('public')->delete($tourismSpot->thumbnail);
        }

        $tourismSpot->delete();

        return redirect('/tourism-spots')->with('success', 'Tempat wisata berhasil dihapus!');
    }

    public function indexPublic()
    {
        // Mengambil semua tempat wisata, diurutkan berdasarkan nama, dengan pagination
        $tourismSpots = TourismSpot::orderBy('name')->paginate(10); // Contoh: 9 tempat wisata per halaman

        return view('user.pages.wisata.index', compact('tourismSpots')); // Path view publik
    }


    public function showPublic($slug)
    {
        $tourismSpot = TourismSpot::where('slug', $slug)->firstOrFail();

        // Mendapatkan wisata lainnya, kecuali yang sedang ditampilkan
        // Ambil 3 wisata lainnya secara acak atau berdasarkan kriteria tertentu
        $otherTourismSpots = TourismSpot::where('id', '!=', $tourismSpot->id)
                                    ->inRandomOrder() // Atau orderBy('created_at', 'desc')
                                    ->limit(3) // Batasi jumlah yang ditampilkan
                                    ->get();

        return view('user.pages.wisata.show', compact('tourismSpot', 'otherTourismSpots'));
    }
    
}