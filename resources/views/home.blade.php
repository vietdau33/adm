@extends('layout')
@section("contents")
    <div class="banner-top mb-3">
        <img src="{{ asset('image/adm/bg_1.jpg') }}" alt="Bg 1" class="w-100">
    </div>
    <div class="area-advertisement area-advertisement-top mb-3">
        <h3>Banner Quảng cáo PC: cao = 540px</h3>
    </div>
    <div class="area-investment">
        <h3 class="invest-title">INVESTMENT PLAN</h3>
        <div class="investment-plan mb-3">
            <div class="invest-box invest-box-bronze">
                <h5>BRONZE</h5>
                <ul>
                    <li>Profit 0.5% daily forever</li>
                    <li>Withdraw: Instant</li>
                </ul>
                <button class="btn btn-light">INVEST NOW</button>
            </div>
            <div class="invest-box invest-box-silver">
                <h5>SILVER</h5>
                <ul>
                    <li>Profit 1.3% daily for 90 days</li>
                    <li>Total returns: 117%</li>
                    <li>Withdraw: Instant</li>
                </ul>
                <button class="btn btn-light">INVEST NOW</button>
            </div>
            <div class="invest-box invest-box-gold">
                <h5>GOLD</h5>
                <ul>
                    <li>Profit 0.8% daily for 180 days</li>
                    <li>Total returns: 144%</li>
                    <li>Withdraw: Instant</li>
                </ul>
                <button class="btn btn-light">INVEST NOW</button>
            </div>
            <div class="invest-box invest-box-platinum">
                <h5>PLATINUM</h5>
                <ul>
                    <li>Profit 0.7% daily for 270 days</li>
                    <li>Total returns: 189%</li>
                    <li>Withdraw: Instant</li>
                </ul>
                <button class="btn btn-light">INVEST NOW</button>
            </div>
        </div>
    </div>
    <div class="area-advertisement area-advertisement-body mb-3">
        <div class="img-advertisement">
            <img src="{{ asset('image/adm/meta_1.jpg') }}" alt="Advertisement" class="w-100">
        </div>
    </div>
    @if(user()->role == 'user')
        <div class="user-profile-card d-flex justify-content-around mb-3">
            <div class="area-qr-code">
                <div class="title-qr text-center">Referral Program</div>
                <div
                    class="box-qr"
                    data-qr="{{ route('reflink', user()->reflink) }}"
                    data-qr-width="290"
                    data-qr-height="290"></div>
                <div class="link-qr text-center">
                    <p class="mb-2">{{ route('reflink', user()->reflink) }}</p>
                    <button
                        class="btn btn-success btn-gradient"
                        data-text="{{ route('reflink', user()->reflink) }}"
                        onclick="Home.copyReflinkWithButton(this)">
                        {{ __("home.btn-copy") }}
                    </button>
                </div>
            </div>
        </div>
        <div class="settings-display">
            <div class="box-money money-ib m-1">
                <p class="mb-0">Total bonus</p>
                <a class="money-text" href="javascript:void(0)" data-toggle="modal" data-target="#transferIBToWallet">
                    {{ number_format((float)user('money_ib', 0), 2) }}
                </a>
            </div>
            <div class="box-money money-profit m-1">
                <p class="mb-0">Total Profit</p>
                <a class="money-text" href="javascript:void(0)" data-toggle="modal">
                    {{ number_format((float)user('money_profit', 0), 2) }}
                </a>
            </div>
            <div class="box-money money-wallet m-1">
                <p class="mb-0">Wallet</p>
                <a class="money-text" href="javascript:void(0)" data-toggle="modal">
                    {{ number_format((float)user('money_wallet', 0), 2) }}
                </a>
            </div>
        </div>
    @endif
@endsection

@section('modal')
    @include('modals.change-password')
    @include('modals.transfer-to-invest')
    @include('modals.transfer-ib-to-wallet')
    @include("modals.member-detail")
@endsection
