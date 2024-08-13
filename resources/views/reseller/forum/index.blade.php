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
                        <h3 class="mb-3"><u>Daftar Forum</u></h3>
                        <table class="table table-hover table-bordered dataTable text-center" style="width:100%">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Group</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td><a href="{{ route('reseller.forum.show', ['supplier_id' => $data->member_supplier_id]) }}" class="btn btn-info p-1 px-2">Forum Chat</a></td>
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
