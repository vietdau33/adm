<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getSettingAttribute()
    {
        return json_decode($this->setting_data, 0);
    }

    public static function getSettings(){
        return self::whereGuard('admin')->get()
            ->groupBy('type')
            ->map(function($group) {
                return $group->first();
            });
    }
}
