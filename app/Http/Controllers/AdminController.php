<?php

namespace App\Http\Controllers;

use App\Exceptions\UserException;
use App\Http\Services\AdminService;
use App\Models\BannerModel;
use App\Models\BonusLogs;
use App\Models\DepositLogs;
use App\Models\LinkDaily;
use App\Models\ProfitLogs;
use App\Models\Settings;
use App\Models\SystemSetting;
use App\Models\Transfer;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\TransferToAdmin;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function home()
    {
        session()->flash('menu-active', 'dashboard');
        $totalBonus = BonusLogs::countMoneyBonus();
        $totalWithdraw = Withdraw::countMoneyWithdraw();
        $totalProfit = ProfitLogs::getTotalProfit();
        $totalDeposit = DepositLogs::countTotalMoneyDeposit();
        return view('admin.home', compact(
            'totalWithdraw',
            'totalBonus',
            'totalProfit',
            'totalDeposit'
        ));
    }

    public function listMember()
    {
        session()->flash('menu-active', 'list-member');
        $totalMember = User::all()->count();
        $users = User::getUserWithParamCondition(10);
        return view('admin.list-member', compact(
            'totalMember',
            'users'
        ));
    }

    /**
     * @throws UserException
     */
    public function money($type = 'deposit')
    {
        if($type == 'deposit') {
            return redirect()->route('admin.money.with-type', ['type' => 'withdraw']);
        }
        session()->flash('menu-active', 'money');
        $withdrawRequest = Withdraw::getWithdrawWorking(10, true);
        return view('admin.money', compact(
            'type',
            'withdrawRequest'
        ));
    }

    public function report($type = 'deposit')
    {
        session()->flash('menu-active', 'report');
        return view('admin.report', compact('type'));
    }

    public function reportTransfer()
    {
        session()->flash('menu-active', 'report-transfer');
        $histories = Transfer::getHistoriesAll(10, true);
        return view('admin.report-transfer', compact('histories'));
    }

    public function banner()
    {
        session()->flash('menu-active', 'banner');
        $banners = BannerModel::paginate(5);
        if ($banners->currentPage() > 1 && $banners->currentPage() > $banners->lastPage()) {
            return redirect()->to($banners->url(1));
        }
        return view('admin.banner', compact('banners'));
    }

    public function bannerCreate(Request $request): JsonResponse
    {
        return AdminService::bannerCreate($request);
    }

    public function bannerDelete(Request $request): JsonResponse
    {
        return AdminService::deleteBanner($request->id);
    }

    public function bannerChangeStatus(Request $request): JsonResponse
    {
        return AdminService::bannerChangeStatus((int)$request->id, (int)$request->status);
    }

    public function settings()
    {
        session()->flash('menu-active', 'settings');
        $settings = Settings::getSettings();
        return view('admin.settings', compact('settings'));
    }

    public function saveSettingProfit(Request $request): JsonResponse
    {
        return AdminService::saveSettings($request, 'profit');
    }

    public function saveSettingBonus(Request $request): JsonResponse
    {
        return AdminService::saveSettings($request, 'bonus');
    }

    public function saveSettingWithdraw(Request $request): JsonResponse
    {
        return AdminService::saveSettings($request, 'withdraw');
    }

    public function linkMission()
    {
        session()->flash('menu-active', 'link-mission');
        $links = LinkDaily::paginate(5);
        if ($links->currentPage() > 1 && $links->currentPage() > $links->lastPage()) {
            return redirect()->to($links->url(1));
        }
        return view('admin.link', compact('links'));
    }

    public function linkMissionCreate(Request $request): JsonResponse
    {
        return AdminService::linkDailyCreate($request);
    }

    public function linkMissionDelete(Request $request): JsonResponse
    {
        return AdminService::deleteLinkMission($request->id);
    }

    public function linkMissionChangeStatus(Request $request): JsonResponse
    {
        return AdminService::linkMissionChangeStatus((int)$request->id, (int)$request->status);
    }

    public function changeSetting(Request $request): JsonResponse
    {
        $type = $request->type ?? null;
        $value = $request->value ?? null;
        if (is_null($type) || is_null($value)) {
            return response()->json([
                'success' => false,
                'message' => 'Value empty or wrong format!'
            ]);
        }
        $settingType = ucfirst(strtolower($type));
        $validSetting = SystemSetting::{"validateSetting" . $settingType}($value);

        if (!($validSetting['success'] ?? true)) {
            return response()->json($validSetting);
        }

        $response = SystemSetting::changeSetting($type, $value);
        return response()->json($response);
    }

    public function requestLiquidity()
    {
        $listTransfer = TransferToAdmin::getListTransferPending();
        return view('pages.request-liquidity', compact('listTransfer'));
    }

    /**
     * @throws UserException
     */
    public function requestLiquidityPost(Request $request): JsonResponse
    {
        $typeRequest = strtolower($request->type ?? '');
        $id = (int)($request->code ?? 0);

        if (!in_array($typeRequest, ['agree', 'cancel'])) {
            return jsonError("Type request error!");
        }

        $transfer = TransferToAdmin::getTrasferById($id);
        if ($transfer == null) {
            return jsonError("Transfer cannot find in database!");
        }

        $transfer->status = $typeRequest == 'agree' ? 1 : 2;
        $transfer->admin_submit = Auth::user()->username;
        $transfer->save();

        if ($typeRequest == 'cancel') {
            TransferToAdmin::backAmountInCancelRequest($transfer->from, $transfer->amount);
        }

        return jsonSuccess(ucfirst($typeRequest) . " success!");
    }

    public function requestCryptoWithdrawPost(Request $request): JsonResponse
    {
        return AdminService::requestCryptoWithdrawPost($request);
    }

    public function settingsView()
    {
        $systemSetting = SystemSetting::buildSetting();
        return view("pages.settings", compact("systemSetting"));
    }

    public function saveSystemSetting(Request $request): JsonResponse
    {
        return AdminService::saveSystemSetting($request);
    }

    public function changeStatusWithdraw(Request $request): JsonResponse
    {
        return AdminService::changeStatusWithdraw($request);
    }
}
