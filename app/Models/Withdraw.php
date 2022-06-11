<?php

namespace App\Models;

use App\Exceptions\UserException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdraw extends Model
{
    use HasFactory;

    protected $table = 'withdraw';

    public function getUserAttribute()
    {
        return User::whereId($this->user_id)->first();
    }

    public function getStatus($html = true): string
    {
        switch ($this->status) {
            case 0:
                $status = 'Pending';
                $color = 'secondary';
                break;
            case 1:
                $status = "Accepted";
                $color = 'primary';
                break;
            case 2:
                $status = 'Cancel';
                $color = 'danger';
                break;
            case 3:
                $status = 'Success';
                $color = 'success';
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

    /**
     * @throws UserException
     */
    public static function getWithdrawWorking($paginate = false, $with_param_search = false) {
        $withdraw = self::whereIn('status', [0, 1]);
        if ($with_param_search === true) {
            if (!empty(request()->start_date)) {
                $withdraw->where('created_at', '>=', request()->start_date . ' 00:00:00');
            }
            if (!empty(request()->end_date)) {
                $withdraw->where('created_at', '<=', request()->end_date . ' 23:59:59');
            }
            if (!empty(request()->username)) {
                $user = User::getUserByUsername(request()->username, true);
                if($user != null) {
                    $withdraw->whereUserId($user->id);
                }
            }
        }
        $withdraw->orderBy('created_at', 'DESC');
        return $paginate === false ? $withdraw->get() : $withdraw->paginate($paginate)->appends(request()->query());
    }
}
