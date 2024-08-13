@extends('layouts.supplier')

@section('content')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white pb-2">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-4">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Account Settings - Profile
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <form action="{{ route('supplier.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container-xl px-4 mt-4">
            <hr class="mt-0 mb-4" />
            <div class="row">
                <div class="col-xl-4">
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header bg-purple text-white">Foto profil</div>
                        <div class="card-body text-center">
                            @if (Auth::user()->suspended == 1)
                                <span class="badge bg-danger mb-3">Suspended</span>
                            @else
                                <span class="badge bg-success mb-3">Aktif</span>
                            @endif
                            <br>
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
                            <form>
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
                                <div class="mb-3">
                                    <label class="small mb-1" for="bio">Bio</label>
                                    <input class="form-control" id="bio" name="bio" type="text" value="{{ $user->bio }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="rekening">Rekening</label>
                                    <input class="form-control" id="rekening" name="rekening" type="text" value="{{ $user->rekening }}" />
                                </div>
                                <br>
                                <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
