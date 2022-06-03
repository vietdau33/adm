@extends('layout')
@section("contents")
    <div class="table-content-custom container-fluid">
        <div class="box-setting box-setting-interest">
            <h3 class="heading p-3">Edit Interest Rate</h3>
            <form action="{{ route('admin.settings.save-system-setting') }}" method="POST" onsubmit="return false">
                <input type="hidden" name="type" value="interest-rate">
                <div class="row box-info-setting p-2">
                    <div class="col-4 d-flex justify-content-center">
                        <span>3 months</span>
                        <input type="number" min="0" max="20" name="3month" class="form-control input-number-setting" value="{{ $systemSetting->interest_rate_3month ?? 5 }}">
                        <span class="pl-1">%</span>
                    </div>
                    <div class="col-4 d-flex justify-content-center">
                        <span>6 months</span>
                        <input type="number" min="0" max="20" name="6month" class="form-control input-number-setting" value="{{ $systemSetting->interest_rate_6month ?? 5 }}">
                        <span class="pl-1">%</span>
                    </div>
                    <div class="col-4 d-flex justify-content-center">
                        <span>12 months</span>
                        <input type="number" min="0" max="20" name="12month" class="form-control input-number-setting" value="{{ $systemSetting->interest_rate_12month ?? 5 }}">
                        <span class="pl-1">%</span>
                    </div>
                </div>
                <div class="row justify-content-center p-3">
                    <button class="btn btn-success btn-submit" onclick="Admin.saveSystemSetting(this)">Submit</button>
                </div>
            </form>
        </div>
        <div class="box-setting box-setting-bonus mt-4">
            <h3 class="heading p-3">Edit Bonus</h3>
            <form action="{{ route('admin.settings.save-system-setting') }}" method="POST" onsubmit="return false">
                <input type="hidden" name="type" value="bonus">
                <div class="row box-info-setting p-2">
                    <div class="col-6 d-flex justify-content-center">
                        <span>Referral bonus</span>
                        <input type="number" min="0" max="20" name="referral-bonus" class="form-control input-number-setting" value="{{ $systemSetting->{"solo-referral-bonus"} ?? 5 }}">
                        <span class="pl-1">%</span>
                    </div>
                    <div class="col-6 d-flex justify-content-center">
                        <span>Verify bonus</span>
                        <input type="number" min="0" max="100" name="verify-bonus" class="form-control input-number-setting" value="{{ $systemSetting->{"solo-verify-bonus"} ?? 100 }}">
                    </div>
                </div>
                <div class="row justify-content-center p-3">
                    <button class="btn btn-success btn-submit" onclick="Admin.saveSystemSetting(this)">Submit</button>
                </div>
            </form>
        </div>
        <div class="box-setting box-setting-bonus mt-4">
            <h3 class="heading p-3">Edit Withdraw</h3>
            <form action="{{ route('admin.settings.save-system-setting') }}" method="POST" onsubmit="return false">
                <input type="hidden" name="type" value="withdraw">
                <div class="row box-info-setting p-2">
                    <div class="col-6 d-flex justify-content-center">
                        <span>Number of days:</span>
                        <input type="number" min="0" max="100" name="number-of-day" class="form-control input-number-setting" value="{{ $systemSetting->{"number-of-day"} ?? 30 }}">
                    </div>
                    <div class="col-6 d-flex justify-content-center">
                        <span>Withdraw Rate:</span>
                        <input type="number" min="0" max="100" name="withdraw-rate" class="form-control input-number-setting" value="{{ $systemSetting->{"withdraw-rate"} ?? 100 }}">
                        <span class="pl-1">%</span>
                    </div>
                </div>
                <div class="row justify-content-center p-3">
                    <button class="btn btn-success btn-submit" onclick="Admin.saveSystemSetting(this)">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
