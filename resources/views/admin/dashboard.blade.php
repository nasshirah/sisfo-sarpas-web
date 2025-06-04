@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Generate Laporan
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Total Barang Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Barang</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBarang }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Kategori Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Kategori</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKategori }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tags fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Peminjaman Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Peminjaman</div>
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $totalPeminjaman }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Pengembalian Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Pengembalian</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPengembalian }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-undo fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Status Peminjaman Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Status Peminjaman</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Opsi Tampilan:</div>
                        <a class="dropdown-item" href="#">Minggu Ini</a>
                        <a class="dropdown-item" href="#">Bulan Ini</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Semua Waktu</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="statusPeminjamanChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> Dipinjam
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Dikembalikan
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-danger"></i> Terlambat
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart - Kategori -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Kategori</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Opsi Tampilan:</div>
                        <a class="dropdown-item" href="#">Top 5</a>
                        <a class="dropdown-item" href="#">Semua Kategori</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="kategoriChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    @foreach($kategoriStats as $index => $kategori)
                    <span class="mr-2">
                        <i class="fas fa-circle text-{{ ['primary', 'success', 'info', 'warning', 'danger'][$index % 5] }}"></i> {{ $kategori->nama }}
                    </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Barang Populer -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Barang Paling Sering Dipinjam</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Jumlah Peminjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangPopuler as $barang)
                            <tr>
                                <td>{{ $barang->nama }}</td>
                                <td>{{ $barang->kategori->nama ?? 'Tidak ada kategori' }}</td>
                                <td>{{ $barang->peminjaman_count }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Peminjaman Terbaru -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Peminjaman Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Barang</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamanTerbaru as $peminjaman)
                            <tr>
                                <td>{{ $peminjaman->user->name ?? 'Unknown' }}</td>
                                <td>{{ $peminjaman->barang->nama ?? 'Unknown' }}</td>
                                <td>{{ $peminjaman->created_at->format('d M Y') }}</td>
                                <td>
                                    @if($peminjaman->status == 'dipinjam')
                                        <span class="badge badge-primary">Dipinjam</span>
                                    @elseif($peminjaman->status == 'dikembalikan')
                                        <span class="badge badge-success">Dikembalikan</span>
                                    @elseif($peminjaman->status == 'terlambat')
                                        <span class="badge badge-danger">Terlambat</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $peminjaman->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Total User Card -->
<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Total Pengguna</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUser }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Di bagian bawah layout, sebelum </body> -->
<script src="{{ asset('js/chart.min.js') }}"></script> <!-- Pastikan Chart.js sudah dimuat -->
<script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
@endsection