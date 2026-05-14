<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserWallet extends Model
{
    protected $table = 'user_wallet';

    protected $fillable = [
        'user_id',
        'amount',
        'gc_points',
        'status',
        'no_transfer_all',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    // ─── Relationships ──────────────────────────────────────────

    /**
     * The owner of this wallet.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * All transaction history for this wallet's user.
     */
    public function history(): HasMany
    {
        return $this->hasMany(UserWalletHistory::class, 'user_id', 'user_id');
    }
}
