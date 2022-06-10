@extends('layout')
@section("contents")
    @if(!empty($banners['top']))
        <div class="banner banner-top mb-3">
            @php($bannerTop = $banners['top']->random(1)->first())
            <img src="{{ asset('storage/banner/' . $bannerTop->sp_path) }}" alt="Bg 1" class="w-100 d-lg-none">
            <img src="{{ asset('storage/banner/' . $bannerTop->pc_path) }}" alt="Bg 1" class="w-100 d-none d-lg-block">
        </div>
    @endif
    <div class="area-investment">
        <h3 class="invest-title">INVESTMENT PLAN</h3>
        <div class="investment-plan mb-3">
            @foreach(['bronze', 'silver', 'gold', 'platinum'] as $type)
                @php($setting = $settingProfit->{$type})
                <div class="invest-box invest-box-{{ $type }}">
                    <h5>{{ strtoupper($type) }}</h5>
                    <ul>
                        <li>Profit {{ $setting->profit }}% daily {{ $setting->days == 0 ? 'forever' : "for $setting->days days" }}</li>
                        @if($setting->days > 0)
                            <li>Total returns: {{ $setting->profit * $setting->days }}%</li>
                        @endif
                        <li>Withdraw: Instant</li>
                    </ul>
                    <button
                        class="btn btn-light btn-buy-investment btn-buy-investment--{{ $type }}"
                        data-min-amount="{{ $setting->min_amount }}"
                        data-type="{{ $type }}">
                        INVEST NOW
                    </button>
                </div>
            @endforeach
        </div>
    </div>
    @if(!empty($banners['center']))
        <div class="banner banner-center mb-3">
            @php($bannerCenter = $banners['center']->random(1)->first())
            <img src="{{ asset('storage/banner/' . $bannerCenter->sp_path) }}" alt="Bg 1" class="w-100 d-lg-none">
            <img src="{{ asset('storage/banner/' . $bannerCenter->pc_path) }}" alt="Bg 1" class="w-100 d-none d-lg-block">
        </div>
    @endif
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
                <a class="money-text" href="javascript:void(0)" data-toggle="modal" data-target="#transferBonusToWallet">
                    {{ number_format(user()->money->bonus, 2) }}
                </a>
            </div>
            <div class="box-money money-profit m-1">
                <p class="mb-0">Total Profit</p>
                <a class="money-text" href="javascript:void(0)" data-toggle="modal" data-target="#transferProfitToWallet">
                    {{ number_format(user()->money->profit, 2) }}
                </a>
            </div>
            <div class="box-money money-wallet m-1">
                <p class="mb-0">Wallet</p>
                <a class="money-text" href="javascript:void(0)">
                    {{ number_format(user()->money->wallet, 2) }}
                </a>
            </div>
        </div>
    @endif
@endsection

@section('modal')
    @include('modals.buy-investment')
    @include('modals.transfer-bonus-to-wallet')
    @include('modals.transfer-profit-to-wallet')
@endsection

@section('script')
    <script>
        $('.btn-buy-investment').on('click', function() {
            const type = $(this).attr('data-type');
            const minAmount = $(this).attr('data-min-amount');
            const modal = $('#buyInvestmentModal');
            modal.find('.name-invest').text(type.toUpperCase());
            modal.find('.min-invest').text(minAmount);
            modal.find('[name="type"]').val(type);
            modal.find('.modal-header').removeClassStartWith('btn-buy-investment--').addClass('btn-buy-investment--' + type);
            modal.find('.btn-submit-buy-invest').removeClassStartWith('btn-buy-investment--').addClass('btn-buy-investment--' + type);
            modal.modal();
        });
    </script>
@endsection
