<div class="area-deposit--search d-flex flex-wrap">
    <input type="text" class="form-control m-1" name="username" placeholder="username" style="width: 180px">
    <input type="text" class="form-control m-1" name="start_date" placeholder="{{ date('Y-m-d') }}" style="width: 120px">
    <input type="text" class="form-control m-1" name="end_date" placeholder="{{ date('Y-m-d') }}" style="width: 120px">
    <button class="btn btn-success btn-gradient m-1" style="width: 100px">Search</button>
</div>
<div class="area-deposit--list mt-3">
    <table class="table table-striped" style="background: #fff">
        <thead>
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Username</th>
            <th scope="col">Amount</th>
            <th scope="col">Wallet</th>
            <th scope="col">Status</th>
            <th scope="col">Created Date</th>
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
        <tr class="text-center">
            <td colspan="6">Dont have any history</td>
        </tr>
        </tbody>
    </table>
    {{--{!! view('pages.pagination', ['datas' => $histories])->render() !!}--}}
</div>
