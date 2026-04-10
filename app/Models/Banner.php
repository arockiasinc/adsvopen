<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'copy',
        'detail',
        'footer',
        'highlights',
        'button_rows',
        'image_path',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'highlights' => 'array',
            'button_rows' => 'array',
        ];
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function getImageUrlAttribute(): string
    {
        $imagePath = (string) $this->image_path;

        if (Str::startsWith($imagePath, ['http://', 'https://'])) {
            return $imagePath;
        }

        if (Str::startsWith($imagePath, ['images/', '/images/'])) {
            return asset(ltrim($imagePath, '/'));
        }

        return route('banners.image', $this);
    }

    public function usesManagedUpload(): bool
    {
        return Str::startsWith((string) $this->image_path, 'banners/');
    }
}
