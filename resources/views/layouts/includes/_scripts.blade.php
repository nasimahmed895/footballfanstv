<!--   Core JS Files   -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('public/backend/plugins/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/bootstrap/bootstrap-iconpicker.bundle.min.js') }}"></script>
<!-- jQuery UI -->
<script src="{{ asset('public/backend/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
<!-- jQuery Scrollbar -->
<script src="{{ asset('public/backend/plugins/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
<!-- Bootstrap Notify -->
<script src="{{ asset('public/backend/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<!-- Sweet Alert -->
<script src="{{ asset('public/backend/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('public/backend/plugins/select2/select2.js') }}"></script>
<script src="{{ asset('public/backend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('public/backend/js/print.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('public/backend/plugins/toastr/toastr.js') }}"></script>
<!-- Dropify  -->
<script src="{{ asset('public/backend/plugins/dropify/dropify.min.js') }}"></script>
<!-- Dropify  -->
<script src="{{ asset('public/backend/js/pace.min.js') }}"></script>
<!-- Required datatable js -->
<script src="{{ asset('public/backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Responsive datatable -->
<script src="{{ asset('public/backend/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
<!-- Atlantis JS -->
<script src="{{ asset('public/backend/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('public/backend/plugins/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('public/backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- Atlantis JS -->
<script src="{{ asset('public/backend/js/atlantis.js') }}"></script>
<script src="{{ asset('public/backend/js/app.js') }}"></script>
<!-- Dashboard JS -->
@if (Request::is('dashboardw'))
    <script src="{{ asset('public/backend/js/dashboard.js') }}"></script>
@endif
<script>
    @if (!Request::is('dashboard'))
        $(".page-title").text($(".card-title").first().text());
        $('title').append(' | ' + $(".card-title").first().text());
    @else
        $('title').append(' | '.$lang_dashboard);
    @endif

    @if (Session::has('success'))
        toast('success', '{{ session('success') }}');
    @endif
    @if (Session::has('error'))
        toast('error', '{{ session('error') }}');
    @endif
    @foreach ($errors->all() as $error)
        toast('error', '{{ $error }}');
    @endforeach
</script>
@yield('js-script')
