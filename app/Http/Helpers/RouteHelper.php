<?php

namespace App\Http\Helpers;

use Exception;

class RouteHelper{
    public static function requireRoute($name){
        try{
            @require_once base_path("routes/" . $name . ".php");
        }catch(Exception $exception){
            print_r("Cannot require route: " . $name . "\n");
            print_r($exception->getMessage());
            die();
        }
    }
}
