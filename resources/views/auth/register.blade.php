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
                    placeholder="abc@example.com"
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
                    placeholder="Michael Jackson"
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
                    placeholder="username"
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
                    placeholder="******"
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
                    placeholder="******"
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
                    placeholder="0123456789"
                />
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary btn-gradient" onclick="Auth.register(this)">{{ __('auth.btn_create') }}</button>
            </div>
            <div class="form-group mb-0 text-center">
                <a href="{{ route('auth.login.view') }}" class="color-href">{{ __("auth.has_one_account") }}</a>
            </div>
        </form>
    </div>
@endsection
