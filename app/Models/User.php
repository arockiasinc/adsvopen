<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'username', 'email', 'password', 'role', 'is_approved', 'terms_accepted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
            'terms_accepted_at' => 'datetime',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAdvertiser(): bool
    {
        return $this->role === 'advertiser';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'advertiser') {
            // Advertisers may sign in before approval so they can see their
            // profile/business info and the pending-approval notice. Campaign
            // and payment features are gated separately on isApprovedAdvertiser().
            return $this->isAdvertiser();
        }

        return $this->isAdmin();
    }

    public function isApprovedAdvertiser(): bool
    {
        return $this->isAdvertiser() && $this->is_approved;
    }

    public function advertiserProfile(): HasOne
    {
        return $this->hasOne(AdvertiserProfile::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function advertisingInquiries(): HasMany
    {
        return $this->hasMany(AdvertisingInquiry::class);
    }
}
