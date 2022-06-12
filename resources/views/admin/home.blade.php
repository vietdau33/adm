@extends('layout')
@section("contents")
    <div class="content content-dashboard d-flex flex-wrap justify-content-center font-weight-bold">
        {{--<div class="box-info total-deposit">--}}
        {{--    <h3>TOTAL DEPOSIT</h3>--}}
        {{--    <h4>3,059,129.00</h4>--}}
        {{--</div>--}}
        <div class="box-info total-withdraw">
            <h3>TOTAL WITHDRAW</h3>
            <h4>{{ number_format($totalWithdraw, 2) }}</h4>
        </div>
        <div class="box-info total-profit">
            <h3>TOTAL PROFIT</h3>
            <h4>{{ number_format($totalProfit, 2) }}</h4>
        </div>
        <div class="box-info total-bonus">
            <h3>TOTAL BONUS</h3>
            <h4>{{ number_format($totalBonus, 2) }}</h4>
        </div>
    </div>
@endsection
