@extends('layouts.supplier')

@section('content')
    <header class="page-header page-header-dark pb-10 overlay overlay-10" style="background-color: rgb(134, 134, 134)">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fa-solid fa-regular fa-bell me-3 text-white"></i></div>
                            Notification
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center py-2">
                <nav class="mt-1 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb px-3 py-2 rounded mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Notification</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-sm table-striped table-light text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifs as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>{{ $data->notif_title }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
