<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMenuManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_the_menu_management_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($admin)
            ->get(route('menus.index'));

        $response
            ->assertOk()
            ->assertSee('Add Menu')
            ->assertSee('Menu List')
            ->assertSee('Drag rows');
    }

    public function test_regular_user_cannot_open_the_menu_management_page(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('menus.index'));

        $response
            ->assertForbidden();
    }

    public function test_admin_can_create_a_menu_item(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($admin)
            ->post(route('menus.store'), [
                'label' => 'FAQ',
                'target' => '#faq',
                'sort_order' => 7,
            ]);

        $response
            ->assertRedirect(route('menus.index'))
            ->assertSessionHas('status', 'Menu item created successfully.');

        $this->assertDatabaseHas('menus', [
            'label' => 'FAQ',
            'target' => '#faq',
            'sort_order' => 7,
        ]);
    }

    public function test_admin_can_update_a_menu_item(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $menu = Menu::firstOrFail();

        $response = $this
            ->actingAs($admin)
            ->patch(route('menus.update', $menu), [
                'label' => 'Updated Frontend Menu',
                'target' => '#faq',
                'sort_order' => 9,
            ]);

        $response
            ->assertRedirect(route('menus.index'))
            ->assertSessionHas('status', 'Menu item updated successfully.');

        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'label' => 'Updated Frontend Menu',
            'target' => '#faq',
            'sort_order' => 9,
        ]);
    }

    public function test_admin_can_delete_a_menu_item(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $menu = Menu::firstOrFail();

        $response = $this
            ->actingAs($admin)
            ->delete(route('menus.destroy', $menu));

        $response
            ->assertRedirect(route('menus.index'))
            ->assertSessionHas('status', 'Menu item deleted successfully.');

        $this->assertDatabaseMissing('menus', [
            'id' => $menu->id,
        ]);
    }

    public function test_admin_can_reorder_menu_items(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $menuIds = Menu::query()->ordered()->pluck('id')->all();
        $reorderedIds = array_merge(
            [end($menuIds)],
            array_slice($menuIds, 0, -1),
        );

        $response = $this
            ->actingAs($admin)
            ->patch(route('menus.reorder'), [
                'menu_ids' => $reorderedIds,
            ]);

        $response
            ->assertRedirect(route('menus.index'))
            ->assertSessionHas('status', 'Menu order updated successfully.');

        $this->assertDatabaseHas('menus', [
            'id' => $reorderedIds[0],
            'sort_order' => 1,
        ]);

        $this->assertDatabaseHas('menus', [
            'id' => $reorderedIds[1],
            'sort_order' => 2,
        ]);

        $this->assertDatabaseHas('menus', [
            'id' => $reorderedIds[2],
            'sort_order' => 3,
        ]);
    }

    public function test_non_admin_cannot_modify_menu_items(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $menu = Menu::firstOrFail();

        $this->actingAs($user)
            ->patch(route('menus.update', $menu), [
                'label' => 'Blocked Update',
                'target' => '#hero',
                'sort_order' => 1,
            ])
            ->assertForbidden();

        $this->actingAs($user)
            ->delete(route('menus.destroy', $menu))
            ->assertForbidden();

        $this->actingAs($user)
            ->post(route('menus.store'), [
                'label' => 'Blocked Create',
                'target' => '#hero',
                'sort_order' => 7,
            ])
            ->assertForbidden();

        $this->actingAs($user)
            ->patch(route('menus.reorder'), [
                'menu_ids' => Menu::query()->ordered()->pluck('id')->all(),
            ])
            ->assertForbidden();
    }
}
