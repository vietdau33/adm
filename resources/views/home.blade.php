@extends('layout')
@section("contents")
    @if(!empty($banners['top']))
        @if(count($banners['top']) > 1)
            <div class="banner banner-top mb-3 position-relative">
                <section class="splide splide-banner splide-banner-top" aria-label="Banner Top Slide">
                    <div class="splide__track">
                        <ul class="splide__list align-items-center">
                            @foreach($banners['top'] as $banner)
                                <li class="splide__slide" style="overflow: hidden; border-radius: 14px">
                                    <img src="{{ asset('storage/banner/' . $banner->sp_path) }}" alt="Bg 1" class="w-100 d-lg-none">
                                    <img src="{{ asset('storage/banner/' . $banner->pc_path) }}" alt="Bg 1" class="w-100 d-none d-lg-block">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>
                <div class="overlay-daily-mission">
                    <h3>Daily Mission</h3>
                    <button class="btn btn-primary btn-gradient text-uppercase btn-view-daily">View</button>
                    <div class="close-icon">
                        <img src="{{ asset('image/adm/icon/close.svg') }}" class="w-100" alt="Close">
                    </div>
                </div>
            </div>
        @elseif(count($banners['top']) == 1)
            <div class="banner banner-top mb-3 position-relative">
                @php($bannerTop = $banners['top']->first())
                <img src="{{ asset('storage/banner/' . $bannerTop->sp_path) }}" alt="Bg 1" class="w-100 d-lg-none">
                <img src="{{ asset('storage/banner/' . $bannerTop->pc_path) }}" alt="Bg 1" class="w-100 d-none d-lg-block">
                @if($showDailyToday)
                    <div class="overlay-daily-mission">
                        <h3>Daily Mission</h3>
                        <button class="btn btn-primary btn-gradient text-uppercase btn-view-daily">View</button>
                        <div class="close-icon">
                            <img src="{{ asset('image/adm/icon/close.svg') }}" class="w-100" alt="Close">
                        </div>
                    </div>
                @endif
            </div>
        @endif
    @elseif($showDailyToday)
        <div class="banner banner-top mb-3 position-relative">
            <img src="{{ asset('image/adm/ai_bg.png') }}" alt="Bg 1" class="w-100 d-lg-none">
            <img src="{{ asset('image/adm/ai_bg_pc.png') }}" alt="Bg 1" class="w-100 d-none d-lg-block">
            <div class="overlay-daily-mission">
                <h3>Daily Mission</h3>
                <button class="btn btn-primary btn-gradient text-uppercase btn-view-daily">View</button>
                <div class="close-icon close-banner">
                    <img src="{{ asset('image/adm/icon/close.svg') }}" class="w-100" alt="Close">
                </div>
            </div>
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
    <div class="container">
        <div class="area-invest-activing form-radius mt-3 mb-3 pt-2">
            <h3>List Package Invest Activing</h3>
            <div class="table-list-invest">
                <table class="table table-responsive-md text-center mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Invest Package</th>
                        <th scope="col">Amount Buy</th>
                        <th scope="col">Profit</th>
                        <th scope="col">Days Left</th>
                        <th scope="col">Buy Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($stt = 1)
                    @foreach($invest_bought_activing as $package)
                        @php($diffDay = $package->days - diffDaysWithNow($package->created_at))
                        <tr>
                            <th scope="row">{{ $stt++ }}</th>
                            <td>{{ ucfirst($package->type) }}</td>
                            <td>{{ $package->money_buy }}</td>
                            <td>{{ $package->profit }} %</td>
                            @if($package->days == 0)
                                <td>Forever</td>
                            @else
                                <td>{{ $diffDay }} {{ $diffDay > 1 ? 'days' : 'day' }}</td>
                            @endif
                            <td>{{ __d($package->created_at, 'Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                    @if($invest_bought_activing->count() <= 0)
                        <tr>
                            <th colspan="5">No see any package activing!</th>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if(!empty($banners['center']))
        @if(count($banners['center']) > 1)
            <section class="mb-3 splide splide-banner splide-banner-center" aria-label="Banner Center Slide">
                <div class="splide__track">
                    <ul class="splide__list align-items-center">
                        @foreach($banners['center'] as $banner)
                            <li class="splide__slide" style="overflow: hidden; border-radius: 14px">
                                <img src="{{ asset('storage/banner/' . $banner->sp_path) }}" alt="Bg 1" class="w-100 d-lg-none">
                                <img src="{{ asset('storage/banner/' . $banner->pc_path) }}" alt="Bg 1" class="w-100 d-none d-lg-block">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        @else
            <div class="banner banner-center mb-3">
                @php($bannerCenter = $banners['center']->first())
                <img src="{{ asset('storage/banner/' . $bannerCenter->sp_path) }}" alt="Bg 1" class="w-100 d-lg-none">
                <img src="{{ asset('storage/banner/' . $bannerCenter->pc_path) }}" alt="Bg 1" class="w-100 d-none d-lg-block">
            </div>
        @endif
    @endif
    @if(user()->role == 'user')
        <div class="user-profile-card d-flex justify-content-around mb-3">
            <div class="area-qr-code">
                <div class="title-qr text-center">Referral Program</div>
                <div
                    class="box-qr d-flex justify-content-center"
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
        $('.splide-banner').each(function () {
            new Splide(this, {
                type: 'fade',
                perPage: 1,
                autoplay: true,
                interval: 3500,
                rewind: true,
                pagination: false,
                arrows: false,
                pauseOnHover: false
            }).mount();
        });

        $('.btn-buy-investment').on('click', function () {
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

        $('.overlay-daily-mission .close-icon').on('click', function() {
            const closeBanner = $(this).hasClass('close-banner');
            const parent = closeBanner ? $(this).closest('.banner') : $(this).parent();
            parent.fadeOut(300, function() {
                parent.remove();
            });
        });

        $('.btn-view-daily').on('click', function() {
            const callbackDaily = function(link) {
                Request.ajax('{{ route('user.daily-mission') }}', { link }, function(result) {
                    if(result.success) {
                        alertify.alertSuccess('Success', result.message, () => location.reload());
                    }else{
                        alertify.alertDanger("Error", result.message);
                    }
                });
            }
            Request.ajax('{{ route('get-link-daily') }}', function(result) {
                const link = result.datas.link;
                if(link == '') {
                    return alertify.alertDanger('Error', 'Link daily not exists! Please contact to ADMIN!');
                }
                window.open(link);
                callbackDaily(link);
            });
        });
    </script>
@endsection
