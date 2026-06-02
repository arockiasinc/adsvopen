<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    protected static string $view = 'filament.pages.auth.login';

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
