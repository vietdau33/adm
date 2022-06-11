<form action="" method="GET">
    <div class="d-flex mb-3">
        <input
            type="text"
            style="width: 210px; max-width: 100%"
            class="form-control mr-2"
            name="username"
            value="{{ request()->username ?? '' }}"
            autocomplete="off"
            placeholder="username"
        />
        <input
            type="text"
            style="width: 210px; max-width: 100%"
            class="form-control mr-2 bs-datepicker"
            placeholder="Start date"
            name="start_date"
            value="{{ request()->start_date ?? '' }}"
            autocomplete="off"
        />
        <input
            type="text"
            style="width: 210px; max-width: 100%"
            class="form-control mr-2 bs-datepicker"
            placeholder="End date"
            name="end_date"
            value="{{ request()->end_date ?? '' }}"
            autocomplete="off"
        />
        <button class="btn btn-success btn-gradient">Search</button>
        <button type="reset" class="btn btn-secondary btn-gradient ml-1">Clear</button>
    </div>
</form>
<div class="area-withdraw--list mt-3">
    <div class="form-radius">
        <table class="table table-responsive-md mb-0 text-center">
            <thead>
            <tr>
                <th class="border-top-0" scope="col">No.</th>
                <th class="border-top-0" scope="col">Username</th>
                <th class="border-top-0" scope="col">Amount</th>
                <th class="border-top-0" scope="col">Wallet</th>
                <th class="border-top-0" scope="col">Date</th>
                <th class="border-top-0" scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @php($count = 1)
            @foreach($withdrawRequest as $withdraw)
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $withdraw->user->username ?? '' }}</td>
                    <td>{{ $withdraw->amount }}</td>
                    <td>{{ $withdraw->address }}</td>
                    <td>{{ __d($withdraw->created_at, 'Y-m-d H:i') }}</td>
                    <td style="min-width: 210px;">
                        @if($withdraw->status === 0)
                            <button class="btn btn-primary" onclick="OnClickChangeStatus({{ $withdraw->id }}, 1)">Accept</button>
                        @else
                            <button class="btn btn-success" onclick="OnClickChangeStatus({{ $withdraw->id }}, 2)">Done</button>
                        @endif
                        <button class="btn btn-danger" onclick="OnClickChangeStatus({{ $withdraw->id }}, 3)">Cancel</button>
                    </td>
                </tr>
            @endforeach
            @if($withdrawRequest->count() <= 0)
                <tr class="text-center">
                    <td colspan="6">No see any record</td>
                </tr>
            @endif
            </tbody>
        </table>
        {!! $withdrawRequest->links('vendor.pagination.bootstrap') !!}
    </div>
</div>
<script>
    window.OnClickChangeStatus = function(id, status) {
        if(status == 3 && !confirm('Are you sure cancel this request?')) {
            return false;
        }
        Request.ajax('{{ route('admin.status.withdraw') }}', { id, status }, function (result) {
            if (result.success) {
                alertify.alertSuccess('Success', result.message, () => location.reload());
            } else {
                alertify.alertDanger("Error", result.message);
            }
        });
    }
</script>
