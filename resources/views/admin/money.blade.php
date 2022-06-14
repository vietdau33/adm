@extends('layout')
@section("contents")
    <div class="content mt-3">
        <div class="money-tab-list">
            <ul class="nav nav-tabs" role="tablist">
                <li class="ml-2">&nbsp;</li>
                {{--<li class="nav-item">--}}
                {{--    <a class="nav-link {{ $type == 'deposit' ? 'active' : '' }}" data-toggle="tab" href="#deposit" role="tab">Deposit</a>--}}
                {{--</li>--}}
                <li class="nav-item">
                    <a class="nav-link {{ $type == 'withdraw' ? 'active' : '' }}" data-toggle="tab" href="#withdraw" role="tab">Withdraw</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $type == 'transfer' ? 'active' : '' }}" data-toggle="tab" href="#transfer" role="tab">Transfer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $type == 'usdt' ? 'active' : '' }}" data-toggle="tab" href="#usdt_list" role="tab">USDT List</a>
                </li>
            </ul>
        </div>
        <div class="money-tab-detail">
            <div class="tab-content">
                <div class="tab-pane p-2 {{ $type == 'deposit' ? 'active' : '' }}" id="deposit" role="tabpanel">
                    @include('admin.money.deposit')
                </div>
                <div class="tab-pane p-2 {{ $type == 'withdraw' ? 'active' : '' }}" id="withdraw" role="tabpanel">
                    @include('admin.money.withdraw')
                </div>
                <div class="tab-pane p-2 {{ $type == 'transfer' ? 'active' : '' }}" id="transfer" role="tabpanel">
                    @include('admin.money.transfer')
                </div>
                <div class="tab-pane p-2 {{ $type == 'usdt_list' ? 'active' : '' }}" id="usdt_list" role="tabpanel">
                    @include('admin.money.usdt_list')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            const href = e.target.getAttribute('href').replace('#', '');
            const moneyUrl = '{{ route('admin.money') }}';
            history.replaceState({}, '', moneyUrl + '/' + href);
        });
    </script>
@endsection
