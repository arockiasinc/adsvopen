<?php

namespace App\Http\Controllers;

use App\Models\LegalPage;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class LegalPageController extends Controller
{
    /**
     * Render a legal page (Privacy Policy, Cookies Policy, Terms of Use,
     * Terms & Conditions) inside the public site shell.
     */
    public function show(string $slug): View
    {
        $page = $this->findPublished($slug);

        if (! $page) {
            throw new NotFoundHttpException("Legal page [{$slug}] not found.");
        }

        return view('legal-page', [
            'menus' => $this->menus(),
            'page' => $page,
            'pageTitle' => $page->title,
            'pageDescription' => $page->title.' for VOpen Ads, the advertising platform of VOpen Market.',
        ]);
    }

    /**
     * Feeds the scroll-to-accept modal on the advertiser registration form.
     */
    public function content(string $slug): JsonResponse
    {
        $page = $this->findPublished($slug);

        if (! $page) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'title' => $page->title,
                'content' => $page->content,
            ],
        ]);
    }

    /**
     * The table is absent on a database that has not been migrated yet, and
     * the public site must not hard-fail in that case.
     */
    protected function findPublished(string $slug): ?LegalPage
    {
        try {
            if (! Schema::hasTable('legal_pages')) {
                return null;
            }

            return LegalPage::query()->published()->where('slug', $slug)->first();
        } catch (Throwable $exception) {
            Log::warning('Unable to load legal page.', [
                'slug' => $slug,
                'exception' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Public marketing menus, mirroring routes/web.php behaviour: known labels
     * map to their named route, anything else becomes a home-page anchor.
     */
    protected function menus()
    {
        $routedLabels = [
            'home' => route('home'),
            'panoramic banner ads' => route('banner.ads'),
            'leaderboard ads' => route('leaderboard.ads'),
            'product sponsored ads' => route('product.sponsored.ads'),
            'product carousel' => route('product.carousel'),
            'start advertising' => route('start.advertising'),
        ];

        try {
            $menus = Schema::hasTable('menus')
                ? Menu::query()->ordered()->get()
                : collect();
        } catch (Throwable $exception) {
            Log::warning('Falling back to default legal page menus.', [
                'exception' => $exception->getMessage(),
            ]);

            $menus = collect();
        }

        if ($menus->isEmpty()) {
            $menus = collect([
                (object) ['label' => 'Home', 'target' => ''],
                (object) ['label' => 'Panoramic Banner Ads', 'target' => 'panoramic-banner-ads'],
                (object) ['label' => 'Leaderboard Ads', 'target' => 'leaderboard-ads'],
                (object) ['label' => 'Product Sponsored ads', 'target' => 'product-sponsored-ads'],
                (object) ['label' => 'Product Carousel', 'target' => 'product-carousel'],
                (object) ['label' => 'Start Advertising', 'target' => 'start-advertising'],
                (object) ['label' => 'Contact', 'target' => 'contact'],
            ]);
        }

        return $menus->map(function ($menu) use ($routedLabels) {
            $label = trim(strtolower((string) $menu->label));

            if (isset($routedLabels[$label])) {
                $menu->target = $routedLabels[$label];
            } else {
                $menu->target = route('home').'#'.ltrim((string) $menu->target, '#');
            }

            return $menu;
        });
    }
}
