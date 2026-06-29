<?php

namespace App\Filament\Advertiser\Widgets;

use Filament\Widgets\Widget;

class PendingApprovalNotice extends Widget
{
    protected static string $view = 'filament.advertiser.widgets.pending-approval-notice';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = -10;

    public static function canView(): bool
    {
        $user = auth()->user();

        return $user !== null && $user->isAdvertiser() && ! $user->is_approved;
    }
}
