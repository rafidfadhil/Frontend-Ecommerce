@extends('layouts.supplier')

@section('content')
    <header class="page-header page-header-dark pb-10 overlay overlay-10" style="background-color: teal">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-solid fa-clock-rotate-left me-3 text-white"></i></div>
                            Riwayat Penjualan
                        </h1>
                        <div class="page-header-subtitle mt-3 text-white">Dashboard ini menyajikan ringkasan riwayat penjualan yang mencakup ID Pesanan, Nama Pelanggan, Alamat Pengiriman, Metode
                            Pembayaran, Nilai Pesanan, Tanggal Pesanan, Status Pesanan, dan opsi tindakan. Dengan informasi yang disajikan dengan jelas, pengguna dapat dengan mudah melacak dan mengelola
                            pesanan pelanggan mereka dengan efisiensi.</div>
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
                        <li class="breadcrumb-item">Penjualan</li>
                        <li class="breadcrumb-item active">Riwayat Penjualan</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-sm table-striped table-light text-center">
                    <thead>
                        <tr>
                            <th>ID Order</th>
                            <th>Nama Customer</th>
                            <th>Alamat</th>
                            <th>Nilai</th>
                            <th>Tanggal</th>
                            <th>Status Dana Masuk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>#{{ $order->order_number }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->address }}</td>
                                <td>{{ number_format($order->order_total, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->isoFormat('DD MMMM YYYY') }}</td>
                                @if ($order->supplier_payment_status == 'pending')
                                    <td><a class="text-danger p-2" href="#">Pending</a></td>
                                @else
                                    <td><a class="btn btn-sm btn-success p-2" href="#" data-bs-toggle="modal" data-bs-target="#bukti{{ $order->order_id }}">Selesai</a></td>
                                @endif
                                <td><a class="btn btn-sm btn-primary p-2" data-bs-toggle="modal" data-bs-target="#rincianModal{{ $order->order_id }}">Rincian</a></td>
                            </tr>

                            <!-- Modal Bukti Transfer -->
                            <div class="modal fade" id="bukti{{ $order->order_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Bukti Transfer</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ asset('storage/' . $order->admin_transfer_proof) }}" class="img-preview img-fluid mb-2 w-5/12 block">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Rincian -->
    @foreach ($orders as $order)
        <div class="modal fade" id="rincianModal{{ $order->order_id }}" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(59, 53, 139)">
                        <h5 class="modal-title text-white" id="editModalLabel">Rincian Pesanan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body mx-4">
                        <div class="row d-flex justify-content-between mb-4">
                            <div class="col-3">
                                <h5 class="mb-3">Order ID: #{{ $order->order_number }}</h5>
                                <p>{{ \Carbon\Carbon::parse($order->order_date)->isoFormat('DD MMMM YYYY') }}</p>
                            </div>
                            <div class="col-5">
                                <h5 class="mb-3">Customer Information</h5>
                                <p class="mb-1">Name : {{ $order->name }}</p>
                                <p class="mb-1">Alamat : {{ $order->address }}</p>
                                <p class="mb-1">Total Pesanan : {{ number_format($order->order_total, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="col-12">
                                <table class="table table-sm table-bordered border-dark text-center">
                                    <thead class="bg-dark text-light">
                                        <tr>
                                            <th>Gambar Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Kuantitas</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div style="width: 100%; height: 100px; overflow: hidden;">
                                                    <img src="{{ asset('images/' . $order->image) }}" alt="{{ $order->product_name }}"
                                                        style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                                </div>
                                            </td>
                                            <td>{{ $order->product_name }}</td>
                                            <td>{{ $order->order_quantity }}</td>
                                            <td>{{ number_format($order->order_price, 0, ',', '.') }}</td>
                                            <td>{{ number_format($order->order_quantity * $order->order_price, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            
                            <div class="col-6"> Rating :
                                @if ($order->order_rating == 1)
                                    <span class="fa-solid fa-star" style="color: #FFD43B;"></span>
                                    <span class="fa-regular fa-star"></span>
                                    <span class="fa-regular fa-star"></span>
                                    <span class="fa-regular fa-star"></span>
                                    <span class="fa-regular fa-star"></span>
                                @elseif ($order->order_rating == 2)
                                    <span class="fa-solid fa-star" style="color: #FFD43B;"></span>
                                    <span class="fa-solid fa-star" style="color: #FFD43B;"></span>
                                    <span class="fa-regular fa-star"></span>
                                    <span class="fa-regular fa-star"></span>
                                    <span class="fa-regular fa-star"></span>
                                @elseif ($order->order_rating == 3)
                                    <span class="fa-solid fa-star" style="color: #FFD43B;"></span>
                                    <span class="fa-solid fa-star" style="color: #FFD43B;"></span>
                                    <span class="fa-solid fa-star" style="color: #FFD43B;"></span>
                                    <span class="fa-regular fa-star"></span>
                                    <span class="fa-regular fa-star"></span>
                                @elseif ($order->order_rating == 4)
                                    <span class="fa-solid fa-star" style="color: #FFD43B;"></span>
                                    <span class="fa-solid fa-star" style="color: #FFD43B;"></span>
                                    <span class="fa-solid fa-star" style="color: #FFD43B;"></span>
                                    <span class="fa-solid fa-star" style="color: #FFD43B;"></span>
                                    <span class="fa-regular fa-star"></span>
                                @elseif ($order->order_rating == 5)
                                    <span class="fa-solid fa-star" style="color: #FFD43B;"></span>
                                    <span class="fa-solid fa-star" style="color: #FFD43B;"></span>
                                    <span class="fa-solid fa-star" style="color: #FFD43B;"></span>
                                    <span class="fa-solid fa-star" style="color: #FFD43B;"></span>
                                    <span class="fa-solid fa-star" style="color: #FFD43B;"></span>
                                @endif
                                <div class="form-floating">
                                    <textarea class="form-control" id="order_review" name="order_review" style="height: 100px" disabled>{{ $order->order_review }}</textarea>
                                    <label for="order_review">Ulasan</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
