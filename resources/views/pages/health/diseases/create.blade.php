@extends('layout.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Data Penyakit Baru</h1>
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

<form action="{{ route('diseases.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="card-body bg-white mb-3 shadow-sm">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Penyakit <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="case_count" class="form-label">Jumlah Kasus <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('case_count') is-invalid @enderror" id="case_count" name="case_count" value="{{ old('case_count') }}" required min="0">
                @error('case_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
             </div>

            <div class="mb-3">
                <label for="year" class="form-label">Tahun (Opsional)</label>
                <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year', date('Y')) }}" placeholder="{{ date('Y') }}">
                @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('diseases.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
</form>
 
@endsection