@php $currentPage = $datas->currentPage() @endphp
@php $lastPage = $datas->lastPage() @endphp
@php $isFirstPage = $currentPage == 1 @endphp
@php $isLastPage = $currentPage == $lastPage @endphp
@php $GLOBALS['datas'] = $datas @endphp
@php
    function onClick($page): string{
        $datas = $GLOBALS['datas'];
        $path = '';
        if(!isset($datas->userListWithParent)){
            goto _return;
        }
        $path = "{$datas->urlPagination['path']}?size={$datas->urlPagination['size']}&page={$page}";
        _return:
        return "SearchForm.gotoPagePagination(this, $page, '{$path}')";
    }
@endphp
<div class="pagination">
    <a href="javascript:void(0)" onclick="{{ !$isFirstPage ? onClick($currentPage - 1) : "return false;" }}">
        <i class="fas fa-chevron-left prev {{ $isFirstPage ? "disabled" : "" }}"></i>
    </a>
    @for($i = 1; $i <= $lastPage; $i++)
        @php $isActive = $currentPage == $i @endphp
        @php $activeCls = $isActive ? "active" : "" @endphp
        @php $onClick = !$isActive ? onClick($i) : "return false;" @endphp
        <a href="javascript:void(0)" class="page-pagination {{ $activeCls }}" onclick="{{ $onClick }}">{{ $i }}</a>
    @endfor
    <a href="javascript:void(0)" onclick="{{ !$isLastPage ? onClick($currentPage + 1) : "return false;" }}">
        <i class="fas fa-chevron-right next {{ $isLastPage ? "disabled" : "" }}"></i>
    </a>
</div>
