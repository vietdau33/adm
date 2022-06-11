<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BonusLogs extends Model
{
    use HasFactory;

    protected $table = 'bonus_logs';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function userForm(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_from', 'id');
    }
}
