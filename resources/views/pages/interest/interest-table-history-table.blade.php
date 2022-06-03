<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Date</th>
        <th scope="col">Rate 3 month (%)</th>
        <th scope="col">Rate 6 month (%)</th>
        <th scope="col">Rate 12 month (%)</th>
    </tr>
    </thead>
    <tbody id="interestHistoryBody">
{{--        @php $count = 1; $isAdmin = user()->role == 'admin'; @endphp--}}
{{--        @foreach($interestHistory->items() as $history)--}}
{{--            @php $isDaily = $history->is_daily @endphp--}}
{{--            <tr>--}}
{{--                <td>{{ $count++ }}</td>--}}
{{--                <td class="{{ ($isAdmin && $isDaily) ? "text-secondary" : "" }}">{{ $history->dateCreate() }}</td>--}}
{{--                <td>{{ $history->value }}</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        @if($interestHistory->count() == 0)--}}
{{--            <tr>--}}
{{--                <td colspan="3" class="text-center">No Record</td>--}}
{{--            </tr>--}}
{{--        @endif--}}
        @for($i = 1; $i <= 10; $i++)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ date('d/m/Y',strtotime("-$i days")) }}</td>
                <td>0.3</td>
                <td>0.8</td>
                <td>0.8</td>
            </tr>
        @endfor
    </tbody>
</table>
{{--{!! view('pages.pagination', ['datas' => $interestHistory])->render() !!}--}}
{!! view('pages.pagination', ['datas' => fakePagination()])->render() !!}
