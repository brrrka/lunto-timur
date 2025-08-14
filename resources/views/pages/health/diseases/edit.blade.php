@extends('layout.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Data Penyakit</h1>
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

<form action="{{ route('diseases.update', $disease->id) }}" method="POST">       
    @csrf
    @method('PUT')
    <div class="card-body bg-white mb-3 shadow-sm">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Penyakit <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $disease->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="case_count" class="form-label">Jumlah Kasus <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('case_count') is-invalid @enderror" id="case_count" name="case_count" value="{{ old('case_count', $disease->case_count) }}" required min="0">
            @error('case_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Tahun (Opsional)</label>
            <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year', $disease->year ?? date('Y')) }}" placeholder="{{ date('Y') }}">
            @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <a href="{{ route('diseases.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
        <button type="submit" class="btn btn-warning">Update</button>
    </div>
</form>
@endsection