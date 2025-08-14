@extends('layout.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Kelembagaan Tani</h1>
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


    <form action="{{ route('kelembagaan-tani.update', $kelembagaanTani->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Penting: Untuk operasi update --}}

        <div class="card-body bg-white mb-3 shadow-sm">
            <div class="mb-3">
                <label for="nama_poktan" class="form-label">Nama Kelompok Tani (Poktan) <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_poktan') is-invalid @enderror" id="nama_poktan" name="nama_poktan" value="{{ old('nama_poktan', $kelembagaanTani->nama_poktan) }}" required>
                @error('nama_poktan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="kelas_kemampuan" class="form-label">Kelas Kemampuan <span class="text-danger">*</span></label>
                <select class="form-select @error('kelas_kemampuan') is-invalid @enderror" id="kelas_kemampuan" name="kelas_kemampuan" required>
                    <option value="">Pilih Kelas Kemampuan</option>
                    <option value="Pemula" {{ old('kelas_kemampuan', $kelembagaanTani->kelas_kemampuan) == 'Pemula' ? 'selected' : '' }}>Pemula</option>
                    <option value="Lanjutan" {{ old('kelas_kemampuan', $kelembagaanTani->kelas_kemampuan) == 'Lanjutan' ? 'selected' : '' }}>Lanjutan</option>
                </select>
                @error('kelas_kemampuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="id_poktan" class="form-label">ID Poktan (Opsional)</label>
                <input type="text" class="form-control @error('id_poktan') is-invalid @enderror" id="id_poktan" name="id_poktan" value="{{ old('id_poktan', $kelembagaanTani->id_poktan) }}">
                @error('id_poktan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="jumlah_anggota" class="form-label">Jumlah Anggota <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('jumlah_anggota') is-invalid @enderror" id="jumlah_anggota" name="jumlah_anggota" value="{{ old('jumlah_anggota', $kelembagaanTani->jumlah_anggota) }}" required min="1">
                @error('jumlah_anggota')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="nama_ketua" class="form-label">Nama Ketua <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_ketua') is-invalid @enderror" id="nama_ketua" name="nama_ketua" value="{{ old('nama_ketua', $kelembagaanTani->nama_ketua) }}" required>
                @error('nama_ketua')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label">Nomor HP Ketua (Opsional)</label>
                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $kelembagaanTani->no_hp) }}">
                @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="alamat_sekretariat" class="form-label">Alamat Sekretariat (Opsional)</label>
                <textarea class="form-control @error('alamat_sekretariat') is-invalid @enderror" id="alamat_sekretariat" name="alamat_sekretariat" rows="3">{{ old('alamat_sekretariat', $kelembagaanTani->alamat_sekretariat) }}</textarea>
                @error('alamat_sekretariat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('kelembagaan-tani.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>
@endsection
