@extends('layout')
@section("contents")
    <div class="table-content-custom">
        <div class="title">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Request Liquidity History</span>
        </div>
        <div class="table-detail">
            {!! view("pages.search-form", ['route' => "user.request-liquidity-history-search.post"])->render() !!}
            @if(user()->role == 'admin')
                <div class="row-export mb-2 text-right">
                    <a class="btn btn-success" href="{{ route('admin.request-liquidity.export') }}">Export Excel</a>
                </div>
            @endif
            <div class="table-content" id="table-liquidity-list">
                @if(user()->role == 'admin')
                    @include("pages.request-liquidity.admin")
                @else
                    @include("pages.request-liquidity.user")
                @endif
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.change-password')
@endsection
