<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
        });

        $categoryIds = [];
        foreach (DB::table('products')->whereNotNull('category')->distinct()->pluck('category') as $name) {
            $category = DB::table('categories')->where('name', $name)->first();

            if (!$category) {
                $category = (object) [
                    'id' => DB::table('categories')->insertGetId([
                        'name' => $name,
                        'slug' => $this->uniqueSlug($name, 'categories'),
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]),
                ];
            }

            $categoryIds[$name] = $category->id;
        }

        foreach ($categoryIds as $name => $id) {
            DB::table('products')->where('category', $name)->update(['category_id' => $id]);
        }

        $brandIds = [];
        foreach (DB::table('products')->whereNotNull('brand')->distinct()->pluck('brand') as $name) {
            $brand = DB::table('brands')->where('name', $name)->first();

            if (!$brand) {
                $brandIds[$name] = DB::table('brands')->insertGetId([
                    'name' => $name,
                    'slug' => $this->uniqueSlug($name, 'brands'),
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $brandIds[$name] = $brand->id;
            }
        }

        foreach ($brandIds as $name => $id) {
            DB::table('products')->where('brand', $name)->update(['brand_id' => $id]);
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['brand_id']);
            $table->dropColumn(['category_id', 'brand_id']);
        });

        Schema::dropIfExists('brands');
    }

    private function uniqueSlug(string $name, string $table): string
    {
        $base = Str::slug($name) ?: 'catalog-item';
        $slug = $base;
        $suffix = 2;

        while (DB::table($table)->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
};
