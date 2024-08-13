<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Supplier - MITRA.ID</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/sbadmin/css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>

    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        #datatablesSimple thead th {
            text-align: center !important;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 12px;
        }

        .notification-container {
            position: relative;
            display: inline-block;
        }

        .bg-grey {
            background-color: #868688;
        }
    </style>
</head>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
        <button class="btn btn-icon btn-transparent-secondary order-1 order-lg-0 me-2 ms-lg-2 me-lg-0 " id="sidebarToggle"><i data-feather="menu"></i></button>
        <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="{{ route('supplier.index') }}">MITRA.ID</a>
        <ul class="navbar-nav align-items-center ms-auto">

            <li class="nav-item dropdown no-caret d-none d-sm-block me-4 dropdown-notifications ">
                <a class="btn btn-icon btn-transparent-secondary dropdown-toggle" id="navbarDropdownAlerts" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i data-feather="bell"></i>
                    @if (count($notif) > 0)
                        <span class="notification-badge">{{ count($notif) }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownAlerts">
                    <h6 class="dropdown-header dropdown-notifications-header">
                        <i class="me-2" data-feather="bell"></i>
                        Notifications
                    </h6>
                    @foreach ($notif as $item)
                        @if ($item->notif_type == 'order_selesai')
                            <a class="dropdown-item dropdown-notifications-item" href="{{ route('supplier.order.history') }}">
                                <div class="dropdown-notifications-item-icon bg-primary"><i data-feather="shopping-cart"></i></div>
                            @elseif (Str::contains($item->notif_title, 'Kamu dapat pesan baru dari'))
                                <a class="dropdown-item dropdown-notifications-item" href="/supplier/chat" target="_blank">
                                    <div class="dropdown-notifications-item-icon bg-primary"><i data-feather="message-circle"></i></div>
                                @elseif ($item->notif_type == 'order')
                                    <a class="dropdown-item dropdown-notifications-item" href="{{ route('supplier.order.index') }}">
                                        <div class="dropdown-notifications-item-icon bg-primary"><i data-feather="shopping-cart"></i></div>
                                    @elseif ($item->notif_title == 'Member baru terdaftar')
                                        <a class="dropdown-item dropdown-notifications-item" href="{{ route('supplier.member.list') }}">
                                            <div class="dropdown-notifications-item-icon bg-success"><i data-feather="message-circle"></i></div>
                                        @elseif ($item->notif_title == 'Ada diskusi baru di dalam forum')
                                            <a class="dropdown-item dropdown-notifications-item" href="{{ route('supplier.forum.index') }}">
                                                <div class="dropdown-notifications-item-icon bg-success"><i data-feather="message-circle"></i></div>
                                            @elseif ($item->notif_type == 'suspend')
                                                <a class="dropdown-item dropdown-notifications-item" href="/supplier/{{ Auth::user()->id }}/edit">
                                                    <div class="dropdown-notifications-item-icon bg-danger"><i data-feather="alert-triangle"></i></div>
                        @endif
                        <div class="dropdown-notifications-item-content">
                            <div class="dropdown-notifications-item-content-details">{{ $item->created_at }}</div>
                            <div class="dropdown-notifications-item-content-text">{{ $item->notif_title }}</div>
                        </div>
                        </a>
                    @endforeach
                    <a class="dropdown-item dropdown-notifications-footer" href="/supplier/notif">Lihat Semua</a>
                </div>
            </li>

            <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                <a class="btn btn-icon btn-transparent-secondary dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <img class="img-fluid" src="{{ asset('images') }}/{{ Auth::user()->avatar }}" /></a>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="{{ asset('images') }}/{{ Auth::user()->avatar }}" />
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name">{{ Auth::user()->name }}</div>
                            <div class="dropdown-user-details-email">{{ Auth::user()->email }}</div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('supplier.edit', Auth::user()->id) }}">
                        <a class="dropdown-item" href="{{ route('supplier.edit', Auth::user()->id) }}">
                            <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                            Account
                        </a>
                    </form>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                            Log Out
                        </a>
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sidenav shadow-right sidenav-light">
                <div class="sidenav-menu">
                    <div class="nav accordion" id="accordionSidenav">
                        <div class="sidenav-menu-heading">Home</div>
                        <a class="nav-link" href="{{ route('supplier.index') }}">
                            <div class="nav-link-icon"><i data-feather="activity"></i></div>
                            Dashboard
                        </a>
                        <div class="sidenav-menu-heading">Produk</div>
                        <a class="nav-link" href="{{ route('supplier.product.index') }}">
                            <div class="nav-link-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                            Daftar Produk
                        </a>
                        <a class="nav-link" href="{{ route('supplier.product.stock') }}">
                            <div class="nav-link-icon"><i class="fa-solid fa-boxes-packing"></i></div>
                            Stok Produk
                        </a>
                        <div class="sidenav-menu-heading">Penjualan</div>
                        <a class="nav-link" href="{{ route('supplier.order.index') }}">
                            <div class="nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                            Pesanan Penjualan
                        </a>
                        <a class="nav-link" href="{{ route('supplier.order.history') }}">
                            <div class="nav-link-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                            Riwayat Penjualan
                        </a>
                        <div class="sidenav-menu-heading">Member</div>
                        <a class="nav-link" href="{{ route('supplier.member.index') }}">
                            <div class="nav-link-icon"><i class="fa-solid fa-rectangle-list"></i></div>
                            Form Member
                        </a>
                        <a class="nav-link" href="{{ route('supplier.member.list') }}">
                            <div class="nav-link-icon"><i class="fa-regular fa-address-book"></i></div>
                            Daftar Member
                        </a>
                        <div class="sidenav-menu-heading">Pesan</div>
                        <a class="nav-link" href="{{ route('supplier.chat.index') }}" target="_blank">
                            <div class="nav-link-icon"><i class="fa-solid fa-comments"></i></div>
                            Chat
                        </a>
                        <a class="nav-link" href="{{ route('supplier.forum.index') }}">
                            <div class="nav-link-icon"><i class="fa-solid fa-person-chalkboard"></i></div>
                            Forum Member
                        </a>
                        <a class="nav-link" href="{{ route('supplier.notif.index') }}">
                            <div class="nav-link-icon"><i class="fa-solid fa-bell"></i></div>
                            Notifikasi
                        </a>
                        <div class="sidenav-menu-heading">Lainnya</div>
                        <a class="nav-link" href="{{ route('supplier.artikel.index') }}">
                            <div class="nav-link-icon"><i class="fa-solid fa-rectangle-list"></i></div>
                            Artikel
                        </a>
                        <a class="nav-link" href="{{ route('supplier.course.index') }}">
                            <div class="nav-link-icon"><i class="fa-solid fa-clapperboard"></i></div>
                            Course
                        </a>
                        <a class="nav-link" href="/chatify/1" target="_blank">
                            <div class="nav-link-icon"><i class="fa-solid fa-headset"></i></div>
                            Helpdesk
                        </a>
                    </div>
                </div>
                <div class="sidenav-footer">
                    <div class="sidenav-footer-content">
                        <div class="sidenav-footer-subtitle">Logged in as:</div>
                        <div class="sidenav-footer-title">Supplier Dashboard</div>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            <footer class="footer-admin mt-auto footer-light">
                <div class="container-xl px-4">
                    <div class="row">
                        <div class="col-md-6 small">Copyright &copy; MITRA.ID 2024</div>
                        <div class="col-md-6 text-md-end small">
                            <a href="#!">Privacy Policy</a>
                            &middot;
                            <a href="#!">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/sbadmin/js/scripts.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/sbadmin/js/datatables/datatables-simple-demo.js') }}"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let successMessage = "{{ Session::get('success') }}";
        let errorMessage = "{{ Session::get('error') }}";
        let errorMessage2 = "{{ $errors->first() }}";

        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: successMessage,
            });
        } else if (errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage,
            });
        } else if (errorMessage2) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorMessage,
            });
        }
    </script>
</body>

</html>
