<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyMissionLogs extends Model
{
    use HasFactory;

    protected $table = 'daily_mission_logs';

    public static function showDailyToday(): bool
    {
        $c_today = Carbon::today();
        $c_now = Carbon::now();
        $hourNow = (int)$c_now->format('H');

        $today = $c_today->format('Y-m-d');
        $prevday = $c_today->subDay()->format('Y-m-d');
        $now = $c_now->format('Y-m-d H:i:s');

        $check = self::whereUserId(user()->id);
        if ($hourNow >= 7) {
            $check->where('created_at', '>=', $today . ' 07:00:00');
        } else {
            $check->where('created_at', '>=', $prevday . ' 07:00:00');
            $check->where('created_at', '<=', $now);
        }
        if ($check->get()->count() > 0) {
            return false;
        }

        $hasRecordNeedDaily = false;
        $now = Carbon::now();
        foreach (InvestmentBought::getInvestBought(user()->id) as $invest) {
            $dateCreate = Carbon::parse($invest->created_at);
            $diffTime = $dateCreate->diff($now);
            if(diffDaysWithNow($invest->created_at) > $invest->days) {
                continue;
            }

            if($diffTime->y + $diffTime->m + $diffTime->d > 0) {
                $hasRecordNeedDaily = true;
                break;
            }
            if($hourNow >= 7 && (int)$dateCreate->format('H') < 7) {
                $hasRecordNeedDaily = true;
                break;
            }
            if(
                (int)$dateCreate->format('d') < $now->format('d')
                && (int)$dateCreate->format('H') < 7
            ) {
                $hasRecordNeedDaily = true;
                break;
            }
        }

        return $hasRecordNeedDaily;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function link(): BelongsTo
    {
        return $this->belongsTo(LinkDaily::class, 'link_id', 'id');
    }
}
