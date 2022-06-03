<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Date</th>
        <th scope="col">Request To</th>
        <th scope="col">Amount</th>
        <th scope="col">Note</th>
        <th scope="col">Status</th>
    </tr>
    </thead>
    <tbody>
    @php $count = 1 @endphp
    @foreach($listTransfer as $transfer)
        <tr>
            <td>{{ $count++ }}</td>
            <td style="min-width: 100px;">{{ __d($transfer->created_at, "d/m/Y") }}</td>
            <td>{{ $transfer->userRequestTo->email ?? '' }}</td>
            <td style="min-width: 100px;"> {{ number_format((float)$transfer->amount, 2) }} £</td>
            <td class="break-word">{{ $transfer->note }}</td>
            <td>{!! $transfer->status() !!}</td>
        </tr>
    @endforeach
    @if($listTransfer->count() == 0)
        <tr>
            <td colspan="6">No History</td>
        </tr>
    @endif
    </tbody>
</table>
