<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkDaily extends Model
{
    use HasFactory;

    protected $table = 'link_daily';

    public static function getLinkDailyRandom()
    {
        $links = self::whereActive(1)->get();
        if ($links->count() <= 0) {
            return null;
        }
        return $links->random(1)->first();
    }
}
