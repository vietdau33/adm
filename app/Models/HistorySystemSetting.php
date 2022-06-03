<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class HistorySystemSetting extends Model
{
    use HasFactory;

    protected $table = 'history_system_setting';

    public static function saveHistory($type, $value): HistorySystemSetting
    {
        $history = new self;
        $history->type = $type;
        $history->value = $value;
        $history->save();
        return $history;
    }

    public static function __insert($aryData){
        $history = new self;
        foreach ($aryData as $key => $val){
            $history->{$key} = $val;
        }
        $history->save();
        return $history;
    }

    public static function getHistory($type){
        $defaultSize = SystemSetting::getDefaultSizePagination();
        $condition = [
            'type' => $type
        ];
        if(Auth::user()->role == 'user'){
            $condition['is_daily'] = 1;
        }
        return self::where($condition)->orderBy("created_at", 'DESC')->paginate($defaultSize);
    }

    public function dateCreate(){
        $format = Auth::user()->role == 'admin' ? "H:i d/m/Y" : "d/m/Y";
        return date($format, strtotime($this->created_at));
    }
}
