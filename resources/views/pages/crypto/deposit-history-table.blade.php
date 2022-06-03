<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">#</th>
        @if(user()->role == 'admin')
            <th scope="col">User Request</th>
        @endif
        <th scope="col">Date</th>
        <th scope="col">From Address</th>
        <th scope="col">To Address</th>
        <th scope="col">Type</th>
        <th scope="col">Amount</th>
        <th scope="col">Transfer Amount</th>
        <th scope="col">TxHash</th>
        <th scope="col">Note</th>
    </tr>
    </thead>
    <tbody>
        @php $count = 1 @endphp
        @foreach($histories as $history)
            <tr>
                <td>{{ $count++ }}</td>
                @if(user()->role == 'admin')
                    <td>{{ $history->user_request->username ?? '' }}</td>
                @endif
                <td>{{ __d($history->created_at) }}</td>
                <td>{{ $history->from ?? '' }}</td>
                <td>{{ $history->to ?? '' }}</td>
                <td>{{ $history->method ?? '' }}</td>
                <td>{{ $history->amount }}</td>
                <td>{{ (int)$history->amount * (float)$history->rate }}</td>
                <td>{{ $history->txhash }}</td>
                <td>{{ $history->note }}</td>
            </tr>
        @endforeach
        @if($histories->count() <= 0)
            <tr>
                <td colspan="{{ user()->role == 'admin' ? "10" : "9" }}">No Result</td>
            </tr>
        @endif
    </tbody>
</table>
