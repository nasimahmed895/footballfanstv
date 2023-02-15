<!DOCTYPE html>
<html lang="en">

@include('layouts.includes._head')

<body>
    <!-- Preloader area start -->
    <div id="preloader"></div>
    <!-- Main Wrapper -->
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            @include('layouts.includes._logo-header')

            <!-- Navbar Header -->
            @include('layouts.includes._navbar')
        </div>

        <!-- Sidebar -->
        @include('layouts.includes._sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="content">
                <div class="page-inner">
                    @if (!Request::is('dashboard'))
                        <div class="page-header">
                            <h4 class="page-title">{{ _lang('Dashboard') }}</h4>
                            <ul class="breadcrumbs">
                                <li class="nav-home">
                                    <a href="{{ url('dashboard') }}">
                                        <i class="flaticon-home"></i>
                                    </a>
                                </li>
                                <li class="separator">
                                    <i class="flaticon-right-arrow"></i>
                                </li>
                                @php
                                    $segments = '';
                                @endphp
                                @foreach (Request::segments() as $segment)
                                    @php
                                        if (is_numeric($segment)) {
                                            continue;
                                        }
                                        $segments .= '/' . $segment;
                                    @endphp
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <a href="{{ url($segments) }}">
                                            {{ ucwords(str_replace('_', ' ', $segment)) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
            {{-- Footer --}}
            @include('layouts.includes._footer')
        </div>

    </div>

    {{-- Main Modal --}}
    @include('layouts.includes._main-modal')

    {{-- script --}}
    @include('layouts.includes._scripts')
</body>

</html>
