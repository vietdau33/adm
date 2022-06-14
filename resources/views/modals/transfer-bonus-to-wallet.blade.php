<div class="modal fade" id="transferBonusToWallet" tabindex="-1" role="dialog" aria-labelledby="transferBonusToWallet" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="area-content">
                    <div class="content-header">
                        <h3>Transfer Bonus To Wallet</h3>
                    </div>
                    <hr>
                    <div class="content-body">
                        <form action="" method="POST" onsubmit="return false">
                            <div class="form-group">
                                <label for="amount" class="font-weight-bold">Amount</label>
                                <input type="text" class="form-control number-only" name="amount" placeholder="Enter Amount">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary btn-gradient text-uppercase" onclick="transferBonusToWallet.apply(this)">
                                    Transfer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.transferBonusToWallet = function () {
        const $form = $(this).closest('form');
        const amount = $form.find('[name="amount"]').val().trim();
        Request.ajax('{{ route('user.transfer.bonus') }}', {amount}, function (result) {
            alert(result.message);
            if (result.success) {
                location.reload();
            }
        })
    }
</script>
