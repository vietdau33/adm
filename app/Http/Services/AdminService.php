<?php

namespace App\Http\Services;

use App\Models\BannerModel;
use App\Models\CryptoWithdraw;
use App\Models\LinkDaily;
use App\Models\Settings;
use App\Models\SystemSetting;
use App\Models\Withdraw;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminService
{
    public static function bannerCreate(Request $request): JsonResponse
    {
        $location = $request->location;
        if (!in_array($location, ['top', 'center'])) {
            return jsonError('Position Banner only TOP or CENTER');
        }

        $imgPC = $request->file('img_pc');
        $imgSP = $request->file('img_sp');

        if (empty($imgPC) && empty($imgSP)) {
            return jsonError('Please choose Image Banner!');
        }

        if (empty($imgPC) && !empty($imgSP)) {
            $imgPC = $imgSP;
        }

        if (!empty($imgPC) && empty($imgSP)) {
            $imgSP = $imgPC;
        }

        $originNamePC = $imgPC->getClientOriginalName();
        $originNameSP = $imgSP->getClientOriginalName();

        $aryDataSave = [
            'user_id' => user()->id,
            'position' => $location,
            'pc_real_name' => $originNamePC,
            'pc_path' => sha1(bcrypt($originNamePC)) . '.doc',
            'sp_real_name' => $originNameSP,
            'sp_path' => sha1(bcrypt($originNameSP)) . '.doc',
        ];

        try {
            $imgPC->storeAs('public/banner', $aryDataSave['pc_path']);
            $imgSP->storeAs('public/banner', $aryDataSave['sp_path']);

            if (ModelService::insert(BannerModel::class, $aryDataSave) !== false) {
                return jsonSuccess('Save banner success!');
            }

            return jsonError('Cannot save banner. Please try again!');
        } catch (Exception $exception) {
            return jsonError('Upload Image Error. Please reload page and try again!');
        }
    }

    public static function deleteBanner($id): JsonResponse
    {
        $banner = BannerModel::whereId($id)->first();
        if ($banner == null) {
            return jsonError('Banner not exists!');
        }

        try {
            $banner->delete();
            return jsonSuccess('Delete banner success!');
        } catch (Exception $exception) {
            return jsonError('Cannot delete banner. Please reload page and try again!');
        }
    }

    public static function bannerChangeStatus(int $id, int $status): JsonResponse
    {
        if (!in_array($status, [0, 1], true)) {
            return jsonError('Status not correct!');
        }

        $banner = BannerModel::whereId($id)->first();
        if ($banner == null) {
            return jsonError('Banner not exists!');
        }

        try {
            $banner->active = $status;
            $banner->save();
            return jsonSuccess('Change statu banner success!');
        } catch (Exception $exception) {
            return jsonError('Cannot change status banner. Please reload page and try again!');
        }
    }

    public static function linkDailyCreate(Request $request): JsonResponse
    {
        if (empty($request->link)) {
            return jsonError('Missing Link Mission Daily!');
        }
        $regex = '/^(https?:\/\/)/';
        if (!preg_match($regex, $request->link)) {
            return jsonError('Link Mission Daily not correct!');
        }
        $aryDataSave = [
            'user_id' => user()->id,
            'link' => $request->link
        ];
        if (ModelService::insert(LinkDaily::class, $aryDataSave)) {
            return jsonSuccess('Create Link Daily Success!');
        }
        return jsonError('Cannot create link daily!');
    }

    public static function deleteLinkMission($id): JsonResponse
    {
        $link = LinkDaily::whereId($id)->first();
        if ($link == null) {
            return jsonError('Link Mission Daily not exists!');
        }

        try {
            $link->delete();
            return jsonSuccess('Delete link success!');
        } catch (Exception $exception) {
            return jsonError('Cannot delete link. Please reload page and try again!');
        }
    }

    public static function linkMissionChangeStatus(int $id, int $status): JsonResponse
    {
        if (!in_array($status, [0, 1], true)) {
            return jsonError('Status not correct!');
        }

        $link = LinkDaily::whereId($id)->first();
        if ($link == null) {
            return jsonError('Link not exists!');
        }

        try {
            $link->active = $status;
            $link->save();
            return jsonSuccess('Change status Link success!');
        } catch (Exception $exception) {
            return jsonError('Cannot change status link. Please reload page and try again!');
        }
    }

    public static function saveSettings(Request $request, $type): JsonResponse
    {
        $settings = $request->all();
        $setting = Settings::whereGuard('admin')->whereType($type)->first();
        if ($setting == null) {
            return jsonError('Setting not exists!');
        }

        try {
            $setting->setting_data = json_encode($settings);
            $setting->save();

            return jsonSuccess('Save setting ' . ucfirst($type) . ' success!');
        } catch (Exception $exception) {
            return jsonError("Cannot save setting $type. Please reload page and try again!");
        }
    }

    public static function saveSystemSetting(Request $request): JsonResponse
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

    public static function changeStatusWithdraw(Request $request): JsonResponse
    {
        $withdrawId = $request->id;
        $status = (int)($request->status ?? 9);

        if (empty($withdrawId)) {
            return jsonError('Not see withdraw id!');
        }

        if (!in_array($status, [1, 2, 3])) {
            return jsonError('Status not correct!');
        }

        $withdraw = Withdraw::whereId($withdrawId)->first();
        if ($withdraw == null) {
            return jsonError('Withdraw not exists!');
        }

        DB::beginTransaction();
        try {
            $withdraw->status = $status;
            $withdraw->save();

            if ($status === 3) {
                $user = $withdraw->user;
                $userMoney = $user->money;
                $userMoney->wallet += (double)$withdraw->amount;
                $userMoney->save();
            }

            DB::commit();
            return jsonSuccess('Change status withdraw success!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return jsonError('Cannot change status!');
        }
    }

    public static function requestCryptoWithdrawPost(): JsonResponse
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
}
