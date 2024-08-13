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
                        <li class="breadcrumb-item active" aria-current="page">Keranjang Saya</li>
                    </ol>
                </nav>
            </div>
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <h3 class="mb-2"><u>Keranjang Saya</u></h3>
                        <br>
                        <form id="orderForm" action="{{ route('reseller.cart.order') }}" method="POST">
                            @csrf
                            <table class="table table-hover table-bordered mt-2 dataTable" style="width:100%">
                                <thead class="bg-dark text-white text-center">
                                    <tr>
                                        <th class="col-1">Pilih</th>
                                        <th class="col-2">Produk</th>
                                        <th class="col-4">Nama</th>
                                        <th class="col-2">Kuantitas</th>
                                        <th class="col-1">Harga</th>
                                        <th class="col-1">Total</th>
                                        <th class="col-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $data)
                                        <tr>
                                            <td class="text-center">
                                                <div class="form-check form-check-info form-check-inline">
                                                    <input type="checkbox" class="form-check-input" name="product_ids[]" value="{{ $data->product_id }}">
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <img src="{{ asset('images') }}/{{ $data->image }}" class="img-fluid" style="width: 100px; height: 100px; object-fit: cover;">
                                            </td>
                                            <td>{{ $data->product_name }}</td>
                                            <td class="text-center">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-outline-secondary px-3" type="button" onclick="decreaseQuantity('{{ $data->cart_id }}')">-</button>
                                                    </div>
                                                    @php
                                                        $isMember = false;
                                                        foreach ($members as $member) {
                                                            if ($member->member_reseller_id == Auth::user()->id && $member->member_supplier_id == $data->user_id) {
                                                                $isMember = true;
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                                    <input type="text" class="form-control text-center mx-2 py-1 px-1" id="quantity_{{ $data->cart_id }}" data-price="{{ $data->price }}"
                                                        data-price-member="{{ $data->price_member }}" data-is-member="{{ $isMember ? 'true' : 'false' }}" value="{{ $data->cart_quantity }}"
                                                        data-update-url="{{ route('reseller.cart.update', $data->cart_id) }}" readonly style="color: black">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-primary px-3" type="button" onclick="increaseQuantity('{{ $data->cart_id }}')">+</button>
                                                    </div>
                                                </div>
                                            </td>
                                            @if ($isMember)
                                                <td class="text-end">{{ number_format($data->price_member, 0, ',', '.') }}</td>
                                                <td class="text-end" id="total_{{ $data->cart_id }}">{{ number_format($data->price_member * $data->cart_quantity, 0, ',', '.') }}</td>
                                            @else
                                                <td class="text-end">{{ number_format($data->price, 0, ',', '.') }}</td>
                                                <td class="text-end" id="total_{{ $data->cart_id }}">{{ number_format($data->price * $data->cart_quantity, 0, ',', '.') }}</td>
                                            @endif
                                            <td class="text-center">
                                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(event, '#deleteForm_{{ $data->cart_id }}')"><i
                                                        class="fa-solid fa-trash text-white my-2"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach



                                    <!-- <tr style="font-size: 2rem">
                                                <td colspan="4" class="text-end">Total:</td>
                                                <td colspan="3" id="totalPrice"></td>
                                            </tr> -->
                                </tbody>
                            </table>
                            <div class="row justify-content-end">
                                <div class="col text-end">
                                    <h2 class="mt-3">Total:</h2>
                                </div>
                                <div class="col-auto">
                                    <h2 class="mt-3" id="totalPrice"></h2>
                                </div>
                            </div>
                            <div class="text-center py-3">
                                <button type="submit" class="btn btn-lg btn-outline-primary rounded-pill" style="width: 13rem">Buat Pesanan</button>
                            </div>
                        </form>
                        @foreach ($carts as $data)
                            <form action="{{ route('reseller.cart.destroy', $data->cart_id) }}" method="post" id="deleteForm_{{ $data->cart_id }}">
                                @csrf
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        document.querySelector('button[type="submit"]').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Produk yang di pilih akan di proses ke pembayaran.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, buat pesanan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form
                    e.target.closest('form').submit();
                }
            })
        });
    </script>
    <script>
        function confirmDelete(event, formId) {
            event.preventDefault();
            swal({
                    title: "Apa kamu yakin ?",
                    text: "Setelah dihapus, Anda tidak akan dapat memulihkan keranjang ini !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        // event.target.closest('form').submit();
                        document.querySelector(formId).submit();
                    }
                });
        }

        function increaseQuantity(cartId) {
            var quantityElement = document.getElementById('quantity_' + cartId);
            var currentQuantity = parseInt(quantityElement.value);
            quantityElement.value = currentQuantity + 1;
            updateCartQuantity(cartId, quantityElement.value);
        }

        function decreaseQuantity(cartId) {
            var quantityElement = document.getElementById('quantity_' + cartId);
            var currentQuantity = parseInt(quantityElement.value);
            if (currentQuantity > 1) {
                quantityElement.value = currentQuantity - 1;
                updateCartQuantity(cartId, quantityElement.value);
            }
        }

        function updateCartQuantity(cartId, newQuantity) {
            var xhr = new XMLHttpRequest();
            var quantityElement = document.getElementById('quantity_' + cartId);
            var updateUrl = quantityElement.getAttribute('data-update-url');
            xhr.open("PUT", updateUrl, true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhr.onload = function() {
                if (xhr.status === 200) {
                    updateTotalPrice();
                } else {
                    console.error("Failed to update cart quantity. Status: " + xhr.status);
                }
            };
            xhr.send(JSON.stringify({
                cart_quantity: newQuantity
            }));
        }

        function updateTotalPrice() {
            var totalPrice = 0;
            var rows = document.querySelectorAll('tbody tr');
            rows.forEach(function(row) {
                var inputElement = row.querySelector('td:nth-child(4) input');
                if (inputElement) {
                    var quantity = parseInt(inputElement.value);
                    var price = 0;
                    var isMember = inputElement.getAttribute('data-is-member') === "true";
                    var priceMember = inputElement.getAttribute('data-price-member');

                    if (isMember && priceMember !== "null") {
                        price = parseInt(priceMember);
                    } else {
                        price = parseInt(inputElement.getAttribute('data-price'));
                    }

                    var total = quantity * price;
                    row.querySelector('td:nth-child(6)').textContent = formatPrice(total);
                    totalPrice += total;
                }
            });
            document.getElementById('totalPrice').textContent = formatPrice(totalPrice);
        }

        function formatPrice(price) {
            return new Intl.NumberFormat('id-ID').format(price);
        }

        // Calculate total price on page load
        window.onload = updateTotalPrice;
    </script>
@endsection
