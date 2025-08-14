@extends('user.layout.app')

@section('title', $document->title . ' - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="mb-4">
                @if ($document->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($document->file_path))
                    @if ($document->file_type == 'pdf')
                        <div class="ratio ratio-16x9" style="height: 600px;">
                            <iframe class="embed-responsive-item" src="{{ asset('storage/' . $document->file_path) }}" allowfullscreen></iframe>
                        </div>
                        <p class="text-muted mt-2">Untuk tampilan terbaik, gunakan fitur *zoom* di *viewer* PDF atau unduh dokumen.</p>
                    @elseif (in_array($document->file_type, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']))
                        <div class="alert alert-warning" role="alert">
                            Dokumen ini tidak dapat ditampilkan langsung di browser. Silakan unduh untuk melihat isinya.
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            Tipe file ini tidak didukung untuk preview langsung. Silakan unduh dokumen.
                        </div>
                    @endif
                @else
                    <div class="alert alert-danger" role="alert">
                        File dokumen tidak ditemukan atau belum diunggah.
                    </div>
                @endif
            </div>

            <hr class="my-5">
            <a href="{{ route('user.pages.hukum.index') }}" class="btn btn-outline-secondary me-2"><i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar Dokumen</a>
            @if ($document->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($document->file_path))
                <a href="{{ route('hukum.download', $document->slug) }}" class="btn btn-success"><i class="fa-solid fa-download me-2"></i> Unduh Dokumen</a>
            @endif
        </div>
    </div>
</div>
@endsection