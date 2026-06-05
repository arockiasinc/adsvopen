<?php

namespace App\Filament\Advertiser\Pages;

use App\Models\AdvertisingInquiry;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class StartAdvertising extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationLabel = 'Start Advertising';

    protected static ?string $title = 'Start Advertising';

    protected static ?int $navigationSort = 0;

    protected static string $view = 'filament.advertiser.pages.start-advertising';

    public ?array $data = [];

    /** @var array<int, string>|null Recommendations shown after submission. */
    public ?array $recommendations = null;

    public function mount(): void
    {
        $user = auth()->user();
        $profile = $user->advertiserProfile;

        // Contact and business info are pre-filled from the account/profile
        // (entered while registering) and remain editable.
        $this->form->fill([
            'business_name' => $profile?->business_name ?? $user->name,
            'industry' => $profile?->industry,
            'business_province' => $profile?->business_province,
            'company_size' => $profile?->company_size,
            'wants_website_link' => filled($profile?->website) ? true : null,
            'website_link' => $profile?->website,
            'contact_name' => $profile?->contact_name ?? $user->name,
            'contact_email' => $profile?->contact_email ?? $user->email,
            'contact_phone' => $profile?->contact_phone,
            'accepts_terms' => null,
        ]);
    }

    public function getHeading(): string|Htmlable
    {
        return 'Start Advertising';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Our AI-driven platform helps you choose the best option for your brand and message to reach '
            .'your target market — local or coast-to-coast. Answer a few quick questions to get custom '
            .'recommendations for your business. Advertisements with VOpen Market start from a minimum of '
            .'one month commitment.';
    }

    public function form(Form $form): Form
    {
        $regionCategories = config('advertising.region_categories');
        $provinceRegionCategories = config('advertising.province_region_categories', []);

        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Commitment')
                        ->icon('heroicon-o-check-circle')
                        ->schema([
                            Forms\Components\Radio::make('accepts_terms')
                                ->label('Advertisements with VOpen Market start from a minimum of one month commitment. Do you accept?')
                                ->options(['yes' => 'Yes', 'no' => 'No'])
                                ->required()
                                ->live(),
                            Forms\Components\Placeholder::make('decline_notice')
                                ->hiddenLabel()
                                ->content(config('advertising.min_commitment_notice'))
                                ->extraAttributes(['class' => 'text-danger-600 font-medium'])
                                ->visible(fn (Get $get): bool => $get('accepts_terms') === 'no'),
                        ]),

                    Wizard\Step::make('Business')
                        ->icon('heroicon-o-building-office-2')
                        ->visible(fn (Get $get): bool => $get('accepts_terms') === 'yes')
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('business_name')
                                ->label('Business name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('industry')
                                ->label('Industry')
                                ->options(array_combine(
                                    config('advertising.industries'),
                                    config('advertising.industries'),
                                ))
                                ->searchable()
                                ->required(),
                            Forms\Components\Select::make('business_province')
                                ->label('Business location (province)')
                                ->options(array_combine(
                                    config('advertising.provinces'),
                                    config('advertising.provinces'),
                                ))
                                ->searchable()
                                ->required(),
                        ]),

                    Wizard\Step::make('Company size')
                        ->icon('heroicon-o-users')
                        ->visible(fn (Get $get): bool => $get('accepts_terms') === 'yes')
                        ->schema([
                            Forms\Components\Radio::make('company_size')
                                ->label('Select company size')
                                ->options(config('advertising.company_sizes'))
                                ->descriptions([
                                    'micro' => 'Recommended: Business listing page.',
                                    'small' => 'Recommended: Business listing page + ads on that page + ads on the home page (except slider ads).',
                                    'medium' => 'Recommended: Home page slider + other home page ads.',
                                    'large' => 'Recommended: Home page sliders, other home page ads and the business listing page ad.',
                                ])
                                ->required(),
                        ]),

                    Wizard\Step::make('Targeting')
                        ->icon('heroicon-o-map')
                        ->visible(fn (Get $get): bool => $get('accepts_terms') === 'yes')
                        ->schema([
                            Forms\Components\CheckboxList::make('target_provinces')
                                ->label('Where do you want to advertise? (Select all that apply)')
                                ->options(array_merge(
                                    [config('advertising.country_wide_label') => config('advertising.country_wide_label')],
                                    array_combine(
                                        config('advertising.provinces'),
                                        config('advertising.provinces'),
                                    ),
                                ))
                                ->columns(2)
                                ->required()
                                ->live(),
                            Forms\Components\Repeater::make('target_regions')
                                ->label('Select the region(s) you would like to advertise')
                                ->helperText('Add a row for each province/region you want to target.')
                                ->visible(fn (Get $get): bool => ! empty(array_diff(
                                    (array) $get('target_provinces'),
                                    [config('advertising.country_wide_label')],
                                )))
                                ->schema([
                                    Forms\Components\Select::make('province')
                                        ->options(fn (Get $get): array => array_combine(
                                            $p = array_values(array_diff(
                                                (array) $get('../../target_provinces'),
                                                [config('advertising.country_wide_label')],
                                            )),
                                            $p,
                                        ))
                                        ->required()
                                        ->live(),
                                    Forms\Components\Select::make('category')
                                        ->options(function (Get $get) use ($regionCategories, $provinceRegionCategories): array {
                                            $province = $get('province');
                                            $categories = array_replace_recursive(
                                                $regionCategories,
                                                $provinceRegionCategories[$province] ?? [],
                                            );

                                            return collect($categories)
                                                // Hide categories with no data for this province,
                                                // but always keep "Across the Province".
                                                ->filter(function ($category, $key): bool {
                                                    if ($key === 'across_province') {
                                                        return true;
                                                    }

                                                    return ($category['display_count'] ?? count($category['places'] ?? [])) > 0;
                                                })
                                                ->mapWithKeys(function ($category, $key) {
                                                    $count = $category['display_count'] ?? count($category['places'] ?? []);
                                                    $label = $category['label'].($count ? " ({$count})" : '');

                                                    return [$key => $label];
                                                })
                                                ->all();
                                        })
                                        ->required()
                                        ->live(),
                                    Forms\Components\Select::make('places')
                                        ->multiple()
                                        ->options(function (Get $get) use ($regionCategories, $provinceRegionCategories): array {
                                            $province = $get('province');
                                            $cat = $get('category');
                                            $categories = array_replace_recursive(
                                                $regionCategories,
                                                $provinceRegionCategories[$province] ?? [],
                                            );
                                            $places = $categories[$cat]['places'] ?? [];

                                            return array_combine($places, $places);
                                        })
                                        ->visible(function (Get $get) use ($regionCategories, $provinceRegionCategories): bool {
                                            $province = $get('province');
                                            $cat = $get('category');
                                            $categories = array_replace_recursive(
                                                $regionCategories,
                                                $provinceRegionCategories[$province] ?? [],
                                            );

                                            return ! empty($categories[$cat]['places'] ?? []);
                                        })
                                        ->helperText('Leave empty to target the whole category.'),
                                ])
                                ->columns(3)
                                ->addActionLabel('Add a region')
                                ->default([]),
                        ]),

                    Wizard\Step::make('Selling & duration')
                        ->icon('heroicon-o-shopping-bag')
                        ->visible(fn (Get $get): bool => $get('accepts_terms') === 'yes')
                        ->columns(2)
                        ->schema([
                            Forms\Components\Radio::make('sells_on_vopen')
                                ->label('Do you sell any of your products on VOpen Market?')
                                ->boolean()
                                ->required()
                                ->live(),
                            Forms\Components\TextInput::make('seller_id')
                                ->label('Seller ID')
                                ->visible(fn (Get $get): bool => $get('sells_on_vopen') === true)
                                ->required(fn (Get $get): bool => $get('sells_on_vopen') === true)
                                ->maxLength(255),
                            Forms\Components\Radio::make('duration')
                                ->label('How many months are you planning to advertise in your targeted location?')
                                ->options(config('advertising.durations'))
                                ->required()
                                ->columnSpanFull(),
                            Forms\Components\Radio::make('wants_website_link')
                                ->label('Do you want to get the most views and link customers to your website?')
                                ->boolean()
                                ->required()
                                ->live(),
                            Forms\Components\TextInput::make('website_link')
                                ->label('Enter link')
                                ->url()
                                ->visible(fn (Get $get): bool => $get('wants_website_link') === true)
                                ->required(fn (Get $get): bool => $get('wants_website_link') === true)
                                ->maxLength(255),
                        ]),

                    Wizard\Step::make('Ad content')
                        ->icon('heroicon-o-document-text')
                        ->visible(fn (Get $get): bool => $get('accepts_terms') === 'yes')
                        ->schema([
                            Forms\Components\Radio::make('ad_about')
                                ->label('What is your advertisement about?')
                                ->options(config('advertising.ad_about'))
                                ->required()
                                ->live(),
                            Forms\Components\TextInput::make('ad_about_other')
                                ->label('Enter message type')
                                ->visible(fn (Get $get): bool => $get('ad_about') === 'others')
                                ->required(fn (Get $get): bool => $get('ad_about') === 'others')
                                ->maxLength(255),
                            Forms\Components\Radio::make('display_schedule')
                                ->label('Do you want your advertisement displayed during regular business hours or 24 hrs?')
                                ->options(config('advertising.display_schedules'))
                                ->required(),
                        ]),

                    Wizard\Step::make('Budget')
                        ->icon('heroicon-o-banknotes')
                        ->visible(fn (Get $get): bool => $get('accepts_terms') === 'yes')
                        ->columns(2)
                        ->schema([
                            Forms\Components\Select::make('daily_budget_band')
                                ->label('What is your allocated daily budget for advertising?')
                                ->options(config('advertising.daily_budget_bands'))
                                ->required()
                                ->live(),
                            Forms\Components\TextInput::make('daily_budget_other')
                                ->label('Enter other amount')
                                ->numeric()
                                ->prefix('$')
                                ->visible(fn (Get $get): bool => $get('daily_budget_band') === 'other')
                                ->required(fn (Get $get): bool => $get('daily_budget_band') === 'other'),
                            Forms\Components\TextInput::make('yearly_marketing_budget')
                                ->label('What is your yearly marketing budget for your brand? (dollar value)')
                                ->numeric()
                                ->prefix('$')
                                ->columnSpanFull(),
                        ]),

                    Wizard\Step::make('More questions')
                        ->icon('heroicon-o-question-mark-circle')
                        ->visible(fn (Get $get): bool => $get('accepts_terms') === 'yes')
                        ->columns(2)
                        ->schema([
                            Forms\Components\Radio::make('advertising_apps')
                                ->label('Are you advertising any apps to be downloaded?')
                                ->boolean()
                                ->required(),
                            Forms\Components\Radio::make('special_promotion')
                                ->label('Is the advertisement related to any special promotion?')
                                ->boolean()
                                ->required(),
                            Forms\Components\Radio::make('generic_social_message')
                                ->label('Is it a generic social message that you want displayed?')
                                ->boolean()
                                ->required(),
                            Forms\Components\Radio::make('is_government_agency')
                                ->label('Are you a government agency?')
                                ->boolean()
                                ->required(),
                            Forms\Components\FileUpload::make('digital_file_path')
                                ->label('Do you have the digital file ready to start advertising? If so, upload here.')
                                ->disk('public')
                                ->directory('advertising-inquiries')
                                ->acceptedFileTypes(['image/*', 'video/*', 'application/pdf'])
                                ->maxSize(20480)
                                ->columnSpanFull(),
                        ]),

                    Wizard\Step::make('Contact info')
                        ->icon('heroicon-o-user')
                        ->visible(fn (Get $get): bool => $get('accepts_terms') === 'yes')
                        ->description('Pre-filled from your account — edit if needed.')
                        ->columns(2)
                        ->schema([
                            Forms\Components\TextInput::make('contact_name')
                                ->label('Contact name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('contact_email')
                                ->label('Contact email')
                                ->email()
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('contact_phone')
                                ->label('Contact phone')
                                ->tel()
                                ->maxLength(255),
                        ]),
                ])
                    ->submitAction(view('filament.advertiser.pages.partials.start-advertising-submit')),
            ])
            ->statePath('data');
    }

    /**
     * Compute the recommended advertising options from the spec rules.
     *
     * @return array<int, string>
     */
    protected function buildRecommendations(array $data): array
    {
        $recommendations = config('advertising.recommendations_by_size')[$data['company_size']] ?? [];

        $lowBudget = config('advertising.recommendation_low_budget');
        if (($data['daily_budget_band'] ?? null) === $lowBudget['band']) {
            $recommendations = array_merge($recommendations, $lowBudget['options']);
        }

        return array_values(array_unique($recommendations));
    }

    public function save(): void
    {
        $data = $this->form->getState();

        if (($data['accepts_terms'] ?? null) !== 'yes') {
            Notification::make()
                ->title(config('advertising.min_commitment_notice'))
                ->warning()
                ->send();

            return;
        }

        $recommendations = $this->buildRecommendations($data);

        AdvertisingInquiry::create([
            'user_id' => auth()->id(),
            'accepts_terms' => true,
            'business_name' => $data['business_name'],
            'industry' => $data['industry'],
            'business_province' => $data['business_province'],
            'company_size' => $data['company_size'],
            'target_provinces' => $data['target_provinces'] ?? [],
            'target_regions' => $data['target_regions'] ?? [],
            'sells_on_vopen' => (bool) ($data['sells_on_vopen'] ?? false),
            'seller_id' => $data['seller_id'] ?? null,
            'duration' => $data['duration'],
            'wants_website_link' => (bool) ($data['wants_website_link'] ?? false),
            'website_link' => $data['website_link'] ?? null,
            'ad_about' => $data['ad_about'],
            'ad_about_other' => $data['ad_about_other'] ?? null,
            'display_schedule' => $data['display_schedule'],
            'daily_budget_band' => $data['daily_budget_band'],
            'daily_budget_other' => $data['daily_budget_other'] ?? null,
            'advertising_apps' => (bool) ($data['advertising_apps'] ?? false),
            'special_promotion' => (bool) ($data['special_promotion'] ?? false),
            'generic_social_message' => (bool) ($data['generic_social_message'] ?? false),
            'yearly_marketing_budget' => $data['yearly_marketing_budget'] ?? null,
            'is_government_agency' => (bool) ($data['is_government_agency'] ?? false),
            'digital_file_path' => $data['digital_file_path'] ?? null,
            'contact_name' => $data['contact_name'] ?? null,
            'contact_email' => $data['contact_email'] ?? null,
            'contact_phone' => $data['contact_phone'] ?? null,
            'recommendations' => $recommendations,
            'status' => 'New',
        ]);

        $this->recommendations = $recommendations;

        Notification::make()
            ->title('Thank you! Your advertising request has been submitted.')
            ->body('Our team will review it shortly. See your recommended options below.')
            ->success()
            ->send();
    }
}
