<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentPage; 
use App\Models\Document; 
use Illuminate\Support\Facades\Storage;

class HukumPublicController extends Controller
{
    /**
     * Menampilkan halaman indeks publik untuk fitur Hukum (kontak dan dokumen).
     */
    public function indexPublic(Request $request)
    {
        // Ambil data kontak hukum (jika disimpan di ContentPage)
        $legalContact = ContentPage::where('type', 'legal_contact')->first();

        // Ambil data dokumen untuk daftar
        $queryDocuments = Document::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $queryDocuments->where('title', 'like', '%' . $search . '%')
                           ->orWhere('description', 'like', '%' . $search . '%');
        }

        $documents = $queryDocuments->orderBy('published_date', 'desc')->paginate(10);

        return view('user.pages.hukum.index', compact('legalContact', 'documents'));
    }

    /**
     * Mengunduh dokumen.
     */
    public function downloadDocument(Document $document)
    {
        // Pastikan dokumen ada dan file_path tidak null
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download($document->file_path, $document->title . '.' . $document->file_type);
        }

        // Jika file tidak ditemukan, arahkan kembali dengan pesan error
        return redirect()->back()->with('error', 'File dokumen tidak ditemukan.');
    }

    /**
     * Menampilkan halaman detail dokumen (opsional, untuk preview/info lebih lanjut).
     */
    public function showDocument(Document $document)
    {
        return view('user.pages.hukum.show', compact('document'));
    }
}