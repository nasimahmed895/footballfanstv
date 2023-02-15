<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ get_option('site_title') }}</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ get_icon() }}" type="image/x-icon" />
    <!-- Fonts and icons -->
    <script src="{{ asset('public/backend/plugins/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['{{ asset('public/backend/css/fonts.min.css') }}']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!-- DataTables -->
    <link href="{{ asset('public/backend/plugins/datatables/dataTables.bootstrap4.min.css') }}" />
    <link href="{{ asset('public/backend/plugins/datatables/buttons.bootstrap4.min.css') }}" />
    <!-- Responsive datatable examples -->
    <link href="{{ asset('public/backend/plugins/datatables/responsive.bootstrap4.min.css') }}" />
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('public/backend/css/fonts.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/bootstrap/bootstrap-iconpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/select2/select2.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/toastr/toastr.css') }}">
    <!-- Dropify -->
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/dropify/dropify.min.css') }}">
    <!-- datepicker -->
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/bootstrap-datepicker/css/datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- Template Css -->
    <link rel="stylesheet" href="{{ asset('public/backend/css/atlantis.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/css/style.css') }}">
    <style>
        .logo-header,
        .navbar-header,
        .sidebar.sidebar-style-2 .nav.nav-primary>.nav-item.active>a,
        .sidebar.sidebar-style-2 .nav.nav-primary>.nav-item.active>a,
        .btn-primary,
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:disabled,
        .pace .pace-progress,
        .page-item.active .page-link,
        .nav-pills.nav-primary .nav-link.active {
            background: linear-gradient(135deg, #126e51 0%, #126e51 100%) !important;
            border-color: #126e51 !important;
        }

        .form-check [type="checkbox"]:not(:checked)+.form-check-sign:after,
        .form-check [type="checkbox"]:checked+.form-check-sign:after,
        .form-check [type="checkbox"]+.form-check-sign:after {
            color: #126e51;
        }
    </style>
    @include('layouts.includes._variables')
</head>
