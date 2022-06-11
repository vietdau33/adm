<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;

    protected $table = 'withdraw';

    public function getStatus($html = true): string
    {
        switch ($this->status) {
            case 0:
                $status = 'Pending';
                $color = 'primary';
                break;
            case 1:
                $status = "Accepted";
                $color = 'success';
                break;
            case 2:
                $status = 'Cancel';
                $color = 'warning';
                break;
            default:
                $status = 'Not Found';
                $color = 'secondary';
        }
        if (!$html) return $status;
        return '<span class="text-' . $color . '">' . $status . '</span>';
    }

    public static function getHistories($paginate = false, $with_param_search = false)
    {
        $histories = self::whereUserId(user()->id);
        if ($with_param_search === true) {
            if (!empty(request()->start_date)) {
                $histories->where('created_at', '>=', request()->start_date . ' 00:00:00');
            }
            if (!empty(request()->end_date)) {
                $histories->where('created_at', '<=', request()->end_date . ' 23:59:59');
            }
        }
        return $paginate === false ? $histories->get() : $histories->paginate($paginate)->appends(request()->query());
    }
}
