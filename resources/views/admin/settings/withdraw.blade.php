@php($setting = $settings['withdraw']->setting ?? null)
<div class="area-withdraw--list mt-3">
    <div class="form-radius form-mini-size pt-3">
        <form action="" method="POST" onsubmit="return SubmitSaveSettingWithdraw.apply(this)">
            <div class="form-group">
                <label for="withdraw_fee">Withdraw Fee</label>
                <input type="text" class="form-control" id="withdraw_fee" name="fee" value="{{ $setting->fee ?? 0 }}" placeholder="0">
            </div>
            <div class="text-center">
                <button class="btn btn-success btn-gradient">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
    window.SubmitSaveSettingWithdraw = function () {
        const formData = new FormData(this);
        Request.ajax('{{ route('admin.settings.withdraw.save') }}', formData, function (result) {
            if (result.success) {
                alertify.success(result.message);
            } else {
                alertify.error(result.message);
            }
        });
        return false;
    }
</script>
