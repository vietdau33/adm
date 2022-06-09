<?php

namespace App\Http\Controllers;

use App\Exceptions\UserException;
use App\Models\BannerModel;
use App\Models\HistorySystemSetting;
use App\Models\SystemSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Helpers\HistoryHelper;

class HomeController extends Controller
{
    public function home(){
        session()->flash('menu-active', 'dashboard');
        $banners = BannerModel::getBanners();
        return view('home', compact('banners'));
    }

    public function reflink($reflink): RedirectResponse
    {
        return redirect()->to("/auth/register?ref=$reflink");
    }

    /**
     */
    public function userList(){
        $defaultSizePage = SystemSetting::getDefaultSizePagination();
        if(Auth::user()->role == 'admin'){
            $userList = User::where(['level' => 0, 'role' => 'admin', 'is_delete' => 0]);
        }else{
            $userList = User::where(['username' => Auth::user()->username, 'is_delete' => 0]);
        }
        $userList = $userList->paginate($defaultSizePage);
        $userTree = [['username' => '', 'email' => '']];
        session()->flash('menu-active', 'list-member');
        return view('pages.user-list', compact('userList', 'userTree'));
    }

    /**
     * @throws UserException
     */
    public function userListHasParent($parent, Request $request): JsonResponse
    {
        $defaultSize = SystemSetting::getDefaultSizePagination();
        $sizePagination = $request->get('size', $defaultSize);
        $user = User::getUserById($parent);
        $superParent = json_decode($user->super_parent, 1);
        if(Auth::user()->role == 'user' && !in_array(Auth::user()->reflink, $superParent)){
            return jsonError("Permission Denied!");
        }
        $userList = User::where(['upline_by' => $user->reflink, 'is_delete' => 0])->paginate($sizePagination);
        $userList->userListWithParent = true;
        $userList->urlPagination = [
            "path" => $request->getPathInfo(),
            "size" => $sizePagination
        ];

        $html = view('pages.user-list.table', compact('userList'))->render();

        //$userParentTree
        $userTree = User::getUserByArrayReflink($superParent)->map(function($_u){
            return ['username' => $_u->username, 'email' => $_u->email];
        })->toArray();

        $treeParent = view('pages.user-list.tree-parent', compact('userTree'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'html' => $html,
                'tree_parent' => $treeParent
            ]
        ]);
    }

    public function searchUser(Request $request){
        $defaultSize = SystemSetting::getDefaultSizePagination();
        $size        = $request->get("size", $defaultSize);
        $username   = $request->get('username');
        $fromDate   = $request->get('from_date', '');
        $toDate     = $request->get('to_date', '');

        if($toDate != '' && $fromDate == ''){
            $fromDate = $toDate;
        }

        if($fromDate != ''){
            $fromDate = __d($fromDate, "Y/m/d") . " 00:00:00";
        }

        if($toDate != ''){
            $toDate = __d($toDate, "Y/m/d") . " 23:59:59";
        }

        if($username == null && $fromDate == null && $toDate == null){
            return response()->json([
                'success' => false,
                'message' => "Value search empty!"
            ]);
        }

        $userList = User::where(['is_delete' => 0]);
        if($username != null){
            $userList->where(['username' => $username]);
        }
        if($fromDate != '' && $toDate != ''){
            $userList->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $userListGet = $userList->get();
        $userList = $userList->paginate($size);

        $html = view('pages.user-list.table', compact('userList'))->render();
        $userTree = [];

        if($userListGet->count() == 1){
            $superParent = json_decode($userListGet->first()->super_parent, 1);
            //$userParentTree
            $userTree = User::getUserByArrayReflink($superParent)->map(function($_u){
                return $_u->username;
            })->toArray();
        }
        $treeParent = view('pages.user-list.tree-parent', compact('userTree'))->render();
        return response()->json([
            'success' => true,
            'typeSearch' => 'user',
            'data' => [
                'html' => $html,
                'tree_parent' => $treeParent
            ]
        ]);
    }

    /**
     * @throws UserException
     */
    public function getInfoUser($ref){
        $aryKeyResponse = ['fullname', 'birthday', 'phone', 'email'];
        /**
         * $user User
         */
        $user = User::getUserByReflink($ref, true, $aryKeyResponse);
        if($user == null){
            return jsonError("User not found!");
        }
        $user->birthday = date("d/m/Y", strtotime($user->birthday));
        return jsonSuccessData($user->toArray());
    }

    public function homePage(){
        return view("home-page.base");
    }
}
