<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Date</th>
        <th scope="col">Fullname</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        <th scope="col">Amount ($)</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    @php $count = 1 @endphp
    @foreach($listTransfer as $transfer)
        <tr data-code="{{ $transfer->id }}">
            <td>{{ $count++ }}</td>
            <td style="min-width: 100px;">{{ __d($transfer->created_at, "d/m/Y") }}</td>
            <td>{{ $transfer->userRequest->fullname ?? '' }}</td>
            <td>{{ $transfer->userRequest->email ?? '' }}</td>
            <td>{{ $transfer->userRequest->phone ?? '' }}</td>
            <td style="min-width: 100px;"> {{ number_format((float)$transfer->amount, 2) }}</td>
            <td style="min-width: 160px;">
                <button class="btn btn-info" onclick="Admin.changeStatusTransfer(this, 'agree')">Agree</button>
                <button class="btn btn-danger" onclick="Admin.changeStatusTransfer(this, 'cancel')">Cancel</button>
            </td>
        </tr>
    @endforeach
    @if($listTransfer->count() == 0)
        <tr>
            <td colspan="7">No Request Liquidity</td>
        </tr>
    @endif
    </tbody>
</table>
