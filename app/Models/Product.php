<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $appends = ['image_url'];

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'category',
        'brand',
        'category_id',
        'brand_id',
        'stock_quantity',
        'price',
        'old_price',
        'rating',
        'image',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'stock_quantity' => 'integer',
        ];
    }

    public function getImageUrlAttribute(): string
    {
        $image = $this->attributes['image'] ?? '';

        if ($image === '' || Str::startsWith($image, ['http://', 'https://', '/'])) {
            return $image;
        }

        return Storage::disk('uploads')->url($image);
    }

    public function categoryRecord(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brandRecord(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
