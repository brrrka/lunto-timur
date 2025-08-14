@extends('layout.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Dokumen Baru</h1>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
             @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="card-body bg-white mb-3 shadow-sm">
            <div class="mb-3">
                <label for="title" class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi (Opsional)</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="document_file" class="form-label">Pilih File Dokumen <span class="text-danger">*</span></label>
                <input type="file" class="form-control @error('document_file') is-invalid @enderror" id="document_file" name="document_file" required>
                <div class="form-text text-muted">Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP. Max: {{ ini_get('upload_max_filesize') }}.</div>
                @error('document_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="published_date" class="form-label">Tanggal Publikasi (Opsional)</label>
                <input type="date" class="form-control @error('published_date') is-invalid @enderror" id="published_date" name="published_date" value="{{ old('published_date', date('Y-m-d')) }}">
                @error('published_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
</form>
@endsection