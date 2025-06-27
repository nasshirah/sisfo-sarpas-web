@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengembalian</h6>
        </div>
        <div class="card-body">
            @if (session('success'))
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
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Denda</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengembalian as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->peminjaman->user->name ?? 'N/A' }}</td>
                                <td>{{ $item->peminjaman->barang->nama_barang }}</td>
                                <td>{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : 'Belum Dikembalikan' }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>
                                    @if ($item->label_status == 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($item->label_status == 'damage')
                                        <span class="badge bg-danger">Damage</span>
                                    @elseif($item->label_status == 'menunggu')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @else
                                        <span class="badge bg-secondary">Proses</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->denda && $item->denda > 0)
                                        <span class="text-danger fw-bold">Rp {{ number_format($item->denda, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->label_status == 'menunggu')
                                        <a href="{{ route('pengembalian.approve', $item->id_pengembalian) }}"
                                            class="btn btn-success btn-sm me-1"
                                            onclick="return confirm('Yakin menyetujui pengembalian ini?')">
                                            <i class="fas fa-check"></i> Setujui
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#damageModal{{ $item->id_pengembalian }}">
                                            <i class="fas fa-exclamation-triangle"></i> Damage
                                        </button>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Damage Modals -->
    @foreach ($pengembalian as $item)
        @if ($item->label_status == 'menunggu')
            <div class="modal fade" id="damageModal{{ $item->id_pengembalian }}" tabindex="-1"
                aria-labelledby="damageModalLabel{{ $item->id_pengembalian }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="damageModalLabel{{ $item->id_pengembalian }}">
                                Tandai Sebagai Damage
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('pengembalian.damage', $item->id_pengembalian) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Barang:</label>
                                    <p class="fw-bold">{{ $item->peminjaman->barang->nama_barang }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Peminjam:</label>
                                    <p class="fw-bold">{{ $item->peminjaman->user->name ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-3">
                                    <label for="denda{{ $item->id_pengembalian }}" class="form-label">Jumlah Denda (Rp)</label>
                                    <input type="number" class="form-control" id="denda{{ $item->id_pengembalian }}"
                                        name="denda" min="0" step="1000" required placeholder="Masukkan jumlah denda">
                                </div>
                                <div class="mb-3">
                                    <label for="keterangan{{ $item->id_pengembalian }}" class="form-label">Keterangan</label>
                                    <textarea class="form-control" id="keterangan{{ $item->id_pengembalian }}"
                                              name="keterangan" rows="3" placeholder="Tulis keterangan tambahan..."></textarea>
                                </div>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Perhatian:</strong> Tindakan ini akan menandai barang sebagai rusak dan
                                    mengenakan denda kepada peminjam.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Terapkan Damage</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
