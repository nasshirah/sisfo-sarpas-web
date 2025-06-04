@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Permintaan Peminjaman Menunggu Persetujuan') }}</span>
                    @if(isset($requests) && $requests->count() > 0)
                        <span class="badge bg-danger">{{ $requests->count() }} permintaan baru</span>
                    @endif
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Peminjam</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Keterangan</th>
                                    <th>Waktu Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($requests as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->user->name ?? 'N/A' }}</td>
                                        <td>{{ $item->barang->nama_barang ?? 'N/A' }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ $item->tanggal_pinjam }}</td>
                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                        <td>{{ $item->created_at->diffForHumans() }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('request.approve', $item->id_peminjaman) }}" class="btn btn-success btn-sm me-1" onclick="return confirm('Yakin menyetujui peminjaman ini?')">
                                                    <i class="bi bi-check"></i> Setujui
                                                </a>
                                                <a href="{{ route('request.decline', $item->id_peminjaman) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menolak peminjaman ini?')">
                                                    <i class="bi bi-x"></i> Tolak
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada permintaan peminjaman yang menunggu persetujuan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection