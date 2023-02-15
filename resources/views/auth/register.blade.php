<!DOCTYPE html>
<html lang="en">

<head>
    <title>FOOTBALLFANSTV | User Uegister</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/landing_page/css/model.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta name="robots" content="noindex, follow">
</head>

<body>
    <div class="limiter">
        <div class="container-login100"
            style="background-image: url('public/landing_page/wallpaperflare.com_wallpaper.png') ; z-index: auto;">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="{{ route('register') }}"
                    autocomplete="off">
                    @csrf
                    {{-- <span class="login100-form-title text-white mb-3">
                        Register Now
                    </span> --}}
                    @error('name')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                    <input type="hidden" name="user_type" value="user">
                    <div class="wrap-input100 validate-input" data-validate="Valid name is required: ex@abc.xyz">
                        <input class="input100" type="text" required name="name" placeholder="Name"
                            value="{{ old('name') }}">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>
                    @error('email')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" required name="email" placeholder="Email"
                            value="{{ old('email') }}">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    @error('password_confirmation')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password_confirmation"
                            placeholder="Confirm Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" style="background-color: #007bff; margin-right: 10px">
                            Register
                        </button>

                    </div>

                    {{-- <div class="mt-3 text-center">
                        <a href="{{ route('auth.google') }}" target="_blanck">
                            <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png"
                                style="margin-left: 3em;">
                        </a>
                    </div> --}}


                    <div class="text-center p-t-90 " style="text-align: center ; margin-top: 20px">
                        <a class="txt1" href="{{ route('login') }}" style=" text-decoration: none; margin: 0 10px">
                            Already a member? Sign In
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('public/landing_page/js/main.js') }}"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>

    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vaafb692b2aea4879b33c060e79fe94621666317369993"
        integrity="sha512-0ahDYl866UMhKuYcW078ScMalXqtFJggm7TmlUtp0UlD4eQk0Ixfnm5ykXKvGJNFjLMoortdseTfsRT8oCfgGA=="
        data-cf-beacon='{"rayId":"7962b0d45cd3bc2d","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2022.11.3","si":100}'
        crossorigin="anonymous"></script>
</body>

</html>
