<?php

namespace App\Http\Helpers;

use stdClass;

class Helper{

    /**
     * @param array $arrs
     * @return stdClass
     */
    public static function generateStdClass(array $arrs): stdClass
    {
        $obj = new stdClass();
        foreach ($arrs as $key => $arr) {
            $obj->{$key} = $arr;
        }
        return $obj;
    }
}
