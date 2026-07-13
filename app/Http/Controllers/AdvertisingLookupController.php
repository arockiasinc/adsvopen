<?php

namespace App\Http\Controllers;

use App\Services\AdPricingService;
use App\Support\AdQuotePreview;
use App\Support\AdTargeting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Feeds the public Start Advertising form: the province -> region / city
 * cascade, and the live price from the rate card.
 */
class AdvertisingLookupController extends Controller
{
    public function regions(Request $request): JsonResponse
    {
        return response()->json(
            $this->asOptions(AdTargeting::regionOptions($request->query('province_id'))),
        );
    }

    public function cities(Request $request): JsonResponse
    {
        return response()->json(
            $this->asOptions(AdTargeting::cityOptions($request->query('province_id'))),
        );
    }

    public function quote(Request $request, AdPricingService $pricing): JsonResponse
    {
        $target = AdTargeting::normalise([
            'target_scope' => $request->query('target_scope'),
            'target_province_id' => $request->query('target_province_id'),
            'target_province_ids' => (array) $request->query('target_province_ids', []),
            'target_region_ids' => (array) $request->query('target_region_ids', []),
            'target_city_ids' => (array) $request->query('target_city_ids', []),
        ]);

        $quote = $pricing->quote($request->query('ad_type_id'), $target);

        return response()->json([
            'html' => AdQuotePreview::toHtml($quote)->toHtml(),
        ]);
    }

    /**
     * @param  array<int, string>  $options
     * @return array<int, array{id: int, name: string}>
     */
    protected function asOptions(array $options): array
    {
        $result = [];

        foreach ($options as $id => $name) {
            $result[] = ['id' => (int) $id, 'name' => $name];
        }

        return $result;
    }
}
