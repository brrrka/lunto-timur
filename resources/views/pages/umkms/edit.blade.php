@extends('layout.app') 

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit UMKM</h1>
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


    <form action="{{ route('umkms.update', $umkm->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body bg-white mb-3 shadow-sm">
            <div class="mb-3">
                <label for="nama_usaha" class="form-label">Nama Usaha <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_usaha') is-invalid @enderror" id="nama_usaha" name="nama_usaha" value="{{ old('nama_usaha', $umkm->nama_usaha) }}" required>
                @error('nama_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="nama_pemilik" class="form-label">Nama Pemilik <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_pemilik') is-invalid @enderror" id="nama_pemilik" name="nama_pemilik" value="{{ old('nama_pemilik', $umkm->nama_pemilik) }}" required>
                @error('nama_pemilik')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="alamat_usaha" class="form-label">Alamat Usaha (Opsional)</label>
                <textarea class="form-control @error('alamat_usaha') is-invalid @enderror" id="alamat_usaha" name="alamat_usaha" rows="3">{{ old('alamat_usaha', $umkm->alamat_usaha) }}</textarea>
                @error('alamat_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="no_hp_usaha" class="form-label">Nomor HP Usaha (Opsional)</label>
                <input type="text" class="form-control @error('no_hp_usaha') is-invalid @enderror" id="no_hp_usaha" name="no_hp_usaha" value="{{ old('no_hp_usaha', $umkm->no_hp_usaha) }}">
                @error('no_hp_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Foto Usaha (Opsional)</label>
                @if ($umkm->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $umkm->photo) }}" alt="Foto Usaha Saat Ini" class="img-thumbnail" style="max-width: 150px; height: auto;">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="remove_photo" id="remove_photo" value="1">
                            <label class="form-check-label" for="remove_photo">
                                Hapus Foto Saat Ini
                            </label>
                        </div>
                    </div>
                @endif
                <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                <div class="form-text text-muted">Format: JPG, PNG, GIF, SVG. Max: {{ ini_get('upload_max_filesize') }}.</div>
                @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('umkms.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>
@endsection