@extends('layout')
@section("contents")
    <div class="multi-steps">
        <div class="step step-1 active">
            <h3>Please verify your identity in 2 quick steps</h3>
            <h5>91% of users are activated within few minutes</h5>
            <div class="box-info-verify mt-3">
                <div class="box-images mb-3 mt-3">
                    <img src="{{ asset('image/solopayment/veryfile.png') }}" alt="veryfile" class="w-100">
                </div>
                <p class="m-0">Here’s what you need:</p>
                <p class="m-0">@include("pages.upload-documents.icon-success")Your Passport or Driver’s License or Identity Card</p>
                <p class="m-0">@include("pages.upload-documents.icon-success")Make a Selfie</p>
                <div class="btn-goto-verify text-center mt-3 mb-3">
                    <button class="btn btn-primary">Verify your Indentity</button>
                </div>
            </div>
        </div>
    </div>
@endsection
