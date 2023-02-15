<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 , user-scalable=no">
    <title>FOOTBALLFANSTV</title>
    <link rel="stylesheet" href="{{ asset('public/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="public/landing_page/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/landing_page/css/model.css') }}">
    <link rel="stylesheet" href="{{ asset('public/landing_page/css/style.css') }}">
</head>

<body>
    <style>
        .tcus {
            widows: 100px;
        }
        .modal-content{
          width: 50%;
          margin: 0 auto;
        }
        .close {
            float: right !important;
            position: absolute !important;
            top: 19px !important;
            right: 40px !important;
            z-index: 999 !important;
            font-size: 36px !important;
            color: red !important;
        }

        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 100% !important;
                margin: 1.75rem auto;
            }
        }
#paypal-button-container .paypal-button-number-1 {
    display: none !important;
}

    </style>
    <div class="loader">
        <div class="ring"></div>
    </div>
    <div class="background" style="padding-top: 30px;">
        <div class="bg">

            <nav class="navbar navbar-expand-lg navbar-light bg-light " style="overflow: inherit;">
                <div class="container ">
                    <a class="navbar-brand" href="#"><img
                            src="{{ asset('public/landing_page/Football-Fans-TV.png') }}" alt="logo"
                            srcset=""></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item ">
                                <a class="nav-link active" href="#HOME">HOME <span
                                        class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="#SCREEN">SCREEN</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#PRICING">PRICING</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#CONTACT">CONTACT</a>
                            </li>
                            @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="javascript:void(0)" data-toggle="modal" data-target="#staticBackdrop">PROFILE</a>
                                </li>
                            @endauth
                        </ul>
                        @auth
                        <div class="dropdown">
                            <img src="https://as2.ftcdn.net/v2/jpg/02/29/75/83/1000_F_229758328_7x8jwCwjtBMmC6rgFzLFhZoEpLobB6L8.jpg" alt="" style="width:30px; border-radius:100%" srcset="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                        </div>
                            <div class=" my-2 my-lg-0 ml-2">

                                <a class="btn btn-outline-primary" href="{{ route('logout') }}">{{ _lang('LOGOUT') }}</a>
                                <!-- Example single danger button -->
                                <!-- Button trigger modal -->
                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#staticBackdrop">
                                    Launch static backdrop modal
                                </button> -->

                                <!-- Profile Modal -->
                                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false"
                                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content" style="margin-top: 3%;">
                                            <div class="modal-body">
                                                <div class="container">
                                                  <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                       </button>
                                                    <div class="main-body" style="width:100%">

                                                        <div class="row gutters-sm">
                                                            <div class="col-md-12">
                                                                <div class="card mb-3">
                                                                    <div class="card-body">
                                                                        <div class="row justify-content-center">
                                                                            <div class="col-sm-3">
                                                                                <img src="{{ asset("/public/default/profile.png") }}" alt="Admin" class="rounded-circle" width="150">
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <p class="mb-0 text-muted">Full Name</p>
                                                                            </div>
                                                                            <div class="col-sm-9 text-secondary">
                                                                                <p>{{ Auth::user()->name }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <p class="mb-0 text-muted">Email</p>
                                                                            </div>
                                                                            <div class="col-sm-9 text-secondary">
                                                                                <p>{{ Auth::user()->email }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <p class="mb-0 text-muted">Phone</p>
                                                                            </div>
                                                                            <div class="col-sm-9 text-secondary">
                                                                                <p>{{ Auth::user()->phone ?? "No Phone Added Yet!" }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="row">
                                                                            <div class="col-sm-3">
                                                                                <p class="mb-0 text-muted">User Type</p>
                                                                            </div>
                                                                            <div class="col-sm-9 text-secondary">
                                                                                <p>{{ Auth::user()->subscription_id != 0 ? Auth::user()->subscription->name : "Free User"}}</p>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="row">
                                                                            <div class="col-sm-12 text-right">
                                                                                <a class="btn btn-outline-primary" href="">{{ _lang('EDIT') }}</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endauth
                        @guest
                            <div class=" my-2 my-lg-0 ml-2">
                                <a href="{{ route('login') }}" class="btn btn-outline-primary ajax-modal">LOGIN</a>
                            </div>

                        @endguest
                        {{-- <form action="{{ route('verification.resend') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary ajax-modal">
                                click here email verification
                            </button>
                        </form> --}}
                    </div>
                </div>

            </nav>

            <div class="container py-5">
                <div id="whatsapp" class="container">
                    <a href="https://wa.me/+33745014920" target="_blanck">
                        <img src="{{ asset('public/landing_page/whatsapp (1).png') }}" alt="" srcset=""
                            class="whatsapp_logo">
                    </a>
                </div>
                <div class="mcard " id="HOME">

                    <div class="row">
                        <div class="col-md-6 mcardleft">
                            <h2 class="f7 fs15">FOOTBALL FANS TV </h2>
                            {{-- {{$agent = new Agent()}} --}}

                            <div class="w-100">
                                <div class="hborder"></div>
                            </div>
                            <h6 class=" f3 fs9">Football Live Streaming, Scores, News & Updates
                            </h6>
                            <div class="downloadbtn my-4">
                                <a class="dlogo"
                                    href="https://play.google.com/store/apps/details?id=fr.footballfanstv.app"
                                    target="_blank"><img src="{{ asset('public/landing_page/pngwing.com.png') }}"
                                        alt="" srcset=""></a> <br>
                                <a class="dlogo" href="https://apps.apple.com/app/id6444097189" target="_blank"><img
                                        src="{{ asset('public/landing_page/pngwing.com (1).png') }}" alt=""
                                        srcset=""></a>
                            </div>
                            <h5 class="f7 text-left fs9">We Are Showing <span class="tred">......</span></h5>
                            <div class="league">
                                <img class="imagr" style="background-color: white;  margin-right: 8px; "
                                    src="{{ asset('public/landing_page/League Logo/Champions League.png') }}"
                                    alt="" srcset="">
                                <img class="imagr" style="background-color: #fff; margin-right: 8px;"
                                    src="{{ asset('public/landing_page/League Logo/premier league.png') }}"
                                    alt="" srcset="">
                                <img class="imagr" style="background-color: white;  margin-right: 8px;"
                                    src="{{ asset('public/landing_page/League Logo/La Liga.png') }}" alt=""
                                    srcset="">
                                <img class="imagr" style="background-color: #D60117; margin-right: 8px;"
                                    src="{{ asset('public/landing_page/League Logo/Bundesliga.png') }}"
                                    alt="" srcset="">
                                <img class="imagr" style="background-color: #1E353E;  margin-right: 8px;"
                                    src="{{ asset('public/landing_page/League Logo/10197.png') }}" alt=""
                                    srcset="">
                                <img class="imagr" style="background-color: white;  margin-right: 8px;"
                                    src="{{ asset('public/landing_page/League Logo/Seria A.png') }}" alt=""
                                    srcset="">
                                <img class="imagr" style="background-color: #7B0202;  margin-right: 8px;"
                                    src="{{ asset('public/landing_page/League Logo/europa-conference-league.png') }}"
                                    alt="" srcset="">

                            </div>
                        </div>
                        <div class="col-md-6 mcardright">
                            <div class="rightimg">
                                <img src="{{ asset('public/landing_page/Group 19@2x.png') }}" alt=""
                                    srcset="">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mcard" id="SCREEN">
                    <h5 class="f7 fs9">Screens <span style="color: #52B2F5; font-weight: bold;">.....</span></h5>
                    <div id="box">
                        <div class="slider autoplay border-5 w-100">
                            <div> <img class="scrinshortimg"
                                    src="{{ asset('public/landing_page/scrinshort/1.jpg') }}" alt=""
                                    srcset=""> </div>
                            <div> <img class="scrinshortimg"
                                    src="{{ asset('public/landing_page/scrinshort/2.jpg') }}" alt=""
                                    srcset=""> </div>
                            <div> <img class="scrinshortimg"
                                    src="{{ asset('public/landing_page/scrinshort/3.jpg') }}" alt=""
                                    srcset=""> </div>
                            <div> <img class="scrinshortimg"
                                    src="{{ asset('public/landing_page/scrinshort/4.jpg') }}" alt=""
                                    srcset=""> </div>
                            <div> <img class="scrinshortimg"
                                    src="{{ asset('public/landing_page/scrinshort/5.jpg') }}" alt=""
                                    srcset=""> </div>
                            <div> <img class="scrinshortimg"
                                    src="{{ asset('public/landing_page/scrinshort/6.jpg') }}" alt=""
                                    srcset=""> </div>
                            <div> <img class="scrinshortimg"
                                    src="{{ asset('public/landing_page/scrinshort/7.jpg') }}" alt=""
                                    srcset=""> </div>
                        </div>
                    </div>
                </div>
                <div class="mcard content" id="SCREEN">
                    <h4 class="f4 ">Le meilleur du Football en Vidéo Live.
                    </h4>
                    <h5 class="f4 ">
                        L’appli de référence des Fans de Football, qui vous donne accès aux matches, buts et résumés des
                        matches de tous les plus grands Championnats et Compétition Internationale.
                        <br>
                        <br>
                        La seule offre avec 100% de la Ligue 1, Liga, Serie A, Premier League, Bundesliga, Champions
                        League, Europa League, Coupe du Monde, Coupe d'Afrique, Coupe d'Européens...
                    </h5>
                </div>

                <div class="mcard" id="PRICING">
                    @if (Session::has('error'))
                        {{ Session::get('error') }}
                    @endif

                    @if (Session::has('success'))
                        {{ Session::get('success') }}
                    @endif
                    <h5 class="f7 fs9">Choose your plan <span style="color: #52B2F5; font-weight: bold;">.....</span>
                    </h5>
                    <div style="overflow-x:auto; margin-top: 40px;" class="teble-responsiv">
                        <table style="border: 1px solid #52b1f530;">
                            {{-- <tr>
                                <td class="tcus" scope="row" width
                                    style="vertical-align: center !important; text-align: center; padding: 20px;">
                                    <p>Select your plan</p>
                                </td>
                                <td class="text-center tcus " style="padding: 20px;">
                                    <p>Full HD 1080p Live streaming</p>

                                </td>
                                <td class="text-center tcus" style="padding: 20px;">
                                    <p>Unlimited Watching time</p>

                                </td>
                                <td class="text-center tcus" style="padding: 20px;">
                                    <p>Full-screen mode</p>
                                </td>
                                <td class="text-center tcus" style="padding: 20px;">
                                    <p>No ads/popups</p>
                                </td>

                            </tr>
                            <tr class="width">
                                <td class="tcus text-center  py-4">
                                    <h6 class="f4">1 &Year <br> $ <span>$39.99</span> </h6>
                                    <a href="#" class="btn btnclor text-white">Select</a>
                                </td>
                                <td class="text-center  py-4"><i class="fa-solid fa-check"></i></td>
                                <td class="text-center  py-4"><i class="fa-solid fa-check"></i></td>
                                <td class="text-center  py-4"><i class="fa-solid fa-check"></i></td>
                                <td class="text-center  py-4"><i class="fa-solid fa-check"></i></td>
                            </tr> --}}
                            @foreach ($subscription as $item)
                                {{-- <tr>
                                <td class="tcus" scope="row" width
                                    style="vertical-align: center !important; text-align: center; padding: 20px;">
                                    <p>Select your plan</p>
                                </td>
                                @foreach (json_decode($item->description) as $data)
                                <td class="text-center tcus" style="padding: 20px;">
                                    <p>{{ $data->description }}</p>
                                </td>
                                @endforeach


                            </tr> --}}
                                <tr class="width">
                                    <td class="tcus text-center  py-4">
                                        <h6 class="f4">{{ $item->duration }} & {{ $item->duration_type }} <br> $
                                            <span>{{ $item->subscription_price }}</span> </h6>
                                            <form action="{{ route('payment') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="amount" value="{{ $item->subscription_price }}">
                                                <input type="hidden" name="subscription_id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btnclor text-white">Select</button>
                                            </form>
                                    </td>
                                    @foreach (json_decode($item->description) as $data)
                                        <td class="text-center tcus" style="padding: 20px;">
                                            <p>{{ $data->description }}</p>
                                            @if ($data->checkbox == 1)
                                                <i class="fa-solid fa-check">
                                                @else
                                                    <i class="fa fa-check fa-times" aria-hidden="true"></i>
                                            @endif
                                        </td>
                                    @endforeach

                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

                    <div id="paypal-button-container"></div>

                <div class="mcard contac" id="CONTACT">
                    <h5 class="f7 fs9 mb-3">Contact Us<span style="color: #52B2F5; font-weight: bold;">.....</span>
                    </h5>
                    <h6 class="mb-3 f32">If you have any enquiry concerning Football Fans TV service, please contact us
                        via:
                        <h6 class="mb-3 f32">Email address: <a style="color: #52B2F5; "
                                href="mailto:contact.footballfanstv@gmail.com">contact.footballfanstv@gmail.com</a>
                        </h6>

                        <h6 class="mb-3 f32">Phone: <a style="color: #52B2F5; "
                                href="tel:+33745014920">+33745014920</a></h6>

                        <h6 class="mb-3 f32">Thank you for your support</h6>
                </div>
            </div>
            <div class="fmcard text-center w-100">
                <div class="navbar-brands"><img src="{{ asset('public/landing_page/Football-Fans-TV.png') }}"
                        alt="logo" srcset="">
                    <div class="sharlogo my-3">
                        <a href="https://www.facebook.com/footballfanstv.off/" target="_blank"><img
                                src=" {{ asset('public/landing_page/facebook.png') }}" alt="facebook"
                                srcset=""></a>
                        <a href="https://instagram.com/footballfanstv_?igshid=YmMyMTA2M2Y=" target="_blank"><img
                                src="{{ asset('public/landing_page/instagram.png') }}" alt="instagram"
                                srcset=""></a>
                        <a href="https://youtube.com/@mouniroubella" target="_blank"><img
                                src="{{ asset('public/landing_page/youtube.png') }}" alt="youtube"
                                srcset=""></a>
                        <h6>Football-Fans-TV is one of the leadingplatforms on live sports services offering the
                            greatest
                            live Coverage of over 1000 sports.</h6>
                        <h6>Email: <a style="color: #52B2F5; "
                                href="mailto:contact.footballfanstv@gmail.com">contact.footballfanstv@gmail.com</a>
                        </h6>
                        <h6><i class="fa-solid fa-copyright"></i> 2022 Football Fans TV Inc.</h6>
                    </div>
                </div>

            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
        </script>
        <script src="{{ asset('public/landing_page/js/jquery-3.6.1.min.js') }}"></script>
        <script src="{{ asset('public/slick/ezoom.js') }}"></script>
        <script src="{{ asset('public/slick/slick.js') }}"></script>
        <script src="{{ asset('public/landing_page/js/sweetalert.min.js') }}"></script>
        <script src="js/main.js"></script>
          <script src="https://www.paypal.com/sdk/js?client-id=AWM5hw8KSkGrPceGLDLQkumsO-9vGNAome1W_7tv1ibegycs5Zj78lpc9oSoLmA81SwbknC5G15IMwGR&currency=USD"></script>

    <script>
        // Render the PayPal button into #paypal-button-container
        paypal.Buttons({

            // Set up the transaction
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '88.44'
                        }
                    }]
                });
            },

            // Finalize the transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                    // Successful capture! For demo purposes:
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                    // Replace the above to show a success message within this page, e.g.
                    // const element = document.getElementById('paypal-button-container');
                    // element.innerHTML = '';
                    // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                    // Or go to another URL:  actions.redirect('thank_you.html');
                });
            }


        }).render('#paypal-button-container');
    </script>

        <script>

            $(document).ready(function() {
                $('.autoplay').slick({
                    slidesToShow: 5,
                    slidesToScroll: 2,
                    autoplay: true,
                    dots: true,
                    autoplaySpeed: 2000,
                    responsive: [{
                            breakpoint: 768,
                            settings: {
                                arrows: false,
                                centerMode: true,
                                centerPadding: '40px',
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false,
                                centerMode: true,
                                centerPadding: '40px',
                                slidesToShow: 1
                            }
                        }

                    ]
                });
                ezoom.onInit($('.autoplay .scrinshortimg'), {
                    hideControlBtn: false,
                    onClose: function(result) {
                        console.log(result);
                    },
                    onRotate: function(result) {
                        console.log(result);
                    },
                });

            });

            $(document).ready(function() {
                $('ul li a').click(function() {
                    $('li a').removeClass("active");
                    $(this).addClass("active");
                });
            });
            const loader = document.querySelector(".loader");
            window.onload = function() {
                setTimeout(function() {
                    loader.style.opacity = "0";
                    setTimeout(function() {
                        loader.style.display = "none";
                    }, 500);
                }, 1500);
            }
        </script>

</body>

</html>
