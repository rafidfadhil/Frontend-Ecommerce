@extends('layouts.reseller')

@section('style')
    <link href="{{ asset('css/cork/ecommerce-details.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
@endsection

@section('content')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/reseller">MITRA ID</a></li>
                        <li class="breadcrumb-item"><a href="/reseller">Product</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->product_name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="row layout-top-spacing">

                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
                    <div class="widget-content widget-content-area br-8">
                        <div class="row justify-content-center">
                            <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-7 col-sm-9 col-12 pe-3">
                                <div id="main-slider" class="splide">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            <li class="splide__slide">
                                                <img src="{{ asset('images') }}/{{ $product->image }}" class="card-img-top">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-xl-5 col-lg-12 col-md-12 col-12 mt-xl-0 mt-5 align-self-center">
                                <div class="product-details-content">
                                    <a class="btn btn-secondary btn-sm py-1 mb-3" href="{{ route('reseller.product.compare', ['id1' => $product->product_id, 'id2' => '0']) }}">+ Bandingkan Produk</a>
                                    <a class="dropdown-toggle btn btn-warning btn-sm py-1 mb-3" href="/chatify/{{ $product->user_id }}" target="_blank" data-bs-toggle="" aria-expanded="false">Chat</a>
                                    <h3 class="product-title mb-0">{{ $product->product_name }}</h3>
                                    <div class="review mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                        </svg>
                                        <span class="rating-score">{{ $avg_rating }}<span class="rating-count">( {{ $total_review }} )</span></span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-9 col-sm-9 col-9">
                                            <div class="pricing mb-3">
                                                @php
                                                    $isMember = false;
                                                @endphp
                                                @foreach ($members as $member)
                                                    @if ($member->member_reseller_id == Auth::user()->id && $member->member_supplier_id == $product->user_id)
                                                        <h4 class="text-success mb-0 me-2">Rp. {{ number_format($product->price_member, 0, ',', '.') }}</h4>
                                                        <p class="mb-0 line-through"><del>Rp. {{ number_format($product->product_price, 0, ',', '.') }}</del></p>
                                                        <span class="badge badge-light-danger mb-3">Potongan harga khusus member</span>
                                                        @php
                                                            $isMember = true;
                                                        @endphp
                                                    @break
                                                @endif
                                            @endforeach
                                            @if (!$isMember)
                                                <h4 class="text-success mb-0">Rp. {{ number_format($product->product_price, 0, ',', '.') }}</h4>
                                            @endif
                                        </div>
                                        <p>Harga Normal : <span class="text-primary">Rp. {{ number_format($product->product_price, 0, ',', '.') }}</span></p>
                                        <p>Harga Member : <span class="text-primary">Rp. {{ number_format($product->price_member, 0, ',', '.') }}</span></p>
                                    </div>
                                </div>

                                <hr class="mb-4">
                                <h6 class="mb-3">Supplier : <a href="{{ route('reseller.toko.index', ['supplier_name' => $product->supplier_name]) }}"
                                        class="btn btn-info p-1 px-2">{{ $product->supplier_name }}</a></h6>
                                <p>Kategori : <span class="text-primary">{{ $product->category_name }}</span></p>
                                <p>Stock : <span class="text-primary">{{ $product->stock }}</span></p>
                                <hr class="mb-5 mt-1">
                                <div class="action-button text-center">
                                    <div class="row">
                                        <div class="col-xxl-6 col-sm-6">
                                            <a href="{{ route('reseller.cart.store', ['productId' => $product->product_id]) }}"
                                                class="btn btn-primary w-100 btn-lg d-flex align-items-center justify-content-center">
                                                <i class="bi bi-cart-plus me-2"></i>
                                                <span class="btn-text-inner">Tambah Keranjang</span>
                                            </a>
                                        </div>
                                        <div class="col-xxl-4 col-sm-6">
                                            <form action="{{ route('reseller.cart.ordernow') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                                <button type="submit" class="btn btn-success w-100 btn-lg d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-bag-check me-2"></i>
                                                    Pesan Sekarang
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="widget-content widget-content-area br-8">
                    <div class="production-descriptions simple-pills">
                        <div class="pro-des-content">

                            <div class="row">
                                <div class="col-xxl-6 col-xl-8 col-lg-9 col-md-9 col-sm-12 mx-auto">
                                    <div class="product-reviews mb-5">
                                        <div class="row">
                                            <div class="col-sm-6 align-self-center">
                                                <div class="reviews">
                                                    <h1 class="mb-0">{{ $avg_rating }}</h1>
                                                    <span>({{ $review_count }} reviews)</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <div class="row review-progress mb-sm-1 mb-3">
                                                        <div class="col-sm-4">
                                                            <p>{{ $i }} Star</p>
                                                        </div>
                                                        <div class="col-sm-8 align-self-center">
                                                            <div class="progress">
                                                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $star_percentages[$i] }}%"
                                                                    aria-valuenow="{{ $star_percentages[$i] }}" aria-valuemin="0" aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="iconsAccordion" class="accordion-icons accordion">
                                <div class="card">
                                    <div class="card-header" id="headingTwo3">
                                        <section class="mb-0 mt-0">
                                            <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#iconAccordionOne" aria-expanded="false"
                                                aria-controls="iconAccordionOne">
                                                Deskripsi Produk <i class="fa-regular fa-square-caret-down fa-lg"></i>
                                            </div>
                                        </section>
                                    </div>
                                    <div id="iconAccordionOne" class="collapse" aria-labelledby="headingTwo3" data-bs-parent="#iconsAccordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 mx-auto">
                                                    <p><span class="text-dark">{{ $product->product_description }}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="iconsAccordion" class="accordion-icons accordion">
                                        <div class="card">
                                            <div class="card-header" id="headingTwo3">
                                                <section class="mb-0 mt-0">
                                                    <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#iconAccordionTwo" aria-expanded="false"
                                                        aria-controls="iconAccordionTwo">
                                                        Reviews <i class="fa-regular fa-square-caret-down fa-lg"></i>
                                                    </div>
                                                </section>
                                            </div>
                                            <div id="iconAccordionTwo" class="collapse" aria-labelledby="headingTwo3" data-bs-parent="#iconsAccordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mx-auto">
                                                            @foreach ($reviews as $review)
                                                                <div class="media mb-4">
                                                                    <div class="avatar me-sm-4 mb-sm-0 me-0 mb-3">
                                                                        <img alt="avatar" src="{{ asset('images') }}/{{ $review->avatar }}" class="rounded-circle">
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <h4 class="media-heading mb-1">{{ $review->reseller_name }}</h4>
                                                                        <div class="stars">
                                                                            @for ($i = 0; $i < $review->order_rating; $i++)
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                                    class="feather feather-star">
                                                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                                    </polygon>
                                                                                </svg>
                                                                            @endfor
                                                                        </div>
                                                                        <div class="meta-tags">{{ $review->review_date }}</div>
                                                                        <p class="media-text mt-2">{{ $review->order_review }}</p>
                                                                        @if ($review->order_rating_image)
                                                                            <div class="mt-3">
                                                                                <img src="{{ asset('images/' . $review->order_rating_image) }}" class="img-fluid rounded"
                                                                                    style="max-width: 200px; height: auto;">
                                                                            </div>
                                                                        @endif
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
@endsection
