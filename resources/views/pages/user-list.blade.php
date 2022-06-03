@extends('layout')
@section("contents")
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
@section("modal")
    @include("modals.member-detail")
@endsection
