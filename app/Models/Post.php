<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'status',
        'view',
        'photo',
        'descriptions',

    ];
    protected $casts = [
        'title' => 'array',
        'descriptions' => 'array',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public static function boot(){
        parent::boot();
        static::saving(function ($post){
            $post->slug = \Str::slug($post->title['en']);
        });
    }
}
