<div class="modal fade" id="transferToInvest" tabindex="-1" role="dialog" aria-labelledby="transferToInvest" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="area-content">
                    <div class="content-header">
                        <h3>Transfer To Invest</h3>
                    </div>
                    <hr>
                    <div class="content-body">
                        <form action="{{ route('user.transfer-to-invest.post') }}" method="POST" onsubmit="return false">
                            <div class="form-group">
                                <label for="amount" class="font-weight-bold">Amount</label>
                                <input type="number" class="form-control not-show-arrow" name="amount" placeholder="Enter Amount">
                            </div>
                            <div class="form-group mb-0">
                                <button class="btn btn-primary text-uppercase" onclick="Main.transferToInvest(this)">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
