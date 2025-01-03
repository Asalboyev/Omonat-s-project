<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone',
        'description',
        'title',
        'subtitle',
        'apple_link',
        'and_link',
        'app_link',
        'double_description',
        'tg_link',
        'insta_link',
        'you_link'

    ];
    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',

    ];
}
