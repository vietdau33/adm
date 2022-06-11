@php($histories = \App\Models\Withdraw::getHistories(10, true))
<div class="withdraw--box text-center">
    <div class="d-flex justify-content-center">
        <div class="small-box text-left p-3">
            @if(!empty(user()->google2fa_secret))
                <form action="" method="POST" onsubmit="return SubmitWithdraw.apply(this)">
                    <div class="alert alert-info">You current Wallet: <b>{{ user()->money->wallet }}</b></div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input
                            type="text"
                            name="amount"
                            id="amount"
                            class="form-control"
                            placeholder="0.00"
                            autocomplete="off"
                        />
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input
                            type="text"
                            name="address"
                            id="address"
                            class="form-control"
                            placeholder="0x2676fxxxx"
                            autocomplete="off"
                        />
                    </div>
                    <div class="form-group">
                        <label for="2fa_code">Auth Code (2FA)</label>
                        <input
                            type="text"
                            name="2fa_code"
                            id="2fa_code"
                            class="form-control"
                            placeholder="Enter 2FA code"
                            autocomplete="off"
                        />
                    </div>
                    <div class="text-center">
                        <button class="btn btn-success btn-gradient">Withdraw</button>
                    </div>
                </form>
            @else
                <div class="alert alert-warning mb-0">You need <a class="text-decoration-none" href="{{ route('setting.2fa') }}">active 2FA</a> before use withdraw!</div>
            @endif
        </div>
    </div>
    <div class="withdraw-history">
        <div class="d-flex align-items-center mb-3 mt-4">
            <img src="{{ asset('image/adm/icon/history.png') }}" alt="History" style="width: 42px">
            <h3 class="mb-0">HISTORY WITHDRAW</h3>
        </div>
        <form action="" method="GET">
            <div class="d-flex mb-3">
                <input
                    type="text"
                    style="width: 210px; max-width: 100%"
                    class="form-control mr-2 bs-datepicker"
                    placeholder="Start date"
                    name="start_date"
                    value="{{ request()->start_date ?? '' }}"
                    autocomplete="off"
                />
                <input
                    type="text"
                    style="width: 210px; max-width: 100%"
                    class="form-control mr-2 bs-datepicker"
                    placeholder="End date"
                    name="end_date"
                    value="{{ request()->end_date ?? '' }}"
                    autocomplete="off"
                />
                <button class="btn btn-success btn-gradient">Search</button>
                <button type="reset" class="btn btn-secondary btn-gradient ml-1">Clear</button>
            </div>
        </form>
        <div class="form-radius pb-1">
            <table class="table table-responsive-mg mb-0">
                <thead>
                <tr>
                    <th class="border-top-0" scope="col">No.</th>
                    <th class="border-top-0" scope="col">Amount</th>
                    <th class="border-top-0" scope="col">Address</th>
                    <th class="border-top-0" scope="col">Status</th>
                    <th class="border-top-0" scope="col">Created Date</th>
                </tr>
                </thead>
                <tbody>
                @php($count = 1)
                @foreach($histories->items() as $history)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $history->amount }}</td>
                        <td>{{ $history->address }}</td>
                        <td>{!! $history->getStatus() !!}</td>
                        <td>{{ __d($history->created_at, 'Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
                @if($histories->count() <= 0)
                    <tr>
                        <td colspan="5">No History</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {!! $histories->links('vendor.pagination.bootstrap') !!}
            </div>
        </div>
    </div>
</div>
<script>
    window.SubmitWithdraw = function () {
        const formData = new FormData(this);
        Request.ajax('{{ route('money.withdraw.post') }}', formData, function (result) {
            if(result.success) {
                alertify.alertSuccess('Success', result.message, () => location.reload());
            }else{
                alertify.alertDanger("Error", result.message);
            }
        });
        return false;
    }
</script>
