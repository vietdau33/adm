<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="area-content">
                    <div class="content-header">
                        <h3>Change Password</h3>
                    </div>
                    <hr>
                    <div class="content-body">
                        <form action="{{ route('auth.changepassword.post') }}" method="POST" onsubmit="return false">
                            <div class="form-group">
                                <label for="current-password" class="font-weight-bold">Current Password</label>
                                <input type="password" class="form-control" name="current-password" id="current-password" placeholder="Enter Current Password">
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="password" class="font-weight-bold">New Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter New Password">
                            </div>
                            <div class="form-group">
                                <label for="re-password" class="font-weight-bold">Confirm New Password</label>
                                <input type="password" class="form-control" name="re-password" id="re-password" placeholder="Re-Enter New Password">
                            </div>
                            <div class="form-group">
                                <label for="otp_code" class="font-weight-bold">OTP</label>
                                <div class="group-input d-flex">
                                    <input type="text" class="form-control mr-2" id="otp_code" placeholder="Enter OTP" name="otp_code">
                                    <input type="hidden" id="otp_key" name="otp_key">
                                    <button class="btn btn-success btn-get-otp" onclick="Main.getOtpTransfer()">Get OTP</button>
                                </div>
                            </div>
                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary" onclick="Main.changePassword(this)">Change</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
