<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">No.</th>
        <th scope="col">Fullname</th>
        <th scope="col">Username</th>
        <th scope="col">Phone</th>
        <th scope="col">Email</th>
        <th scope="col">Investment Plan</th>
        <th scope="col">Staking</th>
        <th scope="col">Patron</th>
        <th scope="col">Registration Date</th>
    </tr>
    </thead>
    <tbody>
    @php($count = 1)
    @foreach($userList->items() as $user)
        <tr>
            <td>{{ $count++ }}</td>
            <td>
                <a href="{{ route('user.get-info', $user->reflink) }}" onclick="Home.showUserInfo(this)">{{ $user->fullname }}</a>
            </td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ '' }}</td>
            <td>{{ '' }}</td>
            <td>{{ '' }}</td>
            <td>{{ __d($user->created_at) }}</td>
        </tr>
    @endforeach
    @if($userList->count() <= 0)
        <tr>
            <td colspan="9">No User</td>
        </tr>
    @endif
    </tbody>
</table>
{!! view('pages.pagination', ['datas' => $userList])->render() !!}
