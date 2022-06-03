@extends('layout')
@section("contents")
    <div class="table-content-custom">
        <div class="title">
            <i class="fas fa-calendar-alt"></i>
            <span>User Tree</span>
        </div>
        @foreach($trees as $index => $tree)
            <div class="table-detail table-detail-{{ $index }}">
                {!! view('pages.user-tree.table', compact("tree"))->render() !!}
            </div>
        @endforeach
    </div>
@endsection

@section('modal')
    @include("modals.change-ib")
@endsection
