<?php

namespace App\Models;

use App\Support\AdTargeting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdPrice extends Model
{
    public const UNIT_DAY = 'day';
    public const UNIT_WEEK = 'week';
    public const UNIT_MONTH = 'month';
    public const UNIT_FLAT = 'flat';

    protected $fillable = [
        'ad_type_id',
        'scope',
        'province_id',
        'region_id',
        'city_id',
        'price',
        'unit',
        'currency',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * How long one unit lasts, used to price a campaign over a date range.
     * A flat rate is charged once, so it has no length.
     *
     * @return array<string, string>
     */
    public static function unitOptions(): array
    {
        return [
            self::UNIT_DAY => 'Per day',
            self::UNIT_WEEK => 'Per week',
            self::UNIT_MONTH => 'Per month',
            self::UNIT_FLAT => 'Flat / one-time',
        ];
    }

    public static function unitLabel(?string $unit): string
    {
        return static::unitOptions()[$unit] ?? (string) $unit;
    }

    /**
     * Days covered by one unit; null for a flat rate.
     */
    public static function unitDays(string $unit): ?int
    {
        return match ($unit) {
            self::UNIT_DAY => 1,
            self::UNIT_WEEK => 7,
            self::UNIT_MONTH => 30,
            default => null,
        };
    }

    public function adType(): BelongsTo
    {
        return $this->belongsTo(AdType::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Human-readable location this rate applies to.
     */
    public function locationLabel(): string
    {
        return match ($this->scope) {
            AdTargeting::SCOPE_COUNTRY => AdTargeting::countryLabel(),
            AdTargeting::SCOPE_PROVINCE => $this->province?->name.' (province-wide)',
            AdTargeting::SCOPE_REGION => $this->region?->name.', '.$this->province?->name,
            AdTargeting::SCOPE_CITY => $this->city?->name.', '.$this->province?->name,
            default => '—',
        };
    }

    public function formattedPrice(): string
    {
        return $this->currency.' $'.number_format((float) $this->price, 2)
            .' '.strtolower(AdPrice::unitLabel($this->unit));
    }
}
