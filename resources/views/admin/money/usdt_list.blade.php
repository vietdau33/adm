@php($usdtList = \App\Models\UserUsdt::all())
<div class="area-usdt--list mt-3">
    <div class="form-radius">
        <table class="table table-responsive-md mb-0 text-center">
            <thead>
            <tr>
                <th class="border-top-0" scope="col">No.</th>
                <th class="border-top-0" scope="col">Username</th>
                <th class="border-top-0" scope="col">Address</th>
                <th class="border-top-0" scope="col">Private Key</th>
                <th class="border-top-0" scope="col">Date</th>
            </tr>
            </thead>
            <tbody>
            @php($count = 1)
            @foreach($usdtList as $usdt)
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $usdt->user->username }}</td>
                    <td>{{ $usdt->token }}</td>
                    <td>{{ $usdt->private_key }}</td>
                    <td style="min-width: 140px">{{ __d($usdt->created_at, 'Y-m-d H:i') }}</td>
                </tr>
            @endforeach
            @if($usdtList->count() <= 0)
                <tr class="text-center">
                    <td colspan="5">No see any record</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
