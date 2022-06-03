@extends("auth.base")
@section('form-auth')
    <form action="{{ route('auth.login.post') }}" method="POST" onsubmit="return false;">
        @csrf
        <div class="form-auth-login">
            <h2 class="text-uppercase text-center font-weight-bold">{{ __('auth.login_header') }}</h2>
            <div class="form-group">
                <label for="enter_email">{{ __('auth.enter_email') }}</label>
                <input type="text" class="form-control" name="email" id="enter_email" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="enter_password">{{ __('auth.enter_password') }}</label>
                <input type="password" class="form-control" name="password" id="enter_password" required autocomplete="off">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-submit" onclick="Auth.login(this)">{{ __('auth.btn_login') }}</button>
            </div>
            <div class="form-group mb-0 text-right">
                <a href="{{ route('auth.forgotpassword.get') }}" class="color-href">{{ __("auth.forgot_password") }}</a>
                @if(config('app.show-register', false))
                    <a href="{{ route('auth.register.view') }}" class="color-href ml-3">{{ __("auth.create_new_account") }}</a>
                @endif
            </div>
        </div>
    </form>
@endsection
