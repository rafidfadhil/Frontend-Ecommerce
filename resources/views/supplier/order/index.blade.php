@extends('layouts.supplier')

@section('content')
    <header class="page-header page-header-dark pb-10 overlay overlay-10" style="background-color: teal">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-solid fa-file-invoice  me-3 text-white"></i></div>
                            Pesanan Penjualan
                        </h1>
                        <div class="page-header-subtitle mt-3 text-white">Dashboard ini menyajikan ringkasan pesanan penjualan yang mencakup ID Pesanan, Nama Pelanggan, Alamat Pengiriman, Metode
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
                        <li class="breadcrumb-item active">Pesanan Penjualan</li>
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
                            <th>Pembayaran</th>
                            <th>Nilai</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>#{{ $order->order_number }}</td>
                                <td>{{ $order->reseller_name }}</td>
                                <td>{{ $order->address }}</td>
                                @if ($order->order_payment == 'Sukses')
                                    <td><a class="btn btn-sm btn-outline-blue rounded-pill mt-1">Sukses</a></td>
                                @else
                                    <td><a class="btn btn-sm btn-outline-orange rounded-pill mt-1">Pending</a></td>
                                @endif
                                <td>Rp. {{ number_format($order->order_total, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->isoFormat('DD MMMM YYYY') }}</td>
                                @if ($order->order_status == 'Diproses')
                                    <td><span class="badge bg-success rounded-pill mt-1">Diproses</span></td>
                                @elseif ($order->order_status == 'Proses Pengiriman')
                                    <td><span class="badge bg-warning rounded-pill mt-1">Proses Pengiriman</span></td>
                                @elseif ($order->order_status == 'Ditolak')
                                    <td><span class="badge bg-danger rounded-pill mt-1">Ditolak</span></td>
                                @elseif ($order->order_status == 'Selesai')
                                    <td><span class="badge bg-primary rounded-pill mt-1">Selesai</span></td>
                                @else
                                    <td> <span class="badge bg-grey rounded-pill mt-1">Menunggu Konfirmasi</span> </td>
                                @endif
                                @if ($order->order_payment == 'Sukses')
                                    <td><a class="btn btn-primary p-2" data-bs-toggle="modal" data-bs-target="#updateModal{{ $order->order_id }}">Update</a></td>
                                @else
                                    <td> - </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Update -->
    @foreach ($orders as $order)
        <div class="modal fade" id="updateModal{{ $order->order_id }}" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form action="{{ route('supplier.order.update', $order->order_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="order_reseller_id" value="{{ $order->order_reseller_id }}">
                        <input type="hidden" name="order_number" value="{{ $order->order_number }}">
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
                                <div class="col-4">
                                    @if ($order->order_payment != 'Pending')
                                        <div class="dropdown">
                                            <label class="form-label h5" for="order_status_{{ $order->order_id }}">Status</label>
                                            @if ($order->order_status != 'Selesai')
                                                <select class="form-select" name="order_status" id="order_status_{{ $order->order_id }}" onchange="toggleResi({{ $order->order_id }})">
                                                    <option value="Diproses" {{ $order->order_status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                                    <option value="Proses Pengiriman" {{ $order->order_status == 'Proses Pengiriman' ? 'selected' : '' }}>Proses Pengiriman</option>
                                                    <option value="Ditolak" {{ $order->order_status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                </select>
                                            @endif
                                        </div>
                                    @endif
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
                                <div class="form-floating">
                                    <textarea class="form-control {{ $order->order_status == 'Proses Pengiriman' ? '' : 'd-none' }}" id="order_resi_{{ $order->order_id }}" name="order_resi" style="height: 80px">{{ $order->order_resi }}</textarea>
                                    <label for="order_resi_{{ $order->order_id }}">Nomor Resi</label>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function toggleResi(orderId) {
            var status = document.getElementById('order_status_' + orderId).value;
            var resiField = document.getElementById('order_resi_' + orderId);
            if (status === 'Proses Pengiriman') {
                resiField.classList.remove('d-none');
            } else {
                resiField.classList.add('d-none');
            }
        }
    </script>
@endsection
