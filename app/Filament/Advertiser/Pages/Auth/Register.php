<?php

namespace App\Filament\Advertiser\Pages\Auth;

use App\Notifications\AccountRegistered;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),

                Forms\Components\Section::make('Business details')
                    ->description('Tell us about your business. This pre-fills your Start Advertising questionnaire.')
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
                        Forms\Components\Select::make('company_size')
                            ->label('Company size')
                            ->options(config('advertising.company_sizes'))
                            ->required(),
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
                            ->required()
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
                            ->required()
                            ->maxLength(255),
                    ]),
            ])
            ->statePath('data');
    }

    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();

        $user = $this->getUserModel()::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'advertiser',
            'is_approved' => false,
        ]);

        $user->advertiserProfile()->create([
            'business_name' => $data['business_name'] ?? null,
            'industry' => $data['industry'] ?? null,
            'business_province' => $data['business_province'] ?? null,
            'company_size' => $data['company_size'] ?? null,
            'website' => $data['website'] ?? null,
            'contact_name' => $data['contact_name'] ?? null,
            'contact_title' => $data['contact_title'] ?? null,
            'contact_email' => $data['contact_email'] ?: $data['email'],
            'contact_phone' => $data['contact_phone'] ?? null,
        ]);

        $user->notify(new AccountRegistered());

        Notification::make()
            ->title('Registration received')
            ->body('Thanks for registering as an advertiser. Your account is pending admin approval — you can review the details you entered while you wait.')
            ->success()
            ->persistent()
            ->send();

        // Sign the new advertiser in so they land on the restricted dashboard
        // (profile/business info + pending-approval notice). Campaign and
        // payment features stay gated until an admin approves the account.
        Filament::auth()->login($user);
        session()->regenerate();

        return app(RegistrationResponse::class);
    }
}
