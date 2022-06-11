<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class BonusLogs extends Model
{
    use HasFactory;

    protected $table = 'bonus_logs';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function userForm(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_from', 'id');
    }

    public static function countMoneyBonus(): int
    {
        return self::all()->sum('money_bonus');
    }

    public static function getUserBonusHistories($paginate = false, $with_param_search = false) {
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
