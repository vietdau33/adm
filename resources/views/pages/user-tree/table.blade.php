<div class="table-content">
    <table class="table table-bordered table-user-tree">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Username</th>
            <th scope="col">Phone</th>
            <th scope="col">User Upline</th>
            <th scope="col">IB</th>
{{--            <th scope="col">IB Real</th>--}}
{{--            <th scope="col">Level</th>--}}
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @php $count = 1 @endphp
        @foreach(getUserByArrayRef($tree) as $user)
            @php
                if($user->role == 'admin') continue;
            @endphp
            <tr data-row="{{ $user->username }}" data-level="{{ $user->level }}">
                <td>{{ $count++ }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ getUserUpline($user->upline_by)->username ?? '' }}</td>
                <td class="row-ib">
                    {{ $user->rate_ib }}%
                </td>
{{--                <td>--}}
{{--                    {{ $user->ref_is_admin ? calcRateIB($tree) : calcIBRealRecive($tree, $user) }}%--}}
{{--                </td>--}}
{{--                <td>{{ $user->level }}</td>--}}
                <td>
                    @if(user()->role == 'admin')
                        <button class="btn btn-primary" onclick="Home.showModalChangeIB(this, '{{ $user->username }}', {{ json_encode($tree) }})">Change IB</button>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
