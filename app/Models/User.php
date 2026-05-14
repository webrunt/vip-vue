<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'security_pin',
        'role_id',
        'activation_code',
        'forgot_code',
        'date_activated',
        'last_login',
        'is_blocked',
        'is_active',
        'is_corpo',
        'shop_name',
        'shop_activated',
        'num_used',
        'unhash_password',
        'unhash_security_pin',
        'temp_password',
        'last_activity_date',
        'last_activity',
        'otp',
        'last_otp',
        'otp_step',
        'left_build',
    ];

    protected $hidden = [
        'password',
        'security_pin',
        'unhash_password',
        'unhash_security_pin',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password'           => 'hashed',
            'date_activated'     => 'datetime',
            'last_login'         => 'datetime',
            'last_activity_date' => 'datetime',
            'last_otp'           => 'date',
            'shop_activated'     => 'boolean',
            'is_blocked'         => 'boolean',
            'is_active'          => 'boolean',
            'is_corpo'           => 'boolean',
        ];
    }

    // ─── Relationships ──────────────────────────────────────────

    /**
     * The role this user belongs to.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'user_role_id');
    }

    /**
     * The user's profile details (one-to-one).
     */
    public function detail(): HasOne
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }

    /**
     * Affiliate entries where this user is the member.
     */
    public function affiliates(): HasMany
    {
        return $this->hasMany(UserAffiliate::class, 'user_id', 'id');
    }

    /**
     * Affiliate entries where this user is the referral/upline.
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(UserAffiliate::class, 'referral_id', 'id');
    }

    /**
     * The user's wallet (one-to-one).
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(UserWallet::class, 'user_id', 'id');
    }

    /**
     * All wallet transaction history for this user.
     */
    public function walletHistory(): HasMany
    {
        return $this->hasMany(UserWalletHistory::class, 'user_id', 'id');
    }

    /**
     * The user's SMS gateway settings (one-to-one).
     */
    public function smsSetting(): HasOne
    {
        return $this->hasOne(UserSmsSetting::class, 'user_id', 'id');
    }

    /**
     * All SMS messages sent by this user.
     */
    public function smsMessages(): HasMany
    {
        return $this->hasMany(UserSmsMessageHistory::class, 'user_id', 'id');
    }

    /**
     * All SMS load (top-up) transactions for this user.
     */
    public function smsLoads(): HasMany
    {
        return $this->hasMany(UserSmsLoadHistory::class, 'user_id', 'id');
    }

    // ─── Helpers ────────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role_id === 1;
    }

    public function isMember(): bool
    {
        return $this->role_id === 2;
    }

    public function isBlocked(): bool
    {
        return (bool) $this->is_blocked;
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }
}
