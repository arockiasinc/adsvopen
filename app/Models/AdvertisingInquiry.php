<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvertisingInquiry extends Model
{
    protected $fillable = [
        'user_id',
        'accepts_terms',
        'business_name',
        'industry',
        'business_province',
        'company_size',
        'target_provinces',
        'target_regions',
        'sells_on_vopen',
        'seller_id',
        'duration',
        'wants_website_link',
        'website_link',
        'ad_about',
        'ad_about_other',
        'display_schedule',
        'daily_budget_band',
        'daily_budget_other',
        'advertising_apps',
        'special_promotion',
        'generic_social_message',
        'yearly_marketing_budget',
        'is_government_agency',
        'digital_file_path',
        'contact_name',
        'contact_email',
        'contact_phone',
        'recommendations',
        'status',
    ];

    protected $casts = [
        'accepts_terms' => 'boolean',
        'sells_on_vopen' => 'boolean',
        'wants_website_link' => 'boolean',
        'advertising_apps' => 'boolean',
        'special_promotion' => 'boolean',
        'generic_social_message' => 'boolean',
        'is_government_agency' => 'boolean',
        'target_provinces' => 'array',
        'target_regions' => 'array',
        'recommendations' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
