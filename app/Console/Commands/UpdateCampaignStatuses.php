<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateCampaignStatuses extends Command
{
    protected $signature = 'campaigns:update-statuses';

    protected $description = 'Activate scheduled campaigns when their start date arrives and end them once their end date passes';

    public function handle(): int
    {
        $today = Carbon::today();

        // Activate scheduled campaigns whose window has started and not yet ended.
        $activated = Campaign::query()
            ->where('status', Campaign::STATUS_SCHEDULED)
            ->whereNotNull('start_date')
            ->whereDate('start_date', '<=', $today)
            ->where(function ($query) use ($today): void {
                $query->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', $today);
            })
            ->update(['status' => Campaign::STATUS_ACTIVE]);

        // End scheduled or active campaigns whose end date has passed.
        $ended = Campaign::query()
            ->whereIn('status', [Campaign::STATUS_SCHEDULED, Campaign::STATUS_ACTIVE])
            ->whereNotNull('end_date')
            ->whereDate('end_date', '<', $today)
            ->update(['status' => Campaign::STATUS_ENDED]);

        $this->info("Activated {$activated} campaign(s); ended {$ended} campaign(s).");

        return self::SUCCESS;
    }
}
