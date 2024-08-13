@extends('layouts.reseller')

@section('style')
@endsection

@section('content')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/reseller">MITRA ID</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Member</li>
                    </ol>
                </nav>
            </div>
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <h3 class="mb-3"><u>Daftar Member</u></h3>
                        <table class="table table-hover table-bordered dataTable text-center" style="width:100%">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>ID Member</th>
                                    <th>Nama Toko</th>
                                    <th>Tanggal Terdaftar</th>
                                    <th>Nomor Kontak</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $data)
                                    <tr>
                                        <td>{{ $data->member_id }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->created_at }}</td>
                                        <td>{{ $data->phone }}</td>
                                        <td><a href="{{ route('reseller.toko.index', ['supplier_name' => $data->name]) }}" class="btn btn-info p-1 px-2">Lihat Toko</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
