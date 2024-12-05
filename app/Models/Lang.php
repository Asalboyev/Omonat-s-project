<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{
    use HasFactory;
    protected  $fillable =['small', 'lang','group_id'];
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
