@php
    $activeUserList = ['user-list'];
    if(request()->route()->getName() == 'user.user-tree.get'){
        $activeUserList[] = request()->path();
    }
@endphp
<ul class="list-left-menu-ul">
    <li data-active="home">
        <a href="/home"><i class="fas fa-house-user"></i>Dashboard</a>
    </li>
    <li data-active="{{ implode("|", $activeUserList) }}">
        <a href="{{ route('userlist') }}"><i class="fas fa-user"></i>User List</a>
    </li>
    @if(config("transfer.allow-international-transfer"))
        <li data-active="international-transfer">
            <a href="{{ route('user.international-transfer.get') }}"><i class="fas fa-wallet"></i>International Transfer</a>
        </li>
    @endif
{{--        <li class="has-submenu" data-active="international-transfer">--}}
{{--            <a href="#" class="text-link"><i class="fas fa-wallet"></i>Money</a>--}}
{{--            <ul class="submenu">--}}
{{--                <li data-active-submenu="international-transfer">--}}
{{--                    <a href="{{ route('user.international-transfer.get') }}">Internal Transfer</a>--}}
{{--                </li>--}}
{{--                <li data-active-submenu="crypto-deposit">--}}
{{--                    <a href="{{ route('user.crypto-deposit.get') }}">Crypto Deposit</a>--}}
{{--                </li>--}}
{{--                <li data-active-submenu="crypto-withdraw">--}}
{{--                    <a href="{{ route('user.crypto-withdraw.get') }}">Crypto Withdraw</a>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </li>--}}
    @if(user()->role == 'admin')
        <li data-active="request-liquidity">
            <a href="{{ route('admin.request-liquidity.get') }}"><i class="fas fa-file-invoice-dollar"></i>Request Liquidity</a>
        </li>
    @endif
    <li class="has-submenu" data-active="internal-transfer-history">
        <a href="#" class="text-link"><i class="fas fa-book-open"></i>Report</a>
        <ul class="submenu">
            <li data-active-submenu="internal-transfer-history">
                <a href="{{ route('user.internal-transfer-history.get') }}">Internal Transfer History</a>
            </li>
            <li data-active-submenu="request-liquidity-history">
                <a href="{{ route('user.request-liquidity-history.get') }}">Request Liquidity History</a>
            </li>
{{--            <li data-active-submenu="crypto-deposit-history">--}}
{{--                <a href="{{ route('user.crypto-deposit-history.get') }}">Crypto Deposit History</a>--}}
{{--            </li>--}}
{{--            <li data-active-submenu="crypto-withdraw-history">--}}
{{--                <a href="{{ route('user.crypto-withdraw-history.get') }}">Crypto Withdraw History</a>--}}
{{--            </li>--}}
        </ul>
    </li>
    <li class="has-submenu" data-active="my-profile/personal-detail">
        <a href="#" class="text-link"><img src="{{ asset("image/solopayment/profile.png") }}" alt="profile" class="menu-icon">My profle</a>
        <ul class="submenu">
            <li data-active-submenu="my-profile/personal-detail">
                <a href="{{ route('my-profile.personal-detail') }}">Personal Details</a>
            </li>
            @if(user()->role == 'user')
                <li data-active-submenu="my-profile/upload-documents">
                    <a href="{{ route('my-profile.upload-document') }}">Upload documents</a>
                </li>
            @endif
            <li data-active-submenu="my-profile/change-password">
                <a href="{{ route('my-profile.change-password') }}">Change Password</a>
            </li>
        </ul>
    </li>
    @if(user()->role == 'admin')
        <li data-active="admin/settings">
            <a href="{{ route('admin.settings.get') }}"><img src="{{ asset("image/solopayment/config.png") }}" alt="config" class="menu-icon">Settings</a>
        </li>
    @endif
</ul>

<script>
    var menu = document.querySelector(".list-left-menu-ul");
    var path = '{{ request()->path() }}';

    let setClickSubmenu = function(li){
        let submenu = li.querySelector(".submenu");
        li.querySelector("a.text-link").onclick = function(){
            window.event.preventDefault();
            li.classList.toggle('open');
            submenu.classList.toggle('open');
        }
    }

    menu.querySelectorAll("li").forEach(function(li){
        if(li.classList.contains('has-submenu')){
            setClickSubmenu(li);
        }
        var pathActive = li.getAttribute('data-active');
        var pathActiveSubmenu = li.getAttribute('data-active-submenu');
        if(pathActive != null){
            if(pathActive.split("|").indexOf(path) != -1){
                li.classList.add("active");
            }
        }
        if(pathActiveSubmenu != null){
            if(pathActiveSubmenu.split("|").indexOf(path) != -1){
                li.classList.add("submenu-active");
                li.closest(".has-submenu").classList.add("open");
                li.closest(".submenu").classList.add("open");
            }
        }
    });
</script>
