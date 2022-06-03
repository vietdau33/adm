<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class CryptoDeposit extends Model
{
    use HasFactory;

    protected $table = 'crypto_deposit';

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
}
