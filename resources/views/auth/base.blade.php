<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Solopayment</title>
    <link rel="shortcut icon" href="{{ asset('image/home-page/icon-mini.png') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adm.auth.css') }}">
</head>
<body>

@include('bg_particle')

<section id="box-auth" class="position-relative">
    <div class="form-auth">
        <div class="header-img mb-4">
            <img src="{{ asset('image/adm/ai_bg_pc.png') }}" alt="Bg" class="w-100">
        </div>
        <div class="form-auth-bg">
            @yield('form-auth')
        </div>
    </div>
</section>
<div class="pending-request">
    <div class="pending-ring"><div></div><div></div><div></div><div></div></div>
</div>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/request.js') }}"></script>
<script src="{{ asset('js/auth.js') }}"></script>
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
