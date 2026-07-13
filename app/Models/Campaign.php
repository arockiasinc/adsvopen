<?php

namespace App\Models;

use App\Support\AdTargeting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'Draft';
    public const STATUS_PENDING_REVIEW = 'Pending Review';
    public const STATUS_SCHEDULED = 'Scheduled';
    public const STATUS_ACTIVE = 'Active';
    public const STATUS_PAUSED = 'Paused';
    public const STATUS_ENDED = 'Ended';

    /**
     * Status options for select inputs (value => label).
     */
    public static function statusOptions(): array
    {
        return [
            self::STATUS_DRAFT => self::STATUS_DRAFT,
            self::STATUS_PENDING_REVIEW => self::STATUS_PENDING_REVIEW,
            self::STATUS_SCHEDULED => self::STATUS_SCHEDULED,
            self::STATUS_ACTIVE => self::STATUS_ACTIVE,
            self::STATUS_PAUSED => self::STATUS_PAUSED,
            self::STATUS_ENDED => self::STATUS_ENDED,
        ];
    }

    protected $fillable = [
        'user_id',
        'title',
        'status',
        'format',
        'ad_type_id',
        'target_scope',
        'target_province_ids',
        'target_region_ids',
        'target_city_ids',
        'quoted_price',
        'quote',
        'objective',
        'daily_budget',
        'headline',
        'copy',
        'cta',
        'start_date',
        'end_date',
        'placements',
        'metrics',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'placements' => 'array',
            'metrics' => 'array',
            'target_province_ids' => 'array',
            'target_region_ids' => 'array',
            'target_city_ids' => 'array',
            'quote' => 'array',
            'quoted_price' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function adType(): BelongsTo
    {
        return $this->belongsTo(AdType::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Plain-English list of the places this campaign targets.
     *
     * @return array<int, string>
     */
    public function targetSummary(): array
    {
        return AdTargeting::summarise($this->only([
            'target_scope',
            'target_province_ids',
            'target_region_ids',
            'target_city_ids',
        ]));
    }

    /**
     * Days the campaign runs for, used to price it against the rate card.
     */
    public function durationInDays(): ?int
    {
        if (! $this->start_date || ! $this->end_date) {
            return null;
        }

        return $this->start_date->diffInDays($this->end_date) + 1;
    }
}
