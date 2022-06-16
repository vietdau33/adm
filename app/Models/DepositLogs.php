<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DepositLogs extends Model
{
    use HasFactory;

    protected $table = 'deposit_logs';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function getDepositHistories($paginate = false, $with_param_search = false)
    {
        $histories = self::whereUserId(user()->id);
        if ($with_param_search !== false) {
            if (!empty(request()->start_date)) {
                $histories->where('created_at', '>=', request()->start_date . ' 00:00:00');
            }
            if (!empty(request()->end_date)) {
                $histories->where('created_at', '<=', request()->end_date . ' 23:59:59');
            }
            if (!empty(request()->username)) {
                $user = User::getUserByUsername(request()->username, true);
                if ($user != null) {
                    $histories->whereUserId($user->id);
                }
            }
        }
        $histories->orderBy('created_at', 'DESC');
        return $paginate === false ? $histories->get() : $histories->paginate($paginate)->appends(request()->query());
    }

    public static function countMoneyDeposit()
    {
        return self::all()->sum('amount');
    }
}
