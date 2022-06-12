<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfitLogs extends Model
{
    use HasFactory;

    protected $table = 'profit_logs';

    public static function getProfitHistories($paginate = false, $with_param_search = false) {
        $histories = self::whereUserId(user()->id);
        if($with_param_search !== false) {
            if(!empty(request()->start_date)) {
                $histories->where('created_at', '>=', request()->start_date . ' 00:00:00');
            }
            if(!empty(request()->end_date)) {
                $histories->where('created_at', '<=', request()->end_date . ' 23:59:59');
            }
        }
        $histories->orderBy('created_at', 'DESC');
        return $paginate === false ? $histories->get() : $histories->paginate($paginate)->appends(request()->query());
    }
}
