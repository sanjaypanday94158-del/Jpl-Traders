<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Laptops',
            'Desktops',
            'Monitors',
            'Printers',
            'Photocopiers',
            'Accessories',
            'Networking',
            'Components',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => Str::slug($category)],
                ['name' => $category, 'is_active' => true]
            );
        }

        $products = [
            ['Dell Inspiron 15 Laptop', 'dell-inspiron-15', 'Laptops', 'Dell', 54990, 66990, 4.5, 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=650&q=85', '15.6-inch Full HD display, 8GB RAM, SSD storage'],
            ['HP Pavilion Laptop', 'hp-pavilion', 'Laptops', 'HP', 56990, 71990, 4.6, 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=650&q=85', 'Powerful and portable laptop for everyday productivity'],
            ['Lenovo Desktop Computer', 'lenovo-desktop', 'Desktops', 'Lenovo', 39990, 46990, 4.4, 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=650&q=85', 'Business desktop solution for office productivity'],
            ['LG 24-inch Full HD Monitor', 'lg-monitor', 'Monitors', 'LG', 10990, 14990, 4.6, 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=650&q=85', 'Full HD IPS display, slim bezel and vivid colors'],
            ['HP LaserJet Multifunction Printer', 'hp-laserjet', 'Printers', 'HP', 14490, 17990, 4.5, 'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?w=650&q=85', 'Print, scan and copy for home or office'],
            ['ASUS VivoBook Laptop', 'asus-vivobook', 'Laptops', 'ASUS', 59990, 64990, 4.4, 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=650&q=85', 'Modern laptop with fast storage and premium finish'],
            ['Wireless Computer Mouse', 'wireless-computer-mouse', 'Accessories', 'Logitech', 799, 1199, 4.5, 'https://images.unsplash.com/photo-1527814050087-3793815479db?w=650&q=85', 'Wireless mouse for smooth everyday computer use'],
            ['Premium Laptop', 'premium-laptop', 'Laptops', 'Apple', 74990, 84990, 4.6, 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=650&q=85', 'Portable laptop for work, study and everyday productivity'],
        ];

        foreach ($products as [$name, $slug, $category, $brand, $price, $oldPrice, $rating, $image, $description]) {
            $categoryRecord = Category::where('name', $category)->firstOrFail();
            $brandRecord = Brand::firstOrCreate(
                ['name' => $brand],
                ['slug' => Str::slug($brand), 'is_active' => true]
            );

            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'category' => $category,
                    'brand' => $brand,
                    'category_id' => $categoryRecord->id,
                    'brand_id' => $brandRecord->id,
                    'sku' => Str::upper('JPL-'.Str::slug($slug)),
                    'price' => $price,
                    'old_price' => $oldPrice,
                    'rating' => $rating,
                    'image' => $image,
                    'description' => $description,
                    'is_active' => true,
                ]
            );
        }
    }
}
