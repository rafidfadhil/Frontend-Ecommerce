@extends('layouts.supplier')

@section('content')
    <header class="page-header page-header-dark pb-10 overlay overlay-10" style="background-color: rgb(66, 0, 128)">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-solid fa-file-invoice me-3 text-white"></i></div>
                            FORMULIR PRODUK
                        </h1>
                        <div class="page-header-subtitle mt-3 text-white">Dashboard ini menyajikan informasi terkini mengenai paket produk yang dapat di-update oleh supplier.</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center py-3 bg-light">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Member</li>
                    </ol>
                </nav>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    + Tambah Paket Produk
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-lg-4 mb-4">
                            <div class="card border-1 shadow-sm position-relative">
                                <div class="row g-0">
                                    <div class="col-auto bg-dark text-white d-flex align-items-center justify-content-center" style="width: 60px;">
                                        <h2 class="text-white m-0">{{ $loop->iteration }}</h2>
                                    </div>
                                    <div class="col">
                                        <div class="card-body">
                                            <div class="text-center position-relative mb-4">
                                                <div class="position-relative image-container">
                                                    <img id="imagePreview2" class="img-fluid rounded mb-2" src="{{ asset('images/' . $product->image) }}" alt="Pratinjau Gambar"
                                                        style="max-width: 100%; max-height: 200px; object-fit: cover;">
                                                </div>
                                                <h3 class="mt-3">{{ $product->name }}</h3>
                                                <h4 class="text-success">Rp. {{ number_format($product->price, 0, ',', '.') }}</h4>
                                                <p>{{ $product->description }}</p>
                                            </div>
                                            <div class="btn-group position-absolute top-0 end-0 m-2" role="group">
                                                <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $product->product_id }}">
                                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                                </a>
                                                <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->product_id }}">
                                                    <i class="bi bi-trash me-1"></i>Hapus
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('supplier.product.member.store') }}" method="POST" enctype="multipart/form-data">
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
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="price" name="price">
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
        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{ $product->product_id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('supplier.product.member.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
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
                        <form action="{{ route('supplier.product.member.destroy', $product->product_id) }}" method="POST" class="d-inline">
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
