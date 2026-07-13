<?php

namespace App\Filament\Resources\AdTypeResource\Pages;

use App\Filament\Resources\AdTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdType extends EditRecord
{
    protected static string $resource = AdTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
