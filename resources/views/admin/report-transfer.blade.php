@extends('layout')
@section("contents")
    <div class="content">
        <form action="" method="GET">
            <div class="d-flex flex-wrap mb-3 mt-3">
                <input
                    type="text"
                    style="width: 210px; max-width: 100%"
                    class="form-control mr-2 mb-1"
                    name="username"
                    value="{{ request()->username ?? '' }}"
                    autocomplete="off"
                    placeholder="username"
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
        <div class="area-report--list mt-3">
            <div class="form-radius">
                <table class="table table-responsive-md mb-0 text-center">
                    <thead>
                    <tr>
                        <th class="border-top-0" scope="col">No.</th>
                        <th class="border-top-0" scope="col">Username Send</th>
                        <th class="border-top-0" scope="col">Username Receive</th>
                        <th class="border-top-0" scope="col">Amount</th>
                        <th class="border-top-0" scope="col">Created Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($count = 1)
                    @foreach($histories->items() as $history)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $history->user->username }}</td>
                            <td>{{ $history->user_receive->username }}</td>
                            <td>{{ $history->amount }}</td>
                            <td style="min-width: 140px">{{ __d($history->created_at) }}</td>
                        </tr>
                    @endforeach
                    @if($histories->count() <= 0)
                        <tr class="text-center">
                            <td colspan="5">Dont have any history</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {!! $histories->links('vendor.pagination.bootstrap') !!}
            </div>
        </div>
    </div>
@endsection
