@php($histories = \App\Models\BonusLogs::getUserBonusHistories(10, true))
<div class="bonus--box text-center">
    <div class="bonus-history mt-3">
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
            <table class="table table-responsive-xl mb-0">
                <thead>
                <tr>
                    <th class="border-top-0" scope="col">No.</th>
                    <th class="border-top-0" scope="col">Date</th>
                    <th class="border-top-0" scope="col">Bonus From</th>
                    <th class="border-top-0" scope="col">Level</th>
                    <th class="border-top-0" scope="col">Rate</th>
                    <th class="border-top-0" scope="col">Amount</th>
                </tr>
                </thead>
                <tbody>
                @php($count = 1)
                @foreach($histories->items() as $history)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td style="min-width: 140px">{{ __d($history->created_at, 'Y-m-d H:i') }}</td>
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
</div>
