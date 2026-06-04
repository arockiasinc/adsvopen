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
            'query_keys' => array_keys($request->query()),
            'host' => $request->getHost(),
            'scheme' => $request->getScheme(),
            'is_secure' => $request->isSecure(),
            'content_length' => $request->server('CONTENT_LENGTH'),
            'content_type' => $request->headers->get('Content-Type'),
            'has_csrf_header' => $request->headers->has('X-CSRF-TOKEN'),
            'has_session' => $request->hasSession(),
            'has_valid_signature' => $this->hasValidSignature($request),
            'files' => $this->uploadedFiles($request),
            'app_url' => config('app.url'),
            'filesystem_default' => config('filesystems.default'),
            'livewire_upload_disk' => config('livewire.temporary_file_upload.disk'),
            'livewire_upload_rules' => config('livewire.temporary_file_upload.rules'),
            'tmp_dir' => sys_get_temp_dir(),
            'tmp_dir_writable' => is_writable(sys_get_temp_dir()),
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

    private function elapsedMilliseconds(float $startedAt): int
    {
        return (int) round((microtime(true) - $startedAt) * 1000);
    }
}
