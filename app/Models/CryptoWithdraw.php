<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class CryptoWithdraw extends Model
{
    use HasFactory;
    protected $table = 'crypto_withdraw';

    public static function __insert($aryData){
        $history = new self;
        foreach ($aryData as $key => $val){
            $history->{$key} = $val;
        }
        $history->save();
        return $history;
    }

    public static function getHistory(){
        $history = self::with('user_request');
        if(Auth::user()->role == 'admin'){
            return $history->get();
        }
        return $history->where(['user_transfer' => Auth::user()->username])->get();
    }

    public function user_request(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_transfer', "username");
    }

    public static function getRequestPending(){
        return self::with('user_request')->where(['status' => 0])->get();
    }

    public static function getCryptoById($id){
        return self::where(['id' => $id])->first();
    }

    public static function backAmountInCancelRequest($id){
        $transfer = self::getCryptoById($id);
        $userTransfer = User::getUserByUsername($transfer->user_transfer, true);
        if($userTransfer == null){
            return false;
        }
        $userTransfer->money_wallet = (float)$userTransfer->money_wallet + (float)$transfer->amount;
        $userTransfer->save();
        return true;
    }

    public function getStatus($html = true): string
    {
        switch ($this->status){
            case 0:
                $status = 'Pending';
                $color = 'primary';
                break;
            case 1:
                $status = "Accepted";
                $color = 'success';
                break;
            case 2:
                $status = 'Cancel';
                $color = 'warning';
                break;
            default:
                $status = 'Not Found';
        }
        if(!$html) return $status;
        return '<span class="text-' . $color . '">' . $status . '</span>';
    }
}
