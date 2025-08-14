<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Resident;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    // Fungsi untuk menampilkan halaman daftar warga
    public function index(Request $request)
    {
        $query = Resident::query(); // Mulai query dari model Resident
        // Jika ada parameter 'search' di URL
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->Where('name', 'like', '%' . $search . '%'); // Atau di kolom Nama
        }
        // Terapkan with('user') dan paginate(10) langsung pada objek $query
        $residents = $query->with('user')->paginate(10);
        // --- AKHIR PERBAIKAN ---
    
        return view('pages.resident.index', [
            'residents' => $residents,
        ]);
    }
    // Fungsi untuk menampilkan halaman buat warga
    public function create()
    {
        return view('pages.resident.create');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:100'],
            'gender' => ['required', Rule::in(['Pria', 'Wanita'])],
            'birth_date' => ['required', 'string'],
            'birth_place' => ['required', 'max:100'],
            'address' => ['required', 'max:700'],
            'religion' => ['nullable','max:50'],
            'marital_status' => ['required', Rule::in(['Belum Menikah', 'Menikah', 'Cerai', 'Janda/Duda'])],
            'occupation' => ['nullable', 'max:100'],
            'status' => ['required', Rule::in(['Aktif', 'Pindah', 'Meninggal'])],        
        ]);

        Resident::create($validatedData);
        return redirect('/resident')->with('success', 'Data berhasil disimpan!');
    }
    // Fungsi untuk menampilkan halaman edit warga
    public function edit($id)
    {
        $resident = Resident::findOrFail($id);
        return view('pages.resident.edit', [
            'resident' => $resident
        ]);
    }   // Fungsi untuk memperbarui data warga
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:100'],
            'gender' => ['required', Rule::in(['Pria', 'Wanita'])],
            'birth_date' => ['required', 'string'],
            'birth_place' => ['required', 'max:100'],
            'address' => ['required', 'max:700'],
            'religion' => ['nullable','max:50'],
            'marital_status' => ['required', Rule::in(['Belum Menikah', 'Menikah', 'Cerai', 'Janda/Duda'])],
            'occupation' => ['nullable', 'max:100'],
            'status' => ['required', Rule::in(['Aktif', 'Pindah', 'Meninggal'])],        
        ]);

        Resident::findOrFail($id)->update($validatedData);
        return redirect('/resident')->with('success', 'Berhasil Mengubah Data');
    }
    // Fungsi untuk menghapus data warga
    public function destroy($id)
    {
        $residents = Resident::findOrFail($id);
        $residents->delete();
        return redirect('/resident')->with('success', 'Berhasil Menghapus Data');
    }
}
