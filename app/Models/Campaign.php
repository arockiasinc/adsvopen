<?php

namespace App\Models;

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
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
