@php $endUserTree = end($userTree) @endphp
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach($userTree as $user)
            <?php if(!isset($user['username'])) continue ?>
            @php $active = $user['username'] == $endUserTree['username'] @endphp
            <li class="breadcrumb-item user-tree {{ $active ? 'active' : '' }}">
                @if(!$active)
                    <a href="#" data-href="{{ route('userlist.has_parent', $user['username']) }}" onclick="Home.getListUser(this)">{{ $user['email'] }}</a>
                @else
                    {{ $user['email'] }}
                @endif
            </li>
        @endforeach
    </ol>
</nav>
