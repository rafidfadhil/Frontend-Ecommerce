
@extends('layouts.reseller')

@section('content')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="page-meta mb-4">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/reseller">MITRA ID</a></li>
                        <li class="breadcrumb-item"><a href="/reseller">Product</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Order Paket</li>
                    </ol>
                </nav>
            </div>
            <div class="row layout-top-spacing">
                <div class="container-xl px-4 mt-n10">
                    <div class="card mb-4">
                        <div class="alert alert-primary text-center" role="alert">
                            Pilihlah satu paket di bawah untuk di order. Sebagai syarat untuk mendaftar menjadi member!
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($products as $product)
                                    <div class="col-lg-4 mb-4">
                                        <div class="card border-1 shadow-sm position-relative">
                                            <div class="row g-0">
                                                <div class="col">
                                                    <div class="card-body">
                                                        <div class="text-center position-relative mb-4">
                                                            <h2 class="mt-3 mb-3">{{ $product->name }}</h2>
                                                            <div class="position-relative image-container">
                                                                <img id="imagePreview2" class="img-fluid rounded mb-2" src="{{ asset('images/' . $product->image) }}" alt="Pratinjau Gambar"
                                                                    style="max-width: 100%; max-height: 200px; object-fit: cover;">
                                                            </div>
                                                            <h4 class="text-success mb-3">Rp. {{ number_format($product->price, 0, ',', '.') }}</h4>
                                                            <p class="mb-3">{{ $product->description }}</p>
                                                        </div>
                                                        <form action="{{ route('reseller.cart.ordernow') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                                            <button type="submit" class="btn btn-primary w-100 btn-lg d-flex align-items-center justify-content-center">
                                                                <i class="bi bi-bag-check me-2"></i>
                                                                Pesan Sekarang
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
