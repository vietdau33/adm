<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Date</th>
        <th scope="col">From</th>
        <th scope="col">To</th>
        <th scope="col">Amount</th>
        <th scope="col">Note</th>
    </tr>
    </thead>
    <tbody>
        @php $count = 1 @endphp
        @foreach($transferHistory as $history)
            <tr>
                <td>{{ $count++ }}</td>
                <td>{{ date('Y/m/d H:i', strtotime($history->created_at)) }}</td>
                <td>{{ $history->user_from->email ?? '' }}</td>
                <td>{{ $history->user_to->email ?? '' }}</td>
                <td>{{ $history->amount }}</td>
                <td>{{ $history->note }}</td>
            </tr>
        @endforeach
        @if($transferHistory->count() <= 0)
            <tr>
                <td colspan="6">No result</td>
            </tr>
        @endif
    </tbody>
</table>
