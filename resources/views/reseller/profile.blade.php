@extends('layouts.reseller')

@section('style')
    <link href="{{ asset('css/cork/account-setting.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/sbadmin/css/styles.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Profil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pengaturan Profil</li>
                    </ol>
                </nav>
            </div>
            <div class="account-settings-container layout-top-spacing">
                <div class="account-content">
                    <div class="tab-content" id="animateLineContent-4">
                        <div class="tab-pane fade show active" id="animated-underline-home" role="tabpanel" aria-labelledby="animated-underline-home-tab">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form class="section general-info" action="{{ route('reseller.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="info">
                                            <h6 class="">Informasi Akun</h6>
                                            <div class="row">
                                                <div class="col-xl-4">
                                                    <div class="card mb-4 mb-xl-0">
                                                        <div class="card-header bg-primary text-white">Foto profil</div>
                                                        <div class="card-body text-center">
                                                            <img id="profileImage" class="img-account-profile rounded-circle mb-2" src="{{ asset('images') }}/{{ Auth::user()->avatar }}" alt="" />
                                                            <div class="small font-italic text-muted mb-4">JPG atau PNG tidak lebih besar dari 5 MB</div>
                                                            <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;" onchange="previewImage(event);">
                                                            <button class="btn btn-outline-primary" type="button" onclick="document.getElementById('avatar').click();">Pilih Gambar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-8">
                                                    <div class="card mb-4">
                                                        <div class="card-header bg-purple text-white">Detail Akun</div>
                                                        <div class="card-body">
                                                            <div class="mb-3">
                                                                <label class="small mb-1" for="name">Nama</label>
                                                                <input class="form-control" id="name" name="name" type="text" value="{{ Auth::user()->name }}" />
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="small mb-1" for="email">Email</label>
                                                                <input class="form-control" id="email" name="email" type="text" value="{{ Auth::user()->email }}" />
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="small mb-1" for="address">Lokasi</label>
                                                                <input class="form-control" id="address" name="address" type="text" value="{{ $user->address }}" />
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="small mb-1" for="phone">Nomor Kontak</label>
                                                                <input class="form-control" id="phone" name="phone" type="text" value="{{ $user->phone }}" />
                                                            </div>
                                                            {{-- <div class="mb-3">
                                                                <label class="small mb-1" for="bio">Bio</label>
                                                                <input class="form-control" id="bio" name="bio" type="text" value="{{ $user->bio }}" />
                                                            </div> --}}
                                                            <br>
                                                            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/sbadmin/js/scripts.js') }}"></script>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('profileImage');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection


@section('style')
    <script src="{{ asset('js/cork/account-setting.js') }}"></script>
@endsection
