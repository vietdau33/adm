@extends('layout')
@section("contents")
    <div class="table-content-custom">
        <div class="title">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Request Liquidity</span>
        </div>
        <div class="table-detail">
            {!! view("pages.search-form", ['route' => "user.request-liquidity-search.post"])->render() !!}
            <div class="table-content" id="table-liquidity-list">
                @include("pages.request-liquidity.table-list-pending")
            </div>
        </div>
    </div>
@endsection
