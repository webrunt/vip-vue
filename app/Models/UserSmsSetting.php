<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserSmsSetting extends Model
{
    protected $table = 'user_sms_setting';

    protected $fillable = [
        'user_id',
        'mobile_number',
        'balance',
        'starter',
        'premium',
        'stairstep',
        'unilevel',
        'affiliate',
        'message_count',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'balance'    => 'decimal:2',
            'starter'    => 'boolean',
            'premium'    => 'boolean',
            'stairstep'  => 'boolean',
            'unilevel'   => 'boolean',
            'affiliate'  => 'boolean',
            'active'     => 'boolean',
        ];
    }

    // ─── Relationships ──────────────────────────────────────────

    /**
     * The user this SMS setting belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * All message history sent under these settings.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(UserSmsMessageHistory::class, 'user_id', 'user_id');
    }

    /**
     * All load (top-up) history for this SMS account.
     */
    public function loads(): HasMany
    {
        return $this->hasMany(UserSmsLoadHistory::class, 'user_id', 'user_id');
    }
}
