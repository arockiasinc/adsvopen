<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LegalPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_footer',
        'status',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_footer' => 'boolean',
            'status' => 'boolean',
        ];
    }

    /**
     * Keep the slug in sync with the title when an admin leaves it blank, so
     * the public URL (/page/{slug}) never breaks.
     */
    protected static function booted(): void
    {
        static::saving(function (LegalPage $page): void {
            if (blank($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
