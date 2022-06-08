<?php

namespace App\Http\Controllers;

use App\Exceptions\UserException;
use App\Models\CryptoWithdraw;
use App\Models\SystemSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\TransferToAdmin;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function home()
    {
        session()->flash('menu-active', 'dashboard');
        return view('admin.home');
    }

    public function listMember()
    {
        session()->flash('menu-active', 'list-member');
        return view('admin.list-member');
    }

    public function money()
    {
        session()->flash('menu-active', 'money');
        return view('admin.money');
    }

    public function reportTransfer()
    {
        session()->flash('menu-active', 'report-transfer');
        return view('admin.report-transfer');
    }

    public function banner()
    {
        session()->flash('menu-active', 'banner');
        return view('admin.banner');
    }

    public function linkMission()
    {
        session()->flash('menu-active', 'link-mission');
        return view('admin.link');
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
        $typeRequest = strtolower($request->type ?? '');
        $id = (int)($request->code ?? 0);

        if (!in_array($typeRequest, ['agree', 'cancel'])) {
            return jsonError("Type request error!");
        }

        $transfer = CryptoWithdraw::getCryptoById($id);
        if ($transfer == null) {
            return jsonError("Transfer cannot find in database!");
        }

        if ($typeRequest == 'cancel') {
            $statusBackMoney = CryptoWithdraw::backAmountInCancelRequest($id);
            if ($statusBackMoney === false) {
                return jsonError("Back money to user error!");
            }
        }

        $transfer->status = $typeRequest == 'agree' ? 1 : 2;
        $transfer->save();

        return jsonSuccess(ucfirst($typeRequest) . " success!");
    }

    public function settingsView()
    {
        $systemSetting = SystemSetting::buildSetting();
        return view("pages.settings", compact("systemSetting"));
    }

    public function saveSystemSetting(Request $request): JsonResponse
    {
        $type = $request->type ?? false;
        if ($type === false) {
            return jsonError("Not found type system setting!");
        }
        switch ($type) {
            case "interest-rate" :
                $result = SystemSetting::saveInterestRateSolo($request);
                break;
            case "bonus" :
                $result = SystemSetting::saveBonusSolo($request);
                break;
            case "withdraw" :
                $result = SystemSetting::saveWithdrawSolo($request);
                break;
            default :
                return jsonError("Type setting error!");
        }
        if ($result['success'] === true) {
            return jsonSuccess("Save success!");
        }
        return jsonError("Save fail: " . $result['message']);
    }
}
