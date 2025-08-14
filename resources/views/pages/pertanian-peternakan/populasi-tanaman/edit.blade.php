@extends('layout.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Populasi Tanaman</h1>
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

    <form action="{{ route('populasi-tanaman.update', $populasiTanaman->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="card-body bg-white mb-3 shadow-sm">
            <div class="mb-3">
                <label for="nama_komoditi" class="form-label">Nama Komoditi <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_komoditi') is-invalid @enderror" id="nama_komoditi" name="nama_komoditi" value="{{ old('nama_komoditi', $populasiTanaman->nama_komoditi) }}" required>
                @error('nama_komoditi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="tipe_tanaman" class="form-label">Tipe Tanaman <span class="text-danger">*</span></label>
                <select class="form-select @error('tipe_tanaman') is-invalid @enderror" id="tipe_tanaman" name="tipe_tanaman" required>
                    <option value="">Pilih Tipe Tanaman</option>
                    <option value="Buah-buahan" {{ old('tipe_tanaman', $populasiTanaman->tipe_tanaman) == 'Buah-buahan' ? 'selected' : '' }}>Buah-buahan</option>
                    <option value="Perkebunan" {{ old('tipe_tanaman', $populasiTanaman->tipe_tanaman) == 'Perkebunan' ? 'selected' : '' }}>Perkebunan</option>
                </select>
                @error('tipe_tanaman')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Input Jumlah Panen --}}
            <div class="mb-3">
                <label for="jumlah_panen" class="form-label">Jumlah KK<span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('jumlah_panen') is-invalid @enderror" id="jumlah_panen" name="jumlah_panen" value="{{ old('jumlah_panen', $populasiTanaman->jumlah_panen) }}" min="0" required>
                @error('jumlah_panen')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun (Opsional)</label>
                <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', $populasiTanaman->tahun ?? date('Y')) }}" placeholder="{{ date('Y') }}">
                @error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Gambar (Opsional)</label>
                @if ($populasiTanaman->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $populasiTanaman->image) }}" alt="Gambar Saat Ini" class="img-thumbnail" style="max-width: 150px; height: auto;">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                            <label class="form-check-label" for="remove_image">
                                Hapus Gambar Saat Ini
                            </label>
                        </div>
                    </div>
                @endif
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                <div class="form-text text-muted">Format: JPG, PNG, GIF, SVG. Max: {{ ini_get('upload_max_filesize') }}.</div>
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('populasi-tanaman.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>
@endsection
