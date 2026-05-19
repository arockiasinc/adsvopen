<?php

namespace App\Filament\Resources\AdvertisingInquiryResource\Pages;

use App\Filament\Resources\AdvertisingInquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAdvertisingInquiry extends ViewRecord
{
    protected static string $resource = AdvertisingInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->label('Update status'),
        ];
    }
}
