@extends('layout')
@section("contents")
    @php($request = request())
    <div class="content mt-3">
        @if(is_admin())
            <div class="alert-total">
                <div class="alert alert-info">TOTAL MEMBER: <b>{{ $totalMember }}</b></div>
            </div>
        @endif
        <div class="area-user">
            <form action="" method="GET">
                <div class="area-user--search d-flex flex-wrap">
                    <input
                        type="text"
                        class="form-control m-1"
                        value="{{ $request->username ?? '' }}"
                        name="username"
                        placeholder="username"
                        style="width: 180px"
                    />
                    <input
                        type="text"
                        class="form-control m-1 bs-datepicker"
                        value="{{ $request->start_date ?? '' }}"
                        name="start_date"
                        style="width: 140px"
                        autocomplete="off"
                        placeholder="Start date"
                    />
                    <input
                        type="text"
                        class="form-control m-1 bs-datepicker"
                        value="{{ $request->end_date ?? '' }}"
                        name="end_date"
                        style="width: 140px"
                        autocomplete="off"
                        placeholder="End date"
                    />
                    @if(is_user())
                        <select name="level" class="form-control m-1 w-auto">
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ $request->level == $i ? 'selected' : '' }}>
                                    Level {{ $i }}
                                </option>
                            @endfor
                        </select>
                    @endif
                    <button class="btn btn-success btn-gradient m-1" style="width: 100px">Search</button>
                    <button type="reset" class="btn btn-secondary btn-gradient m-1 btn-clear-search" style="width: 100px">Clear</button>
                </div>
            </form>
            <div class="area-user--list mt-3">
                <div class="form-radius text-center">
                    <table class="table table-responsive mb-0">
                        <thead>
                        <tr>
                            <th class="border-top-0" scope="col">No.</th>
                            <th class="border-top-0" scope="col">Fullname</th>
                            <th class="border-top-0" scope="col">Username</th>
                            <th class="border-top-0" scope="col">Phone</th>
                            <th class="border-top-0" scope="col">Email</th>
                            <th class="text-left border-top-0" scope="col">Investment: Staking</th>
                            <th class="border-top-0" scope="col">Patron</th>
                            <th class="border-top-0" scope="col">Registration Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($count = 1)
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $user->fullname }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-left">
                                    @if(!empty($user->investment))
                                        <ul class="mb-0 pl-3">
                                            @foreach($user->investment as $invest)
                                                <li>{{ ucfirst($invest->type) }}: {{ $invest->money_buy }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        No Investment
                                    @endif
                                </td>
                                <td>{{ $user->userUpline->username ?? 'No Patron' }}</td>
                                <td>{{ __d($user->created_at, 'Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                        @if($users->count() <= 0)
                            <tr class="text-center">
                                <td colspan="8">Dont have any user</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    {!! $users->links('vendor.pagination.bootstrap') !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('.btn-clear-search').on('click', function() {
            $('select[name="level"] option[selected]').removeAttr('selected');
            setTimeout(() => {
                $(this).closest('form').trigger('submit');
            }, 100);
        });
    </script>
@endsection
