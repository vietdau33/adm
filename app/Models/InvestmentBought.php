<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestmentBought extends Model
{
    use HasFactory;

    protected $table = 'investment_bought';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function getInvestBought($user_id, $isActiving = true): Collection
    {
        $invest = self::whereUserId($user_id)->get();
        return $isActiving ? self::filterInvestActiving($invest) : $invest;
    }

    public static function filterInvestActiving(Collection $collection): Collection
    {
        return $collection->filter(function ($collect) {
            if ($collect->days == 0) {
                return true;
            }
            return diffDaysWithNow($collect->created_at) <= $collect->days;
        });
    }
}
