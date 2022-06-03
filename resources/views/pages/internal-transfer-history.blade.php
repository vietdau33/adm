@extends('layout')
@section("contents")
    <div class="table-content-custom">
        <div class="title">
            <i class="fas fa-book-open"></i>
            <span>Internal Transfer History</span>
        </div>
        <div class="table-detail">
            {!! view("pages.search-form", ['route' => "user.internal-transfer-search.post"])->render() !!}
            @if(user()->role == 'admin')
                <div class="row-export mb-2 text-right">
                    <a class="btn btn-success" href="{{ route('admin.internal-transfer.export') }}">Export Excel</a>
                </div>
            @endif
            <div class="table-content" id="table-internal-transfer">
                @include("pages.internal-transfer.history-table")
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.change-password')
@endsection
