@php($histories = \App\Models\BonusLogs::getUserBonusHistories(10, true))
<div class="profit--box text-center">
    <div class="profit-history mt-3">
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
        <table class="table table-striped" style="background: #fff">
            <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Date</th>
                <th scope="col">Bonus From</th>
                <th scope="col">Level</th>
                <th scope="col">Rate</th>
                <th scope="col">Amount</th>
            </tr>
            </thead>
            <tbody>
            @php($count = 1)
            @foreach($histories->items() as $history)
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ __d($history->created_at) }}</td>
                    <td>{{ $history->userForm->username }}</td>
                    <td>{{ $history->userForm->level - user()->level }}</td>
                    <td>{{ $history->rate }} %</td>
                    <td>{{ number_format($history->money_bonus, 2) }}</td>
                </tr>
            @endforeach
            @if($histories->count() <= 0)
                <tr>
                    <td colspan="6">No History</td>
                </tr>
            @endif
            </tbody>
        </table>
        {!! $histories->links('vendor.pagination.bootstrap') !!}
    </div>
</div>
