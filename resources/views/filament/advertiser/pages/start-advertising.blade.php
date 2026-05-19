<x-filament-panels::page>
    @if ($recommendations !== null)
        <x-filament::section icon="heroicon-o-sparkles">
            <x-slot name="heading">Based on the information you provided, here are the options for your company to advertise</x-slot>

            @if (count($recommendations) > 0)
                <ul class="list-disc space-y-2 ps-6 text-sm text-gray-700 dark:text-gray-200">
                    @foreach ($recommendations as $recommendation)
                        <li>{{ $recommendation }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Our team will review your request and reach out with tailored options.
                </p>
            @endif

            <x-slot name="footer">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Your request has been saved and our team has been notified. We'll be in touch with
                    package details and pricing for the placements above.
                </p>
            </x-slot>
        </x-filament::section>

        <div class="mt-2">
            <x-filament::button
                tag="a"
                :href="\App\Filament\Advertiser\Resources\CampaignResource::getUrl('index')"
                icon="heroicon-o-rectangle-stack"
            >
                View my campaigns
            </x-filament::button>
        </div>
    @else
        <form wire:submit="save">
            {{ $this->form }}
        </form>
    @endif
</x-filament-panels::page>
