@extends('layouts.supplier')

@section('content')
    <style>
        .image-container {
            width: 150px;
            height: 100px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            /* Center the div itself within the td */
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
    </style>

    <header class="page-header page-header-dark pb-10 overlay overlay-10" style="background-color: rgb(66, 0, 128)">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-solid fa-file-invoice me-3 text-white"></i></div>
                            Daftar Member
                        </h1>
                        <div class="page-header-subtitle mt-3 text-white">Dashboard ini berisikan informasi Member yang telah terdaftar di toko ini.</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center py-3 bg-light">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Member</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-sm table-striped table-light text-center">
                    <thead>
                        <tr>
                            <th>ID Member</th>
                            <th>Photo</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Kontak</th>
                            <th>Pesanan Terakhir</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                            <tr>
                                <td>{{ $member->member_id }}</td>
                                <td>
                                    <div class="image-container">
                                        <img src="{{ asset('images/' . $member->avatar) }}" alt="{{ $member->name }}">
                                    </div>
                                </td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->address }}</td>
                                <td>{{ $member->phone }}</td>
                                <td>{{ \Carbon\Carbon::parse($member->order_date)->format('d F Y') }}</td>
                                @if ($member->status == 'AKTIF')
                                    <td>
                                        <a class="btn btn-sm btn-success">Aktif</a>
                                    </td>
                                @else
                                    <td>
                                        <a class="btn btn-sm btn-danger">Nonaktifkan</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
