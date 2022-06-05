@extends("auth.base")
@section('form-auth')
    <div class="form-auth-login">
        <form action="{{ route('auth.register.post') }}" method="POST" onsubmit="return false;">
            @csrf
            <h2 class="text-uppercase text-center font-weight-bold">{{ __('auth.create_accout') }}</h2>
            <h5 class="text-center">Create New Account</h5>
            @if(request()->get('ref'))
                <div class="form-group">
                    <label for="reflink">{{ __('auth.reflink') }}</label>
                    <input type="text" class="form-control" name="reflink" id="reflink" value="{{ request()->get('ref') }}" readonly>
                </div>
            @endif
            <div class="form-group">
                <label for="enter_email">{{ __('auth.enter_email') }}</label>
                <input
                    type="text"
                    class="form-control"
                    name="email"
                    id="enter_email"
                    autocomplete="off"
                    inline-input
                />
            </div>
            <div class="form-group">
                <label for="enter_fullname">{{ __('auth.enter_fullname') }}</label>
                <input
                    type="text"
                    class="form-control"
                    name="fullname"
                    id="enter_fullname"
                    autocomplete="off"
                    inline-input
                />
            </div>
            <div class="form-group">
                <label for="enter_username">{{ __('auth.enter_username') }}</label>
                <input
                    type="text"
                    class="form-control"
                    name="username"
                    id="enter_username"
                    autocomplete="off"
                    inline-input
                />
            </div>
            <div class="form-group">
                <label for="enter_password">{{ __('auth.enter_password') }}</label>
                <input
                    type="password"
                    class="form-control"
                    name="password"
                    id="enter_password"
                    autocomplete="off"
                    inline-input
                />
            </div>
            <div class="form-group">
                <label for="enter_re_password">{{ __('auth.enter_re_password') }}</label>
                <input
                    type="password"
                    class="form-control"
                    name="password-confirm"
                    id="enter_re_password"
                    autocomplete="off"
                    inline-input
                />
            </div>
            <div class="form-group">
                <label for="enter_phone">{{ __('auth.enter_phone') }}</label>
                <input
                    type="text"
                    class="form-control number-only"
                    name="phone"
                    id="enter_phone"
                    autocomplete="off"
                    inline-input
                />
            </div>
            <div class="form-group">
                <label for="enter_birthday">Date of Birthday</label>
                <input
                    type="text"
                    class="form-control datepicker"
                    name="birthday"
                    id="enter_birthday"
                    autocomplete="off"
                    inline-input
                />
            </div>
            <div class="form-group text-center">
                <button class="btn btn-submit" onclick="Auth.register(this)">{{ __('auth.btn_create') }}</button>
            </div>
            <div class="form-group mb-0 text-right">
                <a href="{{ route('auth.login.view') }}" class="color-href">{{ __("auth.has_one_account") }}</a>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $('#enter_birthday').datepicker({
            dateFormat: "yy/mm/dd",
            changeMonth: true,
            changeYear: true,
            defaultDate: "2000/01/01",
            duration: "slow",
            yearRange : "1900:2022"
        });
    </script>
@endsection
