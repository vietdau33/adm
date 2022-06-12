@extends('layout')
@section("contents")
    <div class="menu-top menu-inline-blue text-center">
        <ul>
            <li>
                <a href="{{ route('setting.profile') }}" class="{{ $page == 'profile' ? 'active' : 'active-bg' }}">
                    <img src="{{ asset('image/adm/icon/profit-icon.png') }}" alt="Profile">
                    <span>PROFILE</span>
                </a>
            </li>
            {{--<li>--}}
            {{--    <a href="{{ route('setting.kyc_account') }}" class="{{ $page == 'kyc_account' ? 'active' : 'active-bg' }}">--}}
            {{--        <img src="{{ asset('image/adm/icon/bonus-icon.png') }}" alt="KYC ACCOUNT">--}}
            {{--        <span>KYC ACCOUNT</span>--}}
            {{--    </a>--}}
            {{--</li>--}}
            <li>
                <a href="{{ route('setting.2fa') }}" class="{{ $page == '2fa' ? 'active' : 'active-bg' }}">
                    <img src="{{ asset('image/adm/icon/profile-icon.png') }}" alt="2FA">
                    <span>2FA</span>
                </a>
            </li>
            <li>
                <a href="{{ route('setting.change_password') }}" class="{{ $page == 'change_password' ? 'active' : 'active-bg' }}">
                    <img src="{{ asset('image/adm/icon/profile-icon.png') }}" alt="CHANGE PASSWORD">
                    <span>CHANGE PASSWORD</span>
                </a>
            </li>
            <li>
                <a href="{{ route('setting.kyc_withdraw') }}" class="{{ $page == 'kyc_withdraw' ? 'active' : 'active-bg' }}">
                    <img src="{{ asset('image/adm/icon/profile-icon.png') }}" alt="KYC WITHDRAW">
                    <span>KYC WITHDRAW</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="content-setting">
        <div class="content-setting--box">
            @include("settings.$page")
        </div>
    </div>
@endsection
