@extends('layout.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Fasilitas Kesehatan</h1>
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

<form action="{{ route('health-facilities.update', $healthFacility->slug) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-body bg-white mb-3 shadow-sm">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Fasilitas <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $healthFacility->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Foto Fasilitas (Opsional)</label>
            @if ($healthFacility->photo)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $healthFacility->photo) }}" alt="Foto Fasilitas Saat Ini" class="img-thumbnail" style="max-width: 150px; height: auto;">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="remove_photo" id="remove_photo" value="1">
                    <label class="form-check-label" for="remove_photo">
                        Hapus Foto Saat Ini
                    </label>
                </div>
            </div>
        </div>
        @endif

        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
        <div class="form-text text-muted">Format: JPG, PNG, GIF, SVG. Max: {{ ini_get('upload_max_filesize') }}.</div>
            @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address', $healthFacility->address) }}</textarea>
            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Nomor Telepon (Opsional)</label>
            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $healthFacility->phone_number) }}">
            @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <a href="{{ route('health-facilities.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
        <button type="submit" class="btn btn-warning">Update</button>
    </div>
</form>
@endsection