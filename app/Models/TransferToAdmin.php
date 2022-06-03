<?php

namespace App\Models;

use App\Exceptions\UserException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TransferToAdmin extends Model
{
    use HasFactory;

    protected $table = 'transfer_to_admin';

    public static function __insert($aryData){
        $model = new self;
        foreach ($aryData as $key => $val){
            $model->{$key} = $val;
        }
        $model->save();
        return $model;
    }

    public static function getListTransferPending(){
        return self::where(['status' => 0])->with("userRequest")->get();
    }

    public static function getListTransferHistory(){
        if(Auth::user()->role == 'admin'){
            return self::where('status', "<>", 0)->with('userRequest')->with('userRequestTo')->get();
        }
        return self::where(['from' => Auth::user()->username])->with('userRequest')->with('userRequestTo')->get();
    }

    public static function getTrasferById($id){
        return self::where(['id' => $id])->first();
    }

    public function status(): string
    {
        switch ($this->status){
            case 0:
                return '<span class="text-info font-italic">Pending</span>';
            case 1:
                return '<span class="text-success">' . (Auth::user()->role == 'admin' ? "Agree" : "Done") . '</span>';
            case 2:
                return '<span class="text-danger">Cancel</span>';
            default:
                return "";
        }
    }

    /**
     * @throws UserException
     */
    public static function backAmountInCancelRequest($username, $amount): bool
    {
        $user = User::getUserByUsername($username);
        $user->money_wallet = (int)$user->money_wallet + (int)$amount;
        $user->save();
        return true;
    }

    public function userRequest(){
        return $this->belongsTo(User::class, 'from', "username");
    }

    public function userRequestTo(){
        return $this->belongsTo(User::class, 'to', "username");
    }
}
