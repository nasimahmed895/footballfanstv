<!DOCTYPE html>
<html lang="en">

<head>
    <title>FOOTBALLFANSTV | Admin Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/auth/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/auth/vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/auth/vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/auth/css/main.css') }}">
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-5" style="width: 350px">
                        <img src="{{ get_logo() }}" alt="IMG" width="100%">
                    </div>
                    <span class="login100-form-title text-white">
                        Admin Login
                    </span>
                    @error('email')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="email" placeholder="Email"
                            value="{{ old('email') }}">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" style="background-color: #1dd6ffbd">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('public/auth/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('public/auth/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('public/auth/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/auth/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('public/auth/js/main.js') }}"></script>

</body>

</html>
