@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Ajukan Peminjaman Barang') }}</span>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('peminjaman.store') }}">
                        @csrf

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(auth()->user()->role == 'admin')
                        <div class="mb-3">
                            <label for="id_user" class="form-label">Peminjam</label>
                            <select name="id_user" id="id_user" class="form-select @error('id_user') is-invalid @enderror" required>
                                <option value="">Pilih Peminjam</option>
                                @foreach($user as $u)
                                    <option value="{{ $u->id_user }}" {{ old('id_user') == $u->id_user ? 'selected' : '' }}>
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_user')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @else
                            <input type="hidden" name="id_user" value="{{ auth()->id() }}">
                        @endif

                        <div class="mb-3">
                            <label for="id_barang" class="form-label">Barang</label>
                            <select name="id_barang" id="id_barang" class="form-select @error('id_barang') is-invalid @enderror" required>
                                <option value="">Pilih Barang</option>
                                @foreach($barang as $b)
                                    <option value="{{ $b->id_barang }}" data-stok="{{ $b->tersedia }}" {{ old('id_barang') == $b->id_barang ? 'selected' : '' }}>
                                        {{ $b->nama_barang }} (Tersedia: {{ $b->tersedia }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" min="1" value="{{ old('jumlah', 1) }}" required>
                            <small class="text-muted" id="stok-info"></small>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control @error('tanggal_pinjam') is-invalid @enderror" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                            @error('tanggal_pinjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Permintaan peminjaman Anda akan menunggu persetujuan dari admin.
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const barangSelect = document.getElementById('id_barang');
        const jumlahInput = document.getElementById('jumlah');
        const stokInfo = document.getElementById('stok-info');
        
        function updateStokInfo() {
            const selectedOption = barangSelect.options[barangSelect.selectedIndex];
            const stokTersedia = selectedOption.getAttribute('data-stok');
            
            if (stokTersedia) {
                stokInfo.textContent = `Stok tersedia: ${stokTersedia}`;
                jumlahInput.max = stokTersedia;
                
                if (parseInt(jumlahInput.value) > parseInt(stokTersedia)) {
                    jumlahInput.value = stokTersedia;
                }
            } else {
                stokInfo.textContent = '';
            }
        }
        
        barangSelect.addEventListener('change', updateStokInfo);
        updateStokInfo();
    });
</script>
@endsection