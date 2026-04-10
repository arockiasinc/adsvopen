<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BannerController extends Controller
{
    public function index(): View
    {
        $this->ensureAdmin();

        return view('banners.index', [
            'bannerTableReady' => Schema::hasTable('banners'),
            'banners' => $this->bannerCollection(),
        ]);
    }

    public function store(BannerRequest $request): RedirectResponse
    {
        $this->ensureAdmin();
        $this->abortIfBannerTableMissing();

        $data = $request->bannerData();
        $data['image_path'] = $request->file('image')->store('banners', 'local');

        Banner::create($data);

        return redirect()
            ->route('banners.index')
            ->with('status', 'Banner created successfully.');
    }

    public function update(BannerRequest $request, Banner $banner): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->bannerData();

        if ($request->hasFile('image')) {
            $this->deleteImage($banner);
            $data['image_path'] = $request->file('image')->store('banners', 'local');
        }

        $banner->update($data);

        return redirect()
            ->route('banners.index')
            ->with('status', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $this->ensureAdmin();

        $this->deleteImage($banner);
        $banner->delete();

        return redirect()
            ->route('banners.index')
            ->with('status', 'Banner deleted successfully.');
    }

    public function image(Banner $banner): BinaryFileResponse
    {
        abort_unless($banner->usesManagedUpload(), 404);
        abort_unless(Storage::disk('local')->exists($banner->image_path), 404);

        return response()->file(Storage::disk('local')->path($banner->image_path), [
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    protected function ensureAdmin(): void
    {
        abort_unless(request()->user()?->isAdmin(), 403);
    }

    protected function abortIfBannerTableMissing(): void
    {
        abort_unless(Schema::hasTable('banners'), 503, 'The banners table is not ready yet. Please run the latest migration.');
    }

    protected function bannerCollection(): Collection
    {
        if (! Schema::hasTable('banners')) {
            return collect();
        }

        return Banner::query()->ordered()->get();
    }

    protected function deleteImage(Banner $banner): void
    {
        if ($banner->usesManagedUpload()) {
            Storage::disk('local')->delete($banner->image_path);
        }
    }
}
