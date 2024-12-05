<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breand extends Model
{
    use HasFactory;
    protected $fillable = ['title','photo','popular','slug'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($breand) {
            if ($breand->title) {
                $breand->slug =\Str::slug($breand->title);
            }
        });
    }

}