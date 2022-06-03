<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryIb extends Model
{
    use HasFactory;

    protected $table = "history_ib";

    public static function __insert($aryData){
        $history = new self;
        foreach ($aryData as $key => $val){
            $history->{$key} = $val;
        }
        $history->save();
        return $history;
    }
}
