@extends('layout')
@section("contents")
    <div class="area-internal-transfer area-transfer">
        <div class="title-form text-center">
            <h2 class="color-white font-weight-bold">Crypto Withdraw</h2>
        </div>
        <div class="form-transfer">
            <form action="{{ route('user.crypto-withdraw.post') }}" method="POST" onsubmit="return false">
                @csrf
                <input type="hidden" id="type_form" value="withdraw">
                <div class="form-group">
                    <label for="crypto-method">Choose Method</label>
                    <select name="method" id="crypto-method" class="form-control" onchange="Crypto.onChangeMethodSelect(this)">
                        @foreach($methodCryptoSetting as $method)
                            <option value="{{ $method }}">{{ $method }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="crypto-amount">Amount</label>
                    <div class="rate-crypto-change mb-2"></div>
                    <input type="hidden" name="rate">
                    <div class="form-group d-flex div-crypto-amount">
                        <input
                            type="text"
                            class="form-control w-45"
                            id="crypto-amount"
                            placeholder="Enter Amount"
                            name="amount"
                            onchange="Crypto.onChangeAmountCypto(this)"
                            oninput="Crypto.onChangeAmountCypto(this)"
                        />
                        <div class="text-center w-10" style="padding: .375rem .75rem;">
                            <img src="{{ asset('image/transfer.svg') }}" alt="Transfer" class="w-100">
                        </div>
                        <input type="text" class="form-control w-45" id="crypto-amount-prev" readonly value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label for="crypto-address">To Address</label>
                    <input type="text" class="form-control" id="crypto-address" placeholder="To Address" name="to">
                </div>
                <div class="form-group">
                    <label for="note">Note</label>
                    <input type="text" class="form-control" id="note" placeholder="Enter Note" name="note">
                </div>
                <div class="form-group">
                    <label for="otp_code">OTP</label>
                    <div class="group-input d-flex">
                        <input type="text" class="form-control" id="otp_code" placeholder="Enter OTP" name="otp_code">
                        <input type="hidden" id="otp_key" name="otp_key">
                        <button class="btn btn-success btn-get-otp" onclick="Main.getOtpTransfer()">Get OTP</button>
                    </div>
                </div>
                <div class="form-group mb-0 text-center">
                    <button class="btn btn-primary btn-transfer" onclick="Main.submitTransfer(this)">Withdraw</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/crypto.js') }}"></script>
    <script>
        window.rateCyptoSetting = {!! json_encode($rateCryptoSetting) !!}
        $(function(){
            $("#crypto-method").trigger("change");
        });
    </script>
@endsection
