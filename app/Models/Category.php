<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public const ICONS = [
        'laptop',
        'desktop',
        'monitor',
        'mouse',
        'keyboard',
        'pendrive',
        'usb',
        'server',
        'router',
        'tablet',
        'smartphone',
        'hard-drive',
        'printer',
        'copy',
        'headphones',
        'wifi',
        'cpu',
        'building',
        'wrench',
        'map-pin',
        'phone',
        'mail',
        'arrow-right',
        'shield',
        'database',
        'gear',
        'network',
        'laptop-gear',
        'message',
        'truck',
        'clock',
        'headphone',
        'heart',
        'cart',
        'search',
        'star',
    ];

    protected $fillable = ['name', 'slug', 'icon', 'is_active'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
