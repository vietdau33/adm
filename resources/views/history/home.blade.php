@extends('layout')
@section("contents")
    <div class="menu-top menu-inline-blue text-center">
        <ul>
            <li>
                <a href="{{ route('history.profit') }}" class="{{ $page == 'profit' ? 'active' : 'active-bg' }}">
                    <img src="{{ asset('image/adm/icon/profit-icon.png') }}" alt="PROFIT DAY">
                    <span>PROFIT DAY</span>
                </a>
            </li>
            <li>
                <a href="{{ route('history.bonus') }}" class="{{ $page == 'bonus' ? 'active' : 'active-bg' }}">
                    <img src="{{ asset('image/adm/icon/bonus-icon.png') }}" alt="DOWNLINE BONUS">
                    <span>DOWNLINE BONUS</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="content-money">
        <div class="content-money--box">
            @include("history.$page")
        </div>
    </div>
@endsection
