<div class="modal fade" id="buyInvestmentModal" tabindex="-1" role="dialog" aria-labelledby="buyInvestmentModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="color: #fff">Buy Investment: <span class="name-invest"></span></h3>
            </div>
            <div class="modal-body">
                <div class="area-content">
                    <form action="" method="POST" onsubmit="return SubmitBuyInvestment.apply(this)">
                        <div class="alert alert-warning">The amount money to buy the package must be greater than or equal to <b class="min-invest"></b></div>
                        <input type="hidden" name="type" value="">
                        <div class="form-group">
                            <label for="current-password" class="font-weight-bold">Enter Amount</label>
                            <input type="text" class="form-control number-only" name="amount">
                        </div>
                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-gradient border-0 btn-submit-buy-invest">Buy Invest</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.SubmitBuyInvestment = function () {
        const formData = new FormData(this);
        Request.ajax('{{ route('user.buy-invest') }}', formData, function (result) {
            if(result.success) {
                alertify.alertSuccess('Success', result.message, () => location.reload());
            }else{
                alertify.alertDanger("Error", result.message);
            }
        });
        return false;
    }
</script>
