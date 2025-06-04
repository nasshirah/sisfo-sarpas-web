@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Kategori Barang</span>
                    <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm">Tambah Kategori</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Kategori</th>
                                    <th>Deskripsi</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kategori as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->nama_kategori }}</td>
                                        <td>{{ $item->deksripsi ?? '-' }}</td>
                                        <td>
                                            <form action="{{ route('kategori.destroy', $item->id_kategori) }}" method="POST">
                                                
                                                <a href="{{ route('kategori.edit', $item->id_kategori) }}" class="btn btn-warning btn-sm">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data kategori</td>
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