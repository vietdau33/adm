<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Database\Eloquent\Model;

class ModelService
{
    public static function insert(string $model, array $datas)
    {
        try {
            !str_contains($model, 'App\Models') && $model = "App\Models\\$model";
            $model = app($model);
            foreach ($datas as $key => $data) {
                $model->{$key} = $data;
            }
            $model->save();
            return $model;
        }catch (Exception $exception) {
            logger($exception->getMessage());
            return false;
        }
    }
}
