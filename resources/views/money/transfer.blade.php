@php($histories = \App\Models\Transfer::getHistories(10, true))
<div class="withdraw--box text-center">
    <div class="d-flex justify-content-center">
        <div class="small-box text-left p-3">
            @if(!empty(user()->google2fa_secret))
                <form action="" method="POST" onsubmit="return SubmitTransfer.apply(this)">
                    <div class="alert alert-info">You current Wallet: <b>{{ user()->money->wallet }}</b></div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" name="amount" id="amount" class="form-control" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label for="username_receive">Username Receive</label>
                        <input
                            type="text"
                            name="username_receive"
                            id="username_receive"
                            class="form-control"
                            placeholder="username"
                            onchange="OnChangeUsernameReceive.apply(this)"
                        />
                    </div>
                    <div class="form-group">
                        <label for="fullname">Fullname</label>
                        <input type="text" id="fullname" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="2fa_code">Auth Code (2FA)</label>
                        <input type="text" name="2fa_code" id="2fa_code" class="form-control" placeholder="Enter 2FA code">
                    </div>
                    <div class="text-center">
                        <button class="btn btn-success btn-gradient">Confirm</button>
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
            <h3 class="mb-0">HISTORY TRANSFER</h3>
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
        <div class="form-radius">
            <table class="table table-responsive-md">
                <thead>
                <tr>
                    <th class="border-top-0" scope="col">No.</th>
                    <th class="border-top-0" scope="col">Flag</th>
                    <th class="border-top-0" scope="col">From / To</th>
                    <th class="border-top-0" scope="col">Amount</th>
                    <th class="border-top-0" scope="col">Created Date</th>
                </tr>
                </thead>
                <tbody>
                @php($count = 1)
                @foreach($histories->items() as $history)
                    @php($isSend = $history->user_id == user()->id)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $isSend ? 'Send' : 'Receive' }}</td>
                        <td>{{ $history->user_receive->username ?? '' }}</td>
                        <td>
                            @if($isSend)
                                <span class="text-danger">-{{ $history->amount }}</span>
                            @else
                                <span class="text-success">+{{ $history->amount }}</span>
                            @endif
                        </td>
                        <td>{{ __d($history->created_at, 'Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
                @if($histories->count() <= 0)
                    <tr>
                        <td colspan="5">No History Transfer</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    window.SubmitTransfer = function () {
        const formData = new FormData(this);
        Request.ajax('{{ route('money.transfer.post') }}', formData, function (result) {
            if (result.success) {
                alertify.alertSuccess('Success', result.message, () => location.reload());
            } else {
                alertify.alertDanger("Error", result.message);
            }
        });
        return false;
    }
    window.OnChangeUsernameReceive = function () {
        const username = this.value.trim();
        const $fieldName = $('#fullname');
        Request.ajax('{{ route('user.get-fullname') }}', { username }, function (result) {
            $fieldName.val(result.datas.fullname);
        });
    }
</script>
