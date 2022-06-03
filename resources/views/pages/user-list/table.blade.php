<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Date</th>
        <th scope="col">Fullname</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        @if(user()->role == 'admin')
            <th scope="col">Action</th>
        @endif
        <th scope="col">Downline</th>
    </tr>
    </thead>
    <tbody>
    @php $count = 1 @endphp
    @foreach($userList->items() as $user)
        <tr>
            <td>{{ $count++ }}</td>
            <td>{{ __d($user->created_at) }}</td>
            <td>
                <a href="{{ route('user.get-info', $user->reflink) }}" onclick="Home.showUserInfo(this)">{{ $user->fullname }}</a>
            </td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            @if(user()->role == 'admin')
                <td style="min-width: 160px">
                    @if(rand(1, 2) == 1)
                        @if(rand(1, 2) == 1)
                            <span class="text-danger">Cancel</span>
                        @else
                            <span class="text-success">Active</span>
                        @endif
                    @else
                        <button class="btn btn-success">Active</button>
                        <button class="btn btn-danger">Cancel</button>
                    @endif
                </td>
            @endif
            <td>
                @if((int)$user->level < 10)
                    <button
                        data-href="{{ route('userlist.has_parent', $user->id) }}"
                        class="btn btn-primary"
                        onclick="Home.getListUser(this)"
                        data-end-tag="true">
                        View Downline
                    </button>
                @endif
            </td>
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
