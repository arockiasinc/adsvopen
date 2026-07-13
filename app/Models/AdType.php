<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class AdType extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'is_active', 'sort_order'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $adType): void {
            if (blank($adType->slug)) {
                $adType->slug = Str::slug($adType->name);
            }
        });
    }

    public function prices(): HasMany
    {
        return $this->hasMany(AdPrice::class);
    }

    /**
     * Active ad types as value => label, for select inputs.
     *
     * @return array<int, string>
     */
    public static function options(): array
    {
        return static::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();
    }
}
