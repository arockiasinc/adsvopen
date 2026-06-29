<?php

namespace App\Filament\Advertiser\Widgets;

use App\Models\Campaign;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdvertiserStatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return (bool) auth()->user()?->isApprovedAdvertiser();
    }

    protected function getStats(): array
    {
        $userId = auth()->id();

        $activeCampaigns = Campaign::where('user_id', $userId)
            ->where('status', 'Active')
            ->count();

        $totalCampaigns = Campaign::where('user_id', $userId)->count();

        $totalSpend = (int) Payment::where('user_id', $userId)->sum('amount');

        $pendingInvoices = Payment::where('user_id', $userId)
            ->where('status', '!=', 'Paid')
            ->count();

        return [
            Stat::make('Active campaigns', $activeCampaigns)
                ->description($totalCampaigns.' total')
                ->color('success'),
            Stat::make('Total spend', '$'.number_format($totalSpend, 2)),
            Stat::make('Pending invoices', $pendingInvoices)
                ->color($pendingInvoices > 0 ? 'warning' : 'gray'),
        ];
    }
}
