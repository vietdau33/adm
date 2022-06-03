@php $index = preg_replace("(\.)", "_", $route) @endphp
@php
    $aryUsernameDisable = ['home.page'];
    if(user()->role != 'admin'){
        $aryUsernameDisable[] = 'user.crypto-deposit-history.get';
        $aryUsernameDisable[] = 'user.crypto-withdraw-history.get';
    }
@endphp
@php
    $defaultSizePage = system_setting()->_getDefaultSizePagination();
    $sizePage = [5, 10, 20];
@endphp
<div class="search-form">
    <form action="{{ route($route) ?? '' }}" onsubmit="return false">
        <input type="hidden" name="page" value="1">
        <div class="form-size">
            <label for="">Size</label>
            <select name="size" id="size{{ $index }}" class="form-control" style="height: 34px">
                @foreach($sizePage as $size)
                    <option value="{{ $size }}" {{ $defaultSizePage == $size ? "selected" : "" }}>{{ $size }}</option>
                @endforeach
            </select>
        </div>
        @if(!in_array(request()->route()->getName(), $aryUsernameDisable))
            <div class="form-group">
                <label for="">Username</label>
                <input
                    type="text"
                    class="form-control"
                    name="username"
                    id="username{{ $index }}"
                    placeholder="Username"
                    style="height: 34px"
                />
            </div>
        @endif
        <div class="form-group">
            <label for="">From date</label>
            <input
                type="text"
                class="form-control datepicker"
                name="from_date"
                id="from_date{{ $index }}"
                data-ref="to_date{{ $index }}"
                data-type="from"
                placeholder="From Date"
                readonly
            />
        </div>
        <div class="form-group">
            <label for="">To Date</label>
            <input
                type="text"
                class="form-control datepicker"
                name="to_date"
                id="to_date{{ $index }}"
                data-ref="from_date{{ $index }}"
                data-type="to"
                placeholder="To Date"
                readonly
            />
        </div>
        <div class="button-contain" data-from="from_date{{ $index }}" data-to="to_date{{ $index }}">
            <button class="button btn-search" onclick="SearchForm.search(this)">
                <i class="fa fa-search"></i> Search
            </button>
{{--            <button class="button btn-export ml-2">--}}
{{--                <img src="{{ asset("image/solopayment/xls.svg") }}" alt="Export"> Export--}}
{{--            </button>--}}
        </div>
    </form>
</div>
