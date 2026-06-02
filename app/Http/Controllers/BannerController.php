<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Serves banner images uploaded through the Filament admin panel
 * without relying on a public/storage symlink being available.
 */
class BannerController extends Controller
{
    public function image(Banner $banner): BinaryFileResponse
    {
        abort_unless($banner->usesManagedUpload(), 404);

        $disk = Storage::disk('public')->exists($banner->image_path)
            ? Storage::disk('public')
            : Storage::disk('local');

        abort_unless($disk->exists($banner->image_path), 404);

        return response()->file($disk->path($banner->image_path), [
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
