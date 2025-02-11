<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'brand',
        'description',
        'price',
        'sale_price',
        'stock',
        'images',
        'rating',
        'review_count',
        'sizes',
        'colors',
    ];

    protected $casts = [
        'images' => 'array',
        'sizes' => 'array',
        'colors' => 'array',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
