@extends('layout')
@section("contents")
    <div class="banner-top mb-3">
        <img src="{{ asset('image/adm/bg_1.jpg') }}" alt="Bg 1" class="w-100">
    </div>
    <div class="area-advertisement area-advertisement-top mb-3">
        <h3>Banner Quảng cáo PC: cao = 540px</h3>
    </div>
    @if(user()->role == 'user')
        <div class="settings-display">
            <div class="box-money money-ib m-1">
                <a class="money-text" href="javascript:void(0)" data-toggle="modal" data-target="#transferIBToWallet">
                    {{ number_format((float)user()->money_ib, 2) }}
                </a>
            </div>
            <div class="box-money money-wallet m-1">
                <a class="money-text" href="javascript:void(0)" data-toggle="modal">
                    {{ number_format((float)user()->money_wallet, 2) }}
                </a>
            </div>
        </div>
    @endif
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
