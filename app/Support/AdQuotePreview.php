<?php

namespace App\Support;

use App\Models\AdPrice;
use App\Services\AdPricingService;
use Filament\Forms;
use Filament\Forms\Get;
use Illuminate\Support\HtmlString;

/**
 * Shows the advertiser what the admin's rate card charges for what they just
 * picked. Purely a preview — the stored quote is recalculated on save.
 */
class AdQuotePreview
{
    /**
     * A live "estimated price" panel for any form that has the targeting fields
     * and an `ad_type_id` select.
     *
     * @param  (\Closure(Get): ?int)|null  $daysUsing  Campaign length, when the form knows it.
     */
    public static function field(?\Closure $daysUsing = null): Forms\Components\Placeholder
    {
        return Forms\Components\Placeholder::make('price_preview')
            ->label('Estimated price')
            ->content(function (Get $get) use ($daysUsing): HtmlString {
                $quote = app(AdPricingService::class)->quote(
                    $get('ad_type_id'),
                    AdTargeting::fromForm($get),
                    $daysUsing ? $daysUsing($get) : null,
                );

                return self::toHtml($quote);
            })
            ->columnSpanFull();
    }

    /**
     * @param  array<string, mixed>  $quote
     */
    public static function toHtml(array $quote): HtmlString
    {
        if (blank($quote['ad_type'])) {
            return new HtmlString(self::muted('Choose an ad type to see pricing.'));
        }

        if ($quote['lines'] === [] && $quote['unpriced'] === []) {
            return new HtmlString(self::muted('Choose where you want to advertise to see pricing.'));
        }

        $currency = $quote['currency'];
        $html = '<div class="space-y-2 text-sm">';

        foreach ($quote['lines'] as $line) {
            $html .= '<div class="flex justify-between gap-4">'
                .'<span>'.e($line['label']).'</span>'
                .'<span class="font-medium whitespace-nowrap">'
                .e($currency).' $'.number_format($line['price'], 2)
                .' <span class="text-gray-500">'.e(strtolower(AdPrice::unitLabel($line['unit']))).'</span>'
                .'</span></div>';
        }

        foreach ($quote['totals_by_unit'] as $unit => $total) {
            // A single line already reads as its own total.
            if (count($quote['lines']) < 2) {
                break;
            }

            $html .= '<div class="flex justify-between gap-4 border-t pt-2 font-semibold">'
                .'<span>Total '.e(strtolower(AdPrice::unitLabel($unit))).'</span>'
                .'<span class="whitespace-nowrap">'.e($currency).' $'.number_format($total, 2).'</span>'
                .'</div>';
        }

        if ($quote['estimated_total'] !== null && $quote['lines'] !== []) {
            $html .= '<div class="flex justify-between gap-4 border-t pt-2 font-semibold text-primary-600">'
                .'<span>Estimated total for '.(int) $quote['days'].' day'.($quote['days'] === 1 ? '' : 's').'</span>'
                .'<span class="whitespace-nowrap">'.e($currency).' $'.number_format($quote['estimated_total'], 2).'</span>'
                .'</div>';
        }

        if ($quote['unpriced'] !== []) {
            $html .= '<div class="text-warning-600 pt-2">'
                .'No published rate yet for: '.e(implode(', ', $quote['unpriced']))
                .'. We will quote these for you.</div>';
        }

        return new HtmlString($html.'</div>');
    }

    protected static function muted(string $text): string
    {
        return '<span class="text-sm text-gray-500">'.e($text).'</span>';
    }
}
