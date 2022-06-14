<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

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
            if($invest->days > 0 && diffDaysWithNow($invest->created_at) > $invest->days) {
                continue;
            }

            if($diffTime->y + $diffTime->m + $diffTime->d > 0) {
                $hasRecordNeedDaily = true;
                break;
            }
            if($hourNow >= 7) {
                if((int)$dateCreate->format('H') < 7 || (int)$dateCreate->format('d') != $now->format('d')) {
                    $hasRecordNeedDaily = true;
                    break;
                }
            }elseif(
                (int)$dateCreate->format('d') != $now->format('d')
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

    /**
     * @throws Exception
     */
    public static function getDailyMissionHistories(): Collection
    {
        $start_date = Carbon::today()->subWeek()->format('Y-m-d');
        $end_date = Carbon::today()->format('Y-m-d');

        if (!empty(request()->start_date)) {
            $start_date = request()->start_date;
        }
        if (!empty(request()->end_date)) {
            $end_date = request()->end_date;
        }

        $histories = self::whereUserId(user()->id)
            ->where('created_at', '>=', $start_date . ' 00:00:00')
            ->where('created_at', '<=', $end_date . ' 23:59:59')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->keyBy(function($item) {
                return explode(' ', $item->created_at)[0];
            });

        $begin = new DateTime($start_date);
        $end = new DateTime($end_date);
        $results = new Collection();

        for($dt = $end; $dt >= $begin; $dt->modify('-1 day')){
            $date = $dt->format("Y-m-d");
            if(isset($histories[$date])) {
                $results->put($date, $histories[$date]);
            }else {
                $results->put($date, null);
            }
        }

        return $results;
    }
}
