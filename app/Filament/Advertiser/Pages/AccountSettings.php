<?php

namespace App\Filament\Advertiser\Pages;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class AccountSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'Account Details';

    protected static ?string $title = 'Account Details';

    protected static ?int $navigationSort = -1;

    protected static string $view = 'filament.advertiser.pages.account-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $user = auth()->user();
        $profile = $user->advertiserProfile;

        // Fall back to the most recent advertising inquiry to pre-fill business
        // details for advertisers who completed the Start Advertising wizard
        // before this section existed.
        $inquiry = $user->advertisingInquiries()->latest()->first();

        $this->form->fill([
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'account_status' => $user->is_approved ? 'Approved' : 'Pending approval',
            'business_name' => $profile?->business_name ?? $inquiry?->business_name ?? $user->name,
            'industry' => $profile?->industry ?? $inquiry?->industry,
            'business_province' => $profile?->business_province ?? $inquiry?->business_province,
            'company_size' => $profile?->company_size ?? $inquiry?->company_size,
            'website' => $profile?->website ?? $inquiry?->website_link,
            'contact_name' => $profile?->contact_name,
            'contact_title' => $profile?->contact_title,
            'contact_email' => $profile?->contact_email ?? $user->email,
            'contact_phone' => $profile?->contact_phone,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Account details')
                    ->description('These details come from your account. Contact an administrator to change them.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')->disabled(),
                        Forms\Components\TextInput::make('username')->disabled(),
                        Forms\Components\TextInput::make('email')->disabled(),
                        Forms\Components\TextInput::make('account_status')
                            ->label('Account status')
                            ->disabled(),
                    ]),
                Forms\Components\Section::make('Business details')
                    ->description('Tell us about your business. We use this to tailor your advertising options.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('business_name')
                            ->label('Business name')
                            ->maxLength(255),
                        Forms\Components\Select::make('industry')
                            ->label('Industry')
                            ->options(array_combine(
                                config('advertising.industries'),
                                config('advertising.industries'),
                            ))
                            ->searchable(),
                        Forms\Components\Select::make('business_province')
                            ->label('Province')
                            ->options(array_combine(
                                config('advertising.provinces'),
                                config('advertising.provinces'),
                            ))
                            ->searchable(),
                        Forms\Components\Select::make('company_size')
                            ->label('Company size')
                            ->options(config('advertising.company_sizes')),
                        Forms\Components\TextInput::make('website')
                            ->label('Website')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Contact information')
                    ->description('How we should reach you about your campaigns.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('contact_name')
                            ->label('Contact name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('contact_title')
                            ->label('Title / role')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('contact_email')
                            ->label('Contact email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('contact_phone')
                            ->label('Contact phone')
                            ->tel()
                            ->maxLength(255),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        auth()->user()->advertiserProfile()->updateOrCreate([], [
            'business_name' => $data['business_name'] ?? null,
            'industry' => $data['industry'] ?? null,
            'business_province' => $data['business_province'] ?? null,
            'company_size' => $data['company_size'] ?? null,
            'website' => $data['website'] ?? null,
            'contact_name' => $data['contact_name'] ?? null,
            'contact_title' => $data['contact_title'] ?? null,
            'contact_email' => $data['contact_email'] ?? null,
            'contact_phone' => $data['contact_phone'] ?? null,
        ]);

        Notification::make()
            ->title('Account details saved')
            ->success()
            ->send();
    }
}
