<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LogLivewireUploadFailures
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->isLivewireUploadRequest($request)) {
            return $next($request);
        }

        $startedAt = microtime(true);

        try {
            $response = $next($request);
        } catch (Throwable $exception) {
            Log::error('Livewire upload request failed with an exception.', $this->context($request, [
                'exception_class' => $exception::class,
                'exception_message' => $exception->getMessage(),
                'elapsed_ms' => $this->elapsedMilliseconds($startedAt),
            ]));

            throw $exception;
        }

        if ($response->getStatusCode() >= 400) {
            Log::warning('Livewire upload request returned an error response.', $this->context($request, [
                'status' => $response->getStatusCode(),
                'elapsed_ms' => $this->elapsedMilliseconds($startedAt),
                'response_preview' => $this->responsePreview($response),
            ]));
        }

        return $response;
    }

    private function isLivewireUploadRequest(Request $request): bool
    {
        return $request->is(
            'livewire/upload-file',
            '*/livewire/upload-file',
            'livewire/update',
            '*/livewire/update',
        );
    }

    /**
     * @param  array<string, mixed>  $extra
     * @return array<string, mixed>
     */
    private function context(Request $request, array $extra = []): array
    {
        return array_merge([
            'method' => $request->method(),
            'url' => $request->url(),
            'url_without_signature' => $this->urlWithoutSignature($request),
            'query_keys' => array_keys($request->query()),
            'host' => $request->getHost(),
            'http_host' => $request->getHttpHost(),
            'scheme' => $request->getScheme(),
            'is_secure' => $request->isSecure(),
            'base_path' => $request->getBasePath(),
            'script_name' => $request->server('SCRIPT_NAME'),
            'request_uri' => $request->server('REQUEST_URI'),
            'route_name' => $request->route()?->getName(),
            'route_uri' => $request->route()?->uri(),
            'content_length' => $request->server('CONTENT_LENGTH'),
            'content_type' => $request->headers->get('Content-Type'),
            'has_csrf_header' => $request->headers->has('X-CSRF-TOKEN'),
            'has_session' => $request->hasSession(),
            'has_valid_signature' => $this->hasValidSignature($request),
            'has_valid_relative_signature' => $this->hasValidRelativeSignature($request),
            'files' => $this->uploadedFiles($request),
            'app_url' => config('app.url'),
            'filesystem_default' => config('filesystems.default'),
            'livewire_upload_disk' => config('livewire.temporary_file_upload.disk'),
            'livewire_upload_rules' => config('livewire.temporary_file_upload.rules'),
            'tmp_dir' => sys_get_temp_dir(),
            'tmp_dir_writable' => is_writable(sys_get_temp_dir()),
            'tmpfile' => $this->tmpfileDiagnostics(),
            'upload_tmp_dir' => ini_get('upload_tmp_dir'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
        ], $extra);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function uploadedFiles(Request $request): array
    {
        return collect($request->file('files', []))
            ->flatten()
            ->filter()
            ->map(fn ($file): array => [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
                'valid' => $file->isValid(),
                'error' => $file->getError(),
            ])
            ->values()
            ->all();
    }

    private function hasValidSignature(Request $request): ?bool
    {
        if (! $request->is('livewire/upload-file', '*/livewire/upload-file')) {
            return null;
        }

        try {
            return $request->hasValidSignature();
        } catch (Throwable) {
            return false;
        }
    }

    private function hasValidRelativeSignature(Request $request): ?bool
    {
        if (! $request->is('livewire/upload-file', '*/livewire/upload-file')) {
            return null;
        }

        try {
            return $request->hasValidRelativeSignature();
        } catch (Throwable) {
            return false;
        }
    }

    private function urlWithoutSignature(Request $request): string
    {
        $query = $request->query();

        unset($query['signature']);

        $queryString = http_build_query($query);

        return $request->url().($queryString === '' ? '' : "?{$queryString}");
    }

    private function responsePreview(Response $response): ?string
    {
        if (! method_exists($response, 'getContent')) {
            return null;
        }

        $content = (string) $response->getContent();

        if ($content === '') {
            return null;
        }

        return mb_substr(trim(strip_tags($content)), 0, 500);
    }

    /**
     * @return array{ok: bool, path?: string|null, error?: array<string, mixed>|null}
     */
    private function tmpfileDiagnostics(): array
    {
        error_clear_last();

        $tmpFile = @tmpfile();

        if ($tmpFile === false) {
            return [
                'ok' => false,
                'error' => error_get_last(),
            ];
        }

        $metadata = stream_get_meta_data($tmpFile);
        fclose($tmpFile);

        return [
            'ok' => true,
            'path' => $metadata['uri'] ?? null,
        ];
    }

    private function elapsedMilliseconds(float $startedAt): int
    {
        return (int) round((microtime(true) - $startedAt) * 1000);
    }
}
