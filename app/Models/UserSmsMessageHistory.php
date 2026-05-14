<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSmsMessageHistory extends Model
{
    protected $table = 'user_sms_message_history';

    protected $fillable = [
        'user_id',
        'message_option',
        'message',
        'message_id',
        'message_status',
        'response',
        'user_balance',
    ];

    protected function casts(): array
    {
        return [
            'response'     => 'array',
            'user_balance' => 'decimal:2',
        ];
    }

    // ─── Relationships ──────────────────────────────────────────

    /**
     * The user who sent this message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
