@extends ('layout.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Pengurus Desa</h1>
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

    {{-- Pesan Sukses (jika ada, dari redirect setelah update) --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Form untuk mengedit Pengurus Nagari --}}
    <form action="{{ route('struktur-organisasi.update', $official->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- PENTING: Untuk operasi update --}}

        <div class="card-body bg-white mb-3 shadow-sm">
            {{-- Input untuk Nama --}}
            <div class="mb-3">
                <label for="name" class="form-label">Nama Pengurus</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $official->name) }}">
                @error('name')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- Input untuk Jabatan --}}
            <div class="mb-3">
                <label for="position" class="form-label">Jabatan</label>
                <input type="text" id="position" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position', $official->position) }}">
                @error('position')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- Input untuk Foto --}}
            <div class="mb-3">
                <label for="photo" class="form-label">Foto Pengurus</label>
                @if ($official->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $official->photo) }}" alt="Foto Saat Ini" class="img-thumbnail" style="max-width: 150px; height: auto; object-fit: cover;">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="remove_photo" id="remove_photo" value="1">
                            <label class="form-check-label" for="remove_photo">
                                Hapus Foto Saat Ini
                            </label>
                        </div>
                    </div>
                @endif
                <input type="file" id="photo" name="photo" class="form-control @error('photo') is-invalid @enderror">
                <div class="form-text text-muted">Unggah foto baru untuk mengganti yang lama. Format: JPG, PNG, GIF, SVG. Max: {{ ini_get('upload_max_filesize') }}.</div>
                @error('photo')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- Input untuk Urutan Tampilan (Order) --}}
            <div class="mb-3">
                <label for="order" class="form-label">Urutan Tampilan (Opsional)</label>
                <input type="number" id="order" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $official->order) }}">
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
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>
@endsection