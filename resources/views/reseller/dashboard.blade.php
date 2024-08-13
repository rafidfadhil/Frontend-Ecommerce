@extends('layouts.reseller')

@section('content')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Home</li>
                    </ol>
                </nav>
            </div>
            <form id="product-filter-form" class="mb-4">
                <div class="row layout-top-spacing">
                    <div class="col-4">
                        <input id="t-text" type="text" name="search" placeholder="Cari.." class="form-control">
                    </div>
                    <div class="col-3">
                        <select id="category-select" name="category" class="form-select form-select" aria-label="Default select example">
                            <option value="" selected>Semua Kategori</option>
                            @foreach ($product_categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <select id="sort-select" name="sort" class="form-select form-select" aria-label="Default select example">
                            <option value="" selected>Urutkan</option>
                            <option value="1">Harga rendah ke tinggi</option>
                            <option value="2">Harga tinggi ke rendah</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary" style="height: 48px ; width : 100%;">Cari</button>
                    </div>
                </div>
            </form>

            <div class="row mb-3">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="text-center">
                                            <a href="{{ route('reseller.artikel.index') }}">
                                                <img src="{{ asset('images/slide1.png') }}" class="w-100" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="text-center">
                                            <a href="{{ route('reseller.course.index') }}">
                                                <img src="{{ asset('images/slide2.png') }}" class="w-100" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($products as $data)
                    <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-4">
                        <a class="card style-6" href="{{ route('reseller.product.show', $data->product_id) }}">
                            @php
                                $isMember = false;
                            @endphp
                            @foreach ($members as $member)
                                @if ($member->member_reseller_id == Auth::user()->id && $member->member_supplier_id == $data->user_id)
                                    <span class="badge badge-primary">Member</span>
                                    @php
                                        $isMember = true;
                                    @endphp
                                @break
                            @endif
                        @endforeach
                        <img src="{{ asset('images/' . $data->image) }}" class="card-img-top" style="width: 100%; height: 200px; overflow: hidden;">
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <b>{{ $data->product_name }}</b>
                                    <p class="text-secondary">{{ $data->supplier_address }}</p>
                                </div>
                                <div class="col-12 text-end">
                                    <div class="pricing d-flex justify-content-end">
                                        @if ($isMember)
                                            <p class="text-success mb-0 me-2">{{ number_format($data->price_member, 0, ',', '.') }}</p>
                                            <p class="mb-0 line-through"><del>{{ number_format($data->product_price, 0, ',', '.') }}</del></p>
                                        @else
                                            <p class="text-success mb-0">{{ number_format($data->product_price, 0, ',', '.') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
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

</div>
@endsection
