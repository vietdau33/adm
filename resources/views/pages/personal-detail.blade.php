@extends('layout')
@php $user = user() @endphp
@section("contents")
    <div class="table-content-custom">
        <div class="referral-program">
            <span>Referral Program</span>
            <div class="form-group">
                <input type="text" value="{{ route('reflink', user()->reflink) }}" disabled id="inputRefLink">
                <button class="btn-copy" onclick="Home.copyRefLink()">{{ __("home.btn-copy") }}</button>
            </div>
        </div>
        <div class="box-edit-info box-edit-personal-detail">
            <h3 class="text-center">Edit Personal Details</h3>
            <div class="form-edit-personal-detail">
                <form action="{{ route('my-profile.personal-detail.edit') }}" method="POST" onsubmit="return false">
                    <div class="form-group">
                        <label for="fullname">Fullname</label>
                        <input type="text" class="form-control" name="fullname" id="fullname" value="{{ $user->fullname }}">
                    </div>
                    <div class="form-group">
                        <label for="birthday">Date of Birth</label>
                        <input type="text" class="form-control" name="birthday" id="birthday" value="{{ __d($user->birthday, "d/m/Y") }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" name="phone" id="phone" value="{{ $user->phone }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="city">City/Town</label>
                        <input type="text" class="form-control" name="city" id="city" value="{{ $user->address ?? '' }}">
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary btn-submit" onclick="Home.changePersonalInfo(this)">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
