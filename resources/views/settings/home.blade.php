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
            <li>
                <a href="{{ route('setting.kyc_account') }}" class="{{ $page == 'kyc_account' ? 'active' : 'active-bg' }}">
                    <img src="{{ asset('image/adm/icon/bonus-icon.png') }}" alt="KYC ACCOUNT">
                    <span>KYC ACCOUNT</span>
                </a>
            </li>
            <li>
                <a href="{{ route('setting.2fa') }}" class="{{ $page == '2fa' ? 'active' : 'active-bg' }}">
                    <img src="{{ asset('image/adm/icon/bonus-icon.png') }}" alt="2FA">
                    <span>2FA</span>
                </a>
            </li>
            <li>
                <a href="{{ route('setting.change_password') }}" class="{{ $page == 'change_password' ? 'active' : 'active-bg' }}">
                    <img src="{{ asset('image/adm/icon/bonus-icon.png') }}" alt="CHANGE PASSWORD">
                    <span>CHANGE PASSWORD</span>
                </a>
            </li>
            <li>
                <a href="{{ route('setting.kyc_withdraw') }}" class="{{ $page == 'kyc_withdraw' ? 'active' : 'active-bg' }}">
                    <img src="{{ asset('image/adm/icon/bonus-icon.png') }}" alt="KYC WITHDRAW">
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
@section('script')
    <script>
        $('.btn-active-2fa').on('click', function(){
            const areaInfo = $('.area-info-active-2fa');
            const areaDetail = $('.area-detail-active-2fa');
            Request.ajax('{{ route('generate-gg-auth') }}', function(result){
                if(result.success == false) {
                    return alert(result.message);
                }
                areaDetail.find('[name="serect"]')
                    .val(result.serect)
                    .next('button')
                    .attr('data-text', result.serect);
                areaDetail.find('.img-qr-auth-2fa div').html(result.image);
                areaInfo.hide(200);
                areaDetail.show(200);
            });
        });
        $('.btn-enable-2fa').on('click', function(){
            const form = this.closest('form');
            const formData = new FormData(form);
            Request.ajax('{{ route('enable-gg-auth') }}', formData, function (result) {
                alert(result.message);
                if(result.success) {
                    location.reload();
                }
            });
        });
        $('.btn-deactive-2fa').on('click', function(){
            if(!confirm('Are you sure deactive 2FA ?')) {
                return false;
            }
            Request.ajax('{{ route('deactive-gg-auth') }}', function (result) {
                alert(result.message);
                if(result.success) {
                    location.reload();
                }
            });
        });
    </script>
@endsection
