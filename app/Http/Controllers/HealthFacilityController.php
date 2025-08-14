<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HealthFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class HealthFacilityController extends Controller
{
    public function index(Request $request)
    {
        $query = HealthFacility::query();
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%');
        }
        $healthFacilities = $query->paginate(10);
        return view('pages.health.health-facilities.index', compact('healthFacilities'));
    }

    public function create() {
        return view('pages.health.health-facilities.create'); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required|string',
            'phone_number' => 'nullable|string|max:15',
        ]);
        $validated['slug'] = Str::slug($validated['name']);
        $originalSlug = $validated['slug']; $count = 1;
        while (HealthFacility::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        if ($request->hasFile('photo')) { $validated['photo'] = $request->file('photo')->store('health_facilities_photos', 'public'); }
        $validated['user_id'] = auth()->id();
        HealthFacility::create($validated);
        return redirect('health-facilities')->with('success', 'Fasilitas kesehatan berhasil ditambahkan!');
    }

    public function show(HealthFacility $healthFacility) { 
        return view('pages.health.health-facilities.show', compact('healthFacility')); 
    }

    public function edit(HealthFacility $healthFacility) { 
        return view('pages.health.health-facilities.edit', compact('healthFacility')); 
    }

    public function update(Request $request, HealthFacility $healthFacility)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('health_facilities')->ignore($healthFacility->id)],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required|string',
            'phone_number' => 'nullable|string|max:15',
            'remove_photo' => 'nullable|boolean',
        ]);
        $validated['slug'] = Str::slug($validated['name']);
        $originalSlug = $validated['slug']; $count = 1;
        while (HealthFacility::where('slug', $validated['slug'])->where('id', '!=', $healthFacility->id)->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        $photoPath = $healthFacility->photo;
        if ($request->hasFile('photo')) {
            if ($photoPath) { Storage::disk('public')->delete($photoPath); }
            $photoPath = $request->file('photo')->store('health_facilities_photos', 'public');
        } elseif ($request->boolean('remove_photo')) {
            if ($photoPath) { Storage::disk('public')->delete($photoPath); }
            $photoPath = null;
        } else { unset($validated['photo']); }

        $validated['user_id'] = auth()->id();
        $healthFacility->update($validated);
        $healthFacility->photo = $photoPath; $healthFacility->save();
        return redirect('health-facilities')->with('success', 'Fasilitas kesehatan berhasil diperbarui!');
    }

    public function destroy(HealthFacility $healthFacility)
    {
        if ($healthFacility->photo) { Storage::disk('public')->delete($healthFacility->photo); }
        $healthFacility->delete();
        return redirect('health-facilities')->with('success', 'Fasilitas kesehatan berhasil dihapus!');
    }
}