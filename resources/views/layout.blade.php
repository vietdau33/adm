<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>AI DIGITAL MEDIA</title>
    <link rel="shortcut icon" href="{{ asset('image/home-page/icon-mini.png') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/solopayment.css') }}">
</head>
<body class="left-menu-mobile">
@include('bg_particle')
<div class="wrapper ready">
    <div class="left-navigation height-100vh">
        <div class="logo">
            <img src="{{ asset('image/solopayment/Asset 22.png') }}" alt="">
        </div>
        <div class="navigation">
            @include('pages.menu-left')
        </div>
        <div class="left-logout-row">
            <a href="{{ route('auth.logout.get') }}" class="left-logout">
                <img src="{{ asset('/image/solopayment/exit.png') }}" alt="logout">
                <span>Logout</span>
            </a>
        </div>
    </div>
    <div class="overlay-left-menu" onclick="Main.hideLeftMenu()"></div>
    <div class="content">
        <div class="header-nav" id="header-content">
            <a class="btn-logout" href="{{ route('auth.logout.get') }}">Logout</a>
            <div class="menu-icon-bars" onclick="Main.showLeftMenu()">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        <div class="main-content" id="main-content">
            @yield('contents')
        </div>
        <div class="footer-nav" id="footer-content">
            Copyright &copy; 2021 Solopayment.co
        </div>
    </div>
</div>

<div class="pending-request">
    <div class="pending-ring"><div></div><div></div><div></div><div></div></div>
</div>

{{--<div class="loading-system">--}}
{{--    <div class="loading-system--img">--}}
{{--        <img src="{{ asset('image/loading.svg') }}" alt="Loading">--}}
{{--    </div>--}}
{{--</div>--}}

@yield('modal')

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
{{--<script src="{{ asset('js/date.js') }}"></script>--}}
<script src="{{ asset('js/request.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/home.js') }}"></script>
<script src="{{ asset('js/SearchForm.js') }}"></script>
@if(user()->role == 'admin')
    <script src="{{ asset('js/admin.js') }}"></script>
@endif
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@yield('script')
</body>
</html>
