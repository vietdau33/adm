@extends('layout')
@section("contents")
    <div class="area-internal-transfer area-transfer">
        <div class="title-form text-center">
            <h2 class="color-white font-weight-bold">Internal Transfer</h2>
        </div>
        <div class="form-transfer">
            <form action="{{ route('user.submit-transfer.post') }}" method="POST" onsubmit="return false">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" placeholder="{{ __("auth.enter_email") }}" name="email">
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="text" class="form-control" id="amount" placeholder="Enter Amount" name="amount">
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
                    <button class="btn btn-primary btn-transfer hidden" onclick="Main.submitTransfer(this)">Transfer</button>
                </div>
            </form>
        </div>
    </div>
@endsection
