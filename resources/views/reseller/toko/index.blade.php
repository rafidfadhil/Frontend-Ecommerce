@extends('layouts.reseller')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .star-rating {
            font-size: 1rem;
            color: #ff0;
        }

        .fa-star,
        .fa-star-half-alt,
        .fa-star-o {
            margin-right: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0 row">
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/reseller">MITRA ID</a></li>
                        <li class="breadcrumb-item"><a href="/reseller">Toko</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $supplier->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="row layout-top-spacing">

                <!-- Profil Supplier -->
                <div class="col-12 col-md-4 mb-4 pt-2">
                    <div class="card mb-3">
                        <div class="card-header bg-primary">
                            <h5 class="card-title text-white">Profil Supplier</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ asset('images') }}/{{ $supplier->avatar }}" class="rounded-circle mb-3" alt="Avatar" style="width: 100px; height: 100px; object-fit: cover;">
                            @if ($supplier->suspended == '1')
                                <br>
                                <span class="badge bg-danger mb-3">Suspended</span>
                            @endif
                            <h6 class="card-subtitle mb-2 text-muted">{{ $supplier->name }}</h6>
                            <p class="card-text">{{ $supplier->bio }}</p>
                            <p class="card-text"> {{ $supplier->address }}</p>
                            <p class="card-text"> Ratings : {{ number_format($averageRating, 2) }} </p>
                            <div class="star-rating">
                                @php
                                    $wholeStars = floor($averageRating);
                                    $halfStar = $averageRating - $wholeStars >= 0.5 ? true : false;
                                    $emptyStars = 5 - $wholeStars - ($halfStar ? 1 : 0);
                                @endphp

                                @for ($i = 0; $i < $wholeStars; $i++)
                                    <span class="fa fa-star"></span>
                                @endfor

                                @if ($halfStar)
                                    <span class="fa fa-star-half-alt"></span>
                                @endif

                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <span class="fa fa-star-o"></span>
                                @endfor
                            </div>
                        </div>

                    </div>
                    <div class="d-grid gap-2 mb-3">
                        <a href="/chatify/{{ $supplier->id }}" target="_blank" class="btn btn-warning btn-lg rounded">Chat Supplier</a>
                    </div>
                    @if ($member == '0')
                        <div class="d-grid gap-2 mb-3">
                            <a href="{{ route('reseller.toko.member', ['supplier_id' => $supplier->id]) }}" class="btn btn-secondary btn-lg rounded">Daftar Member</a>
                        </div>
                    @else
                        <div class="d-grid gap-2 mb-3">
                            <a class="btn btn-outline-secondary btn-lg rounded" disabled>Sudah terdaftar Member</a>
                        </div>
                    @endif
                </div>

                <!-- Filter and Product List -->
                @if ($supplier->suspended == '0')
                    <div class="col-12 col-md-8 mb-4 pt-2">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h5 class="card-title text-white">Filter Produk</h5>
                            </div>
                            <div class="card-body">
                                <form id="product-filter-form" class="mb-4">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-4">
                                            <input id="t-text" type="text" name="search" placeholder="Cari.." class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <select id="category-select" name="category" class="form-select">
                                                <option value="" selected>Semua Kategori</option>
                                                @foreach ($product_categories as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <select id="sort-select" name="sort" class="form-select">
                                                <option value="" selected>Urutkan</option>
                                                <option value="1">Harga rendah ke tinggi</option>
                                                <option value="2">Harga tinggi ke rendah</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <button type="submit" class="btn btn-primary w-100">Cari</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="row g-4">
                                    @foreach ($products as $data)
                                        <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-4">
                                            <a class="card style-6" href="{{ route('reseller.product.show', $data->product_id) }}">
                                                <img src="{{ asset('images') }}/{{ $data->image }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $data->product_name }}</h6>
                                                    <p class="card-text text-muted">{{ $data->category_name }}</p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        @if ($member == '1')
                                                            <p class="text-success mb-0">{{ number_format($data->price_member, 0, ',', '.') }}</p>
                                                            <p class="text-muted mb-0"><del>{{ number_format($data->product_price, 0, ',', '.') }}</del></p>
                                                        @else
                                                            <p class="text-success mb-0">{{ number_format($data->product_price, 0, ',', '.') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-12 col-md-8 pt-2">
                        <div class="card">
                            <div class="alert alert-danger mb-0 " role="alert">
                                Supplier ini telah di-suspend
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.getElementById('product-filter-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            var formData = new FormData(this); // Create FormData object from form
            var queryString = new URLSearchParams(formData).toString(); // Convert FormData to URL query string
            var currentUrl = window.location.href.split('?')[0]; // Get current URL without query string
            var newUrl = currentUrl + '?' + queryString; // Construct new URL with query string
            window.location.href = newUrl; // Redirect to new URL with filters applied
        });
    </script>
@endsection
