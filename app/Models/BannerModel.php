<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    use HasFactory;

    protected $table = 'banner';

    public static function getBanners(){
        return self::whereActive(1)->get()->groupBy('position');
    }
}
