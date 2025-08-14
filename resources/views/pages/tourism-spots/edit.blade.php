@extends('layout.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Tempat Wisata</h1>
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

    {{-- PERBAIKAN: Nama rute menggunakan 'tourism_spots' (underscore) --}}
    <form action="{{ route('tourism-spots.update', $tourismSpot->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body bg-white mb-3 shadow-sm">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Tempat Wisata <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $tourismSpot->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="thumbnail" class="form-label">Foto Utama (Thumbnail)</label>
                @if ($tourismSpot->thumbnail)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $tourismSpot->thumbnail) }}" alt="{{ $tourismSpot->name }}" width="200">
                        <small class="d-block text-muted">Gambar saat ini</small>
                    </div>
                    {{-- Opsi untuk menghapus thumbnail yang sudah ada (disarankan) --}}
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="remove_thumbnail" value="1" id="remove_thumbnail">
                        <label class="form-check-label" for="remove_thumbnail">
                            Hapus gambar saat ini
                        </label>
                    </div>
                @endif
                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail">
                @error('thumbnail')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            </div>

            <div class="mb-3">
                <label for="video_url" class="form-label">Link Video (YouTube/Gdrive)</label>
                <input type="url" class="form-control @error('video_url') is-invalid @enderror" id="video_url" name="video_url" value="{{ old('video_url', $tourismSpot->video_url) }}" placeholder="Contoh: https://www.youtube.com/watch?v=xxxxxxxx">
                @error('video_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $tourismSpot->address) }}</textarea>
                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="latitude" class="form-label">Koordinat Latitude</label>
                    <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude', $tourismSpot->latitude) }}" placeholder="-0.xxxxxx">
                    @error('latitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="longitude" class="form-label">Koordinat Longitude</label>
                    <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude', $tourismSpot->longitude) }}" placeholder="100.xxxxxx">
                    @error('longitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="7" required>{{ old('description', $tourismSpot->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('tourism-spots.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </div>
    </form>
@endsection