<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProductCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_category_id',
        'subcategory_id',
        'title',
        'status',
        'slug',
        'order',
        'photo',
        'popular',
        'descriptions',
        'tip'

    ];
    protected $casts = [
        'title' => 'array',
        'descriptions' => 'array',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if ($category->title) {
                $category->slug = \Str::slug($category->title['en']);
            }
        });
    }


    public function tree()
    {
        $allCategories = ProductCategory::get();

        $rootCategories = $allCategories->whereNull('product_category_id');

        self::formatTree($rootCategories, $allCategories);
        return $rootCategories;
    }


    private static function formatTree($categories, $allCategories)
    {
        foreach ($categories as $category) {
            $category->children = $allCategories->where('product_category_id', $category->id)->values();

            if ($category->children->isNotEmpty()) {

                self::formatTree($category->children, $allCategories);
            }

        }

    }



    public function product_categories()
    {
        return $this->hasMany(self::class)->orderBy('id');
    }

    public function product_category()
    {
        return $this->belongsTo(self::class);
    }

    public function subcategories()
    {
        return $this->hasMany(self::class)->orderBy('id');
    }

    public function subcategory()
    {
        return $this->belongsTo(self::class);
    }

//    public function subcategories()
//    {
//        return $this->hasMany(ProductCategory::class, 'product_category_id');
//    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function subProduct()
    {
        return $this->hasManyThrough(Product::class, ProductCategory::class)->orderBy('id');
    }

}

