<div class="area-transfer--form mt-3 mb-3">
    <div class="small-box m-auto">
        <form action="" method="POST">
            <div class="form-group">
                <label for="amout">Amount</label>
                <input type="text" class="form-control" name="amout" id="amout" placeholder="0.00">
            </div>
            <div class="form-group">
                <label for="username_receive">Username Receive</label>
                <input type="text" class="form-control" name="username_receive" id="username_receive" placeholder="username">
            </div>
            <div class="form-group">
                <label for="fullname">Fullname</label>
                <input type="text" class="form-control" name="fullname" id="fullname" readonly>
            </div>
            <div class="form-group">
                <label for="2fa_code">Auth Code (2FA)</label>
                <input type="text" class="form-control number-only" name="2fa_code" id="2fa_code" placeholder="Enter 2FA code">
            </div>
            <div class="text-center">
                <button class="btn btn-success btn-gradient">Transfer</button>
            </div>
        </form>
    </div>
</div>
<div class="area-transfer--search d-flex flex-wrap">
    <input type="text" class="form-control m-1" name="username" placeholder="username" style="width: 180px">
    <input type="text" class="form-control m-1" name="start_date" placeholder="{{ date('Y-m-d') }}" style="width: 120px">
    <input type="text" class="form-control m-1" name="end_date" placeholder="{{ date('Y-m-d') }}" style="width: 120px">
    <button class="btn btn-success btn-gradient m-1" style="width: 100px">Search</button>
</div>
<div class="area-transfer--list mt-3">
    <table class="table table-striped" style="background: #fff">
        <thead>
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Username</th>
            <th scope="col">Amount</th>
            <th scope="col">Date</th>
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
            <td colspan="4">No see any record</td>
        </tr>
        </tbody>
    </table>
    {{--{!! view('pages.pagination', ['datas' => $histories])->render() !!}--}}
</div>
