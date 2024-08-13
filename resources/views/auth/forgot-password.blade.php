<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <h2 class="active">Forgot Password</h2>
            <div class="fadeIn first">
                <img src="{{ asset('assets/img/mitralogo.png') }}" id="icon" alt="User Icon">
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <input type="email" id="email" class="fadeIn second" name="email" placeholder="Email" required autofocus>
                <button type="submit" class="fadeIn fourth">{{ __('Email Password Reset Link') }}</button>
            </form>

            <div class="regist">Remembered your password?
                <a href="/login">Login now</a>
            </div>
            <br>
        </div>
    </div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('status'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('status') }}',
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Failed to send reset link, please try again!',
            });
        @endif
    </script>
</body>

</html>
