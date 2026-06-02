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

        if ($this->usesManagedUpload() && $this->exists) {
            return $this->managedImageUrl();
        }

        return asset(ltrim($imagePath, '/'));
    }

    public function usesManagedUpload(): bool
    {
        return Str::startsWith((string) $this->image_path, 'banners/');
    }

    private function managedImageUrl(): string
    {
        $basePath = $this->appBasePath();
        $imageRoute = route('banners.image', $this, false);

        return ($basePath === '' ? '' : "/{$basePath}").$imageRoute;
    }

    private function appBasePath(): string
    {
        if (! app()->runningInConsole()) {
            return trim((string) request()->getBasePath(), '/');
        }

        $path = (string) parse_url((string) config('app.url'), PHP_URL_PATH);
        $segments = array_values(array_filter(
            explode('/', trim(str_replace('\\', '/', $path), '/')),
            fn (string $segment): bool => $segment !== '' && $segment !== '.',
        ));

        if (end($segments) === 'index.php') {
            array_pop($segments);
        }

        if (end($segments) === 'public') {
            array_pop($segments);
        }

        return implode('/', $segments);
    }
}
