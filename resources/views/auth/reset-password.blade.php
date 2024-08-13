<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <h2 class="active">Reset Password</h2>
            <div class="fadeIn first">
                <img src="{{ asset('assets/img/mitralogo.png') }}" id="icon" alt="User Icon">
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <input type="email" id="email" class="fadeIn second" name="email" placeholder="Email" value="{{ old('email', $request->email) }}" required autofocus>

                <!-- Password -->
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password" required>

                <!-- Confirm Password -->
                <input type="password" id="password_confirmation" class="fadeIn third" name="password_confirmation" placeholder="Confirm Password" required>

                <button type="submit" class="fadeIn fourth">{{ __('Reset Password') }}</button>
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
                text: 'Failed to reset password, please try again!',
            });
        @endif
    </script>
</body>

</html>
