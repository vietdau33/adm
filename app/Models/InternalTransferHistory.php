<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class InternalTransferHistory extends Model
{
    use HasFactory;

    protected $table = 'internal_transfer_history';

    public static function __insert($aryData){
        $history = new self;
        foreach ($aryData as $key => $val){
            $history->{$key} = $val;
        }
        $history->save();
        return $history;
    }

    public function user_from(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function user_to(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_username', "username");
    }

    public static function getHistory(){
        $isAdmin    = Auth::user()->role == 'admin';
        $userid     = Auth::user()->id;
        $transferHistory = self::with('user_from')->with('user_to');
        if($isAdmin){
            $transferHistory = $transferHistory->get();
        }else{
            $transferHistory = $transferHistory
                                    ->where(['userid' => $userid])
                                    ->orWhere(['to_username' => Auth::user()->username])
                                    ->get();
        }
        return $transferHistory->filter(function($user){
            return $user->user_from != null && $user->user_to != null;
        });
    }
}
