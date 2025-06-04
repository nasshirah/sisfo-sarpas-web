@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Detail Peminjaman') }}</span>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">ID Peminjaman</div>
                        <div class="col-md-8">{{ $peminjaman->id_peminjaman }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Peminjam</div>
                        <div class="col-md-8">{{ $peminjaman->user->name ?? 'N/A' }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Barang</div>
                        <div class="col-md-8">{{ $peminjaman->barang->nama_barang ?? 'N/A' }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Jumlah</div>
                        <div class="col-md-8">{{ $peminjaman->jumlah }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tanggal Pinjam</div>
                        <div class="col-md-8">{{ $peminjaman->tanggal_pinjam }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tanggal Kembali</div>
                        <div class="col-md-8">{{ $peminjaman->tanggal_kembali ?? 'Belum dikembalikan' }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status</div>
                        <div class="col-md-8">
                            @if($peminjaman->status == 'requested')
                                <span class="badge bg-warning">Menunggu Persetujuan</span>
                            @elseif($peminjaman->status == 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($peminjaman->status == 'declined')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">{{ $peminjaman->status }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Keterangan</div>
                        <div class="col-md-8">{{ $peminjaman->keterangan ?? '-' }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Waktu Dibuat</div>
                        <div class="col-md-8">{{ $peminjaman->created_at }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Terakhir Diupdate</div>
                        <div class="col-md-8">{{ $peminjaman->updated_at }}</div>
                    </div>

                    @if(auth()->user()->role == 'admin' && $peminjaman->status == 'requested')
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('peminjaman.approve', $peminjaman->id_peminjaman) }}" class="btn btn-success me-2" onclick="return confirm('Yakin menyetujui peminjaman ini?')">
                            <i class="bi bi-check"></i> Setujui
                        </a>
                        <a href="{{ route('peminjaman.decline', $peminjaman->id_peminjaman) }}" class="btn btn-danger" onclick="return confirm('Yakin menolak peminjaman ini?')">
                            <i class="bi bi-x"></i> Tolak
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection