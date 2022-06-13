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
        try {
            $path = app_path('Python/create_account.py');
            $output = shell_exec("$path $user_id 2>&1");
            dd($output);
            return $output[0] == 'Done';
        } catch (Exception $exception) {
            return false;
        }
    }
}
