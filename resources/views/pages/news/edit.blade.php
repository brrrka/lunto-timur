@extends('layout.app') 

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Berita</h1>
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

    {{-- Pesan Sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Penting: Untuk operasi update --}}

        <div class="card-body bg-white mb-3 shadow-sm">
            <div class="mb-3">
                <label for="title" class="form-label">Judul Berita</label>
                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $news->title) }}">
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Isi Berita</label>
                <textarea id="content" name="content" rows="10" class="form-control @error('content') is-invalid @enderror">{{ old('content', $news->content) }}</textarea>
                @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="thumbnail" class="form-label">Thumbnail Berita</label>
                @if ($news->thumbnail)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="Thumbnail Saat Ini" class="img-thumbnail" style="max-width: 150px; height: auto;">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="remove_thumbnail" id="remove_thumbnail" value="1">
                            <label class="form-check-label" for="remove_thumbnail">
                                Hapus Thumbnail Saat Ini
                            </label>
                        </div>
                    </div>
                @endif
                <input type="file" id="thumbnail" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror">
                <div class="form-text text-muted">Unggah thumbnail baru untuk mengganti yang lama. Format: JPG, PNG, GIF, SVG. Max: {{ ini_get('upload_max_filesize') }}.</div>
                @error('thumbnail')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="published_at" class="form-label">Tanggal Publikasi (Opsional)</label>
                <input type="date" id="published_at" name="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at', $news->published_at ? \Carbon\Carbon::parse($news->published_at)->format('Y-m-d') : '') }}">
                @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('news.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>
@endsection