@extends('layouts.reseller')

@section('style')
    <link href="{{ asset('css/cork/ecommerce-details.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">

            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/reseller">MITRA ID</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bandingkan Produk</li>
                    </ol>
                </nav>
            </div>

            <div class="row layout-top-spacing">

                {{-- Select Produk 1 --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between bg-secondary">
                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#productModal1">
                                Pilih Produk 1
                            </button>
                        </div>
                        <div class="card-body">
                            @if ($product_1)
                                <div class="card mb-3" id="product1-card">
                                    <img src="{{ asset('images') }}/{{ $product_1->image }}" class="card-img-top img-fluid" style="object-fit: cover; height: 300px;">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">{{ $product_1->product_name }}</h5>
                                    </div>
                                </div>
                                <div class="selected-product" id="selectedProduct1"></div>
                                <input type="hidden" id="product_1_id" value="{{ $product_1->product_id }}">
                            @else
                                <div class="selected-product" id="selectedProduct1"></div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Select Produk 2 --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between bg-secondary">
                            @if ($product_1)
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#productModal2" id="selectProduct2Btn">
                                    Pilih Produk 2
                                </button>
                            @else
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#productModal2" id="selectProduct2Btn" disabled>
                                    Pilih Produk 2
                                </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="selected-product" id="selectedProduct2"></div>
                        </div>
                    </div>
                </div>

            </div>

            <h1 class="my-4">Bandingkan Produk <span id="category-name"></span></h1>

            {{-- Table Pemanding --}}
            <style>
                .fixed-table {
                    table-layout: fixed;
                }

                .fixed-table td {
                    white-space: normal !important;
                    overflow-wrap: break-word;
                }
            </style>
            <table class="table table-bordered table-hover fixed-table" style="width:100%">
                <thead class="bg-dark text-white text-center">
                    <tr>
                        <th>Kategori</th>
                        <th>Produk 1</th>
                        <th>Produk 2</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nama Toko Suplier</td>
                        <td id="product1-supplier_name">
                            @if ($product_1)
                                {{ $product_1->supplier_name }}
                            @endif
                        </td>
                        <td id="product2-supplier_name"></td>
                    </tr>
                    <tr>
                        <td>Alamat Supplier</td>
                        <td id="product1-supplier_address">
                            @if ($product_1)
                                {{ $product_1->supplier_address }}
                            @endif
                        </td>
                        <td id="product2-supplier_address"></td>
                    </tr>
                    <tr>
                        <td>Nama Produk</td>
                        <td id="product1-name">
                            @if ($product_1)
                                {{ $product_1->product_name }}
                            @endif
                        </td>
                        <td id="product2-product_name"></td>
                    </tr>
                    <tr>
                        <td>Harga Normal</td>
                        <td id="product1-price">
                            @if ($product_1)
                                Rp. {{ number_format($product_1->product_price, 0, ',', '.') }}
                            @endif
                        </td>
                        <td id="product2-price"></td>
                    </tr>
                    <tr>
                        <td>Harga Member</td>
                        <td id="product1-price_member">
                            @if ($product_1)
                                Rp. {{ number_format($product_1->price_member, 0, ',', '.') }}
                            @endif
                        </td>
                        <td id="product2-price_member"></td>
                    </tr>
                    <tr>
                        <td>Stok</td>
                        <td id="product1-stock">
                            @if ($product_1)
                                {{ $product_1->stock }}
                            @endif
                        </td>
                        <td id="product2-stock"></td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td>
                        <td id="product1-description">
                            @if ($product_1)
                                {{ $product_1->product_description }}
                            @endif
                        </td>
                        <td id="product2-description"></td>
                    </tr>
                </tbody>
            </table>

            {{-- Modal Product 1 --}}
            <div class="modal fade" id="productModal1" tabindex="-1" aria-labelledby="productModal1Label" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content bg-light">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productModal1Label">Pilih Produk 1</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Cari produk" aria-label="Cari produk" id="products_c1_search" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">Cari</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-cols-3" id="products_c1" data-products="{{ $products }}">
                                @foreach ($products as $product)
                                    <div class="col">
                                        <div class="card">
                                            <img src="{{ asset('images') }}/{{ $product->product_image }}" class="card-img-top img-fluid" style="object-fit: cover; height: 200px;">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $product->product_name }}</h5>
                                                <p class="card-text">Kategori : {{ $product->name }}</p>
                                                <p class="card-text">Supplier : {{ $product->supplier_name }}</p>
                                                <a href="{{ route('reseller.product.compare', [$product->product_id, 0]) }}" class="btn btn-primary">Pilih</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Product 2 --}}
            <div class="modal fade" id="productModal2" tabindex="-1" aria-labelledby="productModal2Label" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content bg-light">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productModal2Label">Pilih Produk 2</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Cari produk" aria-label="Cari produk" id="products_c2_search" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">Cari</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-cols-3" id="products_c2">
                                @if ($product_1)
                                    @foreach ($product_2s as $product)
                                        <div class="col">
                                            <div class="card">
                                                <img src="{{ asset('images') }}/{{ $product->product_image }}" class="card-img-top img-fluid" style="object-fit: cover; height: 200px;">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $product->product_name }}</h5>
                                                    <p class="card-text">Kategori : {{ $product->name }}</p>
                                                    <p class="card-text">Supplier : {{ $product->supplier_name }}</p>
                                                    <button type="button" class="btn btn-primary btn-select-product" data-product="{{ $product }}" data-dismiss="modal"
                                                        data-target="#selectedProduct2">
                                                        Pilih
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    @foreach ($products as $product)
                                        <div class="col">
                                            <div class="card">
                                                <img src="{{ asset('images') }}/{{ $product->product_image }}" class="card-img-top img-fluid" style="object-fit: cover; height: 200px;">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $product->product_name }}</h5>
                                                    <p class="card-text">{{ $product->product_description }}</p>
                                                    <p class="card-text">Stok: {{ $product->product_stock }}</p>
                                                    <button type="button" class="btn btn-primary btn-select-product" data-product="{{ $product }}" data-dismiss="modal"
                                                        data-target="#selectedProduct2">
                                                        Pilih
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/cork/ecommerce-details.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#products_c1_search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#products_c1 .col').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('#products_c2_search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#products_c2 .col').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            var product_1_id = document.getElementById('product_1_id').value;
            var selectProductButtons = document.querySelectorAll('.btn-select-product');
            var selectProduct2Btn = document.getElementById('selectProduct2Btn');
            var product1Card = document.getElementById('product1-card');
            var selectedProduct1Category = null;

            function resetProduct2() {
                var product2Container = document.getElementById('selectedProduct2');
                product2Container.innerHTML = "";

                var product2Details = ["supplier_name", "supplier_address", "name", "price", "price_member", "stock", "description"];
                product2Details.forEach(function(detail) {
                    document.getElementById('product2-' + detail).innerText = "";
                });

                selectProduct2Btn.disabled = true;
            }

            function updateProduct2Modal() {
                var product2Modal = document.getElementById('productModal2');
                var product2ListGroup = product2Modal.querySelector('.list-group');
                product2ListGroup.innerHTML = "";

                @json($products).forEach(function(product) {
                    if (product.product_category_id == selectedProduct1Category) {
                        var productButton = document.createElement('button');
                        productButton.type = 'button';
                        productButton.classList.add('list-group-item', 'list-group-item-action', 'btn-select-product');
                        productButton.dataset.product = JSON.stringify(product);
                        productButton.dataset.target = "#selectedProduct2";
                        productButton.innerHTML = `
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">${product.product_name}</h5>
                                <small>Harga : Rp. ${product.product_price.toLocaleString('id-ID')}</small>
                            </div>
                            <p class="mb-1">${product.product_description}</p>
                            <small>Stok: ${product.product_stock}</small>
                        `;

                        product2ListGroup.appendChild(productButton);
                    }
                });

                addSelectProductEventListeners();
            }

            function addSelectProductEventListeners() {
                var newSelectProductButtons = document.querySelectorAll('.btn-select-product');
                newSelectProductButtons.forEach(function(button) {
                    button.addEventListener('click', function() {

                        var productData = JSON.parse(this.dataset.product);
                        var targetContainer = document.querySelector(this.dataset.target);

                        var productHTML = `
                            <div class="card mb-3">
                                <img src="{{ asset('images') }}/${productData.product_image}" class="card-img-top img-fluid" style="object-fit: cover; height: 300px;" alt="${productData.product_name}">
                                <div class="card-body">
                                    <h5 class="card-title text-center">${productData.product_name}</h5>
                                </div>
                            </div>
                        `;

                        targetContainer.innerHTML = productHTML;

                        var tableId = this.dataset.target === "#selectedProduct2" ? "product2" : "product1";
                        var details = ["supplier_name", "supplier_address", "product_name", "price", "price_member", "stock", "description"];
                        details.forEach(function(detail) {
                            document.getElementById(tableId + '-' + detail).innerText = detail === 'price' || detail === 'price_member' ?
                                "Rp. " + productData[detail].toLocaleString('id-ID') : productData[detail];
                        });

                        if (this.dataset.target === "#selectedProduct1") {
                            selectedProduct1Category = productData.product_category_id;
                            document.getElementById('category-name').innerText = productData.category_name;
                            resetProduct2();
                            selectProduct2Btn.disabled = false;
                            updateProduct2Modal();
                        }
                    });
                });
            }

            $('#productModal1').on('show.bs.modal', function(event) {
                if (product1Card) {
                    product1Card.remove();
                }
            });

            addSelectProductEventListeners();

        });
    </script>
@endsection
