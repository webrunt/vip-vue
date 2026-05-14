<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAffiliate extends Model
{
    protected $table = 'user_affiliates';

    protected $fillable = [
        'referral_id',
        'user_id',
        'code_id',
        'desired_package',
        'is_approved',
        'ebp_code',
        'ebp_active',
        'uniquecode',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'ebp_active'  => 'boolean',
        ];
    }

    // ─── Relationships ──────────────────────────────────────────

    /**
     * The member/downline user in this affiliate record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * The referrer/upline user in this affiliate record.
     */
    public function referral(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referral_id', 'id');
    }
}
