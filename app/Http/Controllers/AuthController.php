<?php

namespace App\Http\Controllers;

use App\Exceptions\UserException;
use App\Http\Helpers\OtpHelpers;
use App\Models\SystemSetting;
use App\Models\User;
use App\Http\Requests\User\UserLoginRequest as LoginRq;
use App\Http\Requests\User\UserRegisterRequest as RegisterRq;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AuthController extends Controller{

    public function loginView(){
        return view('auth.login');
    }

    public function loginPost(LoginRq $request): JsonResponse
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json([
                'success'   => true,
                'message'   => Lang::get("auth.login_success"),
                'redirect'  => "home"
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "Info login not correct",
        ]);
    }

    public function registerView(){
        return view('auth.register');
    }

    /**
     * @throws UserException
     */
    public function registerPost(RegisterRq $request): JsonResponse
    {
        $reflink = $request->get('reflink', '');
        $userRef = null;

        if($reflink != ''){
            $userRef = User::getUserByReflink($reflink, true);
        }

        if($userRef == null){
            $reflink = '';
        }

        do{
            $newRef = Str::random(8);
        }while(User::getUserByReflink($newRef, true) != null);

        $superParentParent = $userRef == null ? json_encode([], 1) : $userRef->super_parent;
        $superParentParent = json_decode($superParentParent, 1);
        $superParentParent[] = $newRef;

        $refIsAdmin = !($userRef == null) && $userRef->role == 'admin';

        User::create([
            'username'          => strtolower($request->username),
            'reflink'           => $newRef,
            'password'          => Hash::make($request->password),
            'fullname'          => $request->fullname,
            'email'             => strtolower($request->email),
            'phone'             => $request->phone,
            'password_old'      => json_encode([$request->password]),
            'upline_by'         => $reflink,
            'money_invest'      => '0',
            'money_wallet'      => '0',
            'level'             => (int)($userRef->level ?? 0) + 1,
            'super_parent'      => json_encode($superParentParent),
            'rate_ib'           => $refIsAdmin ? SystemSetting::getSetting('max-ib', 0) : 0,
            'ref_is_admin'      => $refIsAdmin
        ]);

        $this->loginPost(new LoginRq([
            'username' => $request->username,
            'password' => $request->password,
        ]));

        User::sendOtp($request->username);

        return response()->json([
            'success'   => true,
            'message'   => Lang::get("auth.register_success"),
            'redirect'  => "login"
        ]);
    }

    public function otpVerifyView(){
        if(!Auth::check()){
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
        if($otp == null){
            return response()->json([
                'success' => false,
                'message' => Lang::get("auth.otp_is_required")
            ]);
        }
        $otpCheck = User::verifyOtp($otp, Auth::user()->username);
        if(!$otpCheck){
            return response()->json([
                'success' => false,
                'message' => Lang::get("auth.otp_not_valid")
            ]);
        }
        return response()->json([
            'success'   => true,
            'message'   => Lang::get("auth.otp_valid"),
            'redirect'  => 'home'
        ]);
    }

    /**
     * @throws UserException
     */
    public function reSendOtp(): JsonResponse
    {
        if(!Auth::check()){
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

    public function forgotPasswordView(){
        return view('auth.forgot');
    }

    /**
     * @throws UserException
     */
    public function forgotPasswordPost(Request $request): JsonResponse
    {
        if($request->username == null){
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
        if($otpCode == ''){
            return response()->json([
                'success' => false,
                'message' => 'OTP code has required!'
            ]);
        }
        $statusCheckOtp = User::verifyOtp($otpCode, session('username-forgot'));
        if(!$statusCheckOtp){
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

        if($password == '' || $repassword == ''){
            return response()->json([
                'success' => false,
                'message' => 'Password an Re-Password has required!'
            ]);
        }

        if($password != $repassword){
            return response()->json([
                'success' => false,
                'message' => 'Password and Re-Password not match!'
            ]);
        }

        $user = User::getUserByUsername(session('username-forgot'));
        $passOld = json_decode($user->password_old, 1);
        if(in_array($password, $passOld)){
            return jsonError('The new password must be different from the last 3 passwords');
        }

        if(count($passOld) == 3){
            array_shift($passOld);
        }
        $passOld[] = $password;

        $user->password = Hash::make($password);
        $user->password_old = json_encode($passOld);
        $user->save();

        session()->forget('username-forgot');
        return response()->json([
            'success' => true,
            'message' => 'Password changed!',
            'redirect'=> 'login'
        ]);
    }

    public function changePasswordPost(Request $request){
        $currentPass = trim($request->get('current-password', ''));
        $newPassword = trim($request->get('password', ''));
        $rePassword  = trim($request->get('re-password', ''));
        $otp        = (int)($request->otp_code ?? 0);
        $otpKey     = $request->otp_key ?? "";

        if($otpKey == ""){
            return jsonError("You can get OTP key then enter OTP code to input before submit change password!");
        }

        if(
            $currentPass == ""
            || $newPassword == ""
            || $rePassword == ""
            || $otp == ""
        ){
            return jsonError("Form not valid!");
        }

        if($newPassword != $rePassword){
            return jsonError("New Password and Re-New Password not match!");
        }

        if(!Hash::check($currentPass, Auth::user()->password)){
            return jsonError("Current password not correct!");
        }

        $user = User::getUserByUsername(Auth::user()->username);

        $passOld = json_decode($user->password_old, 1);
        if(in_array($newPassword, $passOld)){
            return jsonError('The new password must be different from the last 3 passwords');
        }

        if(!OtpHelpers::verify($otp, $otpKey, true)->status){
            return jsonError("OTP does not match or has expired!");
        }

        if(count($passOld) == 3){
            array_shift($passOld);
        }
        $passOld[] = $newPassword;

        $user->password = Hash::make($newPassword);
        $user->password_old = json_encode($passOld);
        $user->save();
        return jsonSuccess("Change password success!");
    }
}
