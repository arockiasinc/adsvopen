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

        if ($username !== '' || $password !== '') {
            return [$username, $password];
        }

        $authorization = $request->header('Authorization', $request->server('HTTP_AUTHORIZATION'));

        if (! is_string($authorization) || ! str_starts_with($authorization, 'Basic ')) {
            return ['', ''];
        }

        $decoded = base64_decode(substr($authorization, 6), true);

        if ($decoded === false || ! str_contains($decoded, ':')) {
            return ['', ''];
        }

        return explode(':', $decoded, 2);
    }
}
