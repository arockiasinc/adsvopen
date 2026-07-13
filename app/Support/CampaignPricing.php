<?php

namespace App\Support;

use App\Services\AdPricingService;
use Carbon\Carbon;

/**
 * Turns a campaign form's targeting picker into the columns we store, and prices
 * the result against the rate card. Shared by the admin and advertiser panels so
 * a campaign is priced the same way whoever creates it.
 */
class CampaignPricing
{
    /**
     * Inclusive campaign length in days, or null until both dates are set.
     */
    public static function daysBetween(mixed $start, mixed $end): ?int
    {
        if (blank($start) || blank($end)) {
            return null;
        }

        try {
            $days = Carbon::parse($start)->diffInDays(Carbon::parse($end)) + 1;
        } catch (\Throwable) {
            return null;
        }

        return max((int) $days, 1);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function prepare(array $data): array
    {
        $target = AdTargeting::normalise($data);

        $quote = app(AdPricingService::class)->quote(
            $data['ad_type_id'] ?? null,
            $target,
            self::daysBetween($data['start_date'] ?? null, $data['end_date'] ?? null),
        );

        // `format` predates ad types and still shows in older screens, so keep it
        // in step with the selected type.
        $data['format'] = $quote['ad_type'] ?? ($data['format'] ?? '');
        $data['quote'] = $quote;
        $data['quoted_price'] = $quote['estimated_total'];

        // Form-only fields that have no column.
        unset($data['target_province_id'], $data['price_preview']);

        return [...$data, ...$target];
    }
}
