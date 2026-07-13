<?php

namespace App\Filament\Resources\AdPriceResource\Pages;

use App\Filament\Resources\AdPriceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdPrices extends ListRecords
{
    protected static string $resource = AdPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add price'),
        ];
    }
}
