<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon; // Untuk tahun

class DiseaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Disease::query();
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%');
        }
        if ($request->has('year') && $request->year != '') { // Filter tahun
            $query->where('year', $request->year);
        }
        $diseases = $query->paginate(10);

        $availableYears = Disease::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');
        if ($availableYears->isEmpty()) {
            $availableYears = collect([Carbon::now()->year]);
        }
        
        return view('pages.health.diseases.index', compact('diseases', 'availableYears'));
    }

    public function create() {
        return view('pages.health.diseases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:diseases',
            'case_count' => 'required|integer|min:0',
            'year' => 'nullable|integer|digits:4',
        ]);
        $validated['user_id'] = auth()->id();
        Disease::create($validated);
        return redirect('diseases')->with('success', 'Data penyakit berhasil ditambahkan!');
    }

    public function show(Disease $disease) { 
        return view('pages.health.diseases.show', compact('disease')); 
    }

    public function edit(Disease $disease) { 
        return view('pages.health.diseases.edit', compact('disease')); 
    }

    public function update(Request $request, Disease $disease)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('diseases')->ignore($disease->id)],
            'case_count' => 'required|integer|min:0',
            'year' => 'nullable|integer|digits:4',
        ]);
        $validated['user_id'] = auth()->id();
        $disease->update($validated);
        return redirect('diseases')->with('success', 'Data penyakit berhasil diperbarui!');
    }

    public function destroy(Disease $disease)
    {
        $disease->delete();
        return redirect('diseases')->with('success', 'Data penyakit berhasil dihapus!');
    }
}