<div class="setting--box container">
    <form action="{{ route('auth.changepassword.post') }}" method="POST" onsubmit="return false">
        <div class="form-group">
            <label for="current-password">Current Password</label>
            <input type="password" class="form-control" name="current-password" id="current-password" placeholder="******">
        </div>
        <hr>
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="******">
        </div>
        <div class="form-group">
            <label for="re-password">Confirm New Password</label>
            <input type="password" class="form-control" name="re-password" id="re-password" placeholder="******">
        </div>
        {{--<div class="form-group">--}}
        {{--    <label for="otp_code">OTP</label>--}}
        {{--    <div class="group-input d-flex">--}}
        {{--        <input type="text" class="form-control mr-2" id="otp_code" placeholder="Enter OTP" name="otp_code">--}}
        {{--        <input type="hidden" id="otp_key" name="otp_key">--}}
        {{--        <button class="btn btn-success btn-get-otp" onclick="Main.getOtpTransfer()">Get OTP</button>--}}
        {{--    </div>--}}
        {{--</div>--}}
        <div class="form-group mb-0 text-center">
            <button class="btn btn-primary btn-gradient" onclick="Main.changePassword(this)">Update</button>
        </div>
    </form>
</div>
