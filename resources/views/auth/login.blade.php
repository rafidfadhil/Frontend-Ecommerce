<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <h2 class="active">Login</h2>
            <div class="fadeIn first">
                <img src="{{ asset('assets/img/mitralogo.png') }}" id="icon" alt="User Icon">
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="text" id="email" class="fadeIn second" name="email" placeholder="Email" required>
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password" required>
                <div class="forgot-password">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">
                            {{ __('Lupa Password?') }}
                        </a>
                    @endif
                </div>
                <button type="submit" class="fadeIn fourth">{{ __('Log in') }}</button>
            </form>

            <div class="regist">Belum Punya Akun?
                <a href="/register">Daftar sekarang</a>
            </div>
            <br>
        </div>
    </div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('register-success'))
            Swal.fire({
                icon: 'success',
                title: 'Registrasi Berhasil',
                text: '{{ session('success') }}',
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Gagal Login, Email atau Password Salah !',
            });
        @endif
    </script>
</body>

</html>
