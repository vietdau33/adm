<div class="profit--box text-center">
    <div class="profit-history mt-3">
        <div class="d-flex mb-3">
            <input type="text" style="width: 210px; max-width: 100%" class="form-control mr-2" value="{{ date('Y-m-d') }}">
            <input type="text" style="width: 210px; max-width: 100%" class="form-control mr-2" value="{{ date('Y-m-d') }}">
            <button class="btn btn-success btn-gradient">Search</button>
        </div>
        <table class="table table-striped" style="background: #fff">
            <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Date</th>
                <th scope="col">Bonus From</th>
                <th scope="col">Invest</th>
                <th scope="col">Level</th>
                <th scope="col">Rate</th>
                <th scope="col">Amount</th>
            </tr>
            </thead>
            <tbody>
            {{--@php($count = 1)--}}
            {{--@foreach($histories->items() as $history)--}}
            {{--    <tr>--}}
            {{--        <td>{{ $count++ }}</td>--}}
            {{--        <td>{{ $history->amount }}</td>--}}
            {{--        <td>{{ $history->note }}</td>--}}
            {{--        <td>{{ $history->status }}</td>--}}
            {{--        <td>{{ __d($user->created_at) }}</td>--}}
            {{--    </tr>--}}
            {{--@endforeach--}}
            {{--@if($histories->count() <= 0)--}}
            {{--    <tr>--}}
            {{--        <td colspan="5">No User</td>--}}
            {{--    </tr>--}}
            {{--@endif--}}
            <tr>
                <td colspan="7">No History</td>
            </tr>
            </tbody>
        </table>
        {{--{!! view('pages.pagination', ['datas' => $histories])->render() !!}--}}
    </div>
</div>
