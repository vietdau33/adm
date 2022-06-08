@extends('layout')
@section("contents")
    <div class="content">
        <div class="alert-total mt-3">
            <div class="alert alert-info">TOTAL MEMBER: 9,129</div>
        </div>
        <div class="area-user">
            <div class="area-user--search d-flex flex-wrap">
                <input type="text" class="form-control m-1" name="username" placeholder="username" style="width: 180px">
                <input type="text" class="form-control m-1" name="start_date" placeholder="{{ date('Y-m-d') }}" style="width: 120px">
                <input type="text" class="form-control m-1" name="end_date" placeholder="{{ date('Y-m-d') }}" style="width: 120px">
                <select name="level" class="form-control m-1" style="width: 90px">
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">Level {{ $i }}</option>
                    @endfor
                </select>
                <button class="btn btn-success btn-gradient m-1" style="width: 100px">Search</button>
            </div>
            <div class="area-user--list mt-3">
                <table class="table table-striped" style="background: #fff">
                    <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Fullname</th>
                        <th scope="col">Username</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Investment Plan</th>
                        <th scope="col">Staking</th>
                        <th scope="col">Patron</th>
                        <th scope="col">Registration Date</th>
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
                        <td colspan="9">Dont have any user</td>
                    </tr>
                    </tbody>
                </table>
                {{--{!! view('pages.pagination', ['datas' => $histories])->render() !!}--}}
            </div>
        </div>
    </div>
@endsection
