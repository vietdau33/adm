@extends('layout')
@section("contents")
    @if(user()->role == 'user')
        <div class="settings-display">
            <div class="box-money money-ib m-1">
                <a class="money-text" href="javascript:void(0)" data-toggle="modal" data-target="#transferIBToWallet">
                    {{ number_format((float)user()->money_ib, 2) }}
                </a>
            </div>
{{--            <div class="box-money money-invest m-1">--}}
{{--                <span class="money-text">{{ number_format((float)user()->money_invest, 2) }}</span>--}}
{{--            </div>--}}
            <div class="box-money money-wallet m-1">
{{--                <a class="money-text" href="javascript:void(0)" data-toggle="modal" data-target="#transferToInvest">--}}
                <a class="money-text" href="javascript:void(0)" data-toggle="modal">
                    {{ number_format((float)user()->money_wallet, 2) }}
                </a>
            </div>
        </div>
    @endif
{{--    <div class="internet-history table-content-custom">--}}
{{--        <div class="title">--}}
{{--            <i class="fas fa-calendar-alt"></i>--}}
{{--            <span>Interest Rate History</span>--}}
{{--        </div>--}}
{{--        <div class="table-detail">--}}
{{--            {!! view("pages.search-form", ['route' => "user.interest-rate-history-search.post"])->render() !!}--}}
{{--            <div class="table-content" id="interest-rate-history">--}}
{{--                @include('pages.interest.interest-table-history-table')--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="table-content-custom">
        <div class="title">
            <i class="fas fa-calendar-alt"></i>
            <span>User List</span>
        </div>
        <div class="table-detail">
            {!! view("pages.search-form", ['route' => 'userlist.search'])->render() !!}
            <div class="table-content" id="table-user-tree-parent">
                @include("pages.user-list.tree-parent")
            </div>
            <div class="table-content" id="table-user-list">
                @include("pages.user-list.table")
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.change-password')
    @include('modals.transfer-to-invest')
    @include('modals.transfer-ib-to-wallet')
    @include("modals.member-detail")
@endsection
