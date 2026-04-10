<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminBannerManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_the_banner_management_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($admin)
            ->get(route('banners.index'));

        $response
            ->assertOk()
            ->assertSee('Add Banner')
            ->assertSee('Content Guide')
            ->assertSee('Slide #1');
    }

    public function test_regular_user_cannot_open_the_banner_management_page(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $this->actingAs($user)
            ->get(route('banners.index'))
            ->assertForbidden();
    }

    public function test_admin_can_create_a_banner(): void
    {
        Storage::fake('local');

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($admin)
            ->post(route('banners.store'), [
                'image' => UploadedFile::fake()->image('spring-banner.jpg', 1200, 500),
                'title' => 'Spring Campaign',
                'copy' => 'Fresh creative for the season.',
                'detail' => 'Reach shoppers across premium placements.',
                'footer' => 'Designed for high visibility.',
                'highlights' => "Display Ads\nSponsored Ads",
                'button_rows' => "Banner Ads | Native Ads\nListing Ads | Product Ads",
                'sort_order' => 4,
            ]);

        $response
            ->assertRedirect(route('banners.index'))
            ->assertSessionHas('status', 'Banner created successfully.');

        $banner = Banner::query()->where('title', 'Spring Campaign')->first();

        $this->assertNotNull($banner);
        $this->assertSame(['Display Ads', 'Sponsored Ads'], $banner->highlights);
        $this->assertSame([
            ['Banner Ads', 'Native Ads'],
            ['Listing Ads', 'Product Ads'],
        ], $banner->button_rows);
        $this->assertSame(4, $banner->sort_order);
        Storage::disk('local')->assertExists($banner->image_path);
    }

    public function test_admin_can_update_a_banner_and_replace_its_image(): void
    {
        Storage::fake('local');

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $banner = Banner::firstOrFail();
        $originalImagePath = 'banners/original-banner.jpg';

        Storage::disk('local')->put($originalImagePath, 'old-image-content');
        $banner->update([
            'image_path' => $originalImagePath,
        ]);

        $response = $this
            ->actingAs($admin)
            ->patch(route('banners.update', $banner), [
                'image' => UploadedFile::fake()->image('updated-banner.png', 1400, 600),
                'title' => 'Updated Banner Title',
                'copy' => 'Updated copy',
                'detail' => 'Updated detail',
                'footer' => 'Updated footer',
                'highlights' => "Priority Listings\nSponsored Ads",
                'button_rows' => "Banner Ads | Product Ads",
                'sort_order' => 9,
            ]);

        $response
            ->assertRedirect(route('banners.index'))
            ->assertSessionHas('status', 'Banner updated successfully.');

        $banner->refresh();

        $this->assertSame('Updated Banner Title', $banner->title);
        $this->assertSame(['Priority Listings', 'Sponsored Ads'], $banner->highlights);
        $this->assertSame([['Banner Ads', 'Product Ads']], $banner->button_rows);
        $this->assertSame(9, $banner->sort_order);
        $this->assertNotSame($originalImagePath, $banner->image_path);
        Storage::disk('local')->assertMissing($originalImagePath);
        Storage::disk('local')->assertExists($banner->image_path);
    }

    public function test_admin_can_delete_a_banner(): void
    {
        Storage::fake('local');

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $banner = Banner::firstOrFail();
        $imagePath = 'banners/delete-me.jpg';

        Storage::disk('local')->put($imagePath, 'image-content');
        $banner->update([
            'image_path' => $imagePath,
        ]);

        $response = $this
            ->actingAs($admin)
            ->delete(route('banners.destroy', $banner));

        $response
            ->assertRedirect(route('banners.index'))
            ->assertSessionHas('status', 'Banner deleted successfully.');

        $this->assertDatabaseMissing('banners', [
            'id' => $banner->id,
        ]);
        Storage::disk('local')->assertMissing($imagePath);
    }

    public function test_non_admin_cannot_modify_banners(): void
    {
        Storage::fake('local');

        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $banner = Banner::firstOrFail();

        $this->actingAs($user)
            ->post(route('banners.store'), [
                'image' => UploadedFile::fake()->image('blocked.jpg'),
                'title' => 'Blocked Create',
                'sort_order' => 10,
            ])
            ->assertForbidden();

        $this->actingAs($user)
            ->patch(route('banners.update', $banner), [
                'title' => 'Blocked Update',
                'sort_order' => 1,
            ])
            ->assertForbidden();

        $this->actingAs($user)
            ->delete(route('banners.destroy', $banner))
            ->assertForbidden();
    }

    public function test_home_page_uses_banner_records_from_the_database(): void
    {
        $banner = Banner::query()->ordered()->firstOrFail();

        $banner->update([
            'title' => 'Database Driven Banner',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Database Driven Banner');
    }
}
