<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    protected $table = 'user_details';

    protected $fillable = [
        'user_id',
        'leader_id',
        'first_name',
        'middle_name',
        'last_name',
        'dob',
        'pob',
        'citizenship',
        'mobile',
        'mobile_verified',
        'telephone',
        'address',
        'city',
        'province',
        'tin_number',
        'civil_status',
        'bank_acct_name',
        'bank_acct_number',
        'uniquecode',
        'neo_cutoff',
        'neo_funds',
        'user_membership',
        'is_profile_complete',
        'is_affiliate',
        'encashment',
        'monthly_income_monitor',
        'auto_maintain_required',
        'pv_maintain',
        'apple_points',
        'apple_points_transferred',
        'apple_points_received',
        'apple_points_claim_history',
        'apple_points_for_processing',
        'digital_card_id',
        'digital_card_generated_at',
        'digital_card_active',
        'profile_picture',
        'profile_picture_updated_at',
        'terms_accepted',
        'terms_accepted_at',
        'leaderboard',
    ];

    protected function casts(): array
    {
        return [
            'dob'                        => 'date',
            'digital_card_generated_at'  => 'datetime',
            'profile_picture_updated_at' => 'datetime',
            'terms_accepted_at'          => 'datetime',
            'digital_card_active'        => 'boolean',
            'is_profile_complete'        => 'boolean',
            'is_affiliate'               => 'boolean',
            'neo_funds'                  => 'decimal:2',
        ];
    }

    // ─── Relationships ──────────────────────────────────────────

    /**
     * The user this detail record belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * The upline/leader user (self-referential).
     */
    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id', 'id');
    }

    // ─── Helpers ────────────────────────────────────────────────

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }
}
