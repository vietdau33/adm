@php($histories = \App\Models\DailyMissionLogs::getDailyMissionHistories())
@php($today = \Carbon\Carbon::today()->format('Y-m-d'))
@php($prevWeek = \Carbon\Carbon::today()->subWeek()->format('Y-m-d'))
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
                    value="{{ request()->start_date ?? $prevWeek }}"
                    autocomplete="off"
                />
                <input
                    type="text"
                    style="width: 210px; max-width: 100%"
                    class="form-control mr-2 bs-datepicker"
                    placeholder="End date"
                    name="end_date"
                    data-date-end-date="{{ $today }}"
                    value="{{ request()->end_date ?? $today }}"
                    autocomplete="off"
                />
                <button class="btn btn-success btn-gradient">Search</button>
                <button type="reset" class="btn btn-secondary btn-gradient ml-1">Clear</button>
            </div>
        </form>
        <div class="form-radius">
            <table class="table mb-0">
                <thead>
                <tr>
                    <th class="border-top-0" scope="col">No.</th>
                    <th class="border-top-0" scope="col">Date</th>
                    <th class="border-top-0" scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                @php($count = 1)
                @foreach($histories as $date => $history)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ __d($date, 'Y-m-d') }}</td>
                        <td>
                            <span class="text-{{ $history == null ? 'danger' : 'success' }}">
                                {{ $history == null ? 'Incomplete' : 'Complete' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
                @if($histories->count() <= 0)
                    <tr>
                        <td colspan="3">No History</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
