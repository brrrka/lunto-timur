@extends('layout.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Item Galeri</h1>
    </div>

    {{-- Pesan Error Validasi --}}
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

    <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body bg-white mb-3 shadow-sm">
            <div class="mb-3">
                <label for="photo" class="form-label">Foto Kegiatan</label>
                <input type="file" id="photo" name="photo" class="form-control @error('photo') is-invalid @enderror">
                <div class="form-text text-muted">Format: JPG, PNG, GIF, SVG. Maksimal: {{ ini_get('upload_max_filesize') }}.</div>
                @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="activity_date" class="form-label">Tanggal Kegiatan</label>
                <input type="date" id="activity_date" name="activity_date" class="form-control @error('activity_date') is-invalid @enderror" value="{{ old('activity_date') }}">
                @error('activity_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('gallery.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>
@endsection