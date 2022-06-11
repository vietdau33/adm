@extends('layout')
@section("contents")
    <div class="menu-top menu-inline-blue text-center">
        <ul>
            {{--<li>--}}
            {{--    <a href="{{ route('money.deposit') }}" class="{{ $page == 'deposit' ? 'active' : '' }}">--}}
            {{--        <img src="{{ asset('image/adm/icon/deposit-icon.png') }}" alt="DEPOSIT">--}}
            {{--        <span>DEPOSIT</span>--}}
            {{--    </a>--}}
            {{--</li>--}}
            <li>
                <a href="{{ route('money.withdraw') }}" class="{{ $page == 'withdraw' ? 'active' : '' }}">
                    <img src="{{ asset('image/adm/icon/withdraw-icon.png') }}" alt="WITHDRAW">
                    <span>WITHDRAW</span>
                </a>
            </li>
            <li>
                <a href="{{ route('money.transfer') }}" class="{{ $page == 'transfer' ? 'active' : '' }}">
                    <img src="{{ asset('image/adm/icon/transfer-icon.png') }}" alt="TRANSFER">
                    <span>TRANSFER</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="content content-money">
        <div class="content-money--box">
            @include("money.$page")
        </div>
    </div>
@endsection
