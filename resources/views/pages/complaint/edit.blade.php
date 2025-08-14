@extends ('layout.app')

@section('content')
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Buat Pengaduan</h1>
  </div>

  <form action="/complaint{{ $complaint->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-body bg-white mb-3">
      <div class="mb-3">
        <label for="title" class="form-label">Judul</label>
        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid
        @enderror" value="{{ old('title', $complaint->title) }}">
        @error('title')
        <span class="invalid-feedback">
        {{ $message }}
      </span>
        @enderror
      </div>

      <div class="mb-3">
        <label for="content" class="form-label">Isi Pengaduan</label>
        <textarea  id="content" name="content" rows="3" class="form-control @error('content') is-invalid
        @enderror">{{ old('content', $complaint->content) }}</textarea>
        @error('content')
        <span class="invalid-feedback">
        {{ $message }}
        </span>
        @enderror
      </div>

      <div class="mb-3">
        <label for="photo_proof" class="form-label">Bukti Foto</label>
        <input type="file"  id="photo_proof" name="photo_proof" class="form-control @error('photo_proof') is-invalid
        @enderror" value="{{ old('photo_proof') }}">
        @error('photo_proof')
        <span class="invalid-feedback">
        {{ $message }}
      </span>
        @enderror
      </div>
    </div>

    <div class="card-footer">
        <div class="d-flex justify-content-end" style="gap: 10px;">
        <a href="/complaint" class="btn btn-outline-secondary">Kembali</a>
        <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </div>
  </form>
@endsection