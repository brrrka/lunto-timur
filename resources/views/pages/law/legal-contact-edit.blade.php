@extends('layout.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Kontak Hukum Desa</h1>
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

<form action="{{ route('law.contact.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-body bg-white mb-3 shadow-sm">
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Umum Hukum Desa (Opsional)</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $legalContact->body) }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <h5 class="mt-4 mb-3 font-weight-bold">Kontak Polsek</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="contact_polsek_name" class="form-label">Nama Kontak Polsek</label>
                <input type="text" class="form-control @error('contact_polsek_name') is-invalid @enderror" id="contact_polsek_name" name="contact_polsek_name" value="{{ old('contact_polsek_name', $legalContact->contact_polsek_name) }}">
                @error('contact_polsek_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="contact_polsek_phone" class="form-label">Nomor Telepon Polsek</label>
                <input type="text" class="form-control @error('contact_polsek_phone') is-invalid @enderror" id="contact_polsek_phone" name="contact_polsek_phone" value="{{ old('contact_polsek_phone', $legalContact->contact_polsek_phone) }}">
                @error('contact_polsek_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <h5 class="mt-4 mb-3 font-weight-bold">Kontak Babinsa</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="contact_babinsa_name" class="form-label">Nama Kontak Babinsa</label>
                <input type="text" class="form-control @error('contact_babinsa_name') is-invalid @enderror" id="contact_babinsa_name" name="contact_babinsa_name" value="{{ old('contact_babinsa_name', $legalContact->contact_babinsa_name) }}">
                @error('contact_babinsa_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="contact_babinsa_phone" class="form-label">Nomor Telepon Babinsa</label>
                <input type="text" class="form-control @error('contact_babinsa_phone') is-invalid @enderror" id="contact_babinsa_phone" name="contact_babinsa_phone" value="{{ old('contact_babinsa_phone', $legalContact->contact_babinsa_phone) }}">
                @error('contact_babinsa_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <a href="{{ route('health-facilities.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
        <button type="submit" class="btn btn-warning">Update</button>
    </div>
</form>
@endsection


