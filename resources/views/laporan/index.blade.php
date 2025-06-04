@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Manajemen Barang</h1>
        <div class="d-none d-sm-inline-block">
            <button onclick="window.print()" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.index') }}" class="form-inline">
                <div class="form-group mr-2">
                    <label for="start_date" class="mr-2">Dari Tanggal:</label>
                    <input type="date" name="start_date" id="start_date" 
                           class="form-control" value="{{ $startDate }}">
                </div>
                <div class="form-group mr-2">
                    <label for="end_date" class="mr-2">Sampai Tanggal:</label>
                    <input type="date" name="end_date" id="end_date" 
                           class="form-control" value="{{ $endDate }}">
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </form>
        </div>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Barang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $statistik['total_barang'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Barang Tersedia</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $statistik['total_barang_tersedia'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Barang Dipinjam</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $statistik['total_barang_dipinjam'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hand-holding fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Peminjaman</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $statistik['total_peminjaman'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan Barang -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Barang</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableBarang" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Total Barang</th>
                            <th>Tersedia</th>
                            <th>Dipinjam</th>
                            <th>Kondisi</th>
                            <th>Total Peminjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangReport as $barang)
                        <tr>
                            <td>{{ $barang->kode_barang }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->kategori_barang->nama_kategori ?? 'Tidak Berkategori' }}</td>
                            <td>{{ $barang->jumlah }}</td>
                            <td>{{ $barang->tersedia }}</td>
                            <td>{{ $barang->dipinjam }}</td>
                            <td>{{ $barang->kondisi }}</td>
                            <td>{{ $barang->total_dipinjam }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Laporan Peminjaman -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Peminjaman</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTablePeminjaman" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Peminjam</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjamanReport as $peminjaman)
                        <tr>
                            <td>{{ $peminjaman->user->name }}</td>
                            <td>{{ $peminjaman->barang->nama_barang }}</td>
                            <td>{{ $peminjaman->jumlah }}</td>
                            <td>{{ $peminjaman->tanggal_pinjam }}</td>
                            <td>{{ $peminjaman->tanggal_kembali }}</td>
                            <td>{{ $peminjaman->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Laporan Pengembalian -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Pengembalian</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTablePengembalian" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Peminjam</th>
                            <th>Barang</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengembalianReport as $pengembalian)
                        <tr>
                            <td>{{ $pengembalian->peminjaman->user->name }}</td>
                            <td>{{ $pengembalian->peminjaman->barang->nama_barang }}</td>
                            <td>{{ $pengembalian->peminjaman->tanggal_pinjam }}</td>
                            <td>{{ $pengembalian->tanggal_kembali }}</td>
                            <td>{{ $pengembalian->label_status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Optional: Add DataTables for better interactivity
    $(document).ready(function() {
        $('#dataTableBarang, #dataTablePeminjaman, #dataTablePengembalian').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });
    });
</script>
@endpush
@endsection