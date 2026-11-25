<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeaturedProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_shows_a_helpful_empty_state_when_no_featured_products_exist(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('No featured products at the moment')
            ->assertDontSee('Ask about availability')
            ->assertSee('Browse all products');
    }

    public function test_featured_products_replace_the_empty_state_when_available(): void
    {
        $product = Product::create([
            'name' => 'Professional Laptop',
            'slug' => 'professional-laptop',
            'sku' => 'JPL-PROFESSIONAL-LAPTOP',
            'category' => 'Laptops',
            'brand' => 'JPL',
            'price' => 2500,
            'image' => '/images/professional-laptop.jpg',
            'is_active' => true,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($product->name)
            ->assertDontSee('product-rating')
            ->assertDontSee('SKU '.$product->sku)
            ->assertDontSee('No featured products at the moment');

        $this->get(route('products'))
            ->assertOk()
            ->assertDontSee('product-rating')
            ->assertDontSee('SKU '.$product->sku);

        $this->get(route('product.show', $product->sku))
            ->assertOk()
            ->assertSee($product->name)
            ->assertDontSee('product-rating')
            ->assertSee('Zoom in')
            ->assertSee('Zoom out')
            ->assertSee('Product details')
            ->assertSee('Product code')
            ->assertSee($product->sku);

        $this->get(route('product.show', $product->slug))
            ->assertOk()
            ->assertSee($product->name);
    }

    public function test_homepage_shows_at_most_the_ten_newest_active_products(): void
    {
        $products = [];

        for ($index = 1; $index <= 12; $index++) {
            $product = Product::create([
                'name' => 'Featured item '.$index,
                'slug' => 'featured-item-'.$index,
                'sku' => 'JPL-FEATURED-'.$index,
                'category' => 'Accessories',
                'brand' => 'JPL',
                'price' => 100 + $index,
                'image' => '/images/featured-item.jpg',
                'is_active' => true,
            ]);
            $product->forceFill(['created_at' => now()->subSeconds($index)])->save();
            $products[] = $product;
        }

        $response = $this->get(route('home'))->assertOk();

        foreach (array_slice($products, 0, 10) as $product) {
            $response->assertSee($product->name);
        }

        foreach (array_slice($products, 10) as $product) {
            $response->assertDontSee($product->name);
        }
    }

    public function test_product_rating_is_shown_on_list_and_details_when_present(): void
    {
        $product = Product::create([
            'name' => 'Rated Laptop',
            'slug' => 'rated-laptop',
            'sku' => 'JPL-RATED-LAPTOP',
            'category' => 'Laptops',
            'brand' => 'JPL',
            'price' => 2500,
            'rating' => 4.5,
            'image' => '/images/rated-laptop.jpg',
            'is_active' => true,
        ]);

        $this->get(route('products'))
            ->assertOk()
            ->assertSee('4.5 / 5');

        $this->get(route('product.show', $product->sku))
            ->assertOk()
            ->assertSee('4.5 / 5');
    }
}
