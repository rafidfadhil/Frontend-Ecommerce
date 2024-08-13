<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <h2 class="active">Register</h2>

            <form method="POST" action="{{ route('register') }}" class="g-3">
                @csrf

                <div class="mb-3">
                    <label for="user_type_id" class="form-label">Daftar sebagai :</label>
                    <select id="role" name="user_type_id" class="form-select" required>
                        <option value="" disabled selected hidden> </option>
                        <option value="2">Supplier</option>
                        <option value="3">Reseller</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama/Nama Toko :</label>
                    <input type="text" id="username" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email" required>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password :</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password :</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="Masukkan password lagi" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat :</label>
                    <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Masukkan alamat" required>
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor handphone :</label>
                    <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Masukkan nomor handphone" pattern="[0-9]+"
                        title="Please enter numbers only" required>
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <br>
                <div class="mb-3">
                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>

            <div class="login">Sudah punya akun?
                <a href="/login">Login sekarang</a>
            </div>
            <br>
        </div>
    </div>

</body>

</html>
