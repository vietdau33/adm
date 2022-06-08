<ul>
    <li data-active="dashboard">
        <a href="{{ route('home.page') }}">
            <img src="{{ asset('image/adm/icon/dashboard.png') }}" alt="Dashboard">
            <span>Dashboard</span>
        </a>
    </li>
    <li data-active="list-member">
        <a href="{{ route('userlist') }}">
            <img src="{{ asset('image/adm/icon/people.png') }}" alt="List Member">
            <span>List Member</span>
        </a>
    </li>
    <li data-active="money">
        <a href="{{ route('money.home') }}">
            <img src="{{ asset('image/adm/icon/money.png') }}" alt="Money">
            <span>Money</span>
        </a>
    </li>
    <li data-active="history">
        <a href="{{ route('history.home') }}">
            <img src="{{ asset('image/adm/icon/history.png') }}" alt="History">
            <span>History</span>
        </a>
    </li>
    <li data-active="settings">
        <a href="{{ route('setting.home') }}">
            <img src="{{ asset('image/adm/icon/setting.png') }}" alt="Settings">
            <span>Settings</span>
        </a>
    </li>
    <li>
        <a href="{{ route('auth.logout.get') }}">
            <img src="{{ asset('image/adm/icon/logout.png') }}" alt="Logout">
            <span>Logout</span>
        </a>
    </li>
</ul>
