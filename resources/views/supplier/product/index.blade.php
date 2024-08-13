@extends('layouts.supplier')

@section('content')
    <header class="page-header page-header-dark pb-10 overlay overlay-10" style="background-color: rgb(0, 70, 128)">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-solid fa-boxes-stacked me-3 text-white"></i></div>
                            DAFTAR PRODUK
                        </h1>
                        <div class="page-header-subtitle mt-3 text-white">Temukan beragam pilihan produk berkualitas tinggi dari supplier kami, serta nikmati penawaran khusus dan diskon eksklusif untuk
                            produk
                            tertentu.
                            Manfaatkan fitur pencarian kami untuk menemukan produk yang Anda cari dengan cepat, sambil mendapatkan informasi detail tentang setiap produk termasuk deskripsi, spesifikasi,
                            dan gambar.</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center py-2">
                <nav class="mt-1 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb px-3 py-2 rounded mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Produk</li>
                        <li class="breadcrumb-item active">Daftar Produk</li>
                    </ol>
                </nav>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    + Tambah Produk
                </button>
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-sm table-striped table-light">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Kategori Produk</th>
                            <th>Nama</th>
                            <th>Stok</th>
                            <th>Harga Normal</th>
                            <th>Harga Member</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <div style="width: 150px; height: 100px; overflow: hidden;">
                                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->product_name }}"
                                            style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                    </div>
                                </td>
                                <td>{{ $product->category_name }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($product->price_member, 0, ',', '.') }}</td>
                                <td>
                                    <a class="btn btn-sm btn-outline-success rounded-pill" data-bs-toggle="modal" data-bs-target="#viewModal{{ $product->product_id }}">Lihat</a>
                                    <a class="btn btn-sm btn-outline-orange rounded-pill" data-bs-toggle="modal" data-bs-target="#editModal{{ $product->product_id }}">Edit</a>
                                    <a class="btn btn-sm btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->product_id }}">Hapus</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('supplier.product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="image" class="form-label">Ganti Foto Produk</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="product_name" name="product_name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea type="text" class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="product_category_id" class="form-label">Kategori</label>
                            <select class="form-control" id="product_category_id" name="product_category_id" style="height: auto;">
                                @foreach ($categories as $kategori)
                                    <option class="form-control" value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stock" name="stock">
                            </div>
                            <div class="col">
                                <label for="price" class="form-label">Harga Normal</label>
                                <input type="number" class="form-control" id="price" name="price">
                            </div>
                            <div class="col">
                                <label for="price_member" class="form-label">Harga Member</label>
                                <input type="number" class="form-control" id="product_price_member" name="price_member">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($products as $product)

        <!-- Modal Lihat -->
        <div class="modal fade" id="viewModal{{ $product->product_id }}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Lihat Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->product_name }}" width="200" class="mb-3">
                        </div>
                        <p><strong>Nama Produk :</strong> {{ $product->product_name }}</p>
                        <p><strong>Deskripsi :</strong> {{ $product->description }}</p>
                        <p><strong>Kategori :</strong> {{ $product->name }}</p>
                        <p><strong>Stok :</strong> {{ $product->stock }}</p>
                        <p><strong>Harga Normal :</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p><strong>Harga Member :</strong> Rp {{ number_format($product->price_member, 0, ',', '.') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{ $product->product_id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('supplier.product.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Ubah Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="image" class="form-label">Ganti Foto Produk</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $product->product_name }}">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea type="text" class="form-control" id="description" name="description" rows="3">{{ $product->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="product_category_id" class="form-label">Kategori</label>
                                <select class="form-control" id="product_category_id" name="product_category_id" style="height: auto;">
                                    @foreach ($categories as $kategori)
                                        <option class="form-control" value="{{ $kategori->id }}" {{ $product->product_category_id == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col-3">
                                    <label for="stock" class="form-label">Stok</label>
                                    <input type="text" class="form-control" id="stock" name="stock" value="{{ $product->stock }}">
                                </div>
                                <div class="col">
                                    <label for="price" class="form-label">Harga Normal</label>
                                    <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}">
                                </div>
                                <div class="col">
                                    <label for="price_member" class="form-label">Harga Member</label>
                                    <input type="number" class="form-control" id="price_member" name="price_member" value="{{ $product->price_member }}">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Hapus-->
        <div class="modal fade" id="deleteModal{{ $product->product_id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus produk ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('supplier.product.destroy', $product->product_id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
