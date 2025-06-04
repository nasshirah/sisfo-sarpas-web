@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pengembalian</h6>
        
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjaman</th>
                        <th>Barang</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengembalian as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->peminjaman->user->name ?? 'N/A' }}</td>
                        <td>{{ $item->peminjaman->barang->nama_barang }}</td>
                        <td>{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : 'Belum Dikembalikan' }}</td>
                        <td>
                            @if($item->label_status)
                                <span class="badge {{ $item->label_status == 'Tepat Waktu' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $item->label_status }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Proses</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
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