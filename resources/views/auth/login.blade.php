<!DOCTYPE html>
<html lang="en">

<head>
    <title>FOOTBALLFANSTV | User Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/landing_page/css/model.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta name="robots" content="noindex, follow">
</head>

<body>
    <div class="limiter">
        <div class="container-login100"
            style="background-image: url({{ url('public/landing_page/wallpaperflare.com_wallpaper.png') }}); z-index: auto;">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}"
                    autocomplete="off">
                    @csrf

                    @error('email')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="email" name="email" placeholder="Email"
                            value="{{ old('email') }}" required>
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password" required>
                        <span class="focus-input100"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" style="background-color: #007bff; margin-right: 10px">
                            Login
                        </button>

                    </div>
                    <div class="p-t-90 mt-4">
                        <p>
                            <a class="txt1 text-decoration-none" href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                        </p>
                        <p>
                            <a class="txt1 text-decoration-none" href="{{ route('register') }}">
                                New Memeber? Sign up Now
                            </a>
                        </p>
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
