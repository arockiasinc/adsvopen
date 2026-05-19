<x-filament-panels::page>
    <p class="text-sm text-gray-500 dark:text-gray-400">
        Choose from the advertising formats below when creating an ad campaign.
    </p>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($this->getOptions() as $option)
            <x-filament::section>
                <x-slot name="heading">{{ $option['name'] }}</x-slot>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $option['description'] }}</p>
            </x-filament::section>
        @endforeach
    </div>

    <div class="mt-2">
        <x-filament::button
            tag="a"
            :href="\App\Filament\Advertiser\Resources\CampaignResource::getUrl('create')"
            icon="heroicon-o-plus"
        >
            Start a new campaign
        </x-filament::button>
    </div>
</x-filament-panels::page>
