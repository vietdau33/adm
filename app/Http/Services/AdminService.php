<?php

namespace App\Http\Services;

use App\Models\BannerModel;
use App\Models\LinkDaily;
use App\Models\Settings;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public static function settingSaveProfit(Request $request): JsonResponse
    {
        $settings = $request->all();
        $setting = Settings::whereGuard('admin')->whereType('profit')->first();
        if ($setting == null) {
            return jsonError('Setting not exists!');
        }

        try {
            $setting->setting_data = json_encode($settings);
            $setting->save();

            return jsonSuccess('Save setting Profit success!');
        } catch (Exception $exception) {
            return jsonError('Cannot save setting profit. Please reload page and try again!');
        }
    }
}
