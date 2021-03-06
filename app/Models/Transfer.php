<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    use HasFactory;

    protected $table = 'transfer';

    public function getUserReceiveAttribute()
    {
        return User::whereUsername($this->username_receive)->first();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function getHistories($paginate = false, $with_param_search = false)
    {
        //$histories = self::where(function ($query) {
        //    $query->where('user_id', user()->id);
        //    $query->orWhere('username_receive', user()->username);
        //});
        $histories = self::query();
        if ($with_param_search === true) {
            if (!empty(request()->start_date)) {
                $histories->where('created_at', '>=', request()->start_date . ' 00:00:00');
            }
            if (!empty(request()->end_date)) {
                $histories->where('created_at', '<=', request()->end_date . ' 23:59:59');
            }
        }
        return $paginate === false ? $histories->get() : $histories->paginate($paginate)->appends(request()->query());
    }

    public static function getHistoriesAll($paginate = false, $with_param_search = false)
    {
        $histories = self::where('id', '>', 0);
        if ($with_param_search === true) {
            if (!empty(request()->username)) {
                $user = User::getUserByUsername(request()->username, true);
                $histories->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                    $query->orWhere('username_receive', $user->username);
                });
            }
            if (!empty(request()->start_date)) {
                $histories->where('created_at', '>=', request()->start_date . ' 00:00:00');
            }
            if (!empty(request()->end_date)) {
                $histories->where('created_at', '<=', request()->end_date . ' 23:59:59');
            }
        }
        $histories->latest();
        return $paginate === false ? $histories->get() : $histories->paginate($paginate)->appends(request()->query());
    }

    public static function countMoneyTransfer()
    {
        return self::all()->sum('amount');
    }
}
