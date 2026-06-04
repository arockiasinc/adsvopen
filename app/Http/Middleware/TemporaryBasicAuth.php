<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TemporaryBasicAuth
{
    private const USERNAME = 'vopencom';
    private const PASSWORD = 'LJ7ww~j$GTP#';
    private const REALM = 'Adsvopen Demo';

    public function handle(Request $request, Closure $next): Response
    {
        if (! (bool) config('app.temporary_basic_auth', false)) {
            return $next($request);
        }

        // Livewire/Filament drive file uploads and component updates over AJAX
        // requests that the browser fires *after* the gated page has already
        // loaded. Those XHRs don't reliably carry the cached Basic-Auth
        // credentials (and the Authorization header is often dropped once the
        // request is rewritten into public/), so the gate would 401 them and
        // surface a second login popup that breaks uploads. The page itself is
        // still gated, so exempting these sub-requests is safe.
        if ($request->is('livewire/*', '*/livewire/*')) {
            return $next($request);
        }

        [$username, $password] = $this->extractCredentials($request);

        if (
            hash_equals(self::USERNAME, $username)
            && hash_equals(self::PASSWORD, $password)
        ) {
            return $next($request);
        }

        return response('Authentication required.', 401, [
            'WWW-Authenticate' => sprintf('Basic realm="%s"', self::REALM),
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        ]);
    }

    /**
     * Handle servers that don't populate PHP_AUTH_* and only forward the auth header.
     *
     * @return array{0: string, 1: string}
     */
    private function extractCredentials(Request $request): array
    {
        $username = (string) ($request->getUser() ?? '');
        $password = (string) ($request->getPassword() ?? '');

        if ($username !== '' && $password !== '') {
            return [$username, $password];
        }

        foreach ($this->authorizationHeaders($request) as $authorization) {
            if (! is_string($authorization)) {
                continue;
            }

            if (! preg_match('/^\s*Basic\s+(.+)$/i', $authorization, $matches)) {
                continue;
            }

            $decoded = base64_decode($matches[1], true);

            if ($decoded === false || ! str_contains($decoded, ':')) {
                continue;
            }

            return explode(':', $decoded, 2);
        }

        return ['', ''];
    }

    /**
     * Shared hosts may expose the Authorization header under different server
     * variables after the request is internally rewritten into public/.
     *
     * @return array<int, mixed>
     */
    private function authorizationHeaders(Request $request): array
    {
        return [
            $request->header('Authorization'),
            $request->server('HTTP_AUTHORIZATION'),
            $request->server('REDIRECT_HTTP_AUTHORIZATION'),
            $request->server('Authorization'),
            getenv('HTTP_AUTHORIZATION') ?: null,
            getenv('REDIRECT_HTTP_AUTHORIZATION') ?: null,
        ];
    }
}
