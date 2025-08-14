@extends('layout.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Populasi Ternak Baru</h1>
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

<form action="{{ route('populasi-ternak.store') }}" method="POST" enctype="multipart/form-data"> 
    @csrf
    <div class="card-body bg-white mb-3 shadow-sm">

            <div class="mb-3">
                <label for="nama_peternak" class="form-label">Nama Peternak <span class="text-danger">*</span></label>
                <input type="text" 
                    class="form-control @error('nama_peternak') is-invalid @enderror" 
                    id="nama_peternak" 
                    name="nama_peternak" 
                    value="{{ old('nama_peternak') }}" 
                    required>
                @error('nama_peternak')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
                
            <div class="mb-3">
                <label for="jenis_ternak" class="form-label">Jenis Ternak <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('jenis_ternak') is-invalid @enderror" id="jenis_ternak" name="jenis_ternak" value="{{ old('jenis_ternak') }}" required>
                @error('jenis_ternak')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="jumlah_ternak" class="form-label">Jumlah Ternak <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('jumlah_ternak') is-invalid @enderror" id="jumlah_ternak" name="jumlah_ternak" value="{{ old('jumlah_ternak') }}" min="0" required>
                @error('jumlah_ternak')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
    <div class="card-footer d-flex justify-content-end"> {{-- Card footer dipindahkan ke dalam form --}}
        <a href="{{ route('populasi-ternak.index') }}" class="btn btn-outline-secondary me-2">Kembali</a> {{-- PERBAIKAN: Tombol Kembali --}}
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form> 
@endsection