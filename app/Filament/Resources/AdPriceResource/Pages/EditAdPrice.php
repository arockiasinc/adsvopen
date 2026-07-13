<?php

namespace App\Filament\Resources\AdPriceResource\Pages;

use App\Filament\Resources\AdPriceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdPrice extends EditRecord
{
    protected static string $resource = AdPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
