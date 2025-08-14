@extends('layout.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Luas Area Produksi</h1>
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

    <form action="{{ route('luas-area-produksi.update', $luasAreaProduksi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Penting: Untuk operasi update --}}

        <div class="card-body bg-white mb-3 shadow-sm">
            <div class="mb-3">
                <label for="nama_komoditi" class="form-label">Nama Komoditi <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_komoditi') is-invalid @enderror" id="nama_komoditi" name="nama_komoditi" value="{{ old('nama_komoditi', $luasAreaProduksi->nama_komoditi) }}" required>
                @error('nama_komoditi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="tipe_area" class="form-label">Tipe Area <span class="text-danger">*</span></label>
                <select class="form-select @error('tipe_area') is-invalid @enderror" id="tipe_area" name="tipe_area" required>
                    <option value="">Pilih Tipe Area</option>
                    <option value="Sawah" {{ old('tipe_area', $luasAreaProduksi->tipe_area) == 'Sawah' ? 'selected' : '' }}>Sawah</option>
                    <option value="Tanaman Palawija" {{ old('tipe_area', $luasAreaProduksi->tipe_area) == 'Tanaman Palawija' ? 'selected' : '' }}>Tanaman Palawija</option>
                </select>
                @error('tipe_area')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="luas_tanam" class="form-label">Luas Tanam (Ha) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control @error('luas_tanam') is-invalid @enderror" id="luas_tanam" name="luas_tanam" value="{{ old('luas_tanam', $luasAreaProduksi->luas_tanam) }}" required min="0">
                @error('luas_tanam')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="luas_panen" class="form-label">Luas Panen (Ha) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control @error('luas_panen') is-invalid @enderror" id="luas_panen" name="luas_panen" value="{{ old('luas_panen', $luasAreaProduksi->luas_panen) }}" required min="0">
                @error('luas_panen')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="produksi" class="form-label">Produksi (Ton) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control @error('produksi') is-invalid @enderror" id="produksi" name="produksi" value="{{ old('produksi', $luasAreaProduksi->produksi) }}" required min="0">
                @error('produksi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun (Opsional)</label>
                <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', $luasAreaProduksi->tahun ?? date('Y')) }}" placeholder="{{ date('Y') }}">
                @error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Gambar (Opsional)</label>
                @if ($luasAreaProduksi->image) {{-- Ganti $item dengan variabel model yang sesuai --}}
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $luasAreaProduksi->image) }}" alt="Gambar Saat Ini" class="img-thumbnail" style="max-width: 150px; height: auto;">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                            <label class="form-check-label" for="remove_image">
                                Hapus Gambar Saat Ini
                            </label>
                        </div>
                    </div>
                @endif
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="form-text text-muted">Unggah gambar baru untuk mengganti yang lama (opsional).</small>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('luas-area-produksi.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>
@endsection




