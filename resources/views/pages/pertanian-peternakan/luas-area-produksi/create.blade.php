@extends('layout.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Luas Area Produksi Baru</h1>
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

<form action="{{ route('luas-area-produksi.store') }}" method="POST" enctype="multipart/form-data">
     @csrf
    <div class="card-body bg-white mb-3 shadow-sm">
        <div class="mb-3">
            <label for="nama_komoditi" class="form-label">Nama Komoditi <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama_komoditi') is-invalid @enderror" id="nama_komoditi" name="nama_komoditi" value="{{ old('nama_komoditi') }}" required>
            @error('nama_komoditi')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="tipe_area" class="form-label">Tipe Area <span class="text-danger">*</span></label>
            <select class="form-select @error('tipe_area') is-invalid @enderror" id="tipe_area" name="tipe_area" required>
                <option value="">Pilih Tipe Area</option>
                <option value="Sawah" {{ old('tipe_area') == 'Sawah' ? 'selected' : '' }}>Sawah</option>
                <option value="Tanaman Palawija" {{ old('tipe_area') == 'Tanaman Palawija' ? 'selected' : '' }}>Tanaman Palawija</option>
            </select>
            @error('tipe_area')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="luas_tanam" class="form-label">Luas Tanam (Ha) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control @error('luas_tanam') is-invalid @enderror" id="luas_tanam" name="luas_tanam" value="{{ old('luas_tanam') }}" required min="0">
            @error('luas_tanam')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="luas_panen" class="form-label">Luas Panen (Ha) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control @error('luas_panen') is-invalid @enderror" id="luas_panen" name="luas_panen" value="{{ old('luas_panen') }}" required min="0">
            @error('luas_panen')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="produksi" class="form-label">Produksi (Ton) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control @error('produksi') is-invalid @enderror" id="produksi" name="produksi" value="{{ old('produksi') }}" required min="0">
            @error('produksi')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun (Opsional)</label>
            <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}" placeholder="{{ date('Y') }}">
            @error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar (Opsional)</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
            <div class="form-text text-muted">Format: JPG, PNG, GIF, SVG. Max: {{ ini_get('upload_max_filesize') }}.</div>
            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="card-footer d-flex justify-content-end">
        <a href="/luas-area-produksi" class="btn btn-outline-secondary me-2">Kembali</a>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>
@endsection




