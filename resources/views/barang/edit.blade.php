@extends('layouts.admin')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Barang</h1>
    <a href="{{ route('barang.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Barang</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('barang.update', $barang->id_barang) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kode_barang">Kode Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kode_barang') is-invalid @enderror" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" readonly>
                        @error('kode_barang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted">Kode barang tidak dapat diubah</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                        @error('nama_barang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_kategori">Kategori <span class="text-danger">*</span></label>
                        <select class="form-control @error('id_kategori') is-invalid @enderror" id="id_kategori" name="id_kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ old('id_kategori', $barang->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', $barang->jumlah) }}" required min="0">
                        @error('jumlah')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tersedia">Tersedia</label>
                        <input type="number" class="form-control" id="tersedia" name="tersedia" value="{{ old('tersedia', $barang->tersedia) }}" readonly>
                        <small class="text-muted">Diperbarui secara otomatis</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="dipinjam">Dipinjam</label>
                        <input type="number" class="form-control" id="dipinjam" name="dipinjam" value="{{ old('dipinjam', $barang->dipinjam) }}" readonly>
                        <small class="text-muted">Diperbarui secara otomatis</small>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kondisi">Kondisi</label>
                        <select class="form-control" id="kondisi" name="kondisi">
                            <option value="baik" {{ old('kondisi', $barang->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak_ringan" {{ old('kondisi', $barang->kondisi) == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak_berat" {{ old('kondisi', $barang->kondisi) == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ old('lokasi', $barang->lokasi) }}">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                        <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak tersedia" {{ old('status') == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $barang->keterangan) }}</textarea>
            </div>

            <div class="form-group">
        <label for="gambar">Gambar Barang</label>
        <input type="file" name="gambar" class="form-control">
    </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Validasi jumlah barang
    $(document).ready(function() {
        $('#jumlah').change(function() {
            var dipinjam = parseInt($('#dipinjam').val()) || 0;
            var jumlah = parseInt($(this).val()) || 0;
            
            if (jumlah < dipinjam) {
                alert('Jumlah barang tidak boleh kurang dari jumlah yang sedang dipinjam!');
                $(this).val(dipinjam);
            }
            
            $('#tersedia').val(jumlah - dipinjam);
        });
    });
</script>
@endpush