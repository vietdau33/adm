@extends('layout')
@section("contents")
    <div class="table-content-custom">
        <div class="title">
            <i class="fas fa-book-open"></i>
            <span>Crypto Deposit History</span>
        </div>
        <div class="table-detail">
            {!! view("pages.search-form", ['route' => "user.crypto-deposit-history-search.post"])->render() !!}
            @if(user()->role == 'admin')
                <div class="row-export mb-2 text-right">
                    <a class="btn btn-success" href="{{ route('admin.crypto-deposit.export') }}">Export Excel</a>
                </div>
            @endif
            <div class="table-content" id="crypto-history">
                @include("pages.crypto.deposit-history-table")
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.change-password')
@endsection
