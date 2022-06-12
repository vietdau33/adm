<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyMissionLogs extends Model
{
    use HasFactory;

    protected $table = 'daily_mission_logs';

    public static function isDailyToday(): bool
    {
        $check = self::whereUserId(user()->id);
        $check->where('created_at', '>=', date('Y-m-d') . ' 00:00:00');
        $check->where('created_at', '<=', date('Y-m-d') . ' 23:59:59');
        return $check->get()->count() > 0;
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
