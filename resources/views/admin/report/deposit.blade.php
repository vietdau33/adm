@php($histories = \App\Models\DepositLogs::getDepositHistories(10, true))
<div class="deposit-history mt-3">
    <form action="" method="GET">
        <div class="d-flex flex-wrap mb-3">
            <input
                type="text"
                style="width: 210px; max-width: 100%"
                class="form-control mr-2 mb-1"
                name="username"
                value="{{ request()->username ?? '' }}"
                autocomplete="off"
                placeholder="Username"
            />
            <input
                type="text"
                style="width: 210px; max-width: 100%"
                class="form-control mr-2 mb-1 bs-datepicker"
                placeholder="Start date"
                name="start_date"
                value="{{ request()->start_date ?? '' }}"
                autocomplete="off"
            />
            <input
                type="text"
                style="width: 210px; max-width: 100%"
                class="form-control mr-2 mb-1 bs-datepicker"
                placeholder="End date"
                name="end_date"
                value="{{ request()->end_date ?? '' }}"
                autocomplete="off"
            />
            <button class="btn btn-success btn-gradient mb-1">Search</button>
            <button type="reset" class="btn btn-secondary btn-gradient mb-1 ml-1">Clear</button>
        </div>
    </form>
    <div class="form-radius">
        <table class="table table-responsive-md mb-0 text-center">
            <thead>
            <tr>
                <th class="border-top-0" scope="col">No.</th>
                <th class="border-top-0" scope="col">User</th>
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
                    <td>{{ $history->user->username }}</td>
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
