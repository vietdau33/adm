<?php

namespace App\Http\Helpers;

use Illuminate\Database\Eloquent\Model;

class HistoryHelper{

    private $model;

    public function __construct($model){
        $this->model = new $model;
    }

    public function getHistory($from, $to){
        $from   = date('Y-m-d', strtotime($from)) . " 00:00:00";
        $to     = date('Y-m-d', strtotime($to)) . " 23:59:59";
        return $this->model->whereRaw("(created_at >= ? AND created_at <= ?)", [$from, $to])->orderBy("created_at", 'DESC');
    }

}
