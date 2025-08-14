@extends ('layout.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Pengurus Desa</h1>
    </div>

    {{-- Pesan Error Validasi (jika ada) --}}
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

    {{-- Form untuk menambah Pengurus Nagari --}}
    <form action="{{ route('struktur-organisasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- @method('POST') tidak perlu di sini karena method default form adalah POST --}}

        <div class="card-body bg-white mb-3 shadow-sm">
            {{-- Input untuk Nama --}}
            <div class="mb-3">
                <label for="name" class="form-label">Nama Pengurus</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- Input untuk Jabatan --}}
            <div class="mb-3">
                <label for="position" class="form-label">Jabatan</label>
                <input type="text" id="position" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}">
                @error('position')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- Input untuk Foto --}}
            <div class="mb-3">
                <label for="photo" class="form-label">Foto Pengurus</label>
                <input type="file" id="photo" name="photo" class="form-control @error('photo') is-invalid @enderror">
                <div class="form-text text-muted">Format: JPG, PNG, GIF, SVG. Max: 2MB.</div>
                @error('photo')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- Input untuk Urutan Tampilan (Order) --}}
            <div class="mb-3">
                <label for="order" class="form-label">Urutan Tampilan (Opsional)</label>
                <input type="number" id="order" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order') }}">
                <div class="form-text text-muted">Angka lebih kecil akan tampil lebih dulu.</div>
                @error('order')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>

        </div>

        <div class="card-footer d-flex justify-content-end" style="gap: 10px;">
            <a href="/struktur-organisasi" class="btn btn-outline-secondary">Kembali</a>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>
@endsection