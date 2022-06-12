<div class="setting--box container text-center">
    @if(!empty(user()->google2fa_secret))
        <form action="" method="POST" onsubmit="return SubmitChangeAddressWithdraw.apply(this)">
            <div class="form-group">
                <label for="usdt_token">USDT Token Address</label>
                <input
                    type="text"
                    class="form-control text-center"
                    id="usdt_token"
                    name="usdt_token"
                    value="{{ user()->addr_crypto ?? '' }}"
                    placeholder="0x19abcdxxxx"
                    autocomplete="off"
                    onfocus="this.select()"
                />
            </div>
            <div class="form-group">
                <label for="2fa_code">Auth Code (2FA)</label>
                <input
                    type="text"
                    name="2fa_code"
                    id="2fa_code"
                    class="form-control text-center"
                    placeholder="Enter 2FA code"
                    autocomplete="off"
                />
            </div>
            <div class="text-center">
                <button class="btn btn-primary btn-gradient">Update</button>
            </div>
        </form>
    @else
        <div class="alert alert-warning mb-0">You need <a class="text-decoration-none" href="{{ route('setting.2fa') }}">active 2FA</a> before setting address withdraw!</div>
    @endif
</div>
<script>
    window.SubmitChangeAddressWithdraw = function () {
        const formData = new FormData(this);
        Request.ajax('{{ route('setting.kyc_withdraw.save') }}', formData, function (result) {
            if(result.success) {
                alertify.alertSuccess('Success', result.message, () => location.reload());
            }else{
                alertify.alertDanger("Error", result.message);
            }
        });
        return false;
    }
</script>
