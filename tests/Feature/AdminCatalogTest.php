<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_catalog_entries_and_assign_them_to_a_product(): void
    {
        $this->withSession(['admin_id' => 1]);
        Storage::fake('uploads');

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Manage your catalog');

        $this->get(route('admin.categories'))
            ->assertOk()
            ->assertSee('Category directory');

        $this->get(route('admin.enquiries'))
            ->assertOk()
            ->assertSee('Enquiry inbox');

        $this->post(route('admin.categories.store'), [
            'name' => 'Office Equipment',
            'icon' => 'laptop',
            'is_active' => '1',
        ])->assertRedirect(route('admin.categories'));

        $this->post(route('admin.brands.store'), [
            'name' => 'JPL Select',
            'is_active' => '1',
        ])->assertRedirect(route('admin.brands'));

        $category = Category::where('name', 'Office Equipment')->firstOrFail();
        $brand = Brand::where('name', 'JPL Select')->firstOrFail();
        $this->assertSame('laptop', $category->icon);

        $this->get(route('admin.brands'))
            ->assertOk()
            ->assertSee('Brand directory')
            ->assertSee('JPL Select');

        $this->post(route('admin.products.store'), [
            'name' => 'Office Laptop',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'stock_quantity' => 12,
            'price' => '45000',
            'image' => UploadedFile::fake()->image('office-laptop.jpg'),
            'is_active' => '1',
        ])->assertRedirect(route('admin.products'))
            ->assertSessionHasNoErrors();

        $product = Product::where('name', 'Office Laptop')->firstOrFail();

        $this->assertSame('JPL-OFFICE-LAPTOP', $product->sku);
        $this->assertSame(12, $product->stock_quantity);
        $this->assertNull($product->rating);
        $this->assertStringStartsWith('uploads/images/', $product->image);
        Storage::disk('uploads')->assertExists($product->image);
        $this->assertStringEndsWith($product->image, $product->image_url);
        $originalImagePath = $product->image;
        $this->assertSame($category->id, $product->categoryRecord->id);
        $this->assertSame($brand->id, $product->brandRecord->id);
        $this->assertSame('Office Equipment', $product->category);
        $this->assertSame('JPL Select', $product->brand);

        $this->put(route('admin.products.update', $product), [
            'name' => 'Office Laptop Pro',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'stock_quantity' => 7,
            'price' => '47500',
            'image' => UploadedFile::fake()->image('office-laptop-pro.jpg'),
            'is_active' => '1',
        ])->assertRedirect(route('admin.products'))
            ->assertSessionHasNoErrors();

        $this->put(route('admin.categories.update', $category), [
            'name' => 'Office Devices',
            'icon' => 'printer',
            'is_active' => '1',
        ])->assertRedirect(route('admin.categories'));

        $this->put(route('admin.brands.update', $brand), [
            'name' => 'JPL Select Pro',
            'is_active' => '1',
        ])->assertRedirect(route('admin.brands'));

        $product->refresh();
        $this->assertSame('JPL-OFFICE-LAPTOP-PRO', $product->sku);
        $this->assertSame(7, $product->stock_quantity);
        $this->assertNotSame($originalImagePath, $product->image);
        Storage::disk('uploads')->assertExists($product->image);
        $this->assertSame('Office Devices', $product->category);
        $this->assertSame('printer', $category->fresh()->icon);
        $this->assertSame('JPL Select Pro', $product->brand);
        $this->assertSame('Office Devices', $product->categoryRecord->name);
        $this->assertSame('JPL Select Pro', $product->brandRecord->name);

        $this->get(route('admin.products'))
            ->assertOk()
            ->assertSee('Office Laptop Pro')
            ->assertSee('Office Devices')
            ->assertSee('JPL Select Pro');

        $this->get(route('admin.categories'))
            ->assertOk()
            ->assertDontSee(route('admin.categories.destroy', $category), false);

        $this->delete(route('admin.categories.destroy', $category))
            ->assertSessionHasErrors('category');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_admin_catalog_pages_require_an_admin_session(): void
    {
        $this->get(route('admin.categories'))
            ->assertRedirect(route('admin.login'));

        $this->get(route('admin.brands'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_category_icon_must_be_a_supported_icon_name(): void
    {
        $this->withSession(['admin_id' => 1]);

        $this->post(route('admin.categories.store'), [
            'name' => 'Unlisted category icon',
            'icon' => 'not-an-icon',
            'is_active' => '1',
        ])->assertSessionHasErrors('icon');

        $this->assertDatabaseMissing('categories', ['name' => 'Unlisted category icon']);
    }

    public function test_computer_and_accessory_category_icons_are_supported(): void
    {
        $this->withSession(['admin_id' => 1]);

        foreach (['mouse', 'desktop', 'monitor', 'keyboard', 'pendrive'] as $icon) {
            $this->post(route('admin.categories.store'), [
                'name' => ucfirst($icon).' category',
                'icon' => $icon,
                'is_active' => '1',
            ])->assertRedirect(route('admin.categories'))
                ->assertSessionHasNoErrors();

            $this->assertDatabaseHas('categories', ['icon' => $icon]);
        }
    }

    public function test_category_actions_do_not_include_view_and_only_allow_delete_for_empty_categories(): void
    {
        $this->withSession(['admin_id' => 1]);
        $activeCategory = Category::create([
            'name' => 'Active category',
            'slug' => 'active-category',
            'is_active' => true,
        ]);
        $inactiveCategory = Category::create([
            'name' => 'Inactive category',
            'slug' => 'inactive-category',
            'is_active' => false,
        ]);

        $this->get(route('admin.categories'))
            ->assertOk()
            ->assertDontSee(route('products', ['category' => $activeCategory->name]), false)
            ->assertDontSee(route('products', ['category' => $inactiveCategory->name]), false)
            ->assertSee(route('admin.categories.destroy', $activeCategory), false);
    }

    public function test_admin_can_delete_a_category_without_products(): void
    {
        $this->withSession(['admin_id' => 1]);
        $category = Category::create([
            'name' => 'Empty category',
            'slug' => 'empty-category',
            'is_active' => false,
        ]);

        $this->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
