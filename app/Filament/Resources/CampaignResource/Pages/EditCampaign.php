<?php

namespace App\Filament\Resources\CampaignResource\Pages;

use App\Filament\Resources\CampaignResource;
use App\Support\AdTargeting;
use App\Support\CampaignPricing;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCampaign extends EditRecord
{
    protected static string $resource = CampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return AdTargeting::hydrate($data);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return CampaignPricing::prepare($data);
    }
}
