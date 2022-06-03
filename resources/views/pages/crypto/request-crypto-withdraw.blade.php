<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">User Request</th>
        <th scope="col">Date</th>
        <th scope="col">To Address</th>
        <th scope="col">Type</th>
        <th scope="col">Amount</th>
        <th scope="col">Transfer Amount</th>
        <th scope="col">Note</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
        @php $count = 1 @endphp
        @foreach($withdrawTransfer as $transfer)
            <tr data-code="{{ $transfer->id }}" data-url="/crypto-withdraw/change-status">
                <td>{{ $count++ }}</td>
                <td>{{ $transfer->user_request->username ?? '' }}</td>
                <td>{{ date('Y/m/d H:i', strtotime($transfer->created_at)) }}</td>
                <td>{{ $transfer->to ?? '' }}</td>
                <td>{{ $transfer->method ?? '' }}</td>
                <td>{{ $transfer->amount }}</td>
                <td>{{ number_format((int)$transfer->amount * (float)$transfer->rate, 6) }}</td>
                <td>{{ $transfer->note }}</td>
                <td style="min-width: 160px;">
                    <button class="btn btn-info" onclick="Admin.changeStatusTransfer(this, 'agree')">Agree</button>
                    <button class="btn btn-danger" onclick="Admin.changeStatusTransfer(this, 'cancel')">Cancel</button>
                </td>
            </tr>
        @endforeach
        @if($withdrawTransfer->count() <= 0)
            <tr>
                <td colspan="9">No Result</td>
            </tr>
        @endif
    </tbody>
</table>
