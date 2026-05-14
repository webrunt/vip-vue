<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserWalletHistory extends Model
{
    protected $table = 'user_wallet_history';

    protected $fillable = [
        'user_id',
        'head_id',
        'type',
        'head_income',
        'head_gc',
        'datecreated',
    ];

    protected function casts(): array
    {
        return [
            'datecreated' => 'datetime',
            'head_income' => 'decimal:2',
        ];
    }

    // ─── Relationships ──────────────────────────────────────────

    /**
     * The user this transaction belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * The head/source user of the transaction (e.g. who triggered it).
     */
    public function head(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_id', 'id');
    }
}
