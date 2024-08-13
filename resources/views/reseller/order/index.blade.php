@extends('layouts.reseller')

@section('style')
@endsection

@section('content')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/reseller">MITRA ID</a></li>
                        <li class="breadcrumb-item"><a href="/reseller/order">Pesanan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Riwayat Pesanan</li>
                    </ol>
                </nav>
            </div>
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <h3 class="mb-3"><u>Riwayat Pesanan</u></h3>
                        <table class="table table-hover table-bordered dataTable" style="width:100%">
                            <thead class="bg-dark text-white text-center">
                                <tr>
                                    <th class="col-2">No Transaksi</th>
                                    <th class="col-2">Nama Toko</th>
                                    <th class="col-2">Tanggal Pemesanan</th>
                                    <th class="col-2">Produk</th>
                                    <th class="col-2">Status Pesanan</th>
                                    <th class="col-1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mergedOrders as $order)
                                    <tr>
                                        @if ($order['order_status'] == 'Need Payment')
                                            <td>-</td>
                                        @else
                                            <td>{{ $order['order_number'] }}</td>
                                        @endif
                                        <td>{!! nl2br(e(implode("\n", array_unique($order['supplier_name'])))) !!}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($order['order_date'])->format('d F Y') }}</td>
                                        <td>{!! nl2br(e(implode("\n", $order['products']))) !!}</td>
                                        <td class="text-center">
                                            @if ($order['order_status'] == 'Selesai')
                                                <span class="badge bg-success m-0 px-2">{{ $order['order_status'] }}</span>
                                            @elseif ($order['order_status'] == 'Proses Pengiriman')
                                                <span class="badge bg-primary m-0 px-2">{{ $order['order_status'] }}</span>
                                            @elseif ($order['order_status'] == 'Ditolak')
                                                <span class="badge bg-danger m-0 px-2">{{ $order['order_status'] }}</span>
                                            @elseif ($order['order_status'] == 'Diproses')
                                                <span class="badge bg-warning m-0 px-2">{{ $order['order_status'] }}</span>
                                            @else
                                                <span class="badge bg-grey m-0 px-2">{{ $order['order_status'] }}</span>
                                            @endif
                                        </td>
                                        @if ($order['order_status'] == 'Need Payment')
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-danger batalkan-pesanan" data-cart-id="{{ $order['order_date'] }}">Batalkan</button>
                                                <a class="btn btn-sm btn-success" href="{{ route('reseller.cart.order.show', $order['order_date']) }}">Bayar</a>
                                            </td>
                                        @else
                                            <td class="text-center"><a class="btn btn-sm btn-info"
                                                    href="{{ route('reseller.order.show', $order['order_number']) }}?supplier_id={{ $order['supplier_id'] }}">Lihat</a></td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.batalkan-pesanan').on('click', function() {
                const cart_id = $(this).data('cart-id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, batalkan pesanan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('reseller.order.cancel') }}",
                            type: "POST",
                            data: {
                                cart_id: cart_id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message,
                                    }).then((result) => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message,
                                    });
                                }
                            }
                        });
                    }
                })
            });
        });
    </script>
@endsection
