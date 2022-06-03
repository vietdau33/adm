@extends("auth.base")
@section('form-auth')
    <form action="{{ route('auth.verify.post') }}" method="POST" onsubmit="return false">
        @csrf
        <div class="form-auth-login">
            <h2 class="text-uppercase text-center font-weight-bold">{{ __('auth.otp_header') }}</h2>
            <div class="form-group mb-2">
                <label for="enter_otp_code">{{ __('auth.enter_otp_code') }}</label>
                <input type="text" class="form-control" name="otp_code" id="enter_otp_code" autocomplete="off">
            </div>
            <div class="form-group text-right">
                <a href="#" class="color-href" onclick="Auth.reSendOtp()">{{ __("auth.btn_resend_otp") }}</a>
                <a href="{{ route('auth.logout.get') }}" class="color-href ml-2">{{ __("auth.logout") }}</a>
            </div>
            <div class="form-group text-center">
                <button class="btn btn-submit" onclick="Auth.checkOtp(this)">{{ __('auth.btn_verify') }}</button>
            </div>
        </div>
    </form>
@endsection
