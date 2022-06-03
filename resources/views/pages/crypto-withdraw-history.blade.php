@extends('layout')
@section("contents")
    <div class="table-content-custom">
        <div class="title">
            <i class="fas fa-book-open"></i>
            <span>Crypto Withdraw History</span>
        </div>
        <div class="table-detail">
            {!! view("pages.search-form", ['route' => "user.crypto-withdraw-history-search.post"])->render() !!}
            @if(user()->role == 'admin')
                <div class="row-export mb-2 text-right">
                    <a class="btn btn-success" href="{{ route('admin.crypto-withdraw.export') }}">Export Excel</a>
                </div>
            @endif
            <div class="table-content" id="crypto-history">
                @include('pages.crypto.withdraw-history-table')
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.change-password')
@endsection
