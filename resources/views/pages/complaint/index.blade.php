@extends('layout.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaduan</h1>
        @if (isset(auth()->user()->resident)) {{-- Pastikan relasi 'resident' di model User ada --}}
        <a href="{{ route('complaint.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                        class="fas fa-plus fa-sm text-white-50"></i> Buat Aduan</a>
        @endif
    </div>
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    {{-- === PERBAIKAN DI SINI === --}}
                    {{-- Pindahkan table-responsive ke div di luar table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover w-100"> {{-- Tambahkan w-100 di sini --}}
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Isi Pengaduan</th>
                                    <th>Status</th>
                                    <th>Foto Bukti</th>
                                    <th>Tanggal Laporan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($complaints as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + ($complaints->currentPage() - 1) * $complaints->perPage() }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{!! wordwrap($item->content, 50,"<br>\n") !!}</td>
                                        <td>{{ $item->status_label }}</td> {{-- Pastikan status_label ada di model atau accessor --}}
                                        <td>
                                            @if (isset($item->photo_proof))
                                                @php
                                                    $filePath = 'storage/' . $item->photo_proof;
                                                @endphp
                                                <a href="{{ asset($filePath) }}" target="_blank" rel="noopener noreferrer"> {{-- Gunakan asset() untuk path --}}
                                                    <img src="{{ asset($filePath) }}" alt="Foto Bukti" class="img-thumbnail" style="max-width: 100px; max-height: 100px; object-fit: cover;"> {{-- Tambah img-thumbnail dan gaya --}}
                                                </a>
                                            @else
                                                Tidak Ada
                                            @endif
                                        </td>
                                        <td>{{ $item->report_date_label }}</td> {{-- Pastikan report_date_label ada --}}

                                        <td>
                                            @if (Auth::user()->role_id == 1) {{-- Admin --}}
                                                {{-- Hanya admin yang bisa ubah status --}}
                                                <form action="{{ route('complaint.updateStatus', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                        <option value="new" {{ $item->status == 'new' ? 'selected' : '' }}>Baru</option>
                                                        <option value="processing" {{ $item->status == 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                                                        <option value="completed" {{ $item->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                    </select>
                                                </form>
                                            @else
                                                <div class="d-flex">
                                                    {{-- Tombol Edit (jika ada) --}}
                                                    <a href="{{ route('complaint.edit', $item->id) }}" class="btn btn-warning btn-sm me-2">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    {{-- Tombol Hapus --}}
                                                    <button type="button" class="btn btn-sm btn-danger me-2" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"> {{-- Ubah colspan menjadi 7 (jumlah kolom) --}}
                                            <p class="pt-3 text-center">Tidak ada data pengaduan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div> {{-- Akhir div table-responsive --}}
                </div>
                {{-- Pagination Navigation --}}
                <div class="card-footer">
                    {{ $complaints->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection