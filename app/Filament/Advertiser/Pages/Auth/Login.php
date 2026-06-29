<?php

namespace App\Filament\Advertiser\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Models\Contracts\FilamentUser;
use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    protected static string $view = 'filament.advertiser.pages.auth.login';

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();

        if (! Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        $user = Filament::auth()->user();

        // Unapproved advertisers are allowed to sign in; they land on a
        // restricted dashboard (profile/business info + pending notice) and
        // cannot reach campaign/payment features until an admin approves them.
        if (($user instanceof FilamentUser) && (! $user->canAccessPanel(Filament::getCurrentPanel()))) {
            Filament::auth()->logout();

            $this->throwFailureValidationException();
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }

    protected function getEmailFormComponent(): Component
    {
        return parent::getEmailFormComponent()
            ->extraInputAttributes(['name' => 'email'], merge: true);
    }

    protected function getPasswordFormComponent(): Component
    {
        return parent::getPasswordFormComponent()
            ->extraInputAttributes(['name' => 'password'], merge: true);
    }

    protected function getRememberFormComponent(): Component
    {
        return parent::getRememberFormComponent()
            ->extraInputAttributes([
                'name' => 'remember',
                'value' => '1',
            ], merge: true);
    }
}
