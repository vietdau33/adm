@php($usdt = user()->usdt)
@php($histories = \App\Models\DepositLogs::getDepositHistories(10, true))
<div class="deposit--box text-center">
    <div class="d-flex justify-content-center">
        <div class="small-box">
            @if($usdt == null)
                <div class="alert alert-info">
                    We are creating a wallet for you, please wait a moment!
                </div>
            @else
                <h2 class="text-center">Choose coin Deposit</h2>
                <div class="alert alert-warning">Minimum deposit 20 USDT</div>
                <div class="alert alert-warning">Only send USDT BEP20, BNB BEP20 to this address.</div>
                <div class="qr-code-box">
                    <div
                        class="d-flex justify-content-center mt-3 mb-3"
                        data-qr-width="160"
                        data-qr-height="160"
                        data-qr="{{ $usdt->token }}"></div>
                    <h3>QR CODE</h3>
                </div>
                <div class="input-canable-copy group-deposit-text mb-3">
                    <input type="text" id="btn-deposit-text" class="form-control" value="{{ $usdt->token }}" disabled>
                    <button onclick="Home.copyTextRaw('{{ $usdt->token }}', () => alertify.success('Copy Success'))">
                        <img src="{{ asset('image/adm/icon/copy-icon.png') }}" alt="Copy" class="w-100">
                    </button>
                </div>
                <div class="alert alert-warning">Sending any other asset to this address may result in the loss of your deposit!</div>
                <div class="alert alert-warning mb-0">After receiving the payment order. It will take a while for us to authenticate. After 5 minutes of not receiving money in your wallet, please contact ADMIN immediately.</div>
            @endif
        </div>
    </div>
    <div class="deposit-history">
        <div class="d-flex align-items-center mb-3 mt-4">
            <img src="{{ asset('image/adm/icon/history.png') }}" alt="History" style="width: 42px">
            <h3 class="mb-0">HISTORY DEPOSIT</h3>
        </div>
        <div class="d-flex flex-wrap mb-3">
            <input type="text" style="width: 210px; max-width: 100%" class="form-control mr-2 mb-1" value="{{ date('Y-m-d') }}">
            <input type="text" style="width: 210px; max-width: 100%" class="form-control mr-2 mb-1" value="{{ date('Y-m-d') }}">
            <button class="btn btn-success btn-gradient mb-1">Search</button>
        </div>
        <div class="form-radius">
            <table class="table table-responsive-md mb-0">
                <thead>
                <tr>
                    <th class="border-top-0" scope="col">No.</th>
                    <th class="border-top-0" scope="col">From</th>
                    <th class="border-top-0" scope="col">Amount</th>
                    <th class="border-top-0" scope="col">Date</th>
                </tr>
                </thead>
                <tbody>
                @php($count = 1)
                @foreach($histories as $history)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $history->from }}</td>
                        <td>{{ number_format($history->amount, 2) }}</td>
                        <td style="min-width: 140px">{{ __d($history->created_at) }}</td>
                    </tr>
                @endforeach
                @if($histories->count() <= 0)
                    <tr>
                        <td colspan="5">No History</td>
                    </tr>
                @endif
                </tbody>
            </table>
            {!! $histories->links('vendor.pagination.bootstrap') !!}
        </div>
    </div>
</div>
