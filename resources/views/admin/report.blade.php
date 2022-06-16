@extends('layout')
@section("contents")
    <div class="content mt-3">
        <div class="money-tab-list">
            <ul class="nav nav-tabs" role="tablist">
                <li class="ml-2">&nbsp;</li>
                <li class="nav-item">
                    <a class="nav-link {{ $type == 'deposit' ? 'active' : '' }}" data-toggle="tab" href="#deposit" role="tab">Deposit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $type == 'bonus' ? 'active' : '' }}" data-toggle="tab" href="#bonus" role="tab">Bonus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $type == 'profit' ? 'active' : '' }}" data-toggle="tab" href="#profit" role="tab">Profit</a>
                </li>
            </ul>
        </div>
        <div class="money-tab-detail">
            <div class="tab-content">
                <div class="tab-pane p-2 {{ $type == 'deposit' ? 'active' : '' }}" id="deposit" role="tabpanel">
                    @include('admin.report.deposit')
                </div>
                <div class="tab-pane p-2 {{ $type == 'bonus' ? 'active' : '' }}" id="bonus" role="tabpanel">
                    @include('admin.report.bonus')
                </div>
                <div class="tab-pane p-2 {{ $type == 'profit' ? 'active' : '' }}" id="profit" role="tabpanel">
                    @include('admin.report.profit')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            const href = e.target.getAttribute('href').replace('#', '');
            const moneyUrl = '{{ route('admin.report') }}';
            history.replaceState({}, '', moneyUrl + '/' + href);
        });
    </script>
@endsection
