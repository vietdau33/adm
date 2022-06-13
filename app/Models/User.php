<?php

namespace App\Models;

use App\Exceptions\UserException;
use App\Http\Helpers\MailHelper;
use App\Http\Helpers\OtpHelpers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Encryption\Encrypter;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Seshac\Otp\Otp;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'username', 'password', 'fullname', 'email',
        'phone', 'birthday', 'address', 'phone_telegram', 'login_fail', 'password_old',
        'otp_key', 'otp_public_key', 'verified', 'remember_token',
        'created_at', 'updated_at', 'reflink', 'role', 'upline_by',
        'money_invest', 'money_wallet', 'bonus_received_type1', 'bonus_received_type2',
        'level', 'rate_ib', 'money_ib', 'super_parent', 'ref_is_admin', 'google2fa_secret'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected string $custom_key_2fa = 'jo99dBUvBjOugMjSS62cOUTKns2nDKLn';

    public function setGoogle2faSecretAttribute($value): void
    {
        $encrypter = new Encrypter($this->custom_key_2fa, config('app.cipher'));
        $this->attributes['google2fa_secret'] = empty($value) ? null : $encrypter->encrypt($value);
    }

    public function getGoogle2faSecretAttribute($value)
    {
        $encrypter = new Encrypter($this->custom_key_2fa, config('app.cipher'));
        return empty($value) ? null : $encrypter->decrypt($value);
    }

    /**
     * @throws UserException
     */
    public static function sendOtp($username)
    {
        $otpGen = OtpHelpers::generate(24);
        $otp = $otpGen->otp;
        $otpPublicKey = $otpGen->key;

        $user = self::getUserByUsername($username);
        $user->otp_public_key = $otpPublicKey;
        $user->otp_key = $otp;
        $user->save();

        MailHelper::sendOtp([
            'email' => $user->email,
            'fullname' => $user->fullname,
            'otp' => $otp
        ]);
    }

    /**
     * @throws UserException
     */
    public static function verifyOtp($otp, $username): bool
    {
        $user = self::getUserByUsername($username);
        $verify = Otp::validate($user->otp_public_key, $otp);
        if (!$verify->status) {
            return false;
        }
        $user->otp_public_key = '';
        $user->otp_key = '';
        $user->verified = 1;
        $user->save();
        return true;
    }

    public function userUpline(): BelongsTo
    {
        return $this->belongsTo(User::class, 'upline_by', 'reflink');
    }

    public function getInvestmentAttribute()
    {
        $invest = InvestmentBought::whereUserId($this->id)->get()->groupBy('user_id');
        if ($invest->count() <= 0) {
            return null;
        }
        return $invest[$this->id];
    }

    /**
     * @throws UserException
     */
    public static function getUserByUsername($username, $returnNULL = false)
    {
        $user = self::where(['username' => $username, 'is_delete' => 0])->first();
        if ($user == null && !$returnNULL) {
            throw new UserException("Username not exists");
        }
        return $user;
    }

    /**
     * @throws UserException
     */
    public static function getUserById($id, $returnNULL = false)
    {
        $user = self::where(['id' => $id, 'is_delete' => 0])->first();
        if ($user == null && !$returnNULL) {
            throw new UserException("Id not exists");
        }
        return $user;
    }

    /**
     * @throws UserException
     */
    public static function getUserByEmail($email, $returnNULL = false)
    {
        $user = self::where(['email' => $email, 'is_delete' => 0])->first();
        if ($user == null && !$returnNULL) {
            throw new UserException("Email not exists");
        }
        return $user;
    }

    /**
     * @throws UserException
     */
    public static function getUserByReflink($reflink, $returnNULL = false, $select = ["*"])
    {
        $user = self::select($select)->where(['reflink' => $reflink, 'is_delete' => 0])->first();
        if ($user == null && !$returnNULL) {
            throw new UserException("Reflink not exists");
        }
        return $user;
    }

    public static function getUserByArrayReflink($aryReflink)
    {
        return self::where(['is_delete' => 0])->whereIn('reflink', $aryReflink)->get();
    }

    public static function transferToAdmin(User $user, array $arg): TransferToAdmin
    {
        $aryInsert = [
            'from' => Auth::user()->username,
            'to' => $user->username,
            'amount' => $arg['amount'],
            'note' => $arg['note'],
        ];
        return TransferToAdmin::__insert($aryInsert);
    }

    /**
     * @throws UserException
     */
    public static function getUserChildrent($reflink)
    {
        $user = self::getUserByReflink($reflink);
        return self::where(['is_delete' => 0])
            ->where('level', '>', $user->level)
            ->get()
            ->filter(function ($_u) use ($reflink) {
                $superParent = json_decode($_u->super_parent, 1);
                return in_array($reflink, $superParent);
            });
    }

    public static function getStructUsernameWithReflink($aryReflink)
    {
        $users = self::getUserByArrayReflink($aryReflink);
        return $users->map(function ($user) {
            return $user->username;
        })->toArray();
    }

    /**
     * @throws UserException
     */
    public static function buildTreeChildrent($reflink): array
    {
        $allChild = User::getUserChildrent($reflink)->sortBy(function ($child) {
            $superParent = json_decode($child->super_parent, 1);
            return -count($superParent);
        });
        $aryStructUser = [];
        $allChild->map(function ($child) use (&$aryStructUser) {
            $superParent = json_decode($child->super_parent, 1);
            if (count($aryStructUser) == 0) {
                $aryStructUser[] = $superParent;
                return;
            }
            foreach ($aryStructUser as $struct) {
                $diff = array_diff($superParent, $struct);
                if (count(array_intersect($diff, $superParent)) == 0) {
                    return;
                }
            }
            $aryStructUser[] = $superParent;
        });
        if (empty($aryStructUser)) {
            $user = self::getUserByReflink($reflink);
            $aryStructUser[] = json_decode($user->super_parent);
        }
        return $aryStructUser;
    }

    public static function validateTransferLiquidityTime()
    {
        $usernameLogin = Auth::user()->username;
        $lastTransfer = TransferToAdmin::where(['from' => $usernameLogin, 'status' => 1])->orderBy("created_at", "DESC")->first();
        if ($lastTransfer == null) {
            return true;
        }
        $difference = Carbon::parse(Carbon::now())->diffInDays($lastTransfer->created_at);
        $numDayBlock = (int)SystemSetting::getSetting("number-of-day", 30);
        if ($difference >= $numDayBlock) {
            return true;
        }
        return $numDayBlock - $difference;
    }

    public function getMoneyAttribute() //dont delete
    {
        return $this->belongsTo(MoneyModel::class, 'id', 'user_id')->first();
    }

    public function usdt(): BelongsTo
    {
        return $this->belongsTo(UserUsdt::class, 'id', 'user_id');
    }

    public static function countMoneyInvest($user_id)
    {
        return InvestmentBought::whereUserId($user_id)->get()->sum('money_buy');
    }

    public static function countNumberF1ByRef($reflink): int
    {
        return self::whereUplineBy($reflink)->get()->count();
    }

    public static function countNumberF1ById($id): int
    {
        $user = self::whereId($id)->first();
        if ($user == null) {
            return 0;
        }
        return self::countNumberF1ByRef($user->reflink);
    }

    public static function getUserWithCondition(array $conditions, $paginate = false)
    {
        $users = User::whereIsDelete(0);
        if (isset($conditions['username'])) {
            $users->whereUsername($conditions['username']);
        }
        if (isset($conditions['start_date'])) {
            $users->where('created_at', '>=', $conditions['start_date'] . ' 00:00:00');
        }
        if (isset($conditions['end_date'])) {
            $users->where('created_at', '<=', $conditions['end_date'] . ' 23:59:59');
        }
        if (isset($conditions['level'])) {
            $users->whereLevel($conditions['level']);
        }
        if(is_user()) {
            $users->whereJsonContains('super_parent', user()->reflink);
        }
        return $paginate === false ? $users->get() : $users->paginate($paginate)->appends(request()->query());
    }

    public static function getUserWithParamCondition($paginate = false)
    {
        $request = request();
        $condition = [];
        if (!empty($request->username)) {
            $condition['username'] = $request->username;
        }
        if (!empty($request->start_date)) {
            $condition['start_date'] = $request->start_date;
        }
        if (!empty($request->end_date)) {
            $condition['end_date'] = $request->end_date;
        }
        if (!empty($request->level)) {
            $condition['level'] = user()->level + (int)$request->level;
        }
        return self::getUserWithCondition($condition, $paginate);
    }
}
