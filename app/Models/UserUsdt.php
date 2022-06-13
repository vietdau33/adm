<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserUsdt extends Model
{
    use HasFactory;

    protected $table = 'user_usdt';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function createUsdtAccount($user_id): bool
    {
        $path = app_path('Python/create_account.py');
        exec("python3 $path $user_id", $output);
        if ($output[0] == 'Fail') {
            return false;
        }
        try {
            $data = file_get_contents(app("Python/data/create_account_$user_id.txt"));
            $data = explode(' ||| ', $data);
            unlink(app("Python/data/create_account_$user_id.txt"));

            $model = new self;
            $model->user_id = $user_id;
            $model->token = $data[0];
            $model->private_key = $data[1];
            $model->save();
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }
}
