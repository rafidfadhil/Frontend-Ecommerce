@extends('layouts.reseller')

@section('style')
    <style>
        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rate:not(:checked)>input {
            position: absolute;
            top: -9999px;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }
    </style>
@endsection

@section('content')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/reseller">MITRA ID</a></li>
                        <li class="breadcrumb-item"><a href="/reseller/order">Pesanan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">#{{ $orders[0]->order_number }}</li>
                    </ol>
                </nav>
            </div>

            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing ">
                    <div class="widget-content widget-content-area br-8">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="mb-4">Nomor Transaksi : <b> #{{ $orders[0]->order_number }}</b></h3>
                                <h6 class="mb-3">Tanggal Transaksi :<b> {{ \Carbon\Carbon::parse($orders[0]->order_date)->format('d F Y') }}</b></h6>
                                <h6 class="mb-3">Status Pembayaran :<b> {{ $orders[0]->order_payment }}</b></h6>
                                @if ($orders[0]->order_status == 'Proses Pengiriman' || $orders[0]->order_status == 'Selesai')
                                    <h6 class="mb-3">Nomor Resi :<b> {{ $orders[0]->order_resi }}</b></h6>
                                @endif
                                <h6 class="mb-3">Status Pesanan :<b>
                                        @if ($orders[0]->order_status == 'Selesai')
                                            <span class="btn btn-sm btn-success m-0 px-2">{{ $orders[0]->order_status }}</span>
                                        @elseif ($orders[0]->order_status == 'Proses Pengiriman')
                                            <span class="btn btn-sm btn-primary m-0 px-2">{{ $orders[0]->order_status }}</span>
                                        @elseif ($orders[0]->order_status == 'Ditolak')
                                            <span class="btn btn-sm btn-danger m-0 px-2">{{ $orders[0]->order_status }}</span>
                                        @elseif ($orders[0]->order_status == 'Diproses')
                                            <span class="btn btn-sm btn-warning m-0 px-2">{{ $orders[0]->order_status }}</span>
                                        @else
                                            <span class="btn btn-sm btn-secondary m-0 px-2">{{ $orders[0]->order_status }}</span>
                                        @endif
                                    </b></h6>
                            </div>
                            <div class="col-3 text-end me-4">
                                <i class="fa-solid fa-file-lines" style="height: 9rem; color: #558fbb;"></i>
                            </div>
                        </div>

                        <br>
                        <table class="table table-hover table-bordered" style="width:100%">
                            <thead class="text-white text-center" style="background-color: #6faddd;">
                                <tr>
                                    <th class="col-1">No</th>
                                    <th class="col-1">Photo</th>
                                    <th class="col-2">Nama Toko</th>
                                    <th class="col-2">Produk</th>
                                    <th class="col-1">Kuantitas</th>
                                    <th class="col-1">Total</th>
                                    @if ($orders[0]->order_status != 'Ditolak' && $orders[0]->order_status != 'Menunggu Konfirmasi' && $orders[0]->order_status != 'Diproses')
                                        <th class="col-2">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $data)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <img src="{{ asset('images') }}/{{ $data->image }}" class="img-fluid" style="width: 100px; height: 100px; object-fit: cover;">
                                        </td>
                                        <td>{{ $data->supplier_name }}</td>
                                        <td>{{ $data->product_name }}</td>
                                        <td class="text-center">{{ $data->order_quantity }}</td>
                                        <td class="text-end">{{ number_format($data->order_total, 0, ',', '.') }}</td>
                                        @if ($data->order_status != 'Ditolak' && $data->order_status != 'Menunggu Konfirmasi' && $data->order_status != 'Diproses')
                                            <td class="text-center">
                                                @if ($data->order_status == 'Selesai')
                                                    <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $data->order_id }}">Lihat Review</a>
                                                @elseif ($data->order_status == 'Proses Pengiriman' || $data->order_status == 'Diproses')
                                                    <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $data->order_id }}">Selesai</a>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>

                                    <div class="modal fade" id="exampleModal{{ $data->order_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content bg-white">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ulasan Produk</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h5>Rating:</h5>
                                                            <div class="star-rating" style="font-size: 1.5rem; color: #FFD700;">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $data->order_rating)
                                                                        <span class="fa-solid fa-star"></span>
                                                                    @else
                                                                        <span class="fa-regular fa-star"></span>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                            <hr>
                                                            <h5>Ulasan:</h5>
                                                            <p>{{ $data->order_review }}</p>
                                                            @if ($data->order_rating_image)
                                                                <div class="mt-3">
                                                                    <img src="{{ asset('images/' . $data->order_rating_image) }}" class="img-fluid rounded" style="max-width: 200px; height: auto;">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="modal fade" id="reviewModal{{ $data->order_id }}" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-white">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="reviewModalLabel">Berikan Review</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('reseller.order.update', $data->order_id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="product_member" value="{{ $data->product_member }}">
                                                    <input type="hidden" name="order_supplier_id" value="{{ $data->order_supplier_id }}">
                                                    <input type="hidden" name="order_reseller_id" value="{{ $data->order_reseller_id }}">
                                                    <div class="modal-body m-3">
                                                        <div class="row">
                                                            <h6 class="mb-2">Rating Produk :</h6>
                                                            <div class="rate text-center">
                                                                <input type="radio" id="star5-{{ $data->order_id }}" name="rate" value="5" />
                                                                <label for="star5-{{ $data->order_id }}" title="text">5 stars</label>
                                                                <input type="radio" id="star4-{{ $data->order_id }}" name="rate" value="4" />
                                                                <label for="star4-{{ $data->order_id }}" title="text">4 stars</label>
                                                                <input type="radio" id="star3-{{ $data->order_id }}" name="rate" value="3" />
                                                                <label for="star3-{{ $data->order_id }}" title="text">3 stars</label>
                                                                <input type="radio" id="star2-{{ $data->order_id }}" name="rate" value="2" />
                                                                <label for="star2-{{ $data->order_id }}" title="text">2 stars</label>
                                                                <input type="radio" id="star1-{{ $data->order_id }}" name="rate" value="1" />
                                                                <label for="star1-{{ $data->order_id }}" title="text">1 star</label>
                                                            </div>
                                                            <input type="hidden" name="order_rating" id="order_rating-{{ $data->order_id }}" value="">
                                                        </div>
                                                        <div class="row">
                                                            <h6 class="mb-2">Ulasan Produk :</h6>
                                                            <textarea name="order_review" rows="8" class="form-control mb-2"></textarea>
                                                        </div>
                                                        <div class="row">
                                                            <label for="image" class="form-label">Foto Produk</label>
                                                            <input type="file" class="form-control" id="image" name="image">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary" style="width: 8rem">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
        // Get all radio buttons
        var radios = document.querySelectorAll('.rate input[type=radio]');

        // Function to set order_rating value
        function setRatingValue() {
            // Get the order id from the radio button id
            var orderId = this.id.split('-')[1];

            // Find the correct order_rating input
            var orderRating = document.querySelector('#order_rating-' + orderId);

            // Update the order_rating value
            orderRating.value = this.value;
        }

        // Add event listener to each radio button
        radios.forEach(function(radio) {
            radio.addEventListener('change', setRatingValue);
        });
    </script>
@endsection
