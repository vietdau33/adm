@extends("auth.base")
@section('form-auth')
    <form action="{{ route('auth.forgotpassword.post') }}" method="POST" onsubmit="return false;" id="formEnterUsername">
        @csrf
        <div class="form-auth-login">
            <h2 class="text-uppercase text-center font-weight-bold">{{ __("auth.forgot_password") }}</h2>
            <div class="form-group">
                <label for="enter_username">{{ __('auth.enter_username') }}</label>
                <input type="text" class="form-control" name="username" id="enter_username" required autocomplete="off">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-submit" onclick="Auth.forgotPassword(this)">{{ __('auth.btn_forgot') }}</button>
            </div>
        </div>
    </form>
    <form action="{{ route('auth.confirmotp.post') }}" method="POST" onsubmit="return false;" id="formConfirmOTP" style="display: none">
        @csrf
        <div class="form-auth-login">
            <h2 class="text-uppercase text-center font-weight-bold">{{ __("auth.otp_header") }}</h2>
            <div class="form-group mb-2">
                <label for="enter_otp_code">{{ __('auth.enter_otp_code') }}</label>
                <input type="text" class="form-control" name="otp_code" id="enter_otp_code" autocomplete="off">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-submit" data-form-forgot="1" onclick="Auth.checkOtp(this)">{{ __('auth.btn_forgot') }}</button>
            </div>
        </div>
    </form>
    <form action="{{ route('auth.editpasswordforgot.post') }}" method="POST" onsubmit="return false;" id="formEditPassword" style="display: none">
        @csrf
        <div class="form-auth-login">
            <h2 class="text-uppercase text-center font-weight-bold">{{ __("auth.new_password") }}</h2>
            <div class="form-group">
                <label for="enter_password">{{ __('auth.enter_new_password') }}</label>
                <input type="password" class="form-control" name="password" id="enter_password" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="enter_re_password">{{ __('auth.enter_re_password') }}</label>
                <input type="password" class="form-control" name="password-confirm" id="enter_re_password" required autocomplete="off">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-submit" onclick="Auth.editPasswordForgot(this)">{{ __('auth.btn_forgot') }}</button>
            </div>
        </div>
    </form>
@endsection
