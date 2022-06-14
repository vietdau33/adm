<?php

namespace App\Http\Controllers;

use App\Exceptions\UserException;
use App\Http\Helpers\OtpHelpers;
use App\Models\MoneyModel;
use App\Models\User;
use App\Http\Requests\User\UserLoginRequest as LoginRq;
use App\Http\Requests\User\UserRegisterRequest as RegisterRq;
use App\Models\UserUsdt;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function loginView()
    {
        return view('auth.login');
    }

    public function loginPost(LoginRq $request): JsonResponse
    {
        $credentials = $request->only('username', 'password');
        $prevPath = session()->pull('prev_path', 'home');
        if (Auth::attempt($credentials)) {
            return response()->json([
                'success' => true,
                'message' => Lang::get("auth.login_success"),
                'redirect' => $prevPath
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "Username or password not correct",
        ]);
    }

    public function registerView()
    {
        return view('auth.register');
    }

    /**
     * @throws UserException
     */
    public function registerPost(RegisterRq $request): JsonResponse
    {
        $reflink = $request->reflink;
        $userRef = null;

        if (!empty($reflink)) {
            $userRef = User::getUserByReflink($reflink, true);
            if ($userRef == null) {
                return jsonError('User Reference not exists!');
            }
            if (User::countMoneyInvest($userRef->id) < 300) {
                return jsonError('User Reference has not invested enough 300 so you cannot register!');
            }
        }

        do {
            $newRef = Str::random(8);
        } while (
            User::getUserByReflink($newRef, true) != null
        );

        $superParentParent = $userRef == null ? json_encode([], 1) : $userRef->super_parent;
        $superParentParent = json_decode($superParentParent, 1);
        $superParentParent[] = $newRef;

        $refIsAdmin = $userRef != null && $userRef->role == 'admin';

        DB::beginTransaction();
        try {
            $newUserCreate = new User();
            foreach ([
                         'username' => strtolower($request->username),
                         'reflink' => $newRef,
                         'password' => Hash::make($request->password),
                         'fullname' => $request->fullname,
                         'email' => strtolower($request->email),
                         'phone' => $request->phone,
                         'password_old' => json_encode([]),
                         'upline_by' => $reflink ?? '',
                         'money_invest' => '0',
                         'money_wallet' => '0',
                         'level' => (int)($userRef->level ?? 0) + 1,
                         'super_parent' => json_encode($superParentParent),
                         'rate_ib' => 0,
                         'ref_is_admin' => $refIsAdmin
                     ] as $key => $value) {
                $newUserCreate->{$key} = $value;
            }
            $newUserCreate->save();

            $newUserMoney = new MoneyModel();
            $newUserMoney->user_id = $newUserCreate->id;
            $newUserMoney->save();

            $this->loginPost(new LoginRq([
                'username' => $request->username,
                'password' => $request->password,
            ]));

            User::sendOtp($request->username);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => Lang::get("auth.register_success"),
                'redirect' => "login"
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonError('Cannot create new account. Please contact to ADMIN!');
        }
    }

    public function otpVerifyView()
    {
        if (!Auth::check()) {
            return redirect()->to('/auth/login');
        }
        return view('auth.otp');
    }

    /**
     * @throws UserException
     */
    public function otpVerifyPost(Request $request): JsonResponse
    {
        $otp = $request->otp_code ?? null;
        if ($otp == null) {
            return response()->json([
                'success' => false,
                'message' => Lang::get("auth.otp_is_required")
            ]);
        }
        $otpCheck = User::verifyOtp($otp, Auth::user()->username);
        if (!$otpCheck) {
            return response()->json([
                'success' => false,
                'message' => Lang::get("auth.otp_not_valid")
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => Lang::get("auth.otp_valid"),
            'redirect' => 'home'
        ]);
    }

    /**
     * @throws UserException
     */
    public function reSendOtp(): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => Lang::get("auth.send_otp_can_login")
            ]);
        }
        User::sendOtp(Auth::user()->username);
        return response()->json([
            'success' => true,
            'message' => Lang::get("auth.send_otp_success")
        ]);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->to('/home');
    }

    public function forgotPasswordView()
    {
        return view('auth.forgot');
    }

    /**
     * @throws UserException
     */
    public function forgotPasswordPost(Request $request): JsonResponse
    {
        if ($request->username == null) {
            return response()->json([
                'success' => false,
                'message' => 'username has required!'
            ]);
        }
        User::sendOtp($request->username);
        session()->push("username-forgot", $request->username);
        return response()->json([
            'success' => true,
            'message' => 'Send OTP!'
        ]);
    }

    public function confirmOTPPost(Request $request): JsonResponse
    {
        $otpCode = $request->otp_code ?? '';
        if ($otpCode == '') {
            return response()->json([
                'success' => false,
                'message' => 'OTP code has required!'
            ]);
        }
        $statusCheckOtp = User::verifyOtp($otpCode, session('username-forgot'));
        if (!$statusCheckOtp) {
            return response()->json([
                'success' => false,
                'message' => 'OTP code not match!'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'OTP code matched!'
        ]);
    }

    /**
     * @throws UserException
     */
    public function editPasswordForgot(Request $request): JsonResponse
    {
        $password = trim($request->password ?? '');
        $repassword = trim($request->get('password-confirm', ''));

        if ($password == '' || $repassword == '') {
            return response()->json([
                'success' => false,
                'message' => 'Password an Re-Password has required!'
            ]);
        }

        if ($password != $repassword) {
            return response()->json([
                'success' => false,
                'message' => 'Password and Re-Password not match!'
            ]);
        }

        $user = User::getUserByUsername(session('username-forgot'));
        $user->password = Hash::make($password);
        $user->save();

        session()->forget('username-forgot');
        return response()->json([
            'success' => true,
            'message' => 'Password changed!',
            'redirect' => 'login'
        ]);
    }

    /**
     * @throws UserException
     */
    public function changePasswordPost(Request $request): JsonResponse
    {
        $currentPass = trim($request->get('current-password', ''));
        $newPassword = trim($request->get('password', ''));
        $rePassword = trim($request->get('re-password', ''));
        $otp = (int)($request->otp_code ?? 0);
        $otpKey = $request->otp_key ?? "";
        $statusOnOtp = false;

        if ($statusOnOtp && $otpKey == "") {
            return jsonError("You can get OTP key then enter OTP code to input before submit change password!");
        }

        if (
            $currentPass == ""
            || $newPassword == ""
            || $rePassword == ""
            || ($statusOnOtp && $otp == "")
        ) {
            return jsonError("Form not valid!");
        }

        if ($newPassword != $rePassword) {
            return jsonError("New Password and Re-New Password not match!");
        }

        if (!Hash::check($currentPass, user()->password)) {
            return jsonError("Current password not correct!");
        }

        if ($statusOnOtp && !OtpHelpers::verify($otp, $otpKey, true)->status) {
            return jsonError("OTP does not match or has expired!");
        }

        $user = user();
        $user->password = Hash::make($newPassword);
        $user->save();
        return jsonSuccess("Change password success!");
    }

    public function generateGoogleAuthenSerect(): JsonResponse
    {
        try {
            $google2fa = app('pragmarx.google2fa');
            $serect = $google2fa->generateSecretKey();
            $qrImage = $google2fa->getQRCodeInline(
                config('app.name'),
                user()->email,
                $serect
            );
            return response()->json([
                'success' => true,
                'serect' => $serect,
                'image' => $qrImage
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => "Has error generate Google 2FA, please reload page!"
            ]);
        }
    }

    public function enable2FAAuthen(Request $request): JsonResponse
    {
        try {
            $serect = $request->serect;
            $code = $request->code;
            if (empty($code)) {
                return response()->json([
                    'success' => false,
                    'message' => "Please enter code before enable!"
                ]);
            }

            $google2fa = app('pragmarx.google2fa');

            if (!$google2fa->verifyKey($serect, $code)) {
                return response()->json([
                    'success' => false,
                    'message' => "Code verify not match!"
                ]);
            }

            $user = user();
            $user->google2fa_secret = $serect;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => "2FA enabled!"
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => "Has error enable Google 2FA, please reload page!"
            ]);
        }
    }

    public function deactive2FA(): JsonResponse
    {
        try {
            $user = user();
            $user->google2fa_secret = null;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => '2FA deactived!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Has error on deactive 2fa! Please reload page!'
            ]);
        }
    }
}
