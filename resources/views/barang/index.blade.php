@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Barang</h1>
    <a href="{{ route('barang.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Barang
    </a>
</div>

<!-- Alert Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Data Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Barang</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Tersedia</th>
                        <th>Dipinjam</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barang as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->kode_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->kategori_barang->nama_kategori ?? 'Tidak ada kategori' }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ $item->tersedia }}</td>
                        <td>{{ $item->dipinjam }}</td>
                        <td>
                            @if($item->kondisi == 'baik')
                                <span class="badge bg-success text-white">Baik</span>
                            @elseif($item->kondisi == 'rusak_ringan')
                                <span class="badge bg-warning text-dark">Rusak Ringan</span>
                            @elseif($item->kondisi == 'rusak_berat')
                                <span class="badge bg-danger text-white">Rusak Berat</span>
                            @else
                                <span class="badge bg-secondary text-white">{{ $item->kondisi }}</span>
                            @endif
                        </td>
                        <td>{{ $item->lokasi }}</td>
                        <td>
                            @if($item->status == 'aktif')
                                <span class="badge bg-success text-white">Aktif</span>
                            @elseif($item->status == 'nonaktif')
                                <span class="badge bg-danger text-white">Non-Aktif</span>
                            @else
                                <span class="badge bg-secondary text-white">{{ $item->status }}</span>
                            @endif
                        </td>

                        <td>
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" width="100" alt="Gambar Barang">
                        @else
                            <span>Tidak ada gambar</span>
                        @endif

                        </td>
                       
                        <td>
                            <div class="btn-group" role="group">
                                
                    
                                <a href="{{ route('barang.edit', $item->id_barang) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('barang.destroy', $item->id_barang) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush

@push('styles')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
@endpush