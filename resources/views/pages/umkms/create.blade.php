@extends('layout.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah UMKM Baru</h1>
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

    <form action="{{ route('umkms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="card-body bg-white mb-3 shadow-sm">
                <div class="mb-3">
                    <label for="nama_usaha" class="form-label">Nama Usaha <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_usaha') is-invalid @enderror" id="nama_usaha" name="nama_usaha" value="{{ old('nama_usaha') }}" required>
                    @error('nama_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="nama_pemilik" class="form-label">Nama Pemilik <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_pemilik') is-invalid @enderror" id="nama_pemilik" name="nama_pemilik" value="{{ old('nama_pemilik') }}" required>
                    @error('nama_pemilik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="alamat_usaha" class="form-label">Alamat Usaha (Opsional)</label>
                    <textarea class="form-control @error('alamat_usaha') is-invalid @enderror" id="alamat_usaha" name="alamat_usaha" rows="3">{{ old('alamat_usaha') }}</textarea>
                    @error('alamat_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="no_hp_usaha" class="form-label">Nomor HP Usaha (Opsional)</label>
                    <input type="text" class="form-control @error('no_hp_usaha') is-invalid @enderror" id="no_hp_usaha" name="no_hp_usaha" value="{{ old('no_hp_usaha') }}">
                    @error('no_hp_usaha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Foto Usaha (Opsional)</label>
                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                    <div class="form-text text-muted">Format: JPG, PNG, GIF, SVG. Max: {{ ini_get('upload_max_filesize') }}.</div>
                    @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <a href="/kelembagaan-tani" class="btn btn-outline-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
    </form>
@endsection