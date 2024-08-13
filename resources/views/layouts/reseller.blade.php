<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Reseller - MITRA.ID</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" />
    <link href="{{ asset('css/cork/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/cork/main.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/cork/structure.css') }}" rel="stylesheet" type="text/css" />

    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>

    <link href="{{ asset('datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('datatables/responsive/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('datatables/buttons/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">

    <style>
        .bg-grey {
            background-color: #868688;
        }

        .notification-scroll {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
    @yield('style')
</head>

<body class="" data-bs-spy="scroll" data-bs-bs-target="#navSection" data-bs-offset="140">

    <div class="header-container container-xxl">
        <header class="header navbar navbar-expand-sm expand-header">
            <ul class="navbar-item flex-row ms-lg-auto ms-0">
                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        @if (isset($notif) && count($notif) > 0)
                            <span class="badge badge-success"></span>
                        @endif

                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                        <div class="drodpown-title message">
                            <h6 class="d-flex justify-content-between"><span class="align-self-center">Notifications</span> <span
                                    class="badge badge-secondary">{{ isset($notif) ? count($notif) : 0 }}</span></h6>
                        </div>
                        <div class="notification-scroll">
                            @if (isset($notif) && count($notif) > 0)
                                @foreach ($notif as $item)
                                    @if (Str::contains($item->notif_title, 'Ada diskusi baru didalam forum'))
                                        <a class="dropdown-item" href="/reseller/forum/{{ $item->notif_sender_id }}">
                                        @elseif (Str::contains($item->notif_title, 'Kamu dapat pesan baru dari'))
                                            <a class="dropdown-item" href="/chatify/{{ $item->notif_sender_id }}" target="_blank">
                                            @elseif (Str::contains($item->notif_title, 'Anda terdaftar'))
                                                <a class="dropdown-item" href="{{ route('reseller.member.index') }}">
                                                @elseif ($item->notif_type == 'order')
                                                    <a class="dropdown-item" href="{{ route('reseller.order.index') }}">
                                                    @else
                                                        <a class="dropdown-item" href="/reseller/notif">
                                    @endif
                                    <div class="media server-log">
                                        <div class="media-body">
                                            <div class="data-info">
                                                <h6 class="">{{ $item->notif_title }}</h6>
                                                <p class="">{{ $item->created_at }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                @endforeach
                            @endif
                            <a class="dropdown-item dropdown-notifications-footer" href="/reseller/notif">Lihat Semua</a>
                        </div>

                    </div>
                </li>

                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-container">
                            <div class="avatar avatar-sm avatar-indicators avatar-online">
                                <img alt="avatar" src="{{ asset('images') }}/{{ Auth::user()->avatar }}" class="rounded-circle">
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <div class="emoji me-2">
                                    &#x1F44B;
                                </div>
                                <div class="media-body">
                                    <h5>{{ Auth::user()->name }}</h5>
                                    <p>{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="{{ route('reseller.edit', Auth::user()->id) }}">
                                <span>Profile</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                                    Log Out
                                </a>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>

    <div class="main-container " id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>
        <div class="sidebar-wrapper sidebar-theme">
            <nav id="sidebar">
                <div class="navbar-nav theme-brand flex-row ms-4 mt-2">
                    <div class="nav-logo">
                        <div class="nav-item theme-logo">
                            <a href="{{ route('reseller.index') }}" style="text-decoration: none;">
                                <h2 style="color: #343a40; font-family: 'Arial', sans-serif;"><b>MITRA.ID</b></h2>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="profile-info">
                    <div class="user-info">
                        <div class="profile-img">
                            <img src="{{ asset('images') }}/{{ Auth::user()->avatar }}" alt="avatar">
                        </div>
                        <div class="profile-content">
                            <h6 class="">{{ Auth::user()->name }}</h6>
                            <p class="">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    {{-- Dashboard --}}
                    <li class="menu{{ Request::route()->getName() == 'reseller.index' ? ' active' : '' }}">
                        <a href="{{ route('reseller.index') }}" data-bs-toggle="" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i class="fa-solid fa-house"></i>
                                <span>Home</span>
                            </div>
                        </a>
                    </li>
                    {{-- Bandingkan --}}
                    <li class="menu{{ Request::route()->getName() == 'reseller.product.compare' ? ' active' : '' }}">
                        <a href="{{ route('reseller.product.compare.empty') }}" data-bs-toggle="" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i class="fa-solid fa-code-compare"></i>
                                <span>Bandingkan</span>
                            </div>
                        </a>
                    </li>
                    {{-- Chat --}}
                    <li class="menu{{ Request::route()->getName() == 'reseller.chat.index' ? ' active' : '' }}">
                        <a href="{{ route('reseller.chat.index') }}" target="_blank" data-bs-toggle="" aria-expanded="false"
                            class="dropdown-toggle">
                            <div class="">
                                <i class="fa-solid fa-comments"></i>
                                <span>Chat</span>
                            </div>
                        </a>
                    </li>
                    {{-- Forum --}}
                    <li class="menu{{ Request::route()->getName() == 'reseller.forum.index' ? ' active' : '' }}">
                        <a href="{{ route('reseller.forum.index') }}" data-bs-toggle="" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i class="fa-solid fa-person-chalkboard"></i>
                                <span>Forum Member</span>
                            </div>
                        </a>
                    </li>
                    {{-- Keranjang --}}
                    <li class="menu{{ Request::route()->getName() == 'reseller.cart' ? ' active' : '' }}">
                        <a href="{{ route('reseller.cart') }}" data-bs-toggle="" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span>Keranjang</span>
                            </div>
                        </a>
                    </li>
                    {{-- Pesanan --}}
                    <li class="menu{{ Request::route()->getName() == 'reseller.order.index' ? ' active' : '' }}">
                        <a href="{{ route('reseller.order.index') }}" data-bs-toggle="" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                <span>Pesanan</span>
                            </div>
                        </a>
                    </li>
                    {{-- Member --}}
                    <li class="menu{{ Request::route()->getName() == 'reseller.member.index' ? ' active' : '' }}">
                        <a href="{{ route('reseller.member.index') }}" data-bs-toggle="" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i class="fa-solid fa-people-group"></i>
                                <span>Member</span>
                            </div>
                        </a>
                    </li>
                    {{-- Course --}}
                    <li class="menu{{ Request::route()->getName() == 'reseller.course.index' ? ' active' : '' }}">
                        <a href="{{ route('reseller.course.index') }}" data-bs-toggle="" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i class="fa-solid fa-clapperboard"></i>
                                <span>Course</span>
                            </div>
                        </a>
                    </li>
                    {{-- Artikel --}}
                    <li class="menu{{ Request::route()->getName() == 'reseller.artikel.index' ? ' active' : '' }}">
                        <a href="{{ route('reseller.artikel.index') }}" data-bs-toggle="" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i class="fa-solid fa-newspaper"></i>
                                <span>FAQ</span>
                            </div>
                        </a>
                    </li>
                    {{-- Helpdesk --}}
                    <li class="menu{{ Request::route()->getName() == 'helpdesk' ? ' active' : '' }}">
                        <a href="/chatify/1" data-bs-toggle="" target="_blank" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i class="fa-solid fa-headset"></i>
                                <span>Helpdesk</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div id="content" class="main-content">

            @yield('content')

            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © <span class="dynamic-year">2024</span> <a target="_blank" href="#">MITRA.ID</a>, All
                        rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/cork/bootstrap.bundle.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatables/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('datatables/responsive/js/dataTables.responsive.min.js') }}"></script>


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

        $(document).ready(function() {
            const table = $('.dataTable').DataTable();
            $('.dataTable thead tr th').addClass('bg-dark text-white py-4');
        });
    </script>

    @yield('script')

</body>

</html>
