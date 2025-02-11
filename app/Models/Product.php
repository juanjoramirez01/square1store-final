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
        'images',
        'rating',
        'review_count'
    ];

    protected $casts = [
        'other_attributes' => 'array'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function setOtherAttributesAttribute($value)
    {
        $this->attributes['other_attributes'] = json_encode($value);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }
}