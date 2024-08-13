@extends('layouts.reseller')

@section('style')
@endsection

@section('content')
    <form action="{{ route('reseller.order.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="order_date" value="{{ $carts[0]->cart_updated_at }}">
        <div class="layout-px-spacing">
            <div class="middle-content container-xxl p-0">
                <div class="page-meta">
                    <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/reseller">MITRA ID</a></li>
                            <li class="breadcrumb-item"><a href="/reseller/cart">Keranjang</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Proses Pesanan</li>
                        </ol>
                    </nav>
                </div>
                <div class="row layout-top-spacing">
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-8">
                            <h3 class="mb-2"><u>Proses Pesanan</u></h3>
                            <table>
                                <tr>
                                    <td>Waktu</td>
                                    <td>:</td>
                                    <td>{{ $carts[0]->cart_updated_at }}</td>
                                </tr>
                                <tr>
                                    <td>Bayar Sebelum</td>
                                    <td>:</td>
                                    <td>{{ date('Y-m-d H:i:s', strtotime($carts[0]->cart_updated_at . ' + 1 day')) }}</td>
                                </tr>
                            </table>
                            <br>
                            <table class="table table-hover table-bordered mt-2" style="width:100%">
                                <thead class="bg-secondary text-white text-center">
                                    <tr>
                                        <th class="col-2">Produk</th>
                                        <th class="col-4">Nama</th>
                                        <th class="col-2">Kuantitas</th>
                                        <th class="col-1">Harga</th>
                                        <th class="col-1">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $data)
                                        <input type="hidden" name="product_id[]" value="{{ $data->product_id }}">
                                        <input type="hidden" name="order_supplier_id[]" value="{{ $data->user_id }}">
                                        <input type="hidden" name="order_price[]" value="{{ $data->price }}">
                                        <input type="hidden" name="order_total[]" id="order_total_{{ $data->cart_id }}" value="{{ $data->price * $data->cart_quantity }}">
                                        <tr>
                                            <td class="text-center">
                                                <img src="{{ asset('images') }}/{{ $data->image }}" class="img-fluid" style="width: 100px; height: 100px; object-fit: cover;">
                                            </td>
                                            <td>{{ $data->product_name }}</td>
                                            <td class="text-center">
                                                <div class="input-group">
                                                    @php
                                                        $isMember = false;
                                                        foreach ($members as $member) {
                                                            if ($member->member_reseller_id == Auth::user()->id && $member->member_supplier_id == $data->user_id) {
                                                                $isMember = true;
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                                    <input type="text" name="order_quantity[]" class="form-control text-center mx-2 py-1 px-1 text-dark" id="quantity_{{ $data->cart_id }}" readonly
                                                        data-price="{{ $data->price }}" data-price-member="{{ $data->price_member }}" data-is-member="{{ $isMember ? 'true' : 'false' }}"
                                                        value="{{ $data->cart_quantity }}" data-update-url="{{ route('reseller.cart.update', $data->cart_id) }}">
                                                </div>
                                            </td>
                                            @if ($isMember)
                                                <td class="text-end">{{ number_format($data->price_member, 0, ',', '.') }}</td>
                                                <td class="text-end" id="total_{{ $data->cart_id }}">{{ number_format($data->price_member * $data->cart_quantity, 0, ',', '.') }}</td>
                                            @else
                                                <td class="text-end">{{ number_format($data->price, 0, ',', '.') }}</td>
                                                <td class="text-end" id="total_{{ $data->cart_id }}">{{ number_format($data->price * $data->cart_quantity, 0, ',', '.') }}</td>
                                            @endif
                                        </tr>
                                    @endforeach

                                    <tr style="font-size: 1rem">
                                        <td colspan="4" class="text-end">Subtotal :</td>
                                        <td colspan="2" id="subtotalPrice"></td>
                                    </tr>
                                    <tr style="font-size: 1rem">
                                        <td colspan="4" class="text-end">Biaya Aplikasi :</td>
                                        <td colspan="2">1.000</td>
                                    </tr>
                                    <tr style="font-size: 1rem">
                                        <td colspan="4" class="text-end">TOTAL :</td>
                                        <td colspan="2" id="totalPrice"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center py-3">
                                <button type="button" class="btn btn-lg btn-secondary rounded-pill" style="width: 13rem" data-bs-toggle="modal" data-bs-target="#paymentModal">Bayar Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content bg-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Upload Bukti Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="paymentProof" class="form-label">Pilih File Bukti Pembayaran</label>
                            <input name="image" type="file" class="form-control" id="paymentProof" accept="image/*" required>
                        </div>
                        <p class="mt-2">Nomor Rekening: 0899987633<br>A/N: PT. MITRAID<br>Bank: BCA (Bank Central Asia)</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Unggah</button>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection

@section('script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function confirmDelete(event) {
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
                        event.target.closest('form').submit();
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
                    // Update total price after successful update
                    updateTotalPrice();
                } else {
                    console.log("Updating cart quantity to: " + newQuantity);
                    console.error("Failed to update cart quantity. Status: " + xhr.status);
                }
            };
            xhr.send(JSON.stringify({
                cart_quantity: newQuantity
            }));
        }

        function updateTotalPrice() {
            var subtotalPrice = 0;
            var rows = document.querySelectorAll('tbody tr');
            rows.forEach(function(row) {
                var inputElement = row.querySelector('td:nth-child(3) input');
                if (inputElement) {
                    var quantity = parseInt(inputElement.value);
                    var price = 0;
                    var priceMember = inputElement.getAttribute('data-price-member');
                    var isMember = inputElement.getAttribute('data-is-member') === "true";

                    if (isMember && priceMember !== "null") {
                        price = parseInt(priceMember);
                    } else {
                        price = parseInt(inputElement.getAttribute('data-price'));
                    }

                    var total = quantity * price;
                    row.querySelector('td:nth-child(5)').textContent = formatPrice(total);
                    var cartId = inputElement.id.split('_')[1];
                    document.getElementById('order_total_' + cartId).value = total;
                    subtotalPrice += total;
                }
            });
            var totalPrice = subtotalPrice + 1000;
            document.getElementById('subtotalPrice').textContent = formatPrice(subtotalPrice);
            document.getElementById('totalPrice').textContent = formatPrice(totalPrice);
        }

        function formatPrice(price) {
            return new Intl.NumberFormat('id-ID').format(price);
        }

        // Calculate total price on page load
        window.onload = updateTotalPrice;
    </script>
@endsection
