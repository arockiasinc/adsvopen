<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Serves banner images uploaded through the Filament admin panel
 * (stored on the private "local" disk) to the public marketing site.
 */
class BannerController extends Controller
{
    public function image(Banner $banner): BinaryFileResponse
    {
        abort_unless($banner->usesManagedUpload(), 404);
        abort_unless(Storage::disk('local')->exists($banner->image_path), 404);

        return response()->file(Storage::disk('local')->path($banner->image_path), [
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
