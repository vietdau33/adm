@php($stringRandom = \Illuminate\Support\Str::random(32))
<div class="withdraw--box text-center">
    <div class="d-flex justify-content-center">
        <div class="small-box text-left p-5">
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="text" name="amount" id="amount" class="form-control" placeholder="0.00">
            </div>
            <div class="form-group">
                <label for="username_receive">Username Receive</label>
                <input type="text" name="username_receive" id="username_receive" class="form-control" placeholder="username">
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
        </div>
    </div>
    <div class="withdraw-history">
        <div class="d-flex align-items-center mb-3 mt-4">
            <img src="{{ asset('image/adm/icon/history.png') }}" alt="History" style="width: 42px">
            <h3 class="mb-0">HISTORY TRANSFER</h3>
        </div>
        <div class="d-flex mb-3">
            <input type="text" style="width: 210px; max-width: 100%" class="form-control mr-2" value="{{ date('Y-m-d') }}">
            <input type="text" style="width: 210px; max-width: 100%" class="form-control mr-2" value="{{ date('Y-m-d') }}">
            <button class="btn btn-success btn-gradient">Search</button>
        </div>
        <table class="table table-striped" style="background: #fff">
            <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Username Receive / Send</th>
                <th scope="col">Amount</th>
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
            <tr>
                <td colspan="4">No History</td>
            </tr>
            </tbody>
        </table>
        {{--{!! view('pages.pagination', ['datas' => $histories])->render() !!}--}}
    </div>
</div>
