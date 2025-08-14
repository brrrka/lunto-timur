<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::query();
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'like', '%' . $search . '%');
        }
        $documents = $query->paginate(10);
        return view('pages.law.documents.index', compact('documents'));
    }

    public function create() { 
        return view('pages.law.documents.create'); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_file' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip', // Max 10MB, format umum
            'published_date' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $originalSlug = $validated['slug']; $count = 1;
        while (Document::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $validated['file_path'] = $file->store('documents', 'public'); // Simpan di storage/app/public/documents
            $validated['file_type'] = $file->getClientOriginalExtension(); // Ekstensi file
            $validated['file_size'] = round($file->getSize() / 1024, 2) . ' KB'; // Ukuran dalam KB
        } else {
            // Jika validasi mengatakan 'required', ini tidak akan terjadi
            return redirect()->back()->withErrors(['document_file' => 'Dokumen harus diunggah.']);
        }

        $validated['published_date'] = $validated['published_date'] ? Carbon::parse($validated['published_date']) : Carbon::now();
        $validated['user_id'] = auth()->id();
        Document::create($validated);
        return redirect('documents')->with('success', 'Dokumen berhasil diunggah!');
    }

    public function show(Document $document) {
        return view('pages.law.documents.show', compact('document')); 
    }

    public function edit(Document $document) {
        return view('pages.law.documents.edit', compact('document')); 
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('documents')->ignore($document->id)],
            'description' => 'nullable|string',
            'document_file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip',
            'published_date' => 'nullable|date',
            'remove_file' => 'nullable|boolean', // Jika ingin ada opsi hapus file lama
        ]);
        
        $validated['slug'] = Str::slug($validated['title']);
        $originalSlug = $validated['slug']; $count = 1;
        while (Document::where('slug', $validated['slug'])->where('id', '!=', $document->id)->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        $filePath = $document->file_path;
        if ($request->hasFile('document_file')) {
            if ($filePath) { Storage::disk('public')->delete($filePath); }
            $file = $request->file('document_file');
            $filePath = $file->store('documents', 'public');
            $validated['file_type'] = $file->getClientOriginalExtension();
            $validated['file_size'] = round($file->getSize() / 1024, 2) . ' KB';
        } elseif ($request->boolean('remove_file')) {
            if ($filePath) { Storage::disk('public')->delete($filePath); }
            $filePath = null;
            $validated['file_type'] = null;
            $validated['file_size'] = null;
        } else {
            // Pertahankan path lama jika tidak ada upload baru dan tidak dihapus
            unset($validated['file_path']);
            unset($validated['file_type']);
            unset($validated['file_size']);
        }

        $validated['published_date'] = $validated['published_date'] ? Carbon::parse($validated['published_date']) : $document->published_date;
        $validated['user_id'] = auth()->id();
        $document->update($validated);
        $document->file_path = $filePath; $document->save(); // Pastikan path file diperbarui
        return redirect('documents')->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy(Document $document)
    {
        if ($document->file_path) { Storage::disk('public')->delete($document->file_path); }
        $document->delete();
        return redirect('documents')->with('success', 'Dokumen berhasil dihapus!');
    }
}