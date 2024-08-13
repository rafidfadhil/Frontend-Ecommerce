@extends('layouts.supplier')

@section('content')
    <div class="container-xl px-4 mt-5">
        <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
            <div class="me-4 mb-3 mb-sm-0">
                <h1 class="mb-0">Dashboard Supplier</h1>
                <div class="small">
                    <span class="fw-500 text-primary">{{ date('l') }}</span>
                    &middot;
                    {{ date('F d, Y') }}
                    &middot;
                    {{ date('h:i A') }}
                </div>
            </div>
        </div>
        <!-- Illustration dashboard card example-->
        <div class="card card-waves mb-4 mt-5">
            <div class="card-body p-5">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-8">
                        <h2 class="text-primary">Selamat datang kembali, <b>{{ auth()->user()->name }}</b>!</h2>
                        <p class="text-gray-700">
                            Dapatkan pengalaman terbaik dengan MITRA.ID! Dashboard Supplier Anda telah disiapkan dengan fitur-fitur hebat. Mulai dari manajemen produk, pelacakan stok, dan pesanan
                            penjualan, hingga riwayat penjualan, ulasan dan penilaian produk, manajemen member, dan fitur chat yang mudah digunakan.
                        </p>
                        <a class="btn btn-primary p-3 mt-3" href="{{ route('supplier.index') }}">
                            Mulai Sekarang
                            <i class="ms-1" data-feather="arrow-right"></i>
                        </a>
                    </div>
                    <div class="col-lg-4 d-none d-lg-block mt-xxl-n4 text-center">
                        <img class="img-fluid px-xl-4 mt-xxl-n5" src="{{ asset('images/statistics.svg') }}" alt="Statistics Illustration" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card border-start-lg border-start-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-blue small">Menu</div>
                                <div class="text-blue text-lg fw-bold">Management Produk</div>
                            </div>
                            <i class="feather-xl text-blue" data-feather="box"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="text-primary stretched-link" href="/supplier/product">View</a>
                        <div class="text-primary"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card border-start-lg border-start-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-orange small">Menu</div>
                                <div class="text-orange text-lg fw-bold">Pesanan Penjualann</div>
                            </div>
                            <i class="feather-xl text-orange" data-feather="dollar-sign"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="text-orange stretched-link" href="/supplier/order">View</a>
                        <div class="text-orange"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card border-start-lg border-start-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-green small">Menu</div>
                                <div class="text-green text-lg fw-bold">Form Member</div>
                            </div>
                            <i class="feather-xl text-green " data-feather="check-square"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="text-green  stretched-link" href="/supplier/member">View</a>
                        <div class="text-green "><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card border-start-lg border-start-danger h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-red small">Menu</div>
                                <div class="text-red text-lg fw-bold">Daftar Member</div>
                            </div>
                            <i class="feather-xl text-red" data-feather="message-circle"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="text-red stretched-link" href="/supplier/member/list">View</a>
                        <div class="text-red"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Riwayat Pesanan (Bulanan)</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('ordersChart').getContext('2d');
            var ordersChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($months),
                    datasets: [{
                        label: 'Jumlah Pesanan',
                        data: @json($counts),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
