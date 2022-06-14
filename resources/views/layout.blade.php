<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>AI DIGITAL MEDIA</title>
    <link rel="shortcut icon" href="{{ asset('image/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/alertify.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/themes/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('splidejs/css/splide-default.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adm.css') }}">
    @if(is_admin())
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endif
</head>
<body class="left-menu-mobile">
@include('bg_particle')
<div class="wrapper">
    <div class="content">
        <div class="header-nav" id="header-content">
            <a class="logo-header" href="/home">
                <img src="{{ asset('image/adm/ai_bg.png') }}" alt="AI">
            </a>
            <div class="menu-header">
                <div class="close-menu-icon d-lg-none" onclick="this.parentNode.classList.remove('show')">
                    <div class="icon">
                        <img src="{{ asset('image/adm/icon/close.svg') }}" class="w-100" alt="Close">
                    </div>
                </div>
                @if(is_admin())
                    @include('menu-header.admin')
                @else
                    @include('menu-header.user')
                @endif
            </div>
            {{--<a class="btn-logout" href="{{ route('auth.logout.get') }}">Logout</a>--}}
            <div class="menu-icon-bars d-lg-none" onclick="this.previousElementSibling.classList.add('show')">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        <div class="container-fluid main-content pt-3 pb-3" id="main-content">
            @yield('contents')
        </div>
        {{--<div class="footer-nav" id="footer-content">--}}
        {{--    Copyright &copy; 2022 {{ request()->getHost() }}--}}
        {{--</div>--}}
    </div>
</div>

<div class="pending-request">
    <div class="pending-ring"><div></div><div></div><div></div><div></div></div>
</div>

@yield('modal')

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/QRCode/qrcode.min.js') }}"></script>
<script src="{{ asset('alertifyjs/alertify.min.js') }}"></script>
<script src="{{ asset('splidejs/js/splide.min.js') }}"></script>
<script src="{{ asset('js/request.js') }}"></script>
<script src="{{ asset('js/global.js') }}"></script>
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

    const menuActive = '{{ session()->pull('menu-active') ?? '' }}';
    if(menuActive != '') {
        $('[data-active="' + menuActive + '"]').find('a').addClass('active');
    }

    $('[data-qr]').each(function(){
        const text = $(this).attr('data-qr');
        const width = $(this).attr('data-qr-width') || 200;
        const height = $(this).attr('data-qr-height') || 200;
        const level = QRCode.CorrectLevel.H;
        new QRCode(this, {
            width: parseInt(width),
            height: parseInt(height),
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: level,
            text: text
        });
    });
</script>
@yield('script')
</body>
</html>
