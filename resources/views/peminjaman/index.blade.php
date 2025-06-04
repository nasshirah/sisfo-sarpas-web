@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Daftar Peminjaman') }}</span>
                    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm">Buat Peminjaman</a>
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
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peminjaman as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->user->name ?? 'N/A' }}</td>
                                        <td>{{ $item->barang->nama_barang ?? 'N/A' }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ $item->tanggal_pinjam }}</td>
                                        <td>{{ $item->tanggal_kembali ?? 'Belum dikembalikan' }}</td>
                                        <td>
                                            @if($item->status == 'requested')
                                                <span class="badge bg-warning">Menunggu Persetujuan</span>
                                            @elseif($item->status == 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($item->status == 'declined')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('peminjaman.show', $item->id_peminjaman) }}" class="btn btn-info btn-sm me-1">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                
                                                @if(auth()->user()->role == 'admin')
                                                    @if($item->status == 'requested')
                                                        <a href="{{ route('peminjaman.approve', $item->id_peminjaman) }}" class="btn btn-success btn-sm me-1" onclick="return confirm('Yakin menyetujui peminjaman ini?')">
                                                            <i class="bi bi-check"></i>
                                                        </a>
                                                        <a href="{{ route('peminjaman.decline', $item->id_peminjaman) }}" class="btn btn-danger btn-sm me-1" onclick="return confirm('Yakin menolak peminjaman ini?')">
                                                            <i class="bi bi-x"></i>
                                                        </a>
                                                    @endif
                                                    
                                                    <form action="{{ route('peminjaman.destroy', $item->id_peminjaman) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data peminjaman</td>
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