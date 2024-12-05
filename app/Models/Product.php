<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_category_id',
        'title',
        'popular',
        'standard_key',
        'status',
        'slug',
        'view',
        'photo',
        'price',
        'descriptions',
        'breand_id',

    ];
    protected $casts = [
        'title' => 'array',
        'photo' => 'array',
        'descriptions' => 'array',
        'optional_key' => 'array',
        'standard_key' => 'array',
    ];
      public function zayavka()
    {
        return $this->hasMany(Zayavka::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function breand()
    {
        return $this->belongsTo(Breand::class);
    }

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if ($product->title) {
                $product->slug = \Str::slug($product->title['en']);
            }
        });
    }
}
