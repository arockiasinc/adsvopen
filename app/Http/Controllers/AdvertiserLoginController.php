<?php

namespace App\Http\Controllers;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdvertiserLoginController extends Controller
{
    private const MAX_ATTEMPTS = 5;

    public function __invoke(Request $request): RedirectResponse
    {
        $data = $this->validateCredentials($request);
        $throttleKey = $this->throttleKey($request, $data['email']);

        $this->ensureIsNotRateLimited($throttleKey);

        if (! Filament::auth()->attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $request->boolean('remember'))) {
            RateLimiter::hit($throttleKey);

            $this->throwFailureValidationException();
        }

        $user = Filament::auth()->user();
        $panel = Filament::getCurrentPanel() ?? Filament::getPanel('advertiser');

        if ($user instanceof User && $user->isAdvertiser() && ! $user->is_approved) {
            Filament::auth()->logout();
            RateLimiter::hit($throttleKey);

            throw ValidationException::withMessages([
                'data.email' => 'Your advertiser account is awaiting admin approval. Please try again once it has been approved.',
            ]);
        }

        if (! ($user instanceof FilamentUser) || ! $user->canAccessPanel($panel)) {
            Filament::auth()->logout();
            RateLimiter::hit($throttleKey);

            $this->throwFailureValidationException();
        }

        RateLimiter::clear($throttleKey);

        $request->session()->regenerate();

        return redirect()->intended($panel->getUrl());
    }

    /**
     * @return array{email: string, password: string}
     */
    private function validateCredentials(Request $request): array
    {
        $validator = Validator::make($request->only(['email', 'password', 'remember']), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'],
        ]);

        if ($validator->fails()) {
            $errors = [];

            foreach ($validator->errors()->messages() as $field => $messages) {
                $errors["data.{$field}"] = $messages[0];
            }

            throw ValidationException::withMessages($errors);
        }

        return [
            'email' => (string) $request->input('email'),
            'password' => (string) $request->input('password'),
        ];
    }

    private function ensureIsNotRateLimited(string $throttleKey): void
    {
        if (! RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            return;
        }

        $seconds = RateLimiter::availableIn($throttleKey);

        throw ValidationException::withMessages([
            'data.email' => "Too many login attempts. Please try again in {$seconds} seconds.",
        ]);
    }

    private function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.email' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

    private function throttleKey(Request $request, string $email): string
    {
        return Str::transliterate(Str::lower($email).'|'.$request->ip());
    }
}
