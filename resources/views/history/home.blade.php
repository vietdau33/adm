@extends('layout')
@section("contents")
    <div class="menu-top menu-inline-blue text-center">
        <ul>
            <li class="mb-1">
                <a href="{{ $page == 'profit' ? '#' : route('history.profit') }}" class="{{ $page == 'profit' ? 'active' : 'active-bg' }}">
                    <img src="{{ asset('image/adm/icon/profit-icon.png') }}" alt="PROFIT DAY">
                    <span>PROFIT DAY</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ $page == 'bonus' ? '#' : route('history.bonus') }}" class="{{ $page == 'bonus' ? 'active' : 'active-bg' }}">
                    <img src="{{ asset('image/adm/icon/bonus-icon.png') }}" alt="DOWNLINE BONUS">
                    <span>DOWNLINE BONUS</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ $page == 'daily_mission' ? '#' : route('history.daily_mission') }}" class="{{ $page == 'daily_mission' ? 'active' : 'active-bg' }}">
                    <img src="{{ asset('image/adm/icon/profit-icon.png') }}" alt="DAILY MISSION">
                    <span>DAILY MISSION</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="content-history">
        <div class="content-history--box">
            @include("history.$page")
        </div>
    </div>
@endsection
