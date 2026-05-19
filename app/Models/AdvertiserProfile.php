<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvertiserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'contact_name',
        'contact_title',
        'contact_email',
        'contact_phone',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
