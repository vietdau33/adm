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
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adm.css') }}">
</head>
<body class="left-menu-mobile">
@include('bg_particle')
<div class="wrapper">
    <div class="content">
        <div class="header-nav" id="header-content">
            <div class="logo-header">
                <img src="{{ asset('image/adm/ai_bg.png') }}" alt="AI">
            </div>
            <div class="menu-header">
                <ul>
                    <li data-active="dashboard">
                        <a href="{{ route('home.page') }}">
                            <img src="{{ asset('image/adm/icon/dashboard.png') }}" alt="Dashboard">
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li data-active="list-member">
                        <a href="{{ route('userlist') }}">
                            <img src="{{ asset('image/adm/icon/people.png') }}" alt="List Member">
                            <span>List Member</span>
                        </a>
                    </li>
                    <li data-active="money">
                        <a href="{{ route('money.home') }}">
                            <img src="{{ asset('image/adm/icon/money.png') }}" alt="Money">
                            <span>Money</span>
                        </a>
                    </li>
                    <li data-active="history">
                        <a href="{{ route('history.home') }}">
                            <img src="{{ asset('image/adm/icon/history.png') }}" alt="History">
                            <span>History</span>
                        </a>
                    </li>
                    <li data-active="settings">
                        <a href="{{ route('setting.home') }}">
                            <img src="{{ asset('image/adm/icon/setting.png') }}" alt="Settings">
                            <span>Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('auth.logout.get') }}">
                            <img src="{{ asset('image/adm/icon/logout.png') }}" alt="Logout">
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
            {{--<a class="btn-logout" href="{{ route('auth.logout.get') }}">Logout</a>--}}
            {{--<div class="menu-icon-bars" onclick="Main.showLeftMenu()">--}}
            {{--    <i class="fas fa-bars"></i>--}}
            {{--</div>--}}
        </div>
        <div class="container-fluid main-content pt-3 pb-3" id="main-content">
            @yield('contents')
        </div>
        <div class="footer-nav" id="footer-content">
            {{--Copyright &copy; 2022 {{ request()->getHost() }}--}}
        </div>
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
