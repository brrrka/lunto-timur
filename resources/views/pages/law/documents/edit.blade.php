@extends('layout.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Dokumen</h1>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi Kesalahan!</strong> Mohon periksa kembali input Anda.
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('documents.update', $document->slug) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-body bg-white mb-3 shadow-sm">
            <div class="mb-3">
                <label for="title" class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $document->title) }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi (Opsional)</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $document->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="document_file" class="form-label">File Dokumen (Opsional, unggah untuk ganti)</label>
                @if ($document->file_path)
                    <div class="mb-2">
                        <p class="text-muted mb-1">File saat ini: <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">{{ Str::limit($document->title, 30) }}.{{ $document->file_type }}</a> ({{ $document->file_size }})</p>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="remove_file" id="remove_file" value="1">
                            <label class="form-check-label" for="remove_file">
                                Hapus File Saat Ini
                            </label>
                        </div>
                    </div>
                @endif
                <input type="file" class="form-control @error('document_file') is-invalid @enderror" id="document_file" name="document_file">
                <div class="form-text text-muted">Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP. Max: {{ ini_get('upload_max_filesize') }}.</div>
                @error('document_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="published_date" class="form-label">Tanggal Publikasi (Opsional)</label>
                <input type="date" class="form-control @error('published_date') is-invalid @enderror" id="published_date" name="published_date" value="{{ old('published_date', $document->published_date ? $document->published_date->format('Y-m-d') : '') }}">
                @error('published_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
        <button type="submit" class="btn btn-warning">Update</button>
    </div>
</form>
@endsection