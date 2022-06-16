<ul>
    <li data-active="dashboard">
        <a href="{{ route('admin.home') }}">
            <img src="{{ asset('image/adm/icon/dashboard.png') }}" alt="Dashboard">
            <span>Dashboard</span>
        </a>
    </li>
    <li data-active="list-member">
        <a href="{{ route('admin.list-member') }}">
            <img src="{{ asset('image/adm/icon/people.png') }}" alt="List Member">
            <span>List Member</span>
        </a>
    </li>
    <li data-active="money">
        <a href="{{ route('admin.money') }}">
            <img src="{{ asset('image/adm/icon/money.png') }}" alt="Money">
            <span>Money</span>
        </a>
    </li>
    <li data-active="report">
        <a href="{{ route('admin.report') }}">
            <img src="{{ asset('image/adm/icon/history.png') }}" alt="Report Transfer">
            <span>Report</span>
        </a>
    </li>
    <li data-active="settings">
        <a href="{{ route('admin.settings') }}">
            <img src="{{ asset('image/adm/icon/setting.png') }}" alt="Settings">
            <span>Settings</span>
        </a>
    </li>
    <li data-active="banner">
        <a href="{{ route('admin.banner') }}">
            <img src="{{ asset('image/adm/icon/ads-icon.png') }}" alt="Banner Manager">
            <span>Banner Manager</span>
        </a>
    </li>
    <li data-active="link-mission">
        <a href="{{ route('admin.link-mission') }}">
            <img src="{{ asset('image/adm/icon/link-icon.png') }}" alt="Link Daily Mission">
            <span>Link Daily Mission</span>
        </a>
    </li>
    <li>
        <a href="{{ route('auth.logout.get') }}">
            <img src="{{ asset('image/adm/icon/logout.png') }}" alt="Logout">
            <span>Logout</span>
        </a>
    </li>
</ul>
