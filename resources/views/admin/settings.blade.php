@extends('layout')
@section("contents")
    <div class="content mt-3">
        <div class="money-tab-list">
            <ul class="nav nav-tabs" role="tablist">
                <li class="ml-2">&nbsp;</li>
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#profit" role="tab">Profit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#bonus" role="tab">Bonus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#change_password" role="tab">Change Password</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#change_2fa" role="tab">Two-Factor Authentication (2FA)</a>
                </li>
            </ul>
        </div>
        <div class="money-tab-detail">
            <div class="tab-content">
                <div class="tab-pane p-2 active" id="profit" role="tabpanel">
                    @include('admin.settings.profit')
                </div>
                <div class="tab-pane p-2" id="bonus" role="tabpanel">
                    @include('admin.settings.bonus')
                </div>
                <div class="tab-pane p-2" id="change_password" role="tabpanel">
                    @include('admin.settings.change_password')
                </div>
                <div class="tab-pane p-2" id="change_2fa" role="tabpanel">
                    @include('admin.settings.2fa')
                </div>
            </div>
        </div>
    </div>
@endsection
