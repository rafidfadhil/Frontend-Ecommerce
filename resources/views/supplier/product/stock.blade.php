@extends('layouts.supplier')

@section('content')
    <header class="page-header page-header-dark pb-10 overlay overlay-10" style="background-color: rgb(0, 70, 128)">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-solid fa-boxes-stacked me-3 text-white"></i></div>
                            Stok Produk
                        </h1>
                        <div class="page-header-subtitle mt-3 text-white">Periksalah stok toko Anda secara rutin untuk memastikan tidak ada produk yang kehabisan.</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-n10">
        <div class="row">
            <div class="col-xl-4 mb-4">
                <a class="card lift h-100" href="#!">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <i class="feather-xl text-success mb-3" data-feather="package"></i>
                                <h2>{{ $product_ready }} Barang Ready</h2>
                                <div class="text-muted small">Stok tersedia untuk di jual.</div>
                            </div>
                            <img src="{{ asset('images/stock1.png') }}" alt="..." style="width: 8rem" />
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 mb-4">
                <a class="card lift h-100" href="#!">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <i class="feather-xl text-warning mb-3" data-feather="package"></i>
                                <h2>{{ $product_low }} Barang Hampir Habis</h2>
                                <div class="text-muted small">Stok hampir habis, segera tambahkan persediaan.</div>
                            </div>
                            <img src="{{ asset('images/stock2.png') }}" alt="..." style="width: 8rem" />
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 mb-4">
                <a class="card lift h-100" href="#!">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <i class="feather-xl text-danger mb-3" data-feather="package"></i>
                                <h2>{{ $product_empty }} Barang Habis</h2>
                                <div class="text-muted small">Stok habis, segera tambahkan persediaan.</div>
                            </div>
                            <img src="{{ asset('images/stock3.png') }}" alt="..." style="width: 8rem" />
                        </div>
                    </div>
                </a>
            </div>
            <div class="row pe-0">
                <div class="col-12 pe-0">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center py-2">
                            <nav class="mt-1 rounded" aria-label="breadcrumb">
                                <ol class="breadcrumb px-3 py-2 rounded mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item">Produk</li>
                                    <li class="breadcrumb-item active">Stok Produk</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-sm table-striped table-light">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nama Produk</th>
                                        <th>Status Produk</th>
                                        <th>Kategori Produk</th>
                                        <th>Jumlah Stok</th>
                                        <th>Harga Normal</th>
                                        <th>Harga Member</th>
                                        <th>Tanggal Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->product_id }}</td>
                                            <td>{{ $product->product_name }}</td>
                                            @if ($product->stock > 10)
                                                <td><a class="btn btn-sm btn-outline-blue rounded-pill p-1">Tersedia</a></td>
                                            @elseif ($product->stock < 11 && $product->stock > 0)
                                                <td><a class="btn btn-sm btn-outline-warning rounded-pill p-1">Segera Habis</a></td>
                                            @else
                                            <td><a class="btn btn-sm btn-outline-danger rounded-pill p-1">Habis</a></td>
                                            @endif
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($product->price_member, 0, ',', '.') }}</td>
                                            <td>{{ $product->last_update }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
