<?php

namespace App\Filament\Resources\AdvertisingInquiryResource\Pages;

use App\Filament\Resources\AdvertisingInquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdvertisingInquiry extends EditRecord
{
    protected static string $resource = AdvertisingInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
