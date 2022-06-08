@extends('layout')
@section("contents")
    <div class="content mt-3">
        <div class="money-tab-list">
            <ul class="nav nav-tabs" role="tablist">
                <li class="ml-2">&nbsp;</li>
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#deposit" role="tab">Deposit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#withdraw" role="tab">Withdraw</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#transfer" role="tab">Transfer</a>
                </li>
            </ul>
        </div>
        <div class="money-tab-detail">
            <div class="tab-content">
                <div class="tab-pane p-2 active" id="deposit" role="tabpanel">
                    @include('admin.money.deposit')
                </div>
                <div class="tab-pane p-2" id="withdraw" role="tabpanel">
                    @include('admin.money.withdraw')
                </div>
                <div class="tab-pane p-2" id="transfer" role="tabpanel">
                    @include('admin.money.transfer')
                </div>
            </div>
        </div>
    </div>
@endsection
