<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Feeds - MITRA.ID</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" />
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet"> --}}
    <link href="{{ asset('css/cork/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/cork/main.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('css/cork/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{ asset('css/cork/waves.min.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('css/cork/structure.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('css/cork/monokai-sublime.css') }}" rel="stylesheet" type="text/css" /> --}}

    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>

    <link href="{{ asset('datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('datatables/responsive/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('datatables/buttons/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">

    @yield('style')
</head>

<body class="" data-bs-spy="scroll" data-bs-bs-target="#navSection" data-bs-offset="140">

    <div class="header-container container-xxl">
        <header class="header navbar navbar-expand-sm expand-header">
            <ul class="navbar-item flex-row ms-lg-auto ms-0">
                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                            <a href="{{ url('') }}" style="text-decoration: none;">
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
                @yield('sidebar')
            </nav>
        </div>

        <div id="content" class="main-content">

            @yield('content')

            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © <span class="dynamic-year">2024</span> <a target="_blank" href="#">MITRA.ID</a>, All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/cork/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('js/cork/app.js') }}"></script> --}}

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
            $('.dataTable').DataTable();
        });
    </script>

    @yield('script')

</body>

</html>