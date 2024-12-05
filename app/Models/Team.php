<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'FIO',
        'job_title',
        'instagram',
        'tel_number',
        'telegram_nickname',
        'photo',
        'descriptions',

    ];
    protected $casts = [
        'FIO' => 'array',
        'job_title' => 'array',
        'descriptions' => 'array',
    ];
}
