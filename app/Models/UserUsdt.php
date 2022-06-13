<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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
            $process = new Process(['python3', "$path $user_id"]);
            $process->run();
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            dd($process->getOutput());
        } catch (Exception $exception) {
            dd("Exception:", $exception->getMessage());
            return false;
        }
    }
}
